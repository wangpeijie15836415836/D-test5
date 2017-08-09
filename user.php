<?php
	//var_dump($_SERVER);die;
	include_once "lib/fun.php";
	getUrl(1);
//	session_start();//开启session
	if(!checkLogin()){//判断session是否存在
		msg(2,"请完成登录","login.php");
	}
//	 print_r($_SESSION["user"]);die;
	 $user = $_SESSION["user"]["username"];	 
	 $userId = $_SESSION["user"]["user_id"];
//	 数据库中查询
	$pdo =mysqlInit("mysql","localhost","artgallary","root","");//数据库连接	
	
	$page = isset($_GET["page"])&&intval($_GET["page"])?intval($_GET["page"]):1;//判断页数   给$page设置默认值
	$page = max(1,$page);//限制$page不能小于1
	$pageSize = 3;//设置每页最多展示的数据条数
	$result = $pdo->query("select count(goods_id) as total from goods where user_id={$userId}");
	$row = $result->fetchAll(PDO::FETCH_ASSOC);	
	$total = $row[0]["total"];//获取该用户上传的作品总条数
	if($total == 0){
		msg(2,"你还未上传任何作品，请先上传作品","publish.php");
	}
	$totalPage = max(1,ceil($total/$pageSize));//总页数
	$page = $page > $totalPage ? $totalPage : $page;//$page不能超出最大页数
	$offset = ($page-1) * $pageSize;//偏移量
	
	$result = $pdo->query("select goods_id,goodsname,des,pic from goods where user_id='{$userId}' order by goods_id asc limit {$offset},{$pageSize}");//查询,将关于画的字段取出来
	$goods = $result->fetchAll(PDO::FETCH_ASSOC);
//	print_r($goods);die;
	//调用函数，拼接按钮结构，并返回字符串
	$pages = pages($totalPage,$page);
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|首页</title>
    <link rel="stylesheet" type="text/css" href="static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/index.css"/>
   
</head>
<style type="text/css">
    	.img-li-fix{
    		width: 358px;
    		height: 276.84px;
    	}
    </style>
<body>
<div class="header">
    <div class="logo f1">
        <img src="static/img/logo.png">
    </div>
    <div class="auth fr">
        <ul>
            <li><span>管理员：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $user; ?></span></li>
            <li><a href="publish.php">发布</a></li>
            <li><a href="login_out.php">退出</a></li>
        </ul>
    </div>
</div>
<div class="content">
    <div class="banner">
        <img class="banner-img" src="static/img/welcome.png" width="732px" height="372px" alt="图片描述">
    </div>
    <div class="img-content">
        <ul>
        	<?php foreach($goods as $v): ?>
            <li>
                <img class="img-li-fix" src="<?php echo $v["pic"]; ?>" alt="">
                <div class="info">
                    <a href="detail.php?goodsId=<?php echo $v["goods_id"]; ?>"><h3 class="img_title"><?php echo $v["goodsname"]; ?></h3></a>
                    <p><?php echo $v["des"]; ?>                    
                    </p>
                    <div class="btn">
                        <a href="edit.php?goodsId=<?php echo $v["goods_id"]; ?>" class="edit">编辑</a>
                        <a href="delete.php?goodsId=<?php echo $v["goods_id"]; ?>" class="del">删除</a>
                    </div>
                </div>
            </li>
            <?php endforeach ;?>
            <!--<li>
                <img class="img-li-fix" src="static/img/hongmofangde wuhui.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">红磨坊的舞会</h3></a>
                    <p><?php echo $v["des"]; ?>                                     
                    </p>
                    <div class="btn">
                        <a href="edit.html" class="edit">编辑</a>
                        <a href="delete.html" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/richuyinxing.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">日出·印象</h3></a>
                    <p> 日出时， 海上雾气迷朦， 水中反射着天空和太阳的颜色．岸上景色隐隐约约， 模模糊糊看不清， 给人一种瞬间的感受。                                     
                    </p>
                    <div class="btn">
                        <a href="edit.html" class="edit">编辑</a>
                        <a href="delete.html" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/songshulinzhicheng.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">松树林之晨</h3></a>
                    <p>晨光为松树林涂上一层金辉，松林里荡漾着清新的生气。松树林苏醒了，几只黑熊在嬉闹玩耍，为宁静的松树林增添了生息。                                        
                    </p>
                    <div class="btn">
                        <a href="edit.html" class="edit">编辑</a>
                        <a href="delete.html" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/wen.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">吻</h3></a>
                    <p>画面描写了人们在塞纳河阿尼埃的大碗岛上休息度假的情景：阳光下的河滨树林间，  人们在休憩、散步，垂钓，河面上隐约可见有人在划船，午后的阳光拉下人们长长的身影，画面宁静而和谐。这幅画主要采用了点彩画法                    
                    </p>
                    <div class="btn">
                        <a href="edit.html" class="edit">编辑</a>
                        <a href="delete.html" class="del">删除</a>
                    </div>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>无名女郎，是俄国画家伊万·尼古拉耶维奇·克拉姆斯柯依于1883年创作的一幅现实主义肖像画，是用油彩画于画布之上，现收藏于莫斯科的特列恰科夫美术博物馆。                                        
                    </p>
                    <div class="btn">
                        <a href="edit.html" class="edit">编辑</a>
                        <a href="delete.html" class="del">删除</a>
                    </div>
                </div>
            </li>-->

        </ul>
    </div>
    	<?php echo $pages; ?>
   		<!--<div class="page-nav">
            <ul>
                <li><a href="#">首页</a></li>
                <li><a href="#">上一页</a></li>
                <li><span class="curr-page">1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>...</li>
                <li><a href="#">98</a></li>
                <li><a href="#">99</a></li>
                <li><a href="#">下一页</a></li>
                <li><a href="#">尾页</a></li>
            </ul>
        </div>-->
</div>

<div class="footer">
    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
</div>
</body>

</html>
