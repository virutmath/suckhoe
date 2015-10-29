<?
require_once 'config.php';
//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);

$record_id = getValue('record_id','int','GET',0);
$db_query = new db_query('SELECT * FROM categories WHERE cat_id = '.$record_id.' AND cat_type = '.CATEGORY_TYPE_NEWS);
$cat_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
if(!$cat_data){
    error_404_document();
    die();
}
$page_title = $cat_data['cat_title'];
$page_title = $page_title ? $page_title : 'Tin tức về '.$cat_data['cat_name'];
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('cat_data',$cat_data);
//query
require_once '../includes/mobile/inc_cat_init.php';

$rainTpl->draw('cat');