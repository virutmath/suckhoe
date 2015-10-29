<?php 
session_start();	
error_reporting(E_ALL);
require_once("../functions/functions.php");
require_once('../includes/inc_constant.php');
require_once("../classes/database.php");
require_once("resources/security/functions.php");
require_once("resources/security/functions_1.php");
$username	= getValue("username", "str", "POST", "", 1);
$password	= getValue("password", "str", "POST", "", 1);
$action		= getValue("action", "str", "POST", "");

if($action == "login"){
	$user_id	= 0;
	$user_id = checkLogin($username, $password);
	if($user_id != 0){
		$isAdmin		= 0;
		$db_isadmin	= new db_query("SELECT adm_isadmin FROM admin_users WHERE adm_id = " . $user_id);
		$row			= mysqli_fetch_array($db_isadmin->result);
		if($row["adm_isadmin"] != 0) $isAdmin = 1;
		//Set SESSION
		$_SESSION["logged"]			= 1;
		$_SESSION["user_id"]		= $user_id;
		$_SESSION["userlogin"]		= $username;
		$_SESSION["password"]		= md5($password);
		$_SESSION["isAdmin"]			= $isAdmin;

		unset($db_isadmin);
        redirect('index.php');
	}
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administrator Managerment</title>
<link rel="stylesheet" type="text/css" href="resources/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="resources/css/common.css" />
<link rel="stylesheet" type="text/css" href="resources/css/home.css" />
<script src="resources/js/jquery.js" type="text/javascript"></script>
</head>
<body>
<form method="post" action="" class="form-horizontal">
    <div class="login_container" style="margin: 150px auto;width:500px;padding:20px">
        <div class="form-group">
            <label class="control-label col-sm-4">Tên đăng nhập :</label>
            <div class="col-sm-6">
                <input type="text" name="username" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Mật khẩu :</label>
            <div class="col-sm-6">
                <input type="password" name="password" class="form-control"/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-10">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                <button type="reset" class="btn btn-default">Nhập lại</button>
                <input type="hidden" name="action" value="login"/>
            </div>

        </div>
    </div>
</form>
</body>
</html>