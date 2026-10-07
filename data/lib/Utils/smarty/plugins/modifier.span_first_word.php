<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty span_first_word modifier plugin
 *
 * Type:     modifier<br>
 * Name:     strip_tags<br>
 * Purpose:  strip html tags from text
 * @link http://smarty.php.net/manual/en/language.modifier.strip.tags.php
 *          strip_tags (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @return string
 */
function smarty_modifier_span_first_word($string){
   $words = explode(' ',$string);
   $first = array_shift($words);
   if (mb_strlen($first) <= 3){
	   $first .= ' '.array_shift($words);
   }
   return sprintf('<span>%s</span> %s',$first,join(' ',$words));
}

/* vim: set expandtab: */

?>
