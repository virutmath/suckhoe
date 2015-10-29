<?
require_once '../../resources/security/security.php';
$module_id	= 1;
$module_name = 'Từ điển tiếng Trung';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'dictionary';
$id_field = 'dic_id';