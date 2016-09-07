<?php 
class CaptchaController{
	//建立方法，输出验证码
	public function showAction(){
		CaptchaTool::draw();
	}
}