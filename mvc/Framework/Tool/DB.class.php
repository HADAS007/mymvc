<?php
//封装一个操作数据库的类
class DB{
//    设计，具有的属性
    //声明操作数据库属性
    private $host;//服务器地址
    private $user;//用户名
    private $password;//登录密码
    private $port;//数据库的端口
    private $charset;//设置通信编码
    private $dbName;// 选择的数据库    
    //声明一个连接属性
    private $link;       
    //建立一个静态的私有属性 保存对象
    private static $obj=null;
    //在得到该对象时，可以对属性进行初始化！利用构造函数
    private function __construct($config=array()) {
        //属性的初始化
        $this->host=isset($config["host"])?$config["host"]:"127.0.0.1";
        $this->user=isset($config["user"])?$config["user"]:"root";
        $this->password=isset($config["password"])?$config["password"]:"root";
        $this->port=isset($config["port"])?$config["port"]:3306;
        $this->charset=isset($config["charset"])?$config["charset"]:"utf8";
        $this->dbName=isset($config["dbName"])?$config["dbName"]:"testmvc";
        //调用数据库的连接方法
        $this->connect();
        $this->setCharset();
    }
    //建立一个公有的方法 创建对象
    public static function getInstance($config=array()){
        if(self::$obj==null)
            self::$obj=new DB($config);
        return self::$obj;
    }
    
    //声明一个普通的方法 连接数据库
    private function connect(){
        if(!$this->link=@mysqli_connect($this->host, $this->user, $this->password, $this->dbName, $this->port)){
            echo "connect faill";           
        }
    }  
//    自动设置字符集 
    private function setCharset(){
        if($this->charset!=null){
        //设定字符集
          mysqli_set_charset($this->link, $this->charset);
        }
        else{
            mysqli_set_charset($this->link, "utf8");
        }
    }   
//    增加一个执行sql的方法！  执行 增加 删除 修改  执行返回bool值的语句
    public function query($sql){
        //执行sql语句
      return mysqli_query($this->link, $sql);    
    }  
    //声明一个方法 获取表中的所有数据 并以数组形式 放回所有数据
    public function fetchAll($sql){
        //发送执行语句
        $rst =  mysqli_query($this->link, $sql);
        //没有正确的执行sql代码  返回false
        if(!$rst)
            return false;
        $dataArr=array();
        //循环资源
        while($row=  mysqli_fetch_assoc($rst)){
            $dataArr[]=$row;
        }
        if($dataArr)
          return $dataArr;
      else 
          return [];
    }
    //声明方法获取一条数据
    public function fetchRow($sql){
        //调用查询所有数据的方法
        $rows=$this->fetchAll($sql);
        //判定取得的数据
        if($rows)
            return array_shift($rows);
        else
            return $rows;
    }
    //获取第一条记录的第一个字段 第一行第一列的数据 fetchColumn 
    public function fetchColumn($sql){
        //调用fetchRow方法  取第一个值
        $row=$this->fetchRow($sql);
        //判定当前行的结果
        if($row)
            return array_shift ($row);
        else
             return $row;
    }
    //私有化克隆执行的方法
    private function __clone(){
        
    }
    //  析构函数
    public function __destruct(){      
    }
}

