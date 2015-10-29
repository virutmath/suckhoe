<?
require_once '../../resources/security/security.php';
$module_id	= 2;
$module_name = 'Quản lý tin bệnh';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'news_disease';
$id_field = 'ndi_id';
$array_type = array(
    ND_TYPE_BAC_SI => 'Giải đáp, tư vấn của bác sĩ',
    ND_TYPE_CHUAN_DOAN => 'Chuẩn đoán và xét nghiệm',
    ND_TYPE_DIEU_TRI => 'Điều trị và chăm sóc',
    ND_TYPE_KINH_NGHIEM => 'Kinh nghiệm cộng đồng',
    ND_TYPE_THUOC => 'Các loại thuốc điều trị',
    ND_TYPE_TONG_QUAN=>'Tổng quan',
    ND_TYPE_TRAC_NGHIEM=>'Trắc nghiệm về bệnh',
    ND_TYPE_VAN_DE => 'Vấn đề trong phòng và trị bệnh',
    ND_TYPE_TRIEU_CHUNG => 'Triệu chứng, phân loại bệnh'
);
ksort($array_type);