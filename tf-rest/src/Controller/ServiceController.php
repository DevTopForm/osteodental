<?php

namespace TFRest\Controller;

use Query;
use Params;
use TFRest\CRUDController;
use TFRest\Response;
use Node_Item;
use Image;
use Node;
use Node_Template;
use Node_Type_Template;
use Node_Type;
use Utils;

class ServiceController extends CRUDController
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

        $nodeImagesRaw = $data['images'] ?? [];
        $blockImagesRaw = $data['h2_images'] ?? [];

        // Нормализация: каждая строка → массив
        $normalize = function ($value) {
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                return is_array($decoded) ? $decoded : [];
            }
            return is_array($value) ? $value : [];
        };

        $nodeImagesData = [];
        foreach ((array)$nodeImagesRaw as $item) {
            $parsed = $normalize($item);
            if (isset($parsed[0]) && is_array($parsed[0])) {
                $nodeImagesData = array_merge($nodeImagesData, $parsed); // массив объектов
            } elseif (!empty($parsed)) {
                $nodeImagesData[] = $parsed; // единичный объект
            }
        }

        $blockImagesData = [];
        foreach ((array)$blockImagesRaw as $item) {
            $parsed = $normalize($item);
            if (isset($parsed[0]) && is_array($parsed[0])) {
                $blockImagesData = array_merge($blockImagesData, $parsed);
            } elseif (!empty($parsed)) {
                $blockImagesData[] = $parsed;
            }
        }

        $imagesData = array_merge($nodeImagesData, $blockImagesData);


        // Инициализация объекта Case
        Node_Item::$itemsTable = 'content_services';

        // ID ноды для контента кейсов предоставлен пользователем
        $nodeId = 4215;

        $caseItem = new Node_Item('content_services');
        $caseItem->node = new Node($nodeId);
        $caseItem->title = $article["subject"] ?? "";
        $caseItem->alias = Utils::translit($caseItem->title);
        $caseItem->h1 = $article["title"] ?? "";
        $caseItem->subtitle = $article["subtitle"] ?? "";
        $caseItem->weight = "от 30 кг";
        $caseItem->deadline = $article["time"] ?? "";

        if (count($article["prices"])) {
            $caseItem->price = end($article["prices"]);
        }

        $caseItem->text1_2 = $article["text1_2"] ?? "";
        $caseItem->text2_1 = $article["text2_1"] ?? "";
        $caseItem->feedback_title = $article["form1_title"] ?? "";
        $caseItem->prices_title = $article["prices_title"] ?? "";
        $caseItem->expert_title = $expert["title"] ?? "";
        $caseItem->expert_text = $expert["text"] ?? "";
        $caseItem->meta_title = $metaTitle;
        $caseItem->meta_description = $metaDescription;
        $caseItem->meta_keywords = $metaKeywords;
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

                $i = 1;
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
                        $arrIndex = "node";
                        if ($i > count($nodeImagesData)) {
                            $arrIndex = "content";
                        }

                        if (!is_array($imageIds[$arrIndex])) {
                            $imageIds[$arrIndex] = [];
                        }

                        $imageIds[$arrIndex][] = $image->id;
                    }

                    if (file_exists($tmpAbsPath)) {
                        @unlink($tmpAbsPath);
                    }

                    $i++;
                }

                if (!empty($imageIds)) {
                    if (!empty($imageIds["node"])) {
                        $caseItem->bnr_image = $imageIds["node"][0];
                    }

                    if (!empty($imageIds["content"])) {
                        $caseItem->text_image1 = $imageIds["content"][0];
                    }
                }
            }
        }


        if (!empty($article["prices"])) {
            $faqNode = new Node();
            $faqNode->parent = 4158;
            $faqNode->alias = Utils::translit($article["title"] . "-prices-" . time());
            $faqNode->redirect = '';
            $faqNode->public = 1;
            $faqNode->template = new Node_Template(2);
            $faqNode->content_template = new Node_Type_Template(209);
            $faqNode->type = Node_Type::getByKey('type', 'cost');
            $faqNode->title = $article["title"];
            $faqNode->nomenu = 1;
            $faqNode->sitemap = 0;
            $faqNode->nosearch = 1;
            $faqNode->passworded = 0;
            $faqNode->weight = 0;
            $faqNode->menutitle = "";
            $faqNode->meta_title = "";
            $faqNode->meta_keywords = "";
            $faqNode->meta_description = "";
            $faqNode->h1 = "";

            if ($faqNode->validate()) {
                $faqNode->save();

                $i = 0;
                $weightsArr = ["30-55 кг", "55-250 кг", "250-500 кг", "500-1000 кг", "от 1 тонны"];
                foreach ($article["prices"] as $item) {
                    $faqItem = new Node_Item('content_cost');
                    $faqItem->node = $faqNode;
                    $faqItem->title = $article["title"] . " " . $weightsArr[$i++];
                    $faqItem->price = $item;
                    $faqItem->public = 1;
                    Query::$post["public"] = 1;

                    foreach ($faqItem->node->getFields() as $field) {
                        $fieldName = $field->name;

                        if (empty($faqItem->$fieldName)) {
                            $faqItem->$fieldName = "";
                        }
                    }

                    $faqItem->setFields($faqItem->node->getFields());

                    if ($faqItem->validate()) {
                        $faqItem->save();
                    }
                }

                // multiselect ждёт список с завершающей запятой, multisel2area — без неё,
                // иначе в Module_Cost::getCost() получим 'id IN(4159,)'
                $caseItem->cost_node = $this->getFieldType($caseItem, 'cost_node') === 'multisel2area'
                    ? (string)$faqNode->id
                    : $faqNode->id . ",";
            }
        }


        $faqItemIds = [];
        if (!empty($faq)) {
            $faqNode = new Node(4180);
            foreach ($faq as $item) {
                $faqItem = new Node_Item('content_faq');
                $faqItem->node = $faqNode;
                $faqItem->title = $item["question"];
                $faqItem->answer = $item["answer"];
                $faqItem->public = 1;
                Query::$post["public"] = 1;

                foreach ($faqItem->node->getFields() as $field) {
                    $fieldName = $field->name;

                    if (empty($faqItem->$fieldName)) {
                        $faqItem->$fieldName = "";
                    }
                }

                $faqItem->setFields($faqItem->node->getFields());

                if ($faqItem->validate()) {
                    $faqItem->save();
                    $faqItemIds[] = $faqItem->id;
                }
            }
        }

        if ($faqItemIds) {
            $caseItem->faq = implode(",", $faqItemIds);
        }


        foreach ($caseItem->node->getFields() as $field) {
            $fieldName = $field->name;

            if (empty($caseItem->$fieldName)) {
                $caseItem->$fieldName = "";
            }
        }

        $caseItem->setFields($caseItem->node->getFields());

        // Выше Query::$post["public"] выставлялся для дочерних записей (faq/prices).
        // Form_Checkbox::setQueryValue() читает его безусловно, поэтому возвращаем
        // услуге её собственный флаг публикации, иначе черновик ($caseItem->public = 0)
        // был бы опубликован сразу.
        Query::$post["public"] = $caseItem->public;

        if ($caseItem->validate()) {
            $caseItem->save();
        } else {
            return new Response([
                'status' => 'error',
                'message' => 'Case can not be saved',
                'errors' => $caseItem->errors,
                'messages' => $caseItem->messages
            ]);
        }

        return new Response([
            'status' => 'success',
            'message' => 'Case created',
            'id' => $caseItem->id
        ]);
    }

    /**
     * Возвращает тип поля (multiselect, multisel2area и т.д.) по его имени.
     *
     * @param Node_Item $item
     * @param string $name
     * @return string|null
     */
    private function getFieldType(Node_Item $item, string $name)
    {
        foreach ($item->node->getFields() as $field) {
            if ($field->name === $name) {
                return $field->getTypeField();
            }
        }

        return null;
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
