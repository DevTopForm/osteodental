<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Include the {@link shared.make_timestamp.php} plugin
 */
require_once $smarty->_get_plugin_filepath('shared', 'make_timestamp');
/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     date_format<br>
 * Purpose:  format datestamps via strftime<br>
 * Input:<br>
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
function smarty_modifier_date_format($string, $format = '%b %e, %Y', $default_date = '')
{
    if ($string != '') {
        $timestamp = smarty_make_timestamp($string);
    } elseif ($default_date != '') {
        $timestamp = smarty_make_timestamp($default_date);
    } else {
        return;
    }
	$months = array (
		'01' => 'января',
		'02' => 'февраля',
		'03' => 'марта',
		'04' => 'апреля',
		'05' => 'мая',
		'06' => 'июня',
		'07' => 'июля',
		'08' => 'августа',
		'09' => 'сентября',
		'10' => 'октября',
		'11' => 'ноября',
		'12' => 'декабря'
	);

	$months_i = array (
		'01' => 'Январь',
		'02' => 'Февраль',
		'03' => 'Март',
		'04' => 'Апрель',
		'05' => 'Май',
		'06' => 'Июнь',
		'07' => 'Июль',
		'08' => 'Август',
		'09' => 'Сентябрь',
		'10' => 'Октябрь',
		'11' => 'Ноябрь',
		'12' => 'Декабрь'
	);
	
	$months_short = array (
		'01' => 'янв',
		'02' => 'фев',
		'03' => 'мар',
		'04' => 'апр',
		'05' => 'май',
		'06' => 'июн',
		'07' => 'июл',
		'08' => 'авг',
		'09' => 'сен',
		'10' => 'окт',
		'11' => 'ноя',
		'12' => 'дек'
	);

	$days_short = array (
		'1' => 'пн',
		'2' => 'вт',
		'3' => 'ср',
		'4' => 'чт',
		'5' => 'пт',
		'6' => 'сб',
		'0' => 'вс',
	);
	
	$days_full = array (
		'1' => 'понедельник',
		'2' => 'вторник',
		'3' => 'среда',
		'4' => 'четверг',
		'5' => 'пятница',
		'6' => 'суббота',
		'0' => 'воскресенье',
	);

	if (strpos($format, '%_IM') !== false) {
		$format = str_replace('%_IM', $months_i[date('m',$timestamp)], $format);
	}
	if (strpos($format, '%_M') !== false) {
		$format = str_replace('%_M', $months[date('m',$timestamp)], $format);
	}
	if (strpos($format, '%_SM') !== false) {
		$format = str_replace('%_SM', $months_short[date('m',$timestamp)], $format);
	}
	if (strpos($format, '%_SD') !== false) {
		$format = str_replace('%_SD', $days_short[date('w',$timestamp)], $format);
	}
	if (strpos($format, '%_FD') !== false) {
		$format = str_replace('%_FD', $days_full[date('w',$timestamp)], $format);
	}
    if (DIRECTORY_SEPARATOR == '\\') {
        $_win_from = array('%D',       '%h', '%n', '%r',          '%R',    '%t', '%T');
        $_win_to   = array('%m/%d/%y', '%b', "\n", '%I:%M:%S %p', '%H:%M', "\t", '%H:%M:%S');
        if (strpos($format, '%e') !== false) {
            $_win_from[] = '%e';
            $_win_to[]   = sprintf('%\' 2d', date('j', $timestamp));
        }
        if (strpos($format, '%l') !== false) {
            $_win_from[] = '%l';
            $_win_to[]   = sprintf('%\' 2d', date('h', $timestamp));
        }
		
    }
    return strftime($format, $timestamp);
}

/* vim: set expandtab: */

?>
