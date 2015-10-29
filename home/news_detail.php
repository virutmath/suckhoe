<?
require_once 'config.php';


$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);

//quảng cáo
$adv_top = get_advertising(ADV_POSITION_TOP,1);
$adv_right = get_advertising(ADV_POSITION_RIGHT,1);
//quảng cáo banner
$adv_banner_list = get_advertising(ADV_POSITION_LARGE_BANNER,2);

$iNews = getValue('record_id','int','GET',0);

include_once '../includes/inc_news_detail.php';
//list category
//cat active
$active_cat = intval($detail_data['cat_id']);
$list_category = get_all_categories($active_cat);
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
//so sánh link với link được request
$check_link_redirect = ($_SERVER['REQUEST_URI'] == generate_news_detail_url($detail_data));
if(!$check_link_redirect){
    move301(generate_news_detail_url($detail_data));
}
//assign quảng cáo
$rainTpl->assign('adv_top',$adv_top);
$rainTpl->assign('adv_right',$adv_right);
//quảng cáo banner
$rainTpl->assign('adv_banner_list',$adv_banner_list);


$fb_see_also = '';
if($array_link_see_also){
    foreach($array_link_see_also as $see_also_url){
        $fb_see_also .= '<meta property="og:see_also" content="'.$see_also_url.'" />';
    }
}
$facebook_og = '
<meta property="og:title" content="'.htmlspecialbo($detail_data['new_title']).'"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="fb:profile_id" content="1508569846068761" />
'.$fb_see_also.'
<meta property="og:type" content="article" />
<meta property="og:determiner" content="auto" />
<meta property="article:section" content="'.htmlspecialbo($detail_data['cat_name']).'" />
<meta property="article:publisher" content="https://www.facebook.com/suckhoeankhang" />
<meta property="article:published_time" content="'.$datetime_facebook.'" />
<meta property="og:url" content="http://khang.vn'.generate_news_detail_url($detail_data).'" />
<meta property="og:image" content="'.$detail_data['new_picture'].'"/>
<meta property="og:description" content="'.htmlspecialbo($detail_data['new_teaser']).'">
<meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);
$rainTpl->draw('news_detail');
