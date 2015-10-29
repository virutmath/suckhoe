<?
require_once 'config.php';
//list category
$list_category = get_all_categories();
$count_list_cate = count($list_category) -2;
$list_category2 = array_slice($list_category,1,$count_list_cate);

$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_categories_slice',$list_category2);
//ảnh sơ đồ cơ thể
$anatomy_image = '/themes/img/anatomy.jpg';
$rainTpl->assign('anatomy_image',$anatomy_image);

include_once '../includes/inc_anatomy.php';

$rainTpl->draw('anatomy');
