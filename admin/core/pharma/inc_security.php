<?
require_once '../../resources/security/security.php';
$module_id	= 9;
$module_name = 'Quản lý thuốc';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'pharma';
$id_field = 'pha_id';