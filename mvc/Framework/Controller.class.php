<?php 
  class Controller{
      private $smarty;
      public function __construct(){
       $this->smarty();
      }
      private function smarty(){
         //引入smarty模板
        require TOOL_PATH.'Smarty/Smarty.class.php';
        //实例化smarty类
        $this->smarty = new Smarty();
        //告诉smarty模板存放位置
          $this->smarty->setTemplateDir(CURRENT_VIEW_PATH.'Teacher');
          // echo CURRENT_VIEW_PATH.'Teacher';
          //告诉smarty编译文件存放位置
          $this->smarty->setCompileDir(APPLICATION_PATH.'View_c');
      }
      //display加载视图方法
      protected function display($template_name){
      $this->smarty->display($template_name.'.html');
    }
    //assign定义变量方法
      protected function assign($key,$value){
       $this->smarty->assign($key,$value);
    }
    //跳转方法
  	public static function jump($url,$time=0,$msg=''){
      //判断用什么方式跳转
  		if(headers_sent()){
  			// 使用客户端跳转
  			if ($time==0) {
  				echo "<script>location.href=$url</script>";
  			}else{//延时跳转
  				echo $msg;
  				$time=$time*1000;
  				echo "<script>setTimeout(function(){location.href='$url'},$time)</script>";
  			}
  		}else{
  			//使用服务器端跳转
  			if ($time==0) {
  				//立即跳转
  				header("Location:$url");
  			}else{
          echo $msg;
  				header("refresh:$time;$url");
  			}
  		}
  		exit;
  	}
  }
 ?>