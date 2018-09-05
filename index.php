<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- 欢迎使用，程序来自：xptt.com  有什么建议欢迎交流 -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>xptt通用查询系统-支持后台创建txt数据库</title>
  <style>
    .chax{width:550px;margin:0 auto;}
    
    
    .search-input{
  
  padding: 8px 5px 8px 15px;
  width: 150px;
  border-radius: 18px; 
  color: #ccc; 
          
            outline: none; 
            overflow:hidden; 
            border-radius: 18px; 
          
            border: 1px solid #ddd; 
            -moz-box-shadow: inset 1px 1px 10px rgba(0,0,0,0.1); 
            -webkit-box-shadow: inset 1px 1px 10px rgba(0,0,0,0.1); 
            box-shadow: inset 1px 1px 10px rgba(0,0,0,0.1); 
            -webkit-transition: all .3s; 
            -moz-transition: all .3s; 
            -o-transition: all .3s; 
}

.search-input:hover, .search-input:focus {
    border-color: #fff;
    color: #444;
width: 200px;
}

.xuanze{padding:5px;font-size:16px;}
    
    
@media only screen and (max-width: 750px)  {
    .chax {
        width: 100%;
    }
}

@media only screen and (max-width: 470px)  {
    .chax  {
        width: 100%;
    }
}
    
    @media only screen and (max-width: 334px)  {
    .chax  {
        width: 100%;
    }
}



</style>
  <body>
     
      
      
<div class="chax">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

<form action="" method="get" style=" margin-top:5px;" >
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
<tr>
<td align="center" bgcolor="#FFFFFF"><br>
  
  选择数据库：<select name="shujuming" id="shujuming" class="xuanze" onchange="save()"> //self.location.href=options[selectedIndex].value;onchange=save() 点击刷新
              <?php
    $shujuming=glob("*.txt");
  $shujumingcheng=str_replace(strrchr($shujuming, "."),"",$shujuming);
        for ($i=0; $i<count($shujuming); $i++) { 
echo "<option value='$shujuming[$i]'>$shujumingcheng</option>"; 
} 
      ?>
              </select> <a href="denglu.php">添加数据库</a><br><br>
  
  输入：<input class="search-input" type="text" id="chaxun" name="chaxun" value="请输入搜索内容..." onblur="if(this.value=='') value='请输入搜索内容...';" onclick="if(this.value=='请输入搜索内容...')value='';"/> <input class="BtnStyle" style="WIDTH: 64px" type="submit" value="查询" name="Submit" id="Submit" />
<br><br>
  </tr>

</table>
</form>
        

<?php 
if(isset($_GET['Submit'])){ 
   foreach ($_GET as $key=>$v){
   ${$key}=$v;
   }
  $lines = file ($_GET['shujuming']); //数据库文件txt 比如：'crom.txt'
$rs=array();
  $n=0;
  foreach ($lines as $line_num => $line) {
    if($line_num>0){
      $t=0;
      $p = explode(' ',$line); 
      if($_GET['chaxun']<>""){
        if(strstr($p[0],$chaxun)){
        $t=1; //从0开始
        }
        
      }
    }

    if($t==1){
      $rs[$n]['je']=$p[0];
    $n++;
    }
  }
       
echo "<table width='100%' border='0' align='center' cellpadding='5' cellspacing='1' bgcolor='#B3B3B3'>
<tr>
<th width='60' bgcolor='#EBEBEB'><span id='tongji'></span> 个结果</th> 
</tr>";

$h=0;
foreach ($rs as $k=>$v) {
$h++;
echo "<tr>";
echo "<td align='left' bgcolor='#FFFFFF'>".$v['je']."</td>";
echo "</tr>";
}
echo "</table>";
  
//$count += $v['je']; //计算
}
  ?>        
     <script language="javascript" type="text/javascript">      function save() {  
        selectIndex = document.getElementById("shujuming").selectedIndex;  
        document.cookie = 'selectIndex =' + selectIndex;  
    }  
    window.onload = function () {  
        var cooki = document.cookie;  
        if (cooki != "") {  
            cooki = "{\"" + cooki + "\"}";  
            cooki = cooki.replace(/\s*/g, "").replace(/=/g, '":"').replace(/;/g, '","');  
            var json = eval("(" + cooki + ")"); //将coolies转成json对象  
            document.getElementById("shujuming").options[json.selectIndex].selected = true;  
        }  
        else  
            save();  
    }  
</script>   
  
  </div>
  <script language="javascript">
document.getElementById("tongji").innerHTML="<?='<font color=blue> '.$h.'</font>'?>"
</script>
  
 
</body>
</html>
