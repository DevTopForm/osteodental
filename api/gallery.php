<?php

header('Content-Type: application/json');

$sourceDir = dirname(__DIR__) . '/upload/source/filemanager/';
$baseHttpPath = '/upload/source/filemanager/';

$data = [];

if (is_dir($sourceDir)) {
    $files = scandir($sourceDir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..' || is_dir($sourceDir . $file)) {
            continue;
        }

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];

        if (in_array($extension, $allowedExtensions)) {
            $nameWithoutExt = pathinfo($file, PATHINFO_FILENAME);
            // Преобразуем имя для красоты, например "image_1" -> "Image 1"
            $formattedName = ucwords(str_replace(['_', '-'], ' ', $nameWithoutExt));

            $data[] = [
                "src" => $baseHttpPath . $file,
                "thumbnail" => $baseHttpPath . $file,
                "name" => $formattedName
            ];
        }
    }
}

echo json_encode(["result" => $data], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
