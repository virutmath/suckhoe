<?
require 'config.php';

//list category

$list_category = get_all_categories('qaa');
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);

$iPage = getValue('page','int','GET',0);
$iPage = intval($iPage);
$iPage = $iPage > 1 ? $iPage : 1;

$page_title = t('Khang.vn - Trang hỏi đáp, tư vấn khám chữa bệnh miễn phí | Trang ' . $iPage);

$limit_size = 10;
$limit_start = isset($iPage) && $iPage ? intval(($iPage - 1) * $limit_size) : 0;

if($limit_start < 0){
    $iPage = 1;
    $limit_start = 0;
}


//list category hỏi đáp
$cat_id = getValue('cat_id');
$list_category_hoidap = array();

$db_query = new db_query('SELECT * FROM categories WHERE cat_type = '.CATEGORY_TYPE_HOIDAP);
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['link_cat'] = generate_qaa_url($row);
    if($cat_id && $cat_id == $row['cat_id']){
        $row['is_checked'] = 'checked';
        $cat_name = $row['cat_name'];
        $og_url = $row['link_cat'];
        $og_title = $row['cat_name'] . ' - Hỏi đáp về '.$row['cat_name'];
        $og_description = $row['cat_name'] . ' - Tư vấn về '.$row['cat_name'] . ' - Tư vấn chuyên gia - Ý kiến Bác sĩ';
        $rainTpl->assign('cat_name',$cat_name);
    }else{
        $row['is_checked'] = '';
    }
    $list_category_hoidap[] = $row;
}
//quảng cáo
$adv_top = get_advertising(ADV_POSITION_TOP,1);
$adv_right = get_advertising(ADV_POSITION_RIGHT,1);
$rainTpl->assign('adv_top',$adv_top);
$rainTpl->assign('adv_right',$adv_right);
//quảng cáo banner
$adv_banner_list = get_advertising(ADV_POSITION_LARGE_BANNER,2);
$rainTpl->assign('adv_banner_list',$adv_banner_list);


$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('iPage',$iPage);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
$rainTpl->assign('list_category_hoidap',$list_category_hoidap);
//lấy ra các tin hỏi đáp index
if(!$cat_id){
    $og_url = generate_qaa_url();
    $og_description = 'Hỏi đáp - Tư vấn sức khỏe - Khám bệnh online 24/24';
    $og_title = 'Hỏi đáp y học - Kiến thức y học - Khám bệnh online';
    include_once '../includes/hoidap/inc_list_hoidap_index.php';
    $link_next_page = generate_qaa_url(array(),$iPage + 1);
    if($iPage > 1){
        $link_pre_page = generate_qaa_url(array(),$iPage - 1);
    }else{
        $link_pre_page = '#';
    }
    $rainTpl->assign('link_next_page',$link_next_page);
    $rainTpl->assign('link_pre_page',$link_pre_page);
}else{
    include_once '../includes/hoidap/inc_list_hoidap_cat.php';
    $detail_data['link_cat'] = generate_qaa_url(array('cat_id'=>$cat_id,'cat_name'=>$cat_name));

    $detail_data['link_hoidap'] = generate_qaa_url();
    $link_next_page = generate_qaa_url(array('cat_id'=>$cat_id,'cat_name'=>$cat_name),$iPage + 1);
    if($iPage > 1){
        $link_pre_page = generate_qaa_url(array('cat_id'=>$cat_id,'cat_name'=>$cat_name),$iPage - 1);
    }else{
        $link_pre_page = '#';
    }
    $rainTpl->assign('detail_data',$detail_data);
    $rainTpl->assign('link_next_page',$link_next_page);
    $rainTpl->assign('link_pre_page',$link_pre_page);
}


$meta_description = '';
$rainTpl->assign('meta_description',$meta_description);
$meta_keyword = '';
$rainTpl->assign('meta_keyword',$meta_keyword);

$facebook_og = '<meta property="og:site_name" content="Khang.vn - Hỏi đáp - Khám bệnh online"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="'.DOMAIN_URL . $og_url.'" />
<meta property="og:locale" content="vi_VN"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="og:image" content="'.DOMAIN_URL.'/themes/pc/img/logo1.png"/>
<meta property="og:title" content="'.$og_title.'"/>
<meta property="og:description" content="'.$og_description.'">
<meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);

if(!$cat_id){
    $rainTpl->draw('index');
}else{
    $rainTpl->draw('cat');
}
