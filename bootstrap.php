<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

Autoloader::add_core_namespace('Ga');

Autoloader::add_classes(array(
	'Ga\\Intl'             => __DIR__.'/intl.php',
	'Ga\\Browser'             => __DIR__.'/browser.php',
	'Ga\\Uuid'             => __DIR__.'/uuid.php',
	'Ga\\Upload'             => __DIR__.'/upload.php',
	'Ga\\Utils'             => __DIR__.'/utils.php',
));


/* End of file bootstrap.php */