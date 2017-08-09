<?php
	include_once "lib/fun.php";
	if(!empty($_POST['username'])){		
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$pdo =mysqlInit("mysql","localhost","artgallary","root","");	
		$username = mysql_real_escape_string($username);//会自动识别特殊字符，比如用户名写了分号啥的，这句代码可以解决这个问题
		$password = mysql_real_escape_string($password);//会自动识别
		//echo $username;die;		
		
		$result = $pdo->query("select count(user_id) as total from user where username='{$username}'");//一个对象
		$row = $result->fetchAll(PDO::FETCH_ASSOC);	
		if($row[0]['total']>0){
			//echo "用户已存在";
//			header("location:msg.php?type=2&msg=用户已存在&");
			msg(2,"用户已存在");//fun函数重定义
		}else{
			$now = time();//将时间戳赋值给变量now
			$password = md5(md5($password)."gallery");//加密password
			$result = $pdo->exec("insert into user(username,password,createTime) values('{$username}','{$password}','{$now}')");
			
			if($result){//如果插入成功
				msg(1,"注册成功，请登录","login.php");
			
			}else{
				msg(2,"注册失败，请重试");
				echo "注册失败，请重试";
			}
		}		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
	<title>用户注册</title>
	<link href="static/css/common.css" type="text/css" rel="stylesheet">
  <link href="static/css/add.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="static/css/login.css">
</head>
<body>
  <div class="header">
   <div class="logo f1">
    <img src="static/img/logo.png">
  </div>
  <div class="auth fr">
    <ul>
     <li><a href="#">登录</a></li>
     <li><a href="#">注册</a></li>
   </ul>
 </div>
</div>
<div class="content">
  <div class="center">
    <div class="center-login">
      <div class="login-banner">
       <a href="#"><img src="static/img/login_banner.png" alt=""></a>
     </div>
     <div class="user-login">
       <div class="user-box">
         <div class="user-title">
           <p>用户注册</p>
         </div>
         <form class="login-table" name="register" id="register-form" action="register.php" method="post">
            <div class="login-left">
                <label class="username">用户名</label>
                <input type="text" class="yhmiput" name="username" placeholder="Username" id="username">
            </div>
            <div class="login-right">
                <label class="passwd">密码</label>
                <input type="password" class="yhmiput" name="password" placeholder="Password" id="password">
            </div>
            <div class="login-right">
                <label class="passwd">确认</label>
                <input type="password" class="yhmiput" name="repassword" placeholder="Repassword"
                       id="repassword">
            </div>
            <div class="login-btn">
                <button type="submit">注册</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<div class="footer">
    <p><span>Art-GALLARY</span>©2017 GOOD GOOD STUDY DAY DAY UP</p>
</div>

</body>
<script src="static/js/jquery-1.10.2.min.js" type="text/javascript" charset="utf-8"></script>
<!--layer.js小插件，判断输入框-->
<script src="static/js/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(function () {
        $('#register-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val(),
                repassword = $('#repassword').val();
            if (username == '' || username.length <= 0) {
                layer.tips('用户名不能为空', '#username', {time: 2000, tips: 2});
                $('#username').focus();
                return false;
            }

            if (password == '' || password.length <= 0) {
                layer.tips('密码不能为空', '#password', {time: 2000, tips: 2});
                $('#password').focus();
                return false;
            }

            if (repassword == '' || repassword.length <= 0 || (password != repassword)) {
                layer.tips('两次密码输入不一致', '#repassword', {time: 2000, tips: 2});
                $('#repassword').focus();
                return false;
            }

            return true;
        })

    })
</script>
</html>