<?php

/**
 * Ga: Gubnota & Artwell asset library for FuelPHP.
 * This class is for instantiate Drag & Drop upload files functionality in app
 * 
 * @package    Ga
 * @version    v1
 * @author     Vladislav Muraviev
 * @license    MIT License
 * @copyright  2014 Vladislav Muraviev
 * @link       http://github.com/gubnota/fuelphp-ga
 */

namespace Ga;
// инстанция загружаемой формы
class Upload_Instance {
	/**
	 * Default configuration values
	 *
	 * @var  array
	 */
	protected $config = array(
	);

	/*
	* Тут нужно добавить генерацию js-фвйла, отвечающего за обслуживание конкретной формы загрузки (уникально по id)
	*/

	public function __construct(){
		$args = func_get_args();
		if (isset($args[0])){
		$this->config = $args[0];
		}
		!isset($this->config['tpl_compiled_js']) ? $this->config['tpl_compiled_js'] = 'ga/cache/'.$this->config['param_prefix'].'.js': true;
		if (
			file_exists(PKGPATH.$this->config['tpl_js'])
			AND
				(!file_exists(DOCROOT.'assets/js/'.$this->config['tpl_compiled_js'])
					OR
				filemtime(DOCROOT.'assets/js/'.$this->config['tpl_compiled_js']) + @$this->config['recompile_tpl_js_time'] < time()
				)
			)
		{
			$file = file_get_contents(PKGPATH.$this->config['tpl_js']);
			foreach ($this->config as $key => $value) {
				$file = str_replace('{{'.$key.'}}', $value, $file);
			}
			file_put_contents(DOCROOT.'assets/js/'.$this->config['tpl_compiled_js'],$file);
		return $this->config['tpl_compiled_js'];
		}

	}

	/**
	* compiled asset-js link or contents
	*
	* @var string
	*/
	public function js($get_contents = false){
	if($get_contents) {return @file_get_contents(@DOCROOT.'assets/js/'.@$this->config['tpl_compiled_js']);}
	else {return @$this->config['tpl_compiled_js'];}
	}

	/**
	* generates text for wrapper element in html code
	*
	* @var string
	*/
	public function wrapper($in_images = ''){
	$images = '';
	if (is_array($in_images)){
		foreach ($in_images as $key => $image) {
			$filename = substr($image, strrpos($image, '/')+1);
			$images .= '<div class="col-sm-3 preview done">
			<span class="imageHolder">
			<img src="'.$image.'"><a class="delete" href="'.$image.'">×</a><span class="uploaded"></span></span><div class="progressHolder">
			<div class="progress" style="width: 100%;">'.$filename.'</div></div></div>';
		}
	}
	return str_replace(
	['{{param_prefix}}','{{FilesUpload}}','{{DropHere}}','{{images}}'], 
	[$this->config['param_prefix'],$this->config['FilesUpload'],$this->config['DropHere'],$images], 
		'<div class="dropbox_wrapper">
		<div id="{{param_prefix}}" class="dropbox">
			<span class="message">{{FilesUpload}}<br /></span>
            <i>{{DropHere}}</i>
        {{images}}
		</div>
		</div>');
	}
}

class Upload {

	/**
	 * default instance
	 *
	 * @var  array
	 */
	protected static $_instance = null;

	/**
	 * All the Asset instances
	 *
	 * @var  array
	 */
	protected static $_instances = array();

	/**
	 * Default configuration values consists of two parts: one for global values,
	 * other for instance default values
	 *
	 * @var  array
	 */
	protected static $default_config = array(
		'global' =>array(
		'js_lib' => 'ga/upload.js',// библиотека jquery для загрузки drap & drop
		'css_lib' => 'ga/upload.css',// оформление загрузки drap & drop
		'param_prefix' => 'dropbox', // префикс для id
		),
		'instance' =>array(
	    	'tpl_js' => 'ga/assets/upload.js', // положение в PKGPATH.tpl_js шаблона для инстанциализации js-обработчика формы
			'upload_dir' => 'uploads',
	    	'url' => 'upload/',
			'maxfiles' => 5,
	    	'maxfilesize' => 2,
	    	'recompile_tpl_js_time' => 3600, // позволяет время кэширования сгенерированного файла контролировать
	    	// 'tpl_compiled_js' => 'ga/cache/dropbox.js', // кэшируемый инстанс
			'type' => 'image',
			'param_prefix' =>'dropbox',
			'BrowserNotSupported' => 'Your browser does not support HTML5 file uploads!',
			'TooManyFiles' => 'Too many files! Please select 5 at most!',
			'FileTooLarge' => ' is too large! Please upload files up to ',
			'NotAllowed' => 'Not allowed type!',
			),
	);

	/**
	 * This is called automatically by the Autoloader.  It loads in the config
	 *
	 * @return  void
	 */
	public static function _init()
	{
		\Config::load('ga/upload', true, false, true);
		static::$default_config = array_merge(static::$default_config, \Config::get('ga/upload'));
	}

	/**
	 * Return a specific instance, or the default instance (is created if necessary)
	 *
	 * @param   string  instance name
	 * @return  Asset_Instance
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				return false;
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}

	/**
	 * Gets a new instance of the Asset class.
	 *
	 * @param   string  instance name
	 * @param   array  $config  default config overrides
	 * @return  Asset_Instance
	 */
	public static function forge($name = 'default', array $config = array())
	{
		if ($exists = static::instance($name))
		{
			\Error::notice('Upload instance with the name '.$name.' exists already, cannot be overwritten.');
			return $exists;
		}

		static::$_instances[$name] = new Upload_Instance(
			array_merge(static::$default_config['instance'],
				$config,
				array('param_prefix'=>static::$default_config['global']['param_prefix'].'_'.$name)));

		if ($name == 'default')
		{
			static::$_instance = static::$_instances[$name];
		}

		return static::$_instances[$name];
	}

	/**
	 * Generates link for assets for css by calling Asset::css
	 * if any instance have been created before
	 *
	 * @param   none
	 * @return  string
	 */
	public static function css(){
		if (static::$_instances){
			return static::$default_config['global']['css_lib'];
		}

	}

	/**
	 * Generates link for assets for js by calling Asset::js
	 * if any instance have been created before
	 *
	 * @param   none
	 * @return  string
	 */
	public static function js(){
		if (static::$_instances){
			return static::$default_config['global']['js_lib'];
		}

	}

	/**
	 * This is called when transfer files from upload to images
	 *
	 * @return  void
	 */
	public static function transfer($config = [])
	{
		$moved = [];
		$config = array_merge(['name'=>'default','to_name'=>'default','ring'=>3,'hyphen'=>'/','len'=>2,'rename'=>true,'rename_len'=>5], $config);
		$config['to_id']= \Ga\Uuid::generate(['ring'=>$config['ring'],'hyphen'=>$config['hyphen'],'len'=>$config['len']]);
		$uploads = \Session::get('uploads');
		$config['id'] = $uploads[$config['name']]['id'];
		// get the stored userid from the session
		$from_dir = DOCROOT.'upload/'.$config['name'].'/'.$config['id'].'/';
		$to_dir = DOCROOT.'uploads/'.$config['to_name'].'/'.$config['to_id'].'/';
		if (!is_dir($to_dir)){
		mkdir($to_dir,0777,true);
		}
		if (is_dir($from_dir)){
		$f = scandir($from_dir);
		foreach ($f as $key => $file) {
			if (is_file($from_dir.$file)){

			$pos = strrpos($file, '.');
			if ($pos !== false){
			list($file_woext,$file_ext) = [substr($file,0,$pos),strtolower(substr($file,$pos))];
			if ($config['rename']) $file_woext = \Ga\Uuid::generate(['ring'=>1,'len'=>$config['rename_len']]);
			rename($from_dir.$file,$to_dir.$file_woext.$file_ext);
			$moved[$file] = $config['to_name'].'/'.$config['to_id'].'/'.$file_woext.$file_ext;
			}

			}
		}
		}
		@rmdir($from_dir);
	return $moved;
	}


}
