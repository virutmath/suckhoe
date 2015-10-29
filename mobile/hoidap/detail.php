<?
require 'config.php';
//lấy ra record_id
$que_id = getValue('que_id');
if($que_id < 1) {
    error_404_document();
}
//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);

$page_title = '';
$question_data = array();
$list_cat_news = array();
$list_hot_day = array();
include_once '../../includes/mobile/hoidap/inc_detail_init.php';

$page_title = $question_data['que_title'];

$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('question_data',$question_data);
$rainTpl->assign('list_cat_news',$list_cat_news);
$rainTpl->assign('list_hot_day',$list_hot_day);
$rainTpl->draw('hoidap_detail');
