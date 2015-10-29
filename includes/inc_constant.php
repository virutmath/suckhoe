<?
//config constant
define('DEBUG_LOCAL',false);
define('WEBSITE_NAME','CNSK');
define('MAX_CATEGORY_LEVEL',2);
define('OTHER_DISEASE',156);
define('TIMESTAMP',time());
define('IP_ADDRESS_TEST','118.70.80.56');
define('IP_ADDRESS_CRON','118.70.80.56');
if($_SERVER['SERVER_NAME'] == 'localhost'){
    define('DOMAIN_URL','http://localhost:8021');
    define('DOMAIN_MOBILE','http://localhost:8023');
    define('DOMAIN_STATIC','http://localhost:8021');
    define('DOMAIN_STATIC_MOBILE','http://localhost:8021');
}else{
    define('DOMAIN_URL','http://khang.vn');
    define('DOMAIN_MOBILE','http://m.khang.vn');
    define('DOMAIN_STATIC','http://static.khang.vn:8080');
    define('DOMAIN_STATIC_MOBILE','http://static.khang.vn:8080');
}
define('DOMAIN_STATIC_IMAGE','http://static.khang.vn:8080');

define('TRANSLATED',false);
define('LINK_STATUS_PENDING',0);
define('LINK_STATUS_SUCCESS',1);
define('LINK_STATUS_FAIL',2);
define('MIN_NEWS_VIEW',0);
define('MIN_TIME_NEWS_HOT',strtotime('-2 day'));
define('ND_TYPE_TONG_QUAN',1);
define('ND_TYPE_TRIEU_CHUNG',2);
define('ND_TYPE_CHUAN_DOAN',3);
define('ND_TYPE_DIEU_TRI',4);
define('ND_TYPE_THUOC',5);
define('ND_TYPE_BAC_SI',6);
define('ND_TYPE_TRAC_NGHIEM',7);
define('ND_TYPE_VAN_DE',8);
define('ND_TYPE_KINH_NGHIEM',9);
define('SECTION_TYPE_FRONT',1);
define('SECTION_TYPE_BACK',2);
//bệnh theo đối tượng
define('DOITUONG_TREEM',1);
define('DOITUONG_NAMGIOI',2);
define('DOITUONG_NUGIOI',3);
define('DOITUONG_NGUOICAOTUOI',4);
//bệnh theo mùa
define('BENH_THEO_MUA_XUAN',1);
define('BENH_THEO_MUA_HA',2);
define('BENH_THEO_MUA_THU',3);
define('BENH_THEO_MUA_DONG',4);
//bệnh theo độ tuổi
define('DOTUOI_TRE_SO_SINH',1);
define('DOTUOI_NHI_DONG',2);
define('DOTUOI_THIEU_NIEN',3);
define('DOTUOI_TRUONG_THANH',4);
define('DOTUOI_CAO_TUOI',5);
//hệ cơ quan
define('HE_VAN_DONG',1);
define('HE_TUAN_HOAN',2);
define('HE_HO_HAP',3);
define('HE_TIEU_HOA',4);
define('HE_BAI_TIET',5);
define('HE_THAN_KINH',6);
define('HE_NOI_TIET',7);
define('HE_SINH_DUC',8);
define('HE_VO_BOC',9);
define('HE_GIAC_QUAN',10);
define('HE_BACH_HUYET',11);
define('HE_MIEN_DICH',12);
//loại danh mục
define('CATEGORY_TYPE_NEWS',0);
define('CATEGORY_TYPE_HOIDAP',1);
define('CATEGORY_TYPE_THUOC',2);

//vị trí quảng cáo
define('ADV_POSITION_TOP',1);
define('ADV_POSITION_RIGHT',2);
define('ADV_POSITION_BOTTOM',3);
define('ADV_POSITION_LARGE_BANNER',4);

//keyword chung
define('GENERAL_KEYWORD','alobacsi,afamily,suckhoedoisong,bo y te, kham benh online, thuoc, tu van kham benh');