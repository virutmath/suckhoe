<?
require_once 'config.php';
//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);


$page_title = 'Tin tức, kiến thức sức khỏe trên di động - Khang Mobile';
$rainTpl->assign('page_title',$page_title);

//query
require_once '../includes/mobile/inc_home_init.php';

$rainTpl->draw('index');