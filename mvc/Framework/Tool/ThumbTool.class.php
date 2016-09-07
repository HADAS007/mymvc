<?php
class ThumbTool{
		// 声明一个数组
		public static $creatImg=[
			'image/jpeg'=>'imagecreatefromjpeg',
			'image/png'=>'imagecreatefrompng',
			'image/gif'=>'imagecreatefromgif'
		];
		// 定义输出的图片数组
		public static $outImg=[
			'image/jpeg'=>'imagejpeg',
			'image/png'=>'imagepng',
			'image/gif'=>'imagegif'
		];
		//定义扩展名的数组
		public static $extension=[
			'image/jpeg'=>'.jpg',
			'image/png'=>'.png',
			'image/gif'=>'.gif'
		];
		public static function drawImg($path,$width,$height){
		$dir=$GLOBALS['config']['thumb']['dir'];
		//获取原始图片的属性
		$attr=getimagesize($path);
		//创建原始画布取得图片类型
		$type=$attr['mime'];
		//去得创建画布的方式
		$createPic=self::$creatImg[$type];
		$img=$createPic($path);
		//创建目标画布
		$dst=imagecreatetruecolor($width, $height);
		//求比列
		$bilie=$attr[0]/$width>$attr[1]/$height?$attr[0]/$width:$attr[1]/$height;
		//求目标图形大小
		$min_w=$attr[0]/$bilie;
		$min_h=$attr[1]/$bilie;
		//创建填充的颜色
		$color=imagecolorallocate($dst, 255, 255, 255);
		//填充颜色
		imagefill($dst, 0, 0, $color);
		//拷贝图片到目标
		imagecopyresampled($dst, $img, ($width-$min_w)/2, ($width-$min_h)/2, 0, 0, $min_w, $min_h, $attr[0], $attr[1]);
		// 为缩略图设定名称
		$name=uniqid('thumb_');
		$extName=self::$extension[$type];
		// 最终文件名
		$fileName=$name.$extName;
		//输出图片
		$outPic=self::$outImg[$type];
		$outPic($dst,"$dir.$fileName");
		return $fileName;
		
			
	}
}