<?php

/**
 * Ga: Gubnota & Artwell asset library for FuelPHP.
 * This class are replacement for default Lang class behavior
 * in case there is no language file for default language
 * instead of returning empty string value it returns same string as argument
 *
 * @package    Ga
 * @version    v1
 * @author     Vladislav Muraviev
 * @license    MIT License
 * @copyright  2014 Vladislav Muraviev
 * @link       http://github.com/gubnota/fuelphp-ga
 */

namespace Ga;
class Intl extends \Lang {

	/**
	 * Returns a (dot notated) language string
	 *
	 * @param   string       $line      key for the line
	 * @param   array        $params    array of params to str_replace
	 * @param   mixed        $default   default value to return
	 * @param   string|null  $language  name of the language to get, null for the configurated language
	 * @return  mixed                   either the line or default when not found
	 */
	public static function get($line, array $params = array(), $default = null, $language = null)
	{
		($language === null) and $language = static::get_lang();
		return isset(static::$lines[$language]) ? \Str::tr(\Fuel::value(\Arr::get(static::$lines[$language], $line, $line)), $params) : $default;
	}

}
