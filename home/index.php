<?
require_once 'config.php';
$base_search_url = generate_base_search_url();


$page_title = t('Trang thông tin y tế, sức khỏe cộng đồng');
//list category
$list_category = get_all_categories('home');
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);

//quảng cáo
$adv_top = get_advertising(ADV_POSITION_TOP,1);
$adv_right = get_advertising(ADV_POSITION_RIGHT,1);
//quảng cáo banner
$adv_banner_list = get_advertising(ADV_POSITION_LARGE_BANNER,2);

//link hỏi đáp
$link_hoidap = generate_qaa_url();

$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('meta_description','Cẩm nang sức khỏe, dinh dưỡng cho gia đình, cộng đồng và xã hội');
$rainTpl->assign('meta_keyword',GENERAL_KEYWORD);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
$rainTpl->assign('link_hoidap',$link_hoidap);
$rainTpl->assign('base_search_url',$base_search_url);
//assign quảng cáo
$rainTpl->assign('adv_top',$adv_top);
$rainTpl->assign('adv_right',$adv_right);
//quảng cáo banner
$rainTpl->assign('adv_banner_list',$adv_banner_list);

$rainTpl->assign('time_now',getDateTime());
include_once '../includes/inc_home.php';

$facebook_og = '
<meta property="og:site_name" content="Khang.vn - Cẩm nang sức khỏe cho mọi nhà"/>
<meta property="og:title" content="Thông tin y tế, sức khỏe cộng đồng"/>
<meta property="og:type" content="website" />
<meta property="og:url" content="http://khang.vn/home/" />
<meta property="og:locale " content="vi_VN"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="og:image" content="'.DOMAIN_URL.'/themes/pc/img/logo1.png"/>
<meta property="og:site_name" content="Khang.vn"/>
<meta property="og:description" content="Cẩm nang sức khỏe, dinh dưỡng cho gia đìn, cộng đồng và xã hội">
<meta property="og:updated_time" content="'.time().'">';
$rainTpl->assign('facebook_og',$facebook_og);
$rainTpl->draw('index');