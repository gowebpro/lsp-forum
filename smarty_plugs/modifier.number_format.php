<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty number_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     number_format<br>
 * Purpose:  returns a formatted number as of php number_format
 * @author   ulyxes <zulisse at email dot it>
 * @param string
 * @param string
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_number_format($string, $decimals = 0, $dec_sep = ",", $thous_sep = ".")
{
    return number_format($string, $decimals, $dec_sep, $thous_sep);
}

/* vim: set expandtab: */

?>