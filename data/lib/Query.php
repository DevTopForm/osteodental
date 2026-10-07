<?php

namespace App;

class Query
{
    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static $get;

    public static $post;

    public static $files;

    public static $request;

    private static $areas = array();

    public static function init()
    {
        $files = self::rebuild_files_array();
        self::$get = $_GET;
        self::$post = $_POST;
        self::$files = $files;
        self::$request = array_merge($_GET, $_POST, $files);

        foreach (self::$request as $k => $v) {
            $tmpV = explode('_', $k);

            if (preg_match('/^(.*)\_(\d+)$/', $k, $m)) {
                self::$areas[$m[2]][$m[1]] = $v;
            }
        }
    }

    public static function area($key, $get = false)
    {
        $area = isset(self::$areas[$key]) ? self::$areas[$key] : null;

        if ($get) {
            foreach ($area as $k => $v) {
                if (!isset($_GET[$k])) {
                    unset($area[$k]);
                }
            }
        }

        return $area;
    }

    private static function rebuild_files_array()
    {
        $files = array();

        foreach ($_FILES as $var => $file) {
            if (is_array($file['name'])) {
                foreach ($file['name'] as $k => $v) {
                    if ($file['name'][$k] && is_string($file['name'][$k])) {
                        $file_parts = explode('.', $file['name'][$k]);
                        $ext = (count($file_parts) > 1) ? array_pop($file_parts) : '';
                        $files[$var][$k] = [
                            'name' => $file['name'][$k],
                            'mime' => $file['type'][$k],
                            'extension' => $ext,
                            'tmp_name' => $file['tmp_name'][$k],
                            'error' => $file['error'][$k],
                            'size' => $file['size'][$k]
                        ];
                    } elseif ($file['name'][$k] && is_array($file['name'][$k])) {
                        foreach ($file['name'][$k] as $fieldId => $fileName) {
                            $file_parts = explode('.', $fileName);
                            $ext = (count($file_parts) > 1) ? array_pop($file_parts) : '';
                            $files[$var][$k][$fieldId] = [
                                'name' => $file['name'][$k][$fieldId],
                                'mime' => $file['type'][$k][$fieldId],
                                'extension' => $ext,
                                'tmp_name' => $file['tmp_name'][$k][$fieldId],
                                'error' => $file['error'][$k][$fieldId],
                                'size' => $file['size'][$k][$fieldId]
                            ];
                        }
                    }
                }
            } else {
                $file_parts = explode('.', $file['name']);
                $ext = (count($file_parts) > 1) ? array_pop($file_parts) : '';
                $files[$var] = array(
                    'name' => $file['name'],
                    'mime' => $file['type'],
                    'extension' => $ext,
                    'tmp_name' => $file['tmp_name'],
                    'error' => $file['error'],
                    'size' => $file['size']
                );
            }
        }

        return $files;
    }
}
