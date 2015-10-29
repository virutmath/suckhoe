<?
require_once '../../resources/security/security.php';
$module_id	= 8;
$module_name = 'Quản lý danh mục';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'categories';
$id_field = 'cat_id';
$name_field = 'cat_name';
$array_type = array(CATEGORY_TYPE_NEWS=>'Danh mục tin tức',CATEGORY_TYPE_HOIDAP=>'Danh mục hỏi đáp', CATEGORY_TYPE_THUOC => 'Danh mục thuốc');
?>