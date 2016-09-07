<?php 
 class Model{
 	protected $db;
 	private $fields=array();
 	public function __construct(){
 		// require './Framework/Tool/DB.class.php';
 		 $this->db=DB::getInstance($GLOBALS['config']['db']);
 		// 在构造函数中调用取得字段的方法
 		$this->getFields();
 	}

 	//建立一个去得表名的方法
 	private function getTable(){
 		 // 利用对象取得类名
 		$tableName = get_class($this);
 		//获取表名 去掉类Model
 		$tableName = substr($tableName, 0,-5);
 		// 给tableName 加入反引号
 		$tableName="`$tableName`";
 		return $tableName;
 	} 
 	//获得所有数据
 	protected function getAll($fields="*",$condition=""){
 		//判断条件是否为空
 		if(empty($condition)){
 			//如果为空就执行下面这条sql语句
 			$sql="select $fields from {$this->getTable()}";
 		}else{
 			//如果不为空就执行这条语句
 			$sql="select $fields from {$this->getTable()} where $condition";
 		}
 		// 返回查询到的所有数据
 		return $this->db->fetchAll($sql);
 	}
       //构建方法分页读取数据
        protected  function getPage($page,$pageSize,$fields="*",$condition=""){
        //求取开始位置
        $start=($page-1)*$pageSize;
        if(empty($condition)){  
             //构建sql
            $sql="select $fields from {$this->getTable()} limit $start,$pageSize";
              // echo $sql;exit;
             }else{
            $sql="select $fields from {$this->getTable()} where $condition  limit $start,$pageSize";
               // echo $sql;exit;
           }
          
         return $this->db->fetchAll($sql);
        }
 	 // 构建一个方法执行desc表名保存并记录每个字段名针对为主键那个字段单独记录
 	 private function getFields(){
 	 	//构建desc sql语句
 	 	$sql = "desc {$this->getTable()}";
 	 	$rows = $this->db->fetchAll($sql);
 	 	foreach($rows as $row){
 	 		//判定了主键列进行单独的记录
 	 		if ($row["Key"]=="PRI") {
 	 			$this->fields["pk"]="`{$row['Field']}`";
 	 		}else{
 	 			 //记录保存所有字段名
                $this->fields[]="`{$row['Field']}`";
 	 		}
 	 	}
 	 }
 	  // 封装一个读取一条数据的方法
 	 protected   function getRowByPK($id,$fileds="*"){
 	  	//构建sql语句
 	  	$sql="select $fileds from {$this->getTable()} where {$this->fields['pk']}='$id'";
 	  	return $this->db->fetchRow($sql);
 	  }
 	  //封装按主键删除一条数据
   	 protected    function deleteRowByPk($id){
        // 构建删除语句
        $sql="delete from {$this->getTable()} where {$this->fields['pk']}='$id'";
       
        //执行语句
        return $this->db->query($sql);
 		}
 		//添加一个过滤的方法 如果传递数据的键不再已有的字段中从中删除多余的数据
	 private function filterFields($data){
		//遍历查看键名是否在已经保存的字段中，如果没有就删除
		foreach($data as $key=>$value){
			//判定键是否在存在的字段中
			if(!in_array("`$key`", $this->fields)){
				unset($data[$key]);
			}
		}
  			return $data;
	}
 		//封装添加数据的方法
	 public function insert($data){
		// 调用方法进行过滤
		$data = $this->filterFields($data);
		$str="";
		//将数组构建为字段名=值的形式
		foreach($data as $key=>$value){
            $str.="`$key`='$value',";
        }    
        //去掉最后的逗号
		$str=substr($str,0,-1);
		//构建sql语句
        $sql="insert into {$this->getTable()} set $str";
       //执行语句
        return $this->db->query($sql);
	}
	 //构建修改数据的方法
     protected   function updateByPk($data){
        //过滤有效的数据
         $data=$this->filterFields($data);
         $str="";
        //将数组构建为字段名=值的形式
        foreach($data as $key=>$value){
            $str.="`$key`='$value',";
        }          
        //去掉最后的逗号
        $str=substr($str,0,-1);
        // 取得有反引号的字段名
        $pk=$this->fields["pk"];
        $pk= str_replace("`", "", $pk);
         $val=$data[$pk];
        //构建sql语句
        $sql="update {$this->getTable()} set $str where {$this->fields['pk']}='$val'";
        //执行语句
         return $this->db->query($sql);
    }
    //按条件读取一条数据的方法
    protected function getRow($condition,$fileds='*'){
        //构建sql语句
        $sql="select $fileds from {$this->getTable()} where $condition";
        
       return $this->db->fetchRow($sql);
       
    }
     //添加一个求取数据总条数的方法
    public function getCount(){
        $sql="select count(*) from {$this->getTable()}";

        return $this->db->fetchColumn($sql);
    }
}
?>