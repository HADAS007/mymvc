<?php 
class CaptchaTool{
	//产生验证码支付串
	private static function makecode($size='4' ){
		//验证码原始字符串
		$str='123456789QWERTYUIOPASDFGHJKLZXCVBNM';
		//打乱字符串
		$str=str_shuffle($str);
		//产生验证码
		return substr($str,0,$size); 
	}
	//利用程序绘制验证码
	public static function draw(){
			$n=rand(1,5);
			$img=imagecreatefromjpeg("./Public/captcha/captcha_bg$n.jpg");
			$color=imagecolorallocate($img,255,255,255);
			//为画布设定边框
			imagerectangle($img, 0, 0, 144, 19, $color);
			$colorarr=[0,255];
			$bgcolor=$colorarr[rand(0,1)];
			$fontcolor=imagecolorallocate($img, $bgcolor, $bgcolor, $bgcolor);

			//绘制杂点
			for ($i=0; $i<100; $i++) { 
				$color2=imagecolorallocate($img, rand(0,255),  rand(0,255),  rand(0,255));
				imagesetpixel($img, rand(0,145), rand(0,20), $color2);
			}
			//绘制线条
			for ($i=0; $i<5; $i++) { 
				$color3=imagecolorallocate($img, rand(0,255),  rand(0,255),  rand(0,255));
				imageline($img, rand(0,145), rand(0,20), rand(0,145), rand(0,20), $color3);
			}

			// 取得验证码
			$code=self::makecode();
			// session_start();
		
			new sessionTool();
			$_SESSION['code']=$code;
			
			// 绘制文字
			imagestring($img, 5, 50, 0, $code, $fontcolor);
			// 绘制画布
			header("Content-type:image/jpeg");
			imagejpeg($img);
			//释放画布资源
			imagedestroy($img);
			// new SessionTool();
			// $_SESSION['code']=$code;

}
	//制作验证码校验
	public static function checkcode($code){
		// session_start();
		new SessionTool();
		if (isset($_SESSION['code'])) {
			return strtolower($code)==strtolower($_SESSION['code']);
		}else{
			return false;
		}
		
	}
}
