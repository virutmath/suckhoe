<?php
session_start();
error_reporting(E_ALL);
require_once("../functions/functions.php");
require_once("../classes/database.php");
require_once('../includes/inc_constant.php');
require_once("resources/security/functions.php");
require_once("resources/security/functions_1.php");
checkLogged('login.php');
$isAdmin = getValue('isAdmin', 'int', 'SESSION', 0);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Administrator Managerment</title>
    <link rel="stylesheet" type="text/css" href="resources/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="resources/js/enscroll.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/common.css"/>
    <link rel="stylesheet" type="text/css" href="resources/css/home.css"/>
    <script src="resources/js/jquery.js" type="text/javascript"></script>
    <script src="resources/js/enscroll-0.5.5.min.js" type="text/javascript"></script>
    <script src="resources/js/home.js" type="text/javascript"></script>
    <script src="resources/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
<div id="logocms">
    <?php include 'resources/php/inc_header.php' ?>
</div>
<div id="home_left" class="fl">
    <div id="menu_header">
        <form role="search">
            <input type="text" class="search-bar form-control" placeholder="Tìm chức năng...">
            <i class="fa fa-search field-icon-right"></i>
            <button type="submit" class="search-module btn btn-default hidden"></button>
        </form>
    </div>
    <div id="menu_list">
        <?php include 'resources/php/inc_left.php' ?>
    </div>

</div>
<div id="home_right" class="fl rlt">
    <div id="home_function" class="abs">
        <span class="home_function_item" id="viewHomePage" title="Xem trang chủ"><i class="fa fa-home"></i></span>
        <span class="home_function_item" id="viewBackPage" title="Xem trang trước" onclick="window.history.back()"><i
                class="fa fa-arrow-left"></i></span>
        <span class="home_function_item" id="reloadFrame" title="Nạp lại khung"><i class="fa fa-refresh"></i></span>
    </div>

    <iframe src="intro.php" id="main_frame">

    </iframe>
    <div id="footer">
        <?php include 'resources/php/inc_footer.php' ?>
    </div>
</div>

</body>
</html>