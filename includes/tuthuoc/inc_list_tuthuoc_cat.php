<?
$cat_id = getValue('cat_id');
$db_query = new db_query("SELECT cat_id, cat_name
                         FROM categories WHERE cat_id = ".$cat_id);
$row_cat = mysqli_fetch_assoc($db_query->result);

$rainTpl->assign('row_cat',$row_cat);

$iPage = getValue('page','int','GET',0);
$iPage = intval($iPage);
$iPage = $iPage > 1 ? $iPage : 1;

$limit_size = 12;
$limit_start = isset($iPage) && $iPage ? intval(($iPage - 1) * $limit_size) : 0;

if($limit_start < 0){
    $iPage = 1;
    $limit_start = 0;
}
$og_url = generate_mbox_url();
$og_description = 'Thuốc - Thuốc y dược - phục vụ  24/24';
$og_title = 'Thông tin thuốc và cách sử dụng';


$link_next_page = generate_mbox_cat($row_cat,$iPage + 1);
if($iPage > 1){
    $link_pre_page = generate_mbox_cat($row_cat,$iPage - 1);
}else{
    $link_pre_page = '#';
}



$rainTpl->assign('iPage',$iPage);
$rainTpl->assign('limit_size',$limit_size);
$rainTpl->assign('limit_start',$limit_start);
$rainTpl->assign('link_next_page',$link_next_page);
$rainTpl->assign('link_pre_page',$link_pre_page);

$page_title = t('Khang.vn - Trang danh mục thuốc, danh mục các loại thuốc | Trang ' . $iPage);



$db_query = new db_query('SELECT pha_id,pha_name, pha_image, pha_gia_le, cat_name
                          FROM pharma,categories WHERE cat_id = pha_cat_id AND pha_cat_id = '.$cat_id.'
                          ORDER BY pha_id DESC LIMIT '.$limit_start.','.$limit_size);
$list_cat_thuoc = array();
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['linkSeo'] = generate_tuthuoc_detail($row);
    $row['pha_image'] = get_picture_path($row['pha_image']);
    $list_cat_thuoc[] = $row;
}

$count_cat_product = count($list_cat_thuoc);
$rainTpl->assign('list_cat_thuoc',$list_cat_thuoc);
$rainTpl->assign('count_cat_product',$count_cat_product);



