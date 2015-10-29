<?
require 'config.php';


//list category
$list_category = get_all_categories('qaa');
$detail_data = array();

//list category hỏi đáp
$list_category_hoidap = array();
$db_query = new db_query('SELECT * FROM categories WHERE cat_type = '.CATEGORY_TYPE_HOIDAP);
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['link_cat'] = generate_qaa_url($row);
    $list_category_hoidap[] = $row;
}
$rainTpl->assign('list_category_hoidap',$list_category_hoidap);
//quảng cáo
$adv_top = get_advertising(ADV_POSITION_TOP,1);
$adv_right = get_advertising(ADV_POSITION_RIGHT,1);
$rainTpl->assign('adv_top',$adv_top);
$rainTpl->assign('adv_right',$adv_right);
//quảng cáo banner
$adv_banner_list = get_advertising(ADV_POSITION_LARGE_BANNER,2);
$rainTpl->assign('adv_banner_list',$adv_banner_list);


$que_id = getValue('que_id');
$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);

$rainTpl->assign('list_categories',$list_category);

include_once '../includes/hoidap/inc_hoidap_detail.php';
if(isset($detail_data['que_title']) && $detail_data['que_title']){
    $page_title = t($detail_data['que_title'] . ' | Chuyên mục hỏi đáp');
}else{
    $page_title = t('Trang hỏi đáp, tư vấn khám chữa bệnh miễn phí');
}
$rainTpl->assign('page_title',$page_title);

$og_url = DOMAIN_URL.generate_hoidap_detail($detail_data);
$rainTpl->assign('og_url',$og_url);

//so sánh link với link được request
$check_link_redirect = ($_SERVER['REQUEST_URI'] == generate_hoidap_detail($detail_data));
if(!$check_link_redirect){
    move301(generate_hoidap_detail($detail_data));
}

$meta_description = cut_string($detail_data['que_question_content'],200);
$rainTpl->assign('meta_description',$meta_description);
$meta_keyword = '';
$rainTpl->assign('meta_keyword',$meta_keyword);

$facebook_og = '<meta property="og:title" content="'.htmlspecialbo($detail_data['que_title']).'"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="fb:profile_id" content="1508569846068761" />
<meta property="og:type" content="article" />
<meta property="og:determiner" content="auto" />
<meta property="article:section" content="'.htmlspecialbo($detail_data['cat_name']).'" />
<meta property="article:publisher" content="https://www.facebook.com/suckhoeankhang" />
<meta property="article:published_time" content="'.$datetime_facebook.'" />
<meta property="og:url" content="'.$og_url.'" />
<meta property="og:image" content="'.$detail_data['que_image'].'"/>
<meta property="og:description" content="'.htmlspecialbo(removeHTML($meta_description)).'">
<meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);
$rainTpl->draw('detail');
