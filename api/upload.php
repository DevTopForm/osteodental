<?php
// upload_handler.php

// 1. Проверяем, что файл был отправлен

if(!empty($_FILES['file-0'])){
    $_FILES['file'] = $_FILES['file-0'];
}

if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'Файл не загружен или произошла ошибка']);
    exit;
}

// 2. Определяем целевую директорию
$targetDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/source/filemanager/';

// 3. Проверяем и создаём директорию, если её нет
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

// 4. Формируем безопасное имя файла
$originalName = basename($_FILES['file']['name']);
$ext = pathinfo($originalName, PATHINFO_EXTENSION);
$safeName = uniqid() . '.' . $ext; // уникальное имя, чтобы избежать перезаписи

// 5. Перемещаем загруженный файл
$targetPath = $targetDir . $safeName;
if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
    echo json_encode(['error' => 'Не удалось сохранить файл на сервере']);
    exit;
}

// 6. Формируем URL для доступа к файлу (относительно корня сайта)
$webPath = '/upload/source/filemanager/' . $safeName;

// 7. Возвращаем ответ в формате, ожидаемом SunEditor
echo json_encode([
    'result' => [
        [
            'url' => $webPath,      // обязательно поле 'url'
            'name' => $safeName,
            'size' => $_FILES['file']['size'],
        ]
    ]
]);