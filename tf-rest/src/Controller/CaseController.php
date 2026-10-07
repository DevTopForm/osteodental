<?php

namespace TFRest\Controller;

use Params;
use TFRest\CRUDController;
use TFRest\Response;
use Node_Item;
use Image;
use Node;
use Utils;

class CaseController extends CRUDController
{
    public function createAction(array $urlParts = []): Response
    {
        // Переопределяем root_path, если он указывает на tf-rest
        if (realpath(Params::$params['root_path']) === realpath(__DIR__ . '/../..')) {
            Params::$params['root_path'] = realpath(__DIR__ . '/../../..') . '/';
            // Пересчитываем остальные пути
            Params::$params['upload_path'] = Params::$params['root_path'] . Params::$params['upload_dir'] . '/';
            Params::$params['upload_images_path'] = Params::$params['upload_path'] . 'source/images/';
            Params::$params['upload_images_http_path'] = Params::$params['root_path'] . '/' . Params::$params['upload_dir'] . '/thumbs/';
            Params::$params['upload_files_path'] = Params::$params['upload_path'] . 'source/files/';
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true) ?? $_POST;

        $article = $data['text'] ? $this->decodeJson($data['text']) : null;
        $expert = $data['expert'] ? $this->decodeJson($data['expert']) : null;
        $faq = $data['faq'] ? $this->decodeJson($data['faq'])["faq"] : null;
        $metaTitle = $data['seo_title'] ?? null;
        $metaDescription = $data['seo_description'] ?? null;
        $metaKeywords = $data['seo_keywords'] ?? null;
        $imagesData = $data['images'] ?? null;

        // Инициализация объекта Case
        Node_Item::$itemsTable = 'content_case';

        // ID ноды для контента кейсов предоставлен пользователем
        $nodeId = 4226;

        $caseItem = new Node_Item('content_case');
        $caseItem->node = new Node($nodeId);
        $caseItem->title = $article["title"] ?? "";
        $caseItem->alias = Utils::translit($caseItem->title);
        $caseItem->weight = $article["weight"] ?? 0;
        $caseItem->volume = $article["volume"] ?? 0;
        $caseItem->what = $article["cargo"] ?? "";
        $caseItem->task = $article["task"] ?? "";
        $caseItem->solution = $article["solution"] ?? "";
        $caseItem->text = $article["main_text"] ?? "";
        $caseItem->expert_title = $expert["title"] ?? "";
        $caseItem->expert_text = $expert["text"] ?? "";
        $caseItem->faq_a = [];
        $caseItem->faq_q = [];
        $caseItem->meta_title = $metaTitle;
        $caseItem->meta_description = $metaDescription;
        $caseItem->meta_keywords = $metaKeywords;
        $caseItem->prices_title = "";
        $caseItem->public = 0;
        $caseItem->sorter = 1;

        // Обработка изображений
        if ($imagesData) {
            // images может быть JSON строкой
            if (is_string($imagesData)) {
                $imagesData = json_decode($imagesData, true);
            }

            if (is_array($imagesData)) {
                $imageIds = [];

                // Корень проекта (нормализуем слеши)
                $projectRoot = rtrim(str_replace('\\', '/', realpath(__DIR__ . '/../../..')), '/');

                // Папка для оригиналов изображений кейсов (upload/source/images/case/)
                $uploadPath = Params::$params['upload_images_path'] . 'case/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Временная папка для скачивания исходников
                $tmpDir = $projectRoot . '/upload/tmp';
                if (!is_dir($tmpDir)) {
                    mkdir($tmpDir, 0777, true);
                }

                foreach ($imagesData as $img) {
                    $url = is_array($img) ? ($img['url'] ?? null) : $img;
                    if (!$url) {
                        continue;
                    }

                    $url = "https://table.topform.ru" . $url;

                    // Скачиваем картинку
                    $imgContent = @file_get_contents($url);
                    if (empty($imgContent)) {
                        continue;
                    }

                    // Определяем имя и расширение из URL
                    $originalName = basename($url);
                    if (strpos($originalName, '?') !== false) {
                        $originalName = substr($originalName, 0, strpos($originalName, '?'));
                    }
                    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

                    // Определяем реальное расширение по содержимому файла,
                    // т.к. URL (например, Airtable) часто не содержат расширения
                    $detectedExt = null;
                    $imageInfo = @getimagesizefromstring($imgContent);
                    if ($imageInfo !== false && !empty($imageInfo['mime'])) {
                        $mimeToExt = [
                            'image/jpeg' => 'jpg',
                            'image/png' => 'png',
                            'image/gif' => 'gif',
                            'image/webp' => 'webp',
                            'image/bmp' => 'bmp',
                            'image/svg+xml' => 'svg',
                        ];
                        if (isset($mimeToExt[$imageInfo['mime']])) {
                            $detectedExt = $mimeToExt[$imageInfo['mime']];
                        }
                    }

                    if ($detectedExt !== null) {
                        $ext = $detectedExt;
                    } elseif (empty($ext)) {
                        $ext = 'jpg';
                    }

                    // Сохраняем во временный файл с корректным расширением внутри DOCUMENT_ROOT,
                    // т.к. ядро (File::uploadFromServer) делает $_SERVER["DOCUMENT_ROOT"] . $upload
                    // и разбирает путь через explode('/')
                    $tmpName = 'rest_' . uniqid() . '.' . $ext;
                    $tmpAbsPath = $tmpDir . '/' . $tmpName;
                    if (file_put_contents($tmpAbsPath, $imgContent) === false) {
                        continue;
                    }

                    // Подменяем DOCUMENT_ROOT на корень проекта и передаём web-путь
                    $oldDocRoot = $_SERVER['DOCUMENT_ROOT'] ?? '';
                    $_SERVER['DOCUMENT_ROOT'] = $projectRoot;

                    $image = new Image();
                    // uploadFromServer не возвращает true при успехе — проверяем id
                    $image->uploadFromServer('/upload/tmp/' . $tmpName, 'case');

                    $_SERVER['DOCUMENT_ROOT'] = $oldDocRoot;

                    if (!empty($image->id)) {
                        $imageIds[] = $image->id;
                    }

                    if (file_exists($tmpAbsPath)) {
                        @unlink($tmpAbsPath);
                    }
                }

                if (!empty($imageIds)) {
                    $caseItem->images = implode(';', $imageIds);
                    $caseItem->image = $imageIds[0];
                }
            }
        }

        foreach ($faq as $i => $item) {
            $caseItem->faq_a[] = [
                "id" => $i+1,
                "value" => $item["answer"]
            ];

            $caseItem->faq_q[] = [
                "id" => $i+1,
                "value" => $item["question"]
            ];
        }

        $caseItem->faq_q = serialize($caseItem->faq_q);
        $caseItem->faq_a = serialize($caseItem->faq_a);

//        $logData = [
//            'timestamp' => date('Y-m-d H:i:s'),
//            'method' => $_SERVER['REQUEST_METHOD'],
//            'url' => $_SERVER['REQUEST_URI'] ?? '',
//            'vars' => [
//                'faq' => $faq,
//                'raw' => $data['faq'],
//            ],
//            'saved_id' => $caseItem->id
//        ];
//
//        file_put_contents(__DIR__ . '/../../debug.log', print_r($logData, true), FILE_APPEND);

        $caseItem->setFields($caseItem->node->getFields());
        if ($caseItem->validate()) {
            $caseItem->save();
        } else {
            return new Response([
                'status' => 'error',
                'message' => 'Case can not be saved',
                'errors' => $caseItem->errors
            ]);
        }

        return new Response([
            'status' => 'success',
            'message' => 'Case created',
            'id' => $caseItem->id
        ]);
    }

    /**
     * Декодирует JSON-строку, устойчиво обрабатывая «битые» escape-последовательности.
     *
     * Во входящих данных ключ приходит как "main\_text" — обратный слеш перед "_"
     * является недопустимой escape-последовательностью в JSON, из-за чего обычный
     * json_decode() возвращает null. Перед декодированием убираем такие слеши.
     *
     * @param string $json
     * @return array|null
     */
    private function decodeJson($json)
    {
        if (!is_string($json)) {
            return is_array($json) ? $json : null;
        }

        $decoded = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        // Удаляем обратные слеши, которые не являются началом валидной
        // JSON escape-последовательности (\" \\ \/ \b \f \n \r \t \uXXXX).
        $sanitized = preg_replace('/\\\\(?!["\\\\\/bfnrtu])/', '', $json);
        $decoded = json_decode($sanitized, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
    }
}
