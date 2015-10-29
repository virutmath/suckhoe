<?
require_once '../../resources/security/security.php';
$module_id	= 4;
$module_name = 'Quản lý địa điểm';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
//Thành phố
$bg_table = 'cities';
//Quận huyện
$bg_table_district = 'districts';
$id_field = 'cit_id';
$name_field = 'cit_name';
$array_ship_level = array(
    0=>'Không cố định',
    1=>'20.000',
    2=>'25.000',
    3=>'30.000',
    4=>'35.000',
    5=>'40.000'
);