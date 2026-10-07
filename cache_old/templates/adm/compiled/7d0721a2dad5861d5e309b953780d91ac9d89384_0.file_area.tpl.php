<?php
/* Smarty version 5.8.0, created on 2026-03-02 12:11:02
  from 'file:content/area.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a55426681989_94755145',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7d0721a2dad5861d5e309b953780d91ac9d89384' => 
    array (
      0 => 'content/area.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/node-actions.tpl' => 1,
    'file:menu/node-menu.tpl' => 1,
    'file:menu/parent-select.tpl' => 1,
  ),
))) {
function content_69a55426681989_94755145 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?><section class="catalog">
    <?php $_smarty_tpl->renderSubTemplate('file:menu/node-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('node')), (int) 0, $_smarty_current_dir);
?>

    <h1 class="h1 catalog__h1"><?php echo (($tmp = $_smarty_tpl->getValue('node')->title ?? null)===null||$tmp==='' ? "Новый раздел" ?? null : $tmp);?>
</h1>

    <?php $_smarty_tpl->renderSubTemplate('file:menu/node-menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('node'),'active'=>'area'), (int) 0, $_smarty_current_dir);
?>
    <div class="catalog-controls">
        <form class="form  form--980" action="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/copy/<?php echo $_smarty_tpl->getValue('node')->id;?>
" method="post" enctype="multipart/form-data">
            <div class="filter-form__fieldset">
                <div class="label">
                    <span class="label__name">Скопировать блоки с раздела:</span>
                    <div class="status-select js-blocks">
                        <label class="status-select__select-label" style="display: none">
                            <select name="node" class="status-select__select" tabindex="-1">
                                <option value="0" rel="">---</option>
                                <?php $_smarty_tpl->renderSubTemplate('file:menu/parent-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('data')['nodes'],'cur_pid'=>$_smarty_tpl->getValue('item')->parent,'spacer'=>' - '), (int) 0, $_smarty_current_dir);
?>
                            </select>
                            <span class="status-select__select-svg">
                                <svg fill="none" width="12" height="8">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
                                </svg>
                            </span>
                        </label>
                        <div class="status-select__fake" tabindex="0">
                            <span></span>
                            <span class="status-select__select-svg">
                                <svg fill="none" width="12" height="8">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <button name="save" value="<?php echo $_smarty_tpl->getValue('_LNG_ADM')['SEND'];?>
" class="btn btn--blue btn--lg">
                    <span>Применить</span>
                </button>
            </div>
        </form>
    </div>

    <?php $_smarty_tpl->renderSubTemplate(('../../common/page/scheme/').($_smarty_tpl->getValue('node')->template->scheme_file), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('areas'=>$_smarty_tpl->getValue('list')), (int) 0, $_smarty_current_dir);
?>
</section>
<?php }
}
