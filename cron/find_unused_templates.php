<?php

chdir(dirname(dirname(__FILE__)));
set_include_path(realpath('data/lib') . PATH_SEPARATOR . get_include_path());
include('data/init.php');
//ini_set('display_errors', 1);

if (!empty($_POST['PHPSESSID'])) {
    session_id($_POST['PHPSESSID']);
}
session_start();

try {
    $user = Admin_LoginManager::getLoggedUser();
} catch (Exception $e) {
    Utils::redirect("/adm");
}

if (!empty(Query::$post["delete"]) && is_array(Query::$post["delete"])) {
    foreach (Query::$post["delete"] as $id) {
        $template = new Node_Type_Template((int)$id);
        $dir = Params::$params['root_path'] . 'templates/common/module/' . $template->type . "/";
        unlink($dir . $template->file);
        $template->delete();
        if (count(scandir($dir)) == 2) {
            rmdir($dir);
        }
    }
}

$db = Zend_Registry::get('db');
$unusedTemplatesInAreas = $db->fetchAll(
    "SELECT t1.id FROM nodes_types_templates t1 LEFT JOIN nodes_areas t2 ON t2.template = t1.id WHERE t2.template IS NULL"
);
$unusedTemplatesInNodes = $db->fetchAll(
    "SELECT t1.id FROM nodes_types_templates t1 LEFT JOIN nodes t2 ON t2.content_template = t1.id WHERE t2.content_template IS NULL"
);

$unusedTemplatesInAreas = array_map(function ($el) {
    return (array_shift($el));
}, $unusedTemplatesInAreas);
$unusedTemplatesInNodes = array_map(function ($el) {
    return (array_shift($el));
}, $unusedTemplatesInNodes);

$unusedTemplatesIds = array_intersect($unusedTemplatesInAreas, $unusedTemplatesInNodes);
foreach ($unusedTemplatesIds as $id) {
    $template = new Node_Type_Template($id);

    $type = Node_Type::getByKey("type", $template->type);
    if (!empty($type->id)) {
        $template->type = $type;
    }

    $unusedTemplates[] = $template;
}
?>

<div>
    Всего: <?= count($unusedTemplates) ?>
</div>
<form action="" method="post">
    <div>
        <div style="margin-bottom: 15px; color: black;">
            <label for="all">
                <input type="checkbox" onchange="toggle(this)" name="delete[]" id="all">Выбрать все
            </label>
        </div>
        <?
        foreach ($unusedTemplates as $template): ?>
            <div style="margin-bottom: 15px;">
                <label for="<?= $template->id ?>">
                    <input type="checkbox" name="delete[]" id="<?= $template->id ?>" value="<?= $template->id ?>">
                    <a target="_blank" href="/adm/modtpl/edit/<?= $template->type->id ?>/<?= $template->id ?>"
                       style="color: black; text-decoration: none;"><?= $template->title . "(" . $template->file . ") - " . $template->type->title ?></a>
                </label>
            </div>
        <?
        endforeach; ?>
    </div>

    <button type="submit">Удалить</button>
</form>

<script>
    function toggle(source) {
        checkboxes = document.querySelectorAll("input[name='" + source.name + "']");
        console.log(checkboxes)
        console.log(source.checked)
        checkboxes.forEach((checkbox) => {
            checkbox.click();
        })
    }
</script>