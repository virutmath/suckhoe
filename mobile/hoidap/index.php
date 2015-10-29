<?
require 'config.php';
//lấy ra cat id nếu có
$cat_id = getValue('cat_id');
$page = getValue('page','int','GET',0);
$page = $page > 1 ? $page : 1;
$limit = 10;
$limit_string = (int)(($page -1) * $limit) . ',' .$limit;

//lấy ra menu
$category_news = get_menu_category_news();
$rainTpl->assign('category_news',$category_news);
$category_hoidap = get_menu_category_hoidap();
$rainTpl->assign('category_hoidap',$category_hoidap);
$category_thuoc = get_menu_category_thuoc();
$rainTpl->assign('category_thuoc',$category_thuoc);

$page_title = '';
$cat_data = array();
if($cat_id){
    //là các tin trong danh mục
    $db_query = new db_query('SELECT * FROM categories WHERE cat_id = '.$cat_id.' LIMIT 1');
    $cat_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
    if(!$cat_data){
        error_404_document();
    }
    $page_title = $cat_data['cat_title'] ? $cat_data['cat_title'] : $cat_data['cat_name'];
    include_once '../../includes/mobile/hoidap/inc_cat_init.php';
}else{
    //là trang index
    $page_title = 'Hỏi đáp, tư vấn khám chữa bệnh miễn phí cho mọi người';
    $cat_data['cat_name'] = 'Hỏi đáp';
    $cat_data['cat_id'] = 0;//trang chủ
    include_once '../../includes/mobile/hoidap/inc_home_init.php';
}
$page_title .= ' - Trang ' . $page;
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('cat_data',$cat_data);



$rainTpl->draw('hoidap_index');