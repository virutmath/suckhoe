<?
require_once '../../resources/security/security.php';
$module_id	= 10;
$module_name = 'thành phố';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'city';
$id_field = 'cit_id';