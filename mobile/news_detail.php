<?
require_once 'config.php';
//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);

$record_id = getValue('record_id');
include_once '../includes/mobile/inc_news_detail_init.php';
$page_title = $news_data['new_title'];
//so sánh link để redirect về link đúng
$check_link_redirect = ($_SERVER['REQUEST_URI'] == generate_news_detail_url($news_data));
if(!$check_link_redirect){
    move301(generate_news_detail_url($news_data));
}

$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('news_data',$news_data);

$rainTpl->draw('news_detail');