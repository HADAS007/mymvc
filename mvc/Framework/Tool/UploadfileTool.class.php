<?php
class UploadfileTool{
	//建立属性
	//保存文件路径属性
	private $dir;
	//文件上传的大小
	private $size;
	//文件允许上传的格式
	private $type=[];
	//错误提示
	 public $error;
	 // 前缀属性
	 public $pre;
	 //初始化属性
	 public function __construct(){
	 	//初始化路径
	 	$this->dir=isset($GLOBALS['config']['upload']['dir']) ? $GLOBALS['config']['upload']['dir']:'./';
	 	//初始化文件大小
	 	$this->size=isset($GLOBALS['config']['upload']['size']) ? $GLOBALS['config']['upload']['size']:2*1024*1024;
	 	//初始化文件类型
	 	$this->type=isset($GLOBALS['config']['upload']['type']) ? $GLOBALS['config']['upload']['type']:['image/jpeg','image/png','image/gif'];
	 	//初始化文件前缀
	 	$this->pre=isset($GLOBALS['config']['upload']['pre']) ? $GLOBALS['config']['upload']['pre']:'pic_';
	 }
	 // 上传文件的方法
	 public function upload($file){
	 	//判定上传的错误信息
	 	if($file['error']!=0){
	 		 $this->error='系统配置信息错误';
	 		return false;
	 	}
	 	//判定大小
	 	if($file['size']>$this->size){
	 	 $this->error='文件过大';
	 		return false;
	 	}
	 	//判定文件格式
	 	if(!in_array($file['type'], $this->type)){
	 		$this->error='文件格式错误';
	 		return false;
	 	}
	 	// 构建上传文件的保存名字
	 	$name=uniqid($this->pre);
	 	//求取扩展名
	 	$extName=pathinfo($file['name'])['extension'];
	 	//整体名字
	 	$fileName="$name.$extName";
	 	//移动文件到指定路径
	 	move_uploaded_file($file['tmp_name'], $this->dir.$fileName);
	 	return $fileName;
	 	 
	 }
	 //构建多个上传方法
	 public function multiUpload($fileArr){
	 	 //声明一个数组 保存名字
	 	 $name=[];
	 	 for ($i=0; $i <count($fileArr['name']); $i++) { 
	 	 	 //分离成单个的file文件 才实现上传
	 	 	 $file=[];
	 	 	 $file['name']=$fileArr['name'][$i];
	 	 	 $file['type']=$fileArr['type'][$i];
	 	 	 $file['tmp_name']=$fileArr['tmp_name'][$i];
	 	 	 $file['error']=$fileArr['error'][$i];
	 	 	 $file['size']=$fileArr['size'][$i];
	 	 	 $name[$i]=$this->upload($file);
	 	 }
	 	 return $name;
	 }
	  
}