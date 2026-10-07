<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:12:39
  from 'file:D:\Apps\OSPanel\home\osteodental.local\templates\adm\content\../../common/page/scheme/index-scheme.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56297c30fc8_48270084',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0783a589e42ad0358698e9b2a63fa83eb49d4e0a' => 
    array (
      0 => 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\../../common/page/scheme/index-scheme.tpl',
      1 => 1772446347,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:scheme/main-area-item.tpl' => 1,
    'file:scheme/area-item.tpl' => 4,
  ),
))) {
function content_69a56297c30fc8_48270084 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\page\\scheme';
?><div class="blocks">
	<div class="blocks__row">
		<?php $_smarty_tpl->renderSubTemplate('file:scheme/main-area-item.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
	</div>

	<div class="blocks__row">
		<?php $_smarty_tpl->renderSubTemplate('file:scheme/area-item.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('area'=>$_smarty_tpl->getValue('areas')['about']), (int) 0, $_smarty_current_dir);
?>
	</div>
    <div class="blocks__row">
        <?php $_smarty_tpl->renderSubTemplate('file:scheme/area-item.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('area'=>$_smarty_tpl->getValue('areas')['rating']), (int) 0, $_smarty_current_dir);
?>
    </div>

    <div class="blocks__row">
        <?php $_smarty_tpl->renderSubTemplate('file:scheme/area-item.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('area'=>$_smarty_tpl->getValue('areas')['rating_footer']), (int) 0, $_smarty_current_dir);
?>
    </div>
    <div class="blocks__row">
        <?php $_smarty_tpl->renderSubTemplate('file:scheme/area-item.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('area'=>$_smarty_tpl->getValue('areas')['feedback_form']), (int) 0, $_smarty_current_dir);
?>
    </div>
</div><?php }
}
