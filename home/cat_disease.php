<?
$version_number = 1;
require_once 'config.php';

$page_title = t('Bắt bệnh | Thông tin về bệnh, thuốc | Cơ thể người | Chức năng bộ phận cơ thể người');
//list category
$list_category = get_all_categories('home');
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);
//tham so bo phan co the
$sec_id = getValue('sec_id','int','GET',0);


$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
if(!$sec_id){
    $rainTpl->assign('page_title',$page_title);
}

$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
$rainTpl->assign('time_now',getDateTime());
include_once '../includes/inc_cat_disease.php';
if($sec_id){
    $rainTpl->assign('page_title','Tìm hiểu về '. $sec_name . ' của cơ thể người | Triệu chứng, bệnh thường gặp vùng '.$sec_name);
}

$meta_description = '<meta name="description" content="'.cut_string($sec_desc,250,'').'" />';
$rainTpl->assign('meta_description',$meta_description);
$facebook_og = '<meta property="og:site_name" content="Khang.vn - Tìm hiểu bệnh vùng '.$sec_name.'"/>
    <meta property="og:title" content="Thông tin y tế, sức khỏe cộng đồng"/>
    <meta property="og:type" content="website" />
    <meta property="og:url" content="'.DOMAIN_URL.$_SERVER['REQUEST_URI'].'" />
    <meta property="og:locale " content="vi_VN"/>
    <meta property="fb:app_id" content="1561038610796934" />
    <meta property="og:image" content="'. $sec_picture .'"/>
    <meta property="og:site_name" content="Khang.vn"/>
    <meta property="og:description" content="'.$sec_desc.'">
    <meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);

if($is_pjax){
    $rainTpl->draw('cat_disease_pjax');
    exit();
}
$rainTpl->draw('cat_disease');