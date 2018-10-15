<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- 欢迎使用，程序来自：xptt.com  有什么建议欢迎交流 https://xptt.com/xptt-general-query-support-to-add-the-database-phptxt.html -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>xptt通用查询系统-支持后台创建txt数据库</title>
    <body>
        <?php
        ob_start();
        session_start();
        ?>
        <?php
        if ($_POST['submitdenglu']) {
            if ($_POST['password'] == "admin") {
                //修改密码~~~~~
                $_SESSION['xpttcomchaxun'] = $_POST['password'];

            }
        }
        ?>

        <?php  session_start () ;
        if (!isset ($_SESSION['xpttcomchaxun'])) {
            echo "<script language=javascript>window.location='denglu.php'</script>";
            exit () ;
        }
        ?>

        <?php
        if ($_GET['tj'] == 'logout') {
            session_start();
            //开启session
            session_destroy();
            //注销session
            header("location:denglu.php");
            //跳转到首页
        }
        ?>

        <a href="shujuku.php?tj=logout">退出登录</a> <a href="index.php">返回查询首页</a>

        <?php
        //数据库管理
        $path = "./";
        //一、根据action的信息值，做对应的操作
        switch ($_GET['action']) {
            case "del"://删除一个文件信息
                unlink($_GET["filename"]);
                break;
            case "create":
                //获取要创建的数据库名
                $filename = trim($path,"/")."/".$_POST["filename"];
                //判断数据库是否已经存在
                if (file_exists($filename)) {
                    die ("要创建的数据库已经存在");
                }
                //创建这个数据库
                $filename = $filename.".txt";
                //不让你创建其他格式东东
                $f = fopen($filename,"w");
                $txt = "把excel的数据直接选择粘贴到下面，此行不能删除，否则无法查询你的第一行数据\n";
                fwrite($f, $txt);
                fclose($f);
                break;
            case "edit"://编辑文件信息
                //获取数据库名
                $filename = $_GET["filename"];
                //读取数据库内容
                $fileinfo = file_get_contents($filename);

                break;
            case "update"://执行修改文件信息
                //获取数据库名和内容
                $filename = $_POST["filename"];
                $content = $_POST["content"];
                //执行数据库内容修改
                file_put_contents($filename,$content);
                break;

            case "gaiming"://改名
                //获取数据库名
                $filename = $_GET["filename"];
                break;

            case "rename"://改名
                $old = $_POST["oldfilename"].".txt";
                $_POST["filename"] = $_POST["filename"].".txt";
                $new = $_POST["filename"];
                echo $old,$new;
                rename($old,$new);
                break;
        }
        //二、浏览指定目录下的数据库,并使用表格输出

        //path目录信息的过滤，判断path存在，并且是否是目录
        if (!file_exists($path)||!is_dir($path)) {
            die($path."目录无效！");
        }
        echo "<h3><a href='shujuku.php?action=add'>创建数据库</a></h3>";
        //输出表头信息
        echo "<h3>{$path}目录下的数据库：</h3>";
        echo "<table width='600' border='0'>";
        echo "<tr bgcolor='#cccccc' align='left'>";
        echo "<th>序号</th><th>名称</th><th>类型</th><th>大小</th><th>创建时间</th><th>操作</th>";
        echo "</tr>";

        //打开这个目录，并遍历目录下的数据库,并输出数据库信息
        $dir = opendir($path);
        //指定过滤掉的管理文件
        $filtlist = array("shujuku.php","index.php","denglu.php");
        $i = 0;
        if ($dir) {
            while ($f = readdir($dir)) {
                if ($f == "." || $f == ".." || in_array($f,$filtlist))
                    continue;
                $file = trim($path,"/")."/".$f;
                $i++;
                echo "<tr>";
                echo "<td>{$i}</td>";
                echo  "<td>{$f}</td>";
                echo  "<td>".filetype($file)."</td>";
                echo  "<td>".filesize($file)."</td>";
                echo  "<td>".date("Y-m-d H:i:s ",filectime($file))."</td>";
                echo  "<td><a href='shujuku.php?filename={$file}&action=del'>删除</a>
      <a href='shujuku.php?filename={$file}&action=edit'>编辑</a> <a href='shujuku.php?filename={$file}&action=gaiming'>修改数据库名</a></td>";
                echo  "<tr></tr>";
            }
            closedir($dir);
            //关闭目录
        }
        echo "<tr bgcolor='#cccccc' align='left'><td colspan='6'> </td></tr>";

        echo "</table>";
        //三、、判断是否需要创建数据库的表单，若则输出
        if ($_GET["action"] == "add") {
            echo "<form action='shujuku.php?action=create' method='post'>";
            echo "新建文件：<input type= 'text' name=filename> .txt ";
            echo "<input type= 'submit' value='新建文件'>";
            echo "</form>";
        }
        //四、判断是否需编辑数据库的表单，若则输出
        if ($_GET["action"] == "edit") {
            echo "<form action='shujuku.php?action=update' method='post'>";
            echo "<input type='hidden'name='filename' value='{$filename}'/>";
            echo "文件名：{$filename}<br/><br>";
            echo "文件内容：<br/><br/><textarea name='content' cols='100%'rows='6'>{$fileinfo}</textarea><br/><br/>";
            echo "<input type= 'submit' value='确认编辑'>";
            echo "</form>";
        }

        if ($_GET["action"] == "gaiming") {
            echo "<form action='shujuku.php?action=rename' method='post'>";
            $filename = str_replace(strrchr($filename, "."),"",$filename);
            $filename = substr($filename,2);
            echo "<input type='hidden'name='oldfilename' value='{$filename}'/>";
            echo "<input type='text'name='filename' value='{$filename}'/>";
            echo "<input type= 'submit' value='确认修改'>";
            echo "</form>";
        }

        ?>
    </body>
</head>
</html>
