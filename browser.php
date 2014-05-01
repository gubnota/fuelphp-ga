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

}
