<?php
class PageTool{
    public static function  fPage($url,$pageSize,$count,$page){
        //计算总页数
        $pageCount=ceil($count/$pageSize);
         //计算下一页
         $nextPage=$page+1>$pageCount?$pageCount:$page+1;
         $options="";
         for($i=1;$i<=$pageCount;$i++){  
             //判定$i与page相等 选中
             if($i==$page)
                $options.="<option value='$i' selected='selected'>$i</option>";
             else
                 $options.="<option value='$i'>$i</option>";
         }
        //计算上一页
         $prePage=$page-1<1?1:$page-1;   
        $str=<<<Page
            总计 $count 个记录分为 $pageCount 页当前第 $page 页，
           每页<input size="2" id="pageSize" onblur="jump('$url&page=1')" type="text" value="$pageSize"/>&nbsp;|&nbsp;
           <a onclick="jump('$url&page=1')">  首页</a>&nbsp;&nbsp;&nbsp;
           <a onclick="jump('$url&page=$prePage')">   上一页</a>&nbsp;&nbsp;&nbsp;
           <a onclick="jump('$url&page=$nextPage')">  下一页</a>&nbsp;&nbsp;&nbsp;
           <a onclick="jump('$url&page=$pageCount')">   尾页</a>&nbsp;&nbsp;&nbsp; 
               <select id="page" onchange="jump('$url&page='+this.value)">
                   $options
                </select>
            <script type="text/javascript">
                function jump(url){
                    //声明变量 保存文本框中的值
                    var pageSize=document.getElementById("pageSize").value;
                    //跳转的语法
                    location.href=url+"&pageSize="+pageSize;
                }
            </script>
Page;
        return $str;
    }
}
