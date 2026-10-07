<?php

namespace App;

class File extends Attach
{

    protected $table = 'uploaded_files';
    protected $allowed_ext = array();

    protected $isCachable = true;
    protected $cacheTime = 86400;

    public $params = array();
    public $zip = '.zip';

    public function __construct($id = 0)
    {
        $settings = Registry::get('settings');
        $this->params = $settings->getSiteParams();
        return parent::__construct($id);
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function upload($upload, $type = '', $zip = false)
    {
        if ($upload['error'] == 0) {
            $this->extension = strtolower(
                isset($upload['extension']) ? $upload['extension'] : array_pop(explode('.', $upload['name']))
            );
            $this->size = $upload['size'];
            $this->title = empty($upload['title']) ? '' : $upload['title'];
            $this->alt = empty($this->alt['title']) ? '' : $this->alt['title'];
            $this->description = empty($upload['description']) ? '' : $upload['description'];
            $this->node_type = empty($this->params['node_type']) ? $type : $this->params['node_type'];
            $this->name = $this->getPossibleName($upload['name']);
            $path = $this->getUploadPath($this->node_type) . '/' . $this->name;
            $this->src_name = Utils::translit(
                    basename($upload['name'], '.' . $this->extension)
                ) . '.' . $this->extension;
            if ($this->validate()) {
                if (move_uploaded_file($upload['tmp_name'], $path)) {
                    if ($zip) {
                        if ($this->afterUploadFile($path, $this->node_type)) {
                            $this->save();
                        } else {
                            unlink($path);
                            return false;
                        }
                    } else {
                        $this->save();
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function uploadFromServer($upload, $type = '', $zip = false)
    {
        $file = $_SERVER["DOCUMENT_ROOT"] . $upload;
        if (is_readable($file)) {
            $this->node_type = empty($this->params['node_type']) ? $type : $this->params['node_type'];
            $arPath = explode('/', $file);
            $fileName = array_pop($arPath);
            $arName = explode('.', $fileName);
            $this->extension = array_pop($arName);
            $onlyName = array_pop($arName);
            $this->size = filesize($file);
            $this->title = '';
            $this->alt = '';
            $this->description = empty($upload['description']) ? '' : $upload['description'];
            $this->name = $this->getPossibleName($onlyName);
            $this->src_name = Utils::translit(basename($onlyName, '.' . $this->extension)) . '.' . $this->extension;
            $path = $this->getUploadPath($this->node_type) . $this->name;
            if ($this->validate()) {
                if (copy($file, $path)) {
                    if ($zip) {
                        if ($this->afterUploadFile($path, $this->node_type)) {
                            $this->save();
                        } else {
                            unlink($path);
                            return false;
                        }
                    } else {
                        $this->save();
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function validate()
    {
        $valid = true;
        if (!empty($this->allowed_ext) && !in_array($this->extension, $this->allowed_ext)) {
            $this->errors[] = new Message('Недопустимое расширение файла: ' . $this->extension, 'error');
            $valid = false;
        }
        if (!empty($this->params['max_upload_size']) && !empty($this->size)) {
            if ($this->size > ($this->params['max_upload_size'] * 1024 * 1024)) {
                $this->errors[] = new Message(
                    'Максимальный размер файла ' . $this->params['max_upload_size'] . ' Мб',
                    'error'
                );
                $valid = false;
            }
        }
        return $valid;
    }

    public function afterUploadFile($path, $node_type)
    {
        $zip = new \ZipArchive();
        $zipName = $path . ".zip";

        if ($zip->open($zipName, \ZipArchive::CREATE) !== true) {
            $this->messages[] = new Message('Ошибка создания архива', 'error');
            return false;
        }

        //добавляем файл в архив
        $arFilePath = explode('/', $path);
        $fileName = array_pop($arFilePath);
        $fileInArchiveName = explode($path, $fileName);
        $fileInArchiveName = $fileInArchiveName[0];
        $zip->addFile($path, $fileInArchiveName);
        $zip->close();
        unlink($path);

        return true;
    }

    public function download()
    {
        $path = $this->getUploadPath() . $this->name;
        if (($this->id > 0) && is_file($path)) {
            header('Content-type: ' . $this->mime);
            header('Content-Disposition: attachment; filename=' . $this->src_name);
            header('Content-Transfer-Encoding: binary');
            header('Pragma: no-cache');
            header('Expires: 0');
            readfile($path);
            exit;
        }
    }

    public function getContent()
    {
        $path = $this->getUploadPath() . $this->name;
        $zipFile = $path . '.zip';
        if (($this->id > 0) && is_file($zipFile)) {
            //Выводим содержисое файла из архива
            $zip = new \ZipArchive;
            if ($zip->open($zipFile) === true) {
                $fileInArchiveName = explode($path, array_pop(explode('/', $path)));
                $content = $zip->getFromName($fileInArchiveName[0]);
                $zip->close();
                return $content;
            }
        }
        return null;
    }

    public function prepareDelete()
    {
        $path = $this->getUploadPath($this->node_type) . $this->name . $this->zip;
        if (is_file($path)) {
            unlink($path);
        }
    }

    public function getUploadPath($type = '')
    {
        return Params::$params['upload_files_path'];
    }

    protected function genRNDName($extension)
    {
        return uniqid(time()) . '.' . $extension;
    }

    protected function getPossibleName($realname)
    {
        $filename = Utils::translit(
                empty($this->params['file_title']) ? (basename(
                    $realname,
                    '.' . $this->extension
                )) : $this->params['file_title']
            ) . '_' . substr(uniqid(), 0, 6);
        $i = 0;
        $filepath = $filename;
        while (file_exists($this->getUploadPath($this->node_type) . $filename . '.' . $this->extension)) {
            $filename = $filepath . '_' . ++$i;
        }
        return $filename . '.' . $this->extension;
    }

    public static function getVar($name)
    {
        $fields = get_class_vars(__CLASS__);
        return $fields[$name];
    }

    public function getLink($type = 'default', $url = true)
    {
        return $this->getUploadHttp() . $this->name;
    }

    public function getUploadHttp()
    {
        return Params::$params['upload_files_http'] . "/";
    }

    public function getNonZipLink($type = '', $url = true)
    {
        $path = $this->getUploadHttpPath($type, $this->node_type) . $this->name;
        if (!is_file($path)) {
            $this->resize($type);
            if (!is_file($path)) {
                return '';
            }
        }
        return ($url) ? $this->getUploadHttp($type, $this->node_type) . $this->name : $path;
    }

    protected function getFileHash()
    {
        return substr(md5(sprintf('%s;%s;%s', $this->id, $this->name, $this->extension)), 0, 8);
    }

    public function checkHash($hash)
    {
        $file = $this->getFileHash();
        return $file == $hash;
    }

    public function isImage()
    {
        return in_array(strtolower($this->extension), array('jpg', 'jpeg', 'gif', 'png', 'svg', 'webp', 'avif'));
    }

    // формирование данных объекта для вставки в базу
    protected function getData()
    {
        $data = array(
            'title' => empty($this->title) ? '' : $this->title,
            'node_type' => empty($this->node_type) ? '' : $this->node_type,
            'src_name' => empty($this->src_name) ? '' : $this->src_name,
            'name' => empty($this->name) ? '' : $this->name,
            'mime' => empty($this->mime) ? '' : $this->mime,
            'size' => empty($this->size) ? 0 : $this->size,
            'extension' => empty($this->extension) ? '' : $this->extension,
            'description' => empty($this->description) ? '' : $this->description,
            'crop' => empty($this->crop) ? '' : $this->crop,
        );
        return $data;
    }

    public function copy($url, $node_type)
    {
        $img = file_get_contents($url);
        if (empty($img)) {
            return null;
        }
        $file = array();
        $file['name'] = basename($url);
        $file['extension'] = strtolower(array_pop(explode('.', $file['name'])));
        $filename = $this->getPossibleName($url, $node_type) . $file['extension'];
        $path = $this->getUploadPath($node_type) . $filename;
        $name = basename($file['name'], '.' . $file['extension']);
        file_put_contents($path, $img);
//        $size = getimagesize($path);

        $db = Registry::get('db');
        $data = array(
            'src_name' => Utils::translit($name) . '.' . $file['extension'],
            'name' => $filename,
            'node_type' => $node_type,
            'mime' => mime_content_type($path),
            'extension' => $file['extension'],
            'title' => '',
            'description' => '',
        );

        $insert = $db->sql->insert();
        $insert->into($this->table);
        $insert->columns(array_keys($data));
        $insert->values($data);
        $db->query($db->sql->buildSqlString($insert), $db::QUERY_MODE_EXECUTE);
        $this->id = $db->getDriver()->getConnection()->getLastGeneratedValue();

        $this->loadData();
    }
}
