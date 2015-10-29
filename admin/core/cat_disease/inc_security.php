<?
require_once '../../resources/security/security.php';
$module_id	= 1;
$module_name = 'Quản lý danh mục bệnh';
checkAccessModule($module_id);
checkLogged();
$bg_errorMsg = '';
$bg_table = 'cat_disease';
$id_field = 'cdi_id';
$array_do_tuoi = array(
    DOTUOI_TRE_SO_SINH => 'Từ 0 - 12 tháng',
    DOTUOI_NHI_DONG => 'Từ 1 - 6 tuổi',
    DOTUOI_THIEU_NIEN => 'Từ 6 - 18 tuổi',
    DOTUOI_TRUONG_THANH => 'Từ 19 - 51 tuổi',
    DOTUOI_CAO_TUOI => 'Từ 51 tuổi trở lên'
);
$array_doi_tuong = array(
    DOITUONG_TREEM => 'Trẻ em',
    DOITUONG_NAMGIOI => 'Nam giới',
    DOITUONG_NUGIOI => 'Nữ giới',
    DOITUONG_NGUOICAOTUOI => 'Người cao tuổi'
);
$array_theo_mua = array(
    BENH_THEO_MUA_XUAN => 'Xuân',
    BENH_THEO_MUA_HA => 'Hạ',
    BENH_THEO_MUA_THU => 'Thu',
    BENH_THEO_MUA_DONG => 'Đông'
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