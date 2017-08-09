<?php
	include_once "lib/fun.php";
	if(!checkLogin()){
		msg(2,"请登录","user.php");exit;
	}
	if(!empty($_POST["name"])){
		$goodsId = intval($_POST["goodsId"]);
//		echo $goodsId;die;
	}
		$pdo =mysqlInit("mysql","localhost","artgallary","root","");//数据库连接	
		$name = mysql_real_escape_string(trim($_POST["name"]));
		$price = intval($_POST["price"]);
		$des = mysql_real_escape_string(trim($_POST["des"]));
		$content = mysql_real_escape_string(trim($_POST["content"]));
//		var_dump((bool)$_FILES["file"]);exit;
		if($pic = $_FILES["file"]["size"] > 0){
			$pic = imgUpload($_FILES["file"], $_SESSION["user"]["user_id"]);
		}else{
			$pic = "";
		}
		$now = time();
		if(!$pic){
			$sql = "update goods set goodsname='{$name}',price='{$price}',des='{$des}',content='{$content}',update_time='{$now}' where goods_id='{$goodsId}' ";
		}else{
			$sql = "update goods set goodsname='{$name}',price='{$price}',des='{$des}',content='{$content}',update_time='{$now}',pic='{$pic}' where goods_id='{$goodsId}' ";
		}
		
		$result = $pdo->exec($sql);//die;
		if($result){
			msg(1,"操作成功","user.php");exit;
		}else{
			msg(2,"操作失败","edit.php");exit;
		}
	
?>