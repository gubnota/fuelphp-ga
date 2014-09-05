<?php

/**
 * Ga: Gubnota & Artwell asset library for FuelPHP.
 * This class is for iOS, Android mobile devices detection
 * 
 * @package    Ga
 * @version    v1
 * @author     Vladislav Muraviev
 * @license    MIT License
 * @copyright  2014 Vladislav Muraviev
 * @link       http://github.com/gubnota/fuelphp-ga
 */

namespace Ga;
class Browser {

	protected static $langs = false;
	/**
	 * Returns whether browser is iOS/Android
	 *
	 * @param   string       $agent     User-Agent
	 * @return  bool                   either the line or default when not found
	 */
	public static function mobile()
	{
		$args = func_get_args();
		count($args)>0 or $args = [$_SERVER['HTTP_USER_AGENT']];
		//Detect special conditions devices
		$iPod = stripos($args[0],"iPod");
		$iPhone = stripos($args[0],"iPhone");
		$iPad = stripos($args[0],"iPad");
		if(stripos($args[0],"Android") && stripos($args[0],"mobile")){
		    $Android = true;
		}else if(stripos($args[0],"Android")){
		    $Android = false;
		    $AndroidTablet = true;
		}else{
		    $Android = false;
		    $AndroidTablet = false;
		}
	return (bool) ($iPod OR $iPhone OR $iPad OR $Android OR $AndroidTablet);	
	}

	public static function ie()
	{
		$args = func_get_args();
		count($args)>0 or $args = [$_SERVER['HTTP_USER_AGENT']];
		//Detect special conditions devices
		$IE = strpos($args[0],"MSIE");
	return (bool) ($IE);
	}

	public static function ie_lt9()
	{
		$args = func_get_args();
		count($args)>0 or $args = [$_SERVER['HTTP_USER_AGENT']];
		//Detect special conditions devices
		$IE6 = strpos($args[0],"MSIE 6.0");
		$IE7 = strpos($args[0],"MSIE 7.0");
		$IE8 = strpos($args[0],"MSIE 8.0");
	return (bool) ($IE6 OR $IE7 OR $IE8);
	}

	/**
	 * Returns Accept-lang browser array ['ru-RU'=>float 0.8] etc.
	 *
	 * @param   string       $agent     Accept-Language
	 * @return  array                   either the line or default when not found
	 * 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4,zh-CN;q=0.2,zh;q=0.2,zh-TW;q=0.2,vi;q=0.2,fr;q=0.2'
	 */
	public static function langs(){
		if (self::$langs) return self::$langs;
		$args = func_get_args();
		count($args)>0 or $args = [$_SERVER['HTTP_ACCEPT_LANGUAGE']];
		$a = explode(',', $args[0]);
		$b = [];
		foreach ($a as $v) {
			$p = strpos($v, ';q=0.');
			if ($p === false)
			{$b[$v] = 1;}
		else {$b[substr($v, 0, $p)] = (float)substr($v, $p+3);}
		}
		self::$langs = $b;
		return self::$langs;
	}

	/**
	 * Returns Whether lang accepted by browser and it's weight
	 * @param   string       $agent     Accept-Language
	 * @return  bool                   lang accepts boolean
	 */
	public static function lang(){
		$args = func_get_args();
		count($args)>0 or $args = ['zh'];
		return in_array($args[0],array_keys(self::langs()),true);
	}

	/**
	 * Returns whether browser is Crawler/Bot
	 *
	 * @param   string       $agent     User-Agent
	 * @return  bool                   whether browser is Crawler/Bot
	 */
	public static function is_bot()
	{
		$args = func_get_args();
		count($args)>0 or $args = [$_SERVER['HTTP_USER_AGENT']];
		//Detect special conditions devices
		$Bot = stripos($args[0],"Bot");
		$Googlebot = stripos($args[0],"Googlebot");
		$Yandex = stripos($args[0],"Yandex");
		$MailRu = stripos($args[0],"Mail.Ru");
		$Alexa = stripos($args[0],"ia_archiver");
	return (bool) ($Bot OR $Googlebot OR $Yandex OR $MailRu OR $Alexa);	
	}


}
