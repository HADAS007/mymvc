<?php 
class Frame{
	//定义调用框架run的方法
	public static function run(){
		self::initPath();
		self::initConfig();
		spl_autoload_register("self::autoLoad");
		self::initParam();
	}
	//定义路径常量的方法
	private static function initPath(){
		//定义分隔符"/"
		defined('DS') or define('DS', DIRECTORY_SEPARATOR);
		//定义根路径
		defined('ROOT_PATH') or define('ROOT_PATH',dirname($_SERVER['SCRIPT_FILENAME']).DS);
		//定义应用程序文件夹目录
		defined('APPLICATION_PATH') or define('APPLICATION_PATH',ROOT_PATH.'Application'.DS);
		//定义MODEL路径
		defined('MODEL_PATH') or define('MODEL_PATH',APPLICATION_PATH.'Model'.DS);
		//定义VIEW路径
		defined('VIEW_PATH') or define('VIEW_PATH',APPLICATION_PATH.'View'.DS);
		//定义控制器路径
		defined('CONTROLLER_PATH') or define('CONTROLLER_PATH',APPLICATION_PATH.'Controller'.DS);
		//定义框架路径
		defined('FRAMEWORK_PATH') or define('FRAMEWORK_PATH',ROOT_PATH.'Framework'.DS);
		//定义工具类路径
		defined('TOOL_PATH') or define('TOOL_PATH', FRAMEWORK_PATH.'Tool'.DS);
	}
	//引入配置文件的方法
	private static function initConfig(){
		$GLOBALS['config'] = require'./Application/Config/myshop.config.php';

	}
	// 设置平台参数的方法
	private static function  initParam(){
		//获取控制平台的三个参数
		$p=isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['app']['p'];
		$c=isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['app']['c'];
		$a=isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['app']['a'];
		 //定义当前平台控制器的路径
		 defined('CURRENT_CONTROLLER_PATH') or define('CURRENT_CONTROLLER_PATH',CONTROLLER_PATH.$p.DS);

		 //定义当前视图的路径
		 defined('CURRENT_VIEW_PATH') or define('CURRENT_VIEW_PATH',VIEW_PATH.$p.DS);
		 
		 //设定一个控制的名称
		 $controllerName = $c.'Controller';
		  defined('CONTROLLER_NAME') or define('CONTROLLER_NAME',$controllerName);
		 //设定一个方法名称
		 $actionName = $a.'Action';
		  defined('ACTION_NAME') or define('ACTION_NAME',$actionName);
		 //引入控制器
		 // require "./Application/Controller/$p/$controllerName.class.php";
		 //实例化控制器
		 $obj = new $controllerName();
		 //调用方法
		 $obj->$actionName();
			}
	// 制作自动加载的方法
	private static function autoLoad($className){
		$mapping=['Model'=>FRAMEWORK_PATH.$className.'.class.php',
 			  'DB'=>TOOL_PATH.$className.'.class.php',
 			  'Controller'=>FRAMEWORK_PATH.$className.'.class.php'
 			];
 			// var_dump($mapping['Control  ler']);exit;
 			if (isset($mapping[$className])) {
 				require $mapping[$className] ;	
 			}elseif (substr($className,-5)=='Model') {
 				require MODEL_PATH.$className.'.class.php';
 			}elseif (substr($className,-10)=='Controller') {
 				require CURRENT_CONTROLLER_PATH.$className.'.class.php';
 			}elseif (substr($className,-4)=='Tool') {
 				require TOOL_PATH.$className.'.class.php';
 			}

	}
}