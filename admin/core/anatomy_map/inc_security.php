<?
require_once '../../resources/security/security.php';
$module_id	= 5;
$module_name = 'Quản lý bản đồ cơ thể người';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'anatomy_map';
$id_field = 'ana_id';
$array_type = array(
    SECTION_TYPE_FRONT => 'Phương chính diện',
    SECTION_TYPE_BACK => 'Phương sau lưng'
);
$array_sex = array(
    DOITUONG_NAMGIOI => 'Nam',
    DOITUONG_NUGIOI => 'Nữ'
);