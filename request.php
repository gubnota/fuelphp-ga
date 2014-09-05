<?php

/**
 * Ga: Gubnota & Artwell asset library for FuelPHP.
 * This class is for Request type detection (e.g. ajax or not)
 * 
 * @package    Ga
 * @version    v1
 * @author     Vladislav Muraviev
 * @license    MIT License
 * @copyright  2014 Vladislav Muraviev
 * @link       http://github.com/gubnota/fuelphp-ga
 */

namespace Ga;
class Request {

	protected static $langs = false;
	/**
	 * Returns whether $_SERVER['HTTP_X_REQUESTED_WITH'] points to browser xmlhttprequest
	 *
	 * @param   string $requested_with $_SERVER['HTTP_X_REQUESTED_WITH']
	 * @return  bool either found or not
	 */
	public static function is_ajax($requested_with = $_SERVER['HTTP_X_REQUESTED_WITH']){
		if(!empty(requested_with) && strtolower(requested_with) == 'xmlhttprequest') {
		return true;
		}
	}

}
