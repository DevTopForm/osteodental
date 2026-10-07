<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:menu/structure.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe53f3d3_23701186',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '240c27d1d58b88802849d77a2122707eec81c4ce' => 
    array (
      0 => 'menu/structure.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/structure.tpl' => 2,
  ),
))) {
function content_69e893fe53f3d3_23701186 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('tree'), 'item');
$foreach10DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach10DoElse = false;
?>
    <?php if ($_smarty_tpl->getValue('user')->role == 'sadmin' || !$_smarty_tpl->getValue('item')['sadmin']) {?>
        <li class="menu__item <?php if ($_smarty_tpl->getValue('node')->id == $_smarty_tpl->getValue('item')['id']) {?>active<?php }?> <?php if ($_smarty_tpl->getValue('item')['expanded']) {?>opened<?php }?>"
            data-position="<?php echo $_smarty_tpl->getValue('item')['id'];?>
" <?php if ($_smarty_tpl->getValue('item')['childs']) {?>draggable="false"<?php }?>>
			<span class="menu__span">
				<span class="js-handle" tabindex="0">
                    <svg fill="none" width="7" height="13">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots2"></use>
                    </svg>
                </span>
				<a href="/adm/content/list/<?php echo $_smarty_tpl->getValue('item')['id'];?>
" class="menu__link" title="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')['title'], ENT_QUOTES, 'UTF-8', true);?>
">
					<span class="menu__name"><?php echo $_smarty_tpl->getValue('item')['title'];?>
</span>
				</a>

				<?php if ($_smarty_tpl->getValue('item')['childs']) {?>
                    <button class="btn menu__toggler js-menu-toggler">
					  <svg fill="none" width="12" height="7">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
					  </svg>
					</button>
                <?php }?>
			</span>

            <?php if ($_smarty_tpl->getValue('item')['childs']) {?>
                <ul class="menu__subs">
                    <?php $_smarty_tpl->renderSubTemplate('file:menu/structure.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('item')['childs']), (int) 0, $_smarty_current_dir);
?>
                </ul>
            <?php }?>
        </li>
    <?php }
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
