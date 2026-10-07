<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:service/breadcrumbs.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cf7b66a9_97880368',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b1b36f7974802f8ce1a238043032ef5ce8962f26' => 
    array (
      0 => 'service/breadcrumbs.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a592cf7b66a9_97880368 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\service';
if ($_smarty_tpl->getValue('list') && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('list')) > 1) {?>
    <div class="bread">
        <div class="container">
            <ul class="bread__list" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item', false, NULL, 'bc', array (
  'last' => true,
  'first' => true,
  'iteration' => true,
  'index' => true,
  'total' => true,
));
$foreach22DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach22DoElse = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['iteration']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['index'];
$_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['last'] = $_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['iteration'] === $_smarty_tpl->tpl_vars['__smarty_foreach_bc']->value['total'];
?>
                    <?php if (($_smarty_tpl->getValue('__smarty_foreach_bc')['last'] ?? null)) {
break 1;
}?>
                    <li class="bread__it" itemprop="itemListElement" itemscope="itemscope"
                        itemtype="https://schema.org/ListItem">
                        <a href="<?php echo $_smarty_tpl->getValue('item')['url'];?>
" class="bread__link" itemprop="item">
                            <?php if (($_smarty_tpl->getValue('__smarty_foreach_bc')['first'] ?? null)) {?>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 11" width="10"
                                     height="11">
                                    <path fill="currentColor"
                                          d="M8.75 4.965v3.973a.73.73 0 0 1-.183.485.6.6 0 0 1-.442.202h-6.25a.6.6 0 0 1-.442-.202.73.73 0 0 1-.183-.486V4.966q0-.145.054-.279a.7.7 0 0 1 .15-.23L4.58 1.33A.6.6 0 0 1 5 1.15c.156 0 .306.064.421.18l3.125 3.125a.7.7 0 0 1 .151.23.8.8 0 0 1 .054.279"></path>
                                </svg>
                            <?php }?>
                            <?php echo $_smarty_tpl->getValue('item')['title'];?>

                            <meta itemprop="position" content="<?php echo ($_smarty_tpl->getValue('__smarty_foreach_bc')['iteration'] ?? null);?>
">
                        </a>
                    </li>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </ul>
        </div>
    </div>
<?php }
}
}
