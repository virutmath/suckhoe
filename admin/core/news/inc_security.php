<?
require_once '../../resources/security/security.php';
$module_id	= 7;
$module_name = 'Quản lý tin tức';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'news';
$id_field = 'new_id';