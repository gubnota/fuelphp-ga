<?php

/**
 * Ga: Gubnota & Artwell asset library for FuelPHP.
 * This class is for merge string values only if not empty
 * 
 * @package    Ga
 * @version    v1
 * @author     Vladislav Muraviev
 * @license    MIT License
 * @copyright  2014 Vladislav Muraviev
 * @link       http://github.com/gubnota/fuelphp-ga
 */

namespace Ga;
class Utils {

	/**
	 * Returns whether $_SERVER['HTTP_X_REQUESTED_WITH'] points to browser xmlhttprequest
	 *
	 * @param   string $requested_with $_SERVER['HTTP_X_REQUESTED_WITH']
	 * @return  bool either found or not
	 */
	public static function is_ajax($requested_with = null){
		if ($requested_with == null) $requested_with = @$_SERVER['HTTP_X_REQUESTED_WITH'];
		if(!empty($requested_with) && strtolower($requested_with) == 'xmlhttprequest') {
		return true;
		}
	}

	/**
	 * Returns merged internatiolized string values array
	 * @param   array       $strings1  First string array
	 * @param   array       $strings2  Translated string array
	 * @param   orig_values_only (only thouse values, first array have - third key)
	 * @return  array       merged values
	 */
	public static function merge()
	{
		$args = func_get_args();
		if(count($args)<2) return;
		count($args)==3 or $args = [$args[0],$args[1],true];
		$out = [];
		foreach ((array)$args[0] as $key => $value) {
			$out[$key] = $value; 
		}
		foreach ((array)$args[1] as $key => $value) {
			if ((!(bool)$args[2] OR isset($out[$key])) AND strlen($value)>0)
				$out[$key] = $value; 
		}
	return (array) $out;	
	}

}
