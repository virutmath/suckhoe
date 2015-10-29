<?
require_once 'config.php';
$adv_top = get_advertising(ADV_POSITION_TOP,1);
$adv_right = get_advertising(ADV_POSITION_RIGHT,1);
//quảng cáo banner
$adv_banner_list = get_advertising(ADV_POSITION_LARGE_BANNER,2);


$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$iCat = getValue('record_id','int','GET',0);
$iPage = getValue('page','int','GET',0);
$iPage = intval($iPage);
$iPage = $iPage > 1 ? $iPage : 1;
$limit_size = 10;

$db_detail_cat = new db_query('SELECT * FROM categories WHERE cat_id = '.$iCat);
$detail_data = mysqli_fetch_assoc($db_detail_cat->result);unset($db_detail_cat);
if(!$detail_data){
    error_404_document();
}

$detail_data['link_cat'] = generate_cat_url($detail_data);
if($detail_data['cat_type'] == CATEGORY_TYPE_HOIDAP){
    move301(generate_qaa_url($detail_data));
}
$detail_data['link_cat_next'] = generate_cat_url($detail_data,$iPage+1);
$detail_data['cat_title'] = $detail_data['cat_title'] ? $detail_data['cat_title'] : $detail_data['cat_name'] . ' | Khang.vn - Cẩm nang sức khỏe';

//list category
$list_category = get_all_categories($iCat);
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
$rainTpl->assign('detail_data',$detail_data);
$rainTpl->assign('iPage',$iPage);
$rainTpl->assign('page_title',$detail_data['cat_title']);
$rainTpl->assign('base_search_url','/search');
$rainTpl->assign('meta_description',get_meta_description_category($detail_data));
$rainTpl->assign('meta_keyword',get_meta_keyword_category($detail_data));
$rainTpl->assign('color_cat',get_color_category($detail_data['cat_id']));
$rainTpl->assign('adv_top',$adv_top);
$rainTpl->assign('adv_right',$adv_right);
$rainTpl->assign('link_hoidap',generate_qaa_url());
//quảng cáo banner
$rainTpl->assign('adv_banner_list',$adv_banner_list);
if($is_pjax){
    include_once '../includes/pjax/inc_cat_pjax.php';
    exit();
}
include_once '../includes/inc_cat.php';

$facebook_og = '
<meta property="og:site_name" content="Khang.vn - Cẩm nang sức khỏe cho mọi nhà"/>
<meta property="og:title" content="Thông tin y tế, sức khỏe cộng đồng"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="http://khang.vn'.$detail_data['link_cat'].'" />
<meta property="og:locale " content="vi_VN"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="og:image" content="'.DOMAIN_URL.'/themes/pc/img/logo1.png"/>
<meta property="og:site_name" content="'.$detail_data['cat_name'].' - Khang.vn"/>
<meta property="og:description" content="Cẩm nang sức khỏe, dinh dưỡng cho gia đình, cộng đồng và xã hội">
<meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);
$rainTpl->draw('cat');
