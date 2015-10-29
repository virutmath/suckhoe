<?
require_once '../../resources/security/security.php';
$module_id	= 6;
$module_name = 'Cấu hình website';
checkAccessModule($module_id);
checkLogged();

$bg_errorMsg = '';
$bg_table = 'configuration';

?>