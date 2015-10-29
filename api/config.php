<?
ob_start();
require_once '../classes/database.php';
require_once '../classes/generate_form.php';
require_once '../classes/simple_html_dom.php';
require_once '../functions/functions.php';
require_once '../functions/function_translate.php';
require_once '../functions/rewrite_functions.php';
require_once '../functions/date_functions.php';
//include file cấu hình hằng số, biến css, js global
require_once '../includes/inc_constant.php';
$array_code_error = array(
    101=>'Các luật đã được lấy hết',
    404=>'Lời gọi api không đúng cú pháp'
);