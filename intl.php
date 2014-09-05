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

namespace Ga;//APPPATH
// class Intl extends \Lang {
class Intl {

    public static $lexicon = [];
    public static $loaded = [];
    public static $language = 'en';
    public static function flush(){
    self::$lexicon = [];
    }
	/**
	 * Returns currently active language.
	 *
	 * @return   string    currently active language
	 */
	public static function get_lang()
	{
		$lang = \Session::get('lang');
		if (in_array(\Uri::segment(1), ['en','zh','ru']))
		{
		$lang = \Uri::segment(1);
		}
		if (!$lang)
		{
			\Ga\Browser::lang('zh') ? $lang = 'zh' : $lang = 'en' ;
			if (\Ga\Browser::lang('ru')) $lang = 'ru';
		}
		\Session::set('lang', $lang);
		\Config::set('language', $lang);
		empty($lang) and $lang = static::$lang;
		return $lang;
	}

	public static function load($file, $group = null, $lang = null, $overwrite = false, $reload = false)
	{
		$lang or $lang = static::get_lang();
        $langfile_path = APPPATH.'intl/'.$file.'/'.$lang.'.xml';
        if (!isset(static::$loaded[$langfile_path]) && file_exists($langfile_path)){
            static::$loaded[$langfile_path] = true;
            $translations = simplexml_load_file($langfile_path);
            foreach($translations->key as $t){
                static::$lexicon[(string)$t['name']] = (string)$t;
            }
        return true;
        }
	}

    public static function search_key($s, $return_first=true){
	  $out=[];
	    foreach (static::$lexicon as $k=>$w){
	        if (strpos($k,$s) !== false) {
	            if($return_first) {$out = $w; break;}
	            else {$out[$k] = $w;}
	        }
	    }
	  return $out;
	}

	public static function search_val($s, $return_first=true){
	  $out=[];
	    foreach (static::$lexicon as $k=>$w){
	        if (strpos($w,$s) !== false) {
	            if($return_first) {$out = $k; break;}
	            else {$out[$k] = $w;}
	        }
	    }
	  return $out;
	}
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
        return isset(static::$lexicon[$line]) ? static::$lexicon[$line] : $line;
		// return isset(static::$lines[$language]) ? \Str::tr(\Fuel::value(\Arr::get(static::$lines[$language], $line, $line)), $params) : $default;
	}

	/*
	Echoes value for language key (simplify view output) 
	*/
	public static function _($line, array $params = array(), $default = null, $language = null){
		$res = static::get($line, $params, $default, $language);
		echo $res;
		return $res;
	}
}
