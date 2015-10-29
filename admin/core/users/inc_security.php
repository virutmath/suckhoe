<?
require_once '../../resources/security/security.php';

$module_id	= 10;
$module_name= "Quản lý thành viên";
//check đăng nhập và bảo mật
checkLogged();
//Check access module...
checkAccessModule($module_id);

$bg_errorMsg = '';
$bg_table = 'users';
$id_field = 'use_id';
$name_field = 'use_name';
$bg_filepath = '../../../pictures/avatar/';
$bg_extension = 'jpg,jpe,png,gif,jpeg';
$limit_size = 1200;
$arr_resize = array( "small_" => array("quality" => 100, "width" => 240, "height" => 135),
					 "medium_" => array("quality" => 100, "width" => 400, "height" => 225)
					);
											
?>