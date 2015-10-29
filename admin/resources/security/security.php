<?php
session_start();
ob_start();
error_reporting(E_ALL);
require_once '../../../includes/inc_constant.php';
require_once('../../../classes/database.php');
require_once('../../../classes/generate_form.php');
require_once("../../../classes/simple_html_dom.php");
require_once('../../../classes/rain.tpl.class.php');
require_once('../../../functions/functions.php');
require_once('../../../functions/rewrite_functions.php');
require_once('../../../functions/form.php');
require_once('../../../functions/date_functions.php');
require_once("../../../functions/file_functions.php");
require_once("../../../functions/cron_news_functions.php");


require_once('functions.php');
require_once('grid.php');
require_once('functions_1.php');
require_once('security_function_security.php');

RainTpl::configure("base_url", null );
RainTpl::configure("tpl_dir", "../../resources/templates/" );
RainTpl::configure("cache_dir", "../../resources/caches/" );
RainTPL::configure("path_replace_list",array());

$admin_id 				= getValue("user_id","int","SESSION");
$isAdmin	=	getValue("isAdmin", "int", "SESSION", 0);

$css_global = '';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/bootstrap.min.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/js/bootstrap-tagsinput.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/font-awesome.min.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/js/enscroll.css" media="print"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/common.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/template.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/js/datepicker/datepicker.css" media="screen"/>';
/* khai báo css cho máy in */
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/bootstrap.min.css" media="print"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/font-awesome.min.css" media="screen"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/js/enscroll.css" media="print"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/common.css" media="print"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/template.css" media="print"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="../../resources/css/datepick.css" media="print"/>';


$js_global = '';
$js_global .= '<script src="../../resources/js/jquery.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/plupload/plupload.full.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/bootstrap.min.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/bootstrap-tagsinput.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/jquery.autonumeric.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/tinymce/tinymce.min.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/enscroll-0.5.5.min.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/datepicker/datepicker.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/jquery.autocomplete.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/printer/printer.js" type="text/javascript"></script>';
$js_global .= '<script src="../../resources/js/script.js" type="text/javascript"></script>';
$load_header = $css_global.$js_global;
$load_header .= '<title>Hệ thống quản lý CMS</title>';
?>
