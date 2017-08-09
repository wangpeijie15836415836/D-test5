<?php
	/*数据库连接初始化函数*/
	function mysqlInit($dbms,$host,$dbname,$username,$password){
		$dsn = "{$dbms}:host={$host};dbname={$dbname}";
		$pdo = new PDO($dsn,$username,$password);
		$pdo->query("set names utf8");//设置字符编码
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);//设置警告异常
		return $pdo;
	}
	
	//跳转页面
	function msg($type,$msg=null,$url=null){
		$tomsg = "location:msg.php?type={$type}";
		$tomsg .= $msg ? "&msg={$msg}" : "";
		$tomsg .= $url ? "&url={$url}" : "";
		header($tomsg);
	}
	
	//判断登录
	function checkLogin(){
		session_start();
		if(isset($_SESSION["user"])){
			return true;
		}else{
			return false;
		}
	}
	
//	上传图片并返回上传图片的路径
	function imgUpload($file,$userId){
		
		//判断是否是通过http请求上传的文件
		if(!is_uploaded_file($file["tmp_name"])){
			msg(2,"请通过合法路径上传文件");
		}
		//判断上传文件的类型
		if(!in_array($file["type"], array("image/png","image/gif","image/jpeg"))){
			msg(2,"请上传png,gif,或jpg格式的文件");
		}
		//
		$filePath = "file/";
		$imgPath = "{$userId}/".date("Y/md/",time());
//		"file/1/2017/0807/meinv.jpg"
		$ext =strtolower(pathinfo($file["name"],PATHINFO_EXTENSION));//获取文件后缀名(jpg/png)
//		var_dump($ext);
		$img = uniqid().rand(1000,9999);//存储的图片名称    uniqid()获取微秒数   
//		echo $img;
		//判断指定的路径是否存在，若不存在则创建文件夹
		if(!is_dir($filePath.$imgPath)){
			mkdir($filePath.$imgPath,0777,true);			
		}
		
		//将文件从临时目录移动到指定目录，若成功提示操作成功，跳转到user.php，若失败提示操作失败
		$uploadPath = $filePath.$imgPath.$img.".".$ext;
		$imgUrl = "http://localhost/D-test5/".$uploadPath;
		if(move_uploaded_file($file["tmp_name"], $uploadPath)){
			return $imgUrl;
//			msg(1,"操作成功","user.php");
		}else{
			msg(2,"操作失败，请重试");
		}
	}
	
	
	//获取url链接
	function getUrl($page){
		$url = $_SERVER["REQUEST_SCHEME"]."://";//http://
		$url .= $_SERVER["HTTP_HOST"];//http://localhost
		$url .= $_SERVER["SCRIPT_NAME"];//http://localhost/D-test5/user.php
		$queryString = $_SERVER["QUERY_STRING"];//page=3&id=1&name=abc
		parse_str($queryString,$queryArr);
//		print_r($queryArr);die;
		if(isset($queryArr["page"])){
			unset($queryArr["page"]);
		}
		$queryArr["page"] = $page;
		$queryString = http_build_query($queryArr);//将数组转化为请求字符串name=abc&id=1&page=12
//		echo $queryString;die;
		$url .= "?".$queryString;
		return $url;
	}
	
//	创建页码函数，用来输出一个放有页码标签的字符串
	function pages($totalPage,$page,$show=5){
		$pageStr = "";
		if($totalPage > 1){
//			设置页码起始点
			$from = max(1,$page - intval($show / 2));
//			设置页码的结束点
			$to = $from + $show - 1;
			
			if($to > $totalPage){
				$to = $totalPage;
				$from = max(1,$to - $show + 1);
			}
			
			$pageStr .= "<div class='page-nav'>";
			$pageStr .= "<ul>";
			
			if($page > 1){
				$pageStr .= "<li><a href='".getUrl(1)."'>首页</a></li>";
				$pageStr .= "<li><a href='".getUrl($page-1)."'>上一页</a></li>";
			}
			
			if($from > 1){
				$pageStr .= "<li>...</li>";
			}
			
			for($i=$from; $i<=$to; $i++){
				if($i == $page){
					$pageStr .= "<li><span class='curr-page'>{$i}</span></li>";
				}else{
					$pageStr .= "<li><a href='".getUrl($i)."'>{$i}</a></li>";
				}
			}
			
			if($to < $totalPage){
				$pageStr .= "<li>...</li>";
			}
			
			if($page < $totalPage){
				$pageStr .= "<li><a href='".getUrl($page + 1)."'>下一页</a></li>";
				$pageStr .= "<li><a href='".getUrl($totalPage)."'>尾页</a></li>";
			}	
			$pageStr .= "</ul></div>";		
		}
		
		return $pageStr;
	}
	
	
?>