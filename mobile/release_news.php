<?
require_once 'config.php';
//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);

$page = getValue('page','int','GET',0);
$page = $page > 1 ? $page : 1;
$limit = 10;
$limit_string = (int)(($page -1) * $limit) . ',' .$limit;

include_once '../includes/mobile/inc_release_news_init.php';
$page_title = 'Tin tức sức khỏe, đời sống y tế, tư vấn khám chữa bệnh cho mọi người';
$rainTpl->assign('page_title',$page_title);

$rainTpl->draw('release_news');
