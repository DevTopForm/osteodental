<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:page/blocks/meta.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cf7d9144_30360464',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce1d49afc37cb1fd05da6f2549bfd7a5d955e56f' => 
    array (
      0 => 'page/blocks/meta.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a592cf7d9144_30360464 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\page\\blocks';
?><meta charset="UTF-8">

<title><?php if ($_smarty_tpl->getValue('node')->meta_title) {
echo $_smarty_tpl->getValue('node')->meta_title;
} else {
echo $_smarty_tpl->getValue('node')->title;
}?></title>
<meta name="keywords" content="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('node')->meta_keywords, ENT_QUOTES, 'UTF-8', true);?>
"/>
<meta name="description" content="<?php echo $_smarty_tpl->getValue('node')->meta_description;?>
"/>

<meta property="og:type" content="website">
<meta property="og:title" content="<?php if ($_smarty_tpl->getValue('node')->meta_title) {
echo $_smarty_tpl->getValue('node')->meta_title;
} else {
echo $_smarty_tpl->getValue('node')->title;
}?>">
<meta property="og:description" content="<?php echo $_smarty_tpl->getValue('node')->meta_description;?>
">
<meta property="og:image" content="/htdocs/img/logo-inner.png">
<meta property="og:url" content="<?php if ($_smarty_tpl->getValue('node')->id) {
echo $_smarty_tpl->getValue('node')->getUrl();
}?>">

<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
<?php if (!( !true || empty($_smarty_tpl->getValue('node')->noindex))) {?>
    <meta name="<?php echo $_smarty_tpl->getValue('node')->noindex;?>
" content="noindex,follow">
<?php }?>

<?php if (!( !true || empty($_smarty_tpl->getValue('node')->canonical))) {?>
    <link rel="canonical" href="<?php echo $_smarty_tpl->getValue('params')['site']['protocol'];
echo $_smarty_tpl->getValue('params')['site']['host'];
echo $_smarty_tpl->getValue('node')->canonical;?>
"/>
<?php }?>

<link rel="icon" href="<?php echo $_smarty_tpl->getValue('favicon');?>
" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $_smarty_tpl->getValue('favicon');?>
" type="image/x-icon">
<link rel="stylesheet" href="/htdocs/assets/build/css/style.css"><?php }
}
