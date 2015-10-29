<?
require_once '../../resources/security/security.php';
$module_id	= 10;
$module_name = 'Quản lý quảng cáo';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'advertising';
$id_field = 'adv_id';

$array_position = array(
    ADV_POSITION_TOP => 'Vị trí trên cùng 1000x104',
    ADV_POSITION_BOTTOM => 'Vị trí dưới 701x170',
    ADV_POSITION_RIGHT => 'Vị trí phải 249x280',
    ADV_POSITION_LARGE_BANNER => 'Banner lớn'
);