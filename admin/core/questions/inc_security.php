<?
require_once '../../resources/security/security.php';
$module_id	= 11;
$module_name = 'Quản lý hỏi đáp';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'questions';
$id_field = 'que_id';
