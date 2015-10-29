<?
require_once '../../resources/security/security.php';
$module_id	= 3;
$module_name = 'Quản lý triệu chứng bệnh';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'manifest';
$id_field = 'man_id';