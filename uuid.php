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
class Uuid {

	/**
	 * Generates uuid
	 *
	 * @param   string       $agent     User-Agent
	 * @return  string                  XXXXX-XXXXX-XXXXX-...
	 */
	public static function generate($params = array('from'=>0,'to'=>0,'len'=>5,'ring'=>8,'upper'=>true,'hyphen'=>'-')){
	if (!isset($params['from'])) $params['from'] = 0;
	if (!isset($params['to'])) $params['to'] = 0;
	if (!isset($params['len'])) $params['len'] = 5;
	if (!isset($params['ring'])) $params['ring'] = 8;
	if (!isset($params['upper'])) $params['upper'] = true;
	if (!isset($params['hyphen'])) $params['hyphen'] = '-';
	$string = '';
	for ($j = 0; $j < $params['ring']; $j++) {
	if ($j>0 && $params['hyphen']) $string .= $params['hyphen'];
	for ($i = 0; $i < $params['len']; $i++) {
	if ($params['from'] == 0 && $params['to'] == 0) {
	$r = rand(0,32);//48, 79, 73 - I, O, 0 - исключить: 49,57; 65,72; 74,78; 80,90
	// 33 символа, если (0,8), то +49, если (9,16) то +56; если (17,21) то + 57; если (22,32) то +58; 
	if ($r < 9){$string .= chr($r+49);}
	else if ($r < 17){$string .= chr($r+56);}
	else if ($r < 22){$string .= chr($r+57);}
	else {$string .= chr($r+58);}
	}
	else {$string .= chr(rand($params['from'], $params['to']));}
	}
	}
	return $string;
	}

}