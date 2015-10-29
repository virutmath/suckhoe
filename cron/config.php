<?
//Cấu hình biến static lưu các giá trị đã tồn tại để tránh query 2 lần trên 1 trang
$_static_value = array();
include("initsession.php");
ob_start();
require_once '../classes/database.php';
require_once '../classes/generate_form.php';
require_once '../classes/TagsGenerate.php';
require_once '../classes/rain.tpl.class.php';
require_once '../classes/simple_html_dom.php';
require_once '../functions/functions.php';
require_once '../functions/function_translate.php';
require_once '../functions/rewrite_functions.php';
require_once '../functions/date_functions.php';
//include file cấu hình hằng số, biến css, js global
require_once '../includes/inc_config.php';
?>