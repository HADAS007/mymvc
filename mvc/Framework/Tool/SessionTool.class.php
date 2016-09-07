<?php 
class SessionTool{
	public function __construct(){
		//重写sission规则
		session_set_save_handler(
			array($this,'open'),
			array($this,'close'),
			array($this,'read'),
			array($this,'write'),
			array($this,'destroy'),
			array($this,'gc')
			);
		session_start();
	}
	//打开的方法
	public function open($path,$sessName){
		//引入DB类
		// require "./DB.class.php";
		//取得实例
		$GLOBALS['db']=DB::getInstance();

	}
	//关闭的方法
	public function close(){

	}
	//读取的方法
	public function read($sessID){
		// 构建sql语句
		$sql = "select * from `session` where sessid='$sessID'";
		$row = $GLOBALS['db']->fetchRow($sql);
		if($row){
			return $row['sessData'];
		}
	}
	//写入的方法
	public function write($sessID,$data){
		// 构建sql语句把session写入
		$sql = "insert into `session` set sessid='$sessID',sessData='$data',lifeTime=unix_timestamp() on duplicate key update sessData='$data',lifeTime=unix_timestamp()";
		$GLOBALS['db']->query($sql);
	}
	//销毁的方法
	public function destroy($sessID){
		//构建sql语句删除
		$sql="delete from `session` where sessid='$sessID'";
		// 执行sql语句
		$GLOBALS['db']->query($sql);
	}
	// 自动销毁的方法
	public function gc($lifetime){
		// 构建sql语句删除过期的session
		$sql="delete from `session` where lifetime+$lifetime<unix_timestamp()";
		$GLOBALS['db']->query($sql);
	}

}
