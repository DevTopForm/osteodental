<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/multitext.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6e71931_21527661',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bac82fddc873ba17d1c94d9a561414fdd4caa0b1' => 
    array (
      0 => 'content/fields/multitext.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6e71931_21527661 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

        <?php if ($_smarty_tpl->getValue('field')->example) {?>
            <span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
        <?php }?>
    </div>
    <div class="label__wrapper-labels field-multiselect field-multiselect-<?php echo $_smarty_tpl->getValue('field')->name;?>
">
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('field')->getSpecValue()) > 0) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')->getSpecValue(), 'text');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('text')->value) {
$foreach0DoElse = false;
?>
                <div class="input-yt">
                    <label class="check input-yt__check">
                        <input class="check__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
_delete[]" value="<?php echo $_smarty_tpl->getValue('text')['id'];?>
" type="checkbox">
                        <span class="check__name">выбрать элемент</span>
                    </label>
                    <label class="input-yt__label">
                        <input type="text" class="input-yt__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
[<?php echo $_smarty_tpl->getValue('text')['id'];?>
]"
                               value="<?php echo $_smarty_tpl->getValue('text')['value'];?>
">
                    </label>
                    <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
                        <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
                    <?php }?>
                </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <?php } else { ?>
            <div class="input-yt">
                <label class="check input-yt__check">
                    <input class="check__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
_delete[]" value="1" type="checkbox">
                    <span class="check__name">выбрать элемент</span>
                </label>
                <label class="input-yt__label">
                    <input type="text" class="input-yt__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
[]"
                           value="">
                </label>
            </div>
        <?php }?>

        <div class="label__wrapper-btns">
            <div class="btn btn--lg btn--light field-multiselect__add js-add-multitext-line">
                <svg fill="none" width="16" height="16">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
                </svg>
                <span>Добавить элемент</span>
            </div>
            <div class="btn btn--lg btn--bd field-multiselect__remove js-remove-multitext-line">
                <span>Удалить</span>
            </div>

            <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
                <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
            <?php }?>
        </div>
    </div>
</div>


<?php echo '<script'; ?>
 type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        const fieldName = "<?php echo $_smarty_tpl->getValue('field')->name;?>
";
        let newKey = parseInt("<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('field')->getSpecValue()) > 0) {
echo $_smarty_tpl->getSmarty()->getModifierCallback('max')($_smarty_tpl->getSmarty()->getModifierCallback('array_keys')($_smarty_tpl->getValue('field')->getSpecValue()));
} else { ?>1<?php }?>", 10) + 1;
        const valuesContainer = document.querySelector(".field-multiselect-" + fieldName);
        const addBtn = valuesContainer.querySelector(".js-add-multitext-line");
        const removeBtn = valuesContainer.querySelector(".js-remove-multitext-line");

        addBtn.addEventListener("click", function () {
            const btns = valuesContainer.querySelector(".label__wrapper-btns");
            // valuesContainer.insertBefore("123", btns);
            btns.insertAdjacentHTML('beforebegin',
                `<div class="input-yt">
                    <label class="check input-yt__check">
                        <input class="check__input" name="${fieldName}_delete[]" value="${newKey}" type="checkbox">
                        <span class="check__name">выбрать элемент</span>
                    </label>
                    <label class="input-yt__label">
                        <input type="text" class="input-yt__input" name="${fieldName}[${newKey}]"
                               value="">
                    </label>
                </div>`);

            newKey += 1;
        })

        removeBtn.addEventListener("click", function () {
            const checked = valuesContainer.querySelectorAll("input[type=checkbox]:checked");
            checked.forEach((input) => {
               input.closest(".input-yt").remove();
            });
        });
    });
<?php echo '</script'; ?>
>
<?php }
}
