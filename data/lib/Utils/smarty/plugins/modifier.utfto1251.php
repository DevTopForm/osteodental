<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

function smarty_modifier_utfto1251($string)
{
    return iconv('UTF-8','WINDOWS-1251',$string);
}

?>
