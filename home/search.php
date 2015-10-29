<?
$version_number = 1;
require_once 'config.php';
$page_title = t('Trang thông tin y tế, sức khỏe cộng đồng');
//list category
$list_category = get_all_categories('home');
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);

$meta_description = 'Tìm kiếm';
$meta_keyword = 'search';

$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
$rainTpl->assign('time_now',getDateTime());
$rainTpl->assign('meta_description',$meta_description);
$rainTpl->assign('meta_keyword',$meta_keyword);

include_once '../includes/inc_search.php';

$rainTpl->draw('search');