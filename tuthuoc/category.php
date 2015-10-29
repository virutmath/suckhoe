<?
require 'config.php';


//list category tủ thuốc
$list_category = get_all_categories('mbox');


include_once '../includes/tuthuoc/inc_list_tuthuoc_cat.php';
$list_category_tuthuoc = array();
$db_query = new db_query('SELECT cat_id, cat_name,cat_title
                          FROM categories
                          WHERE cat_type = '.CATEGORY_TYPE_THUOC.'');
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['link_cat'] = generate_tuthuoc_cat($row);
    $list_category_tuthuoc[] = $row;
}

$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('list_category_tuthuoc',$list_category_tuthuoc);

$meta_description = '';
$rainTpl->assign('meta_description',$meta_description);
$meta_keyword = '';
$rainTpl->assign('meta_keyword',$meta_keyword);

$facebook_og = '<meta property="og:site_name" content="Khang.vn - Hỏi đáp - Khám bệnh online"/>
<meta property="og:type" content="website" />
<meta property="og:locale" content="vi_VN"/>
<meta property="fb:app_id" content="1561038610796934" />
<meta property="og:image" content="'.DOMAIN_URL.'/themes/pc/img/logo1.png"/>
<meta property="og:updated_time" content="'.time().'">';


$rainTpl->draw('category');

