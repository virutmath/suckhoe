<?
require_once '../../resources/security/security.php';
$module_id	= 4;
$module_name = 'Quản lý các vùng bộ phận cơ thể';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'sections';
$id_field = 'sec_id';
$array_type = array(
    SECTION_TYPE_FRONT => 'Phương chính diện',
    SECTION_TYPE_BACK => 'Phương sau lưng'
);
$array_he_co_quan = array(
    HE_BAI_TIET => 'Hệ bài tiết',
    HE_HO_HAP => 'Hệ hô hấp',
    HE_NOI_TIET => 'Hệ nội tiết',
    HE_SINH_DUC => 'Hệ sinh dục',
    HE_THAN_KINH => 'Hệ thần kinh',
    HE_TIEU_HOA => 'Hệ tiêu hóa',
    HE_TUAN_HOAN => 'Hệ tuần hoàn',
    HE_VAN_DONG => 'Hệ vận động',
    HE_MIEN_DICH => 'Hệ miễn dịch',
    HE_BACH_HUYET => 'Hệ bạch huyết',
    HE_GIAC_QUAN=>'Hệ giác quan',
    HE_VO_BOC=>'Hệ vỏ bọc'
);