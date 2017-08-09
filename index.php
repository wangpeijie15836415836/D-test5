<?php
	include_once "lib/fun.php";
	$pdo =mysqlInit("mysql","localhost","artgallary","root","");//数据库连接
	
	$result = $pdo->query("select count(goods_id) as total from goods");
	$row = $result->fetchAll(PDO::FETCH_ASSOC);
	$total = $row[0]["total"];
	$pageSize = 2;
	$totalPage = ceil($total/$pageSize);	
	
	$page = isset($_GET["page"])&&intval($_GET["page"]) ? intval($_GET["page"]) : 1;
	$page = max(1,$page);	
	$offset = ($page - 1) * $pageSize;
		
	$result = $pdo->query("select goods_id,pic,goodsname,des from goods order by goods_id limit {$offset},{$pageSize}");
	$goods = $result->fetchAll(PDO::FETCH_ASSOC);
	$pages = pages($totalPage,$page);
//	print_r($goods);
	
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>M-GALLARY|首页</title>
    <link rel="stylesheet" type="text/css" href="static/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/index.css"/>
</head>
<body>
<div class="header">
    <div class="logo f1">
        <img src="static/img/logo.png">
    </div>
    <div class="auth fr">
        <ul>

            <li><a href="login.php">登录</a></li>
            <li><a href="register.php">注册</a></li>
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
                <img style="width: 358.5px;height: 215px;" class="img-li-fix" src="<?php echo $v["pic"]; ?>" alt="">
                <div class="info">
                    <a href="detail.php?goodsId=<?php echo $v["goods_id"]; ?>"><h3 class="img_title"><?php echo $v["goodsname"]; ?></h3></a>
                    <p><?php echo $v["des"]; ?></p>                                        
                </div>
            </li>
            <?php endforeach; ?>
            	
            	
       		 <!--<li>
                <img class="img-li-fix" src="static/img/hongmofangde wuhui.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">红磨坊的舞会</h3></a>
                    <p>这幅作品描绘出众多的人物，给人拥挤的感觉，人头攒动，色斑跳跃，热闹非凡，给人以愉快欢乐的强烈印象。画面用蓝紫为主色调，使人物由近及远，产生一种多层次的节奏感。                                     
                    </p>
                </div>
            </li>-->
            <!--<li>
                <img class="img-li-fix" src="static/img/richuyinxing.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">日出·印象</h3></a>
                    <p> 日出时， 海上雾气迷朦， 水中反射着天空和太阳的颜色．岸上景色隐隐约约， 模模糊糊看不清， 给人一种瞬间的感受。                                     
                    </p>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/songshulinzhicheng.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">松树林之晨</h3></a>
                    <p>晨光为松树林涂上一层金辉，松林里荡漾着清新的生气。松树林苏醒了，几只黑熊在嬉闹玩耍，为宁静的松树林增添了生息。                                        
                    </p>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/wen.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">吻</h3></a>
                    <p>《吻》是一幅正方形的画作，呈现出一对相拥在一起的恋人，他们的身体借由长袍缠绕在一起。</p>
                </div>
            </li>
            <li>
                <img class="img-li-fix" src="static/img/wumingnvlang.jpg" alt="">
                <div class="info">
                    <a href=""><h3 class="img_title">无名女郎</h3></a>
                    <p>无名女郎，是俄国画家伊万·尼古拉耶维奇·克拉姆斯柯依于1883年创作的一幅现实主义肖像画，是用油彩画于画布之上，现收藏于莫斯科的特列恰科夫美术博物馆。                                        
                    </p>
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
        </div>
</div>-->

<div class="footer">
    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
</div>
</body>

</html>
