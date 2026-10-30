<?php

namespace App\Converter;

class Webp
{
    private $destinationDir;
    private $quality;

    public function __construct($destinationDir, $quality = 80)
    {
        $this->destinationDir = $destinationDir;
        $this->quality = $quality;
        $this->ensureDirectoryExists();
    }

    private function ensureDirectoryExists()
    {
        if (!file_exists($this->destinationDir)) {
            mkdir($this->destinationDir, 0777, true);
        }
    }

    public function convert($imageUrl, $customFilename = null)
    {
        $imageData = $this->downloadImage($imageUrl);
        $sourceImage = $this->createImageFromData($imageData);
        $filename = pathinfo($imageUrl, PATHINFO_FILENAME) . '.webp';
        $outputPath = $this->destinationDir . DIRECTORY_SEPARATOR . $filename;

        $this->saveAsWebP($sourceImage, $outputPath);
        imagedestroy($sourceImage);

        return [
            'path' => $outputPath,
            'filename' => $filename,
            'size' => filesize($outputPath),
            'url' => $imageUrl
        ];
    }

    private function downloadImage($url)
    {
        return file_get_contents($url);
    }

    private function createImageFromData($data)
    {
        $image = imagecreatefromstring($data);
        if (!$image) {
            throw new \Exception("Не удалось создать изображение из данных");
        }

        // Сохраняем прозрачность
        imagepalettetotruecolor($image);
        imagealphablending($image, true);
        imagesavealpha($image, true);

        return $image;
    }

    private function generateFilename($customFilename)
    {
        if ($customFilename) {
            return pathinfo($customFilename, PATHINFO_FILENAME) . '.webp';
        }
        return uniqid() . '.webp';
    }

    private function saveAsWebP($image, $path)
    {
        if (!imagewebp($image, $path, $this->quality)) {
            throw new Exception("Ошибка сохранения WebP файла");
        }
    }
}