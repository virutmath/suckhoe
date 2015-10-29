<?
$list_new_thuoc = array();
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

$link_next_page = generate_mbox_url(array(),$iPage + 1);
if($iPage > 1){
    $link_pre_page = generate_mbox_url(array(),$iPage - 1);
}else{
    $link_pre_page = '#';
}


$rainTpl->assign('iPage',$iPage);
$rainTpl->assign('limit_size',$limit_size);
$rainTpl->assign('limit_start',$limit_start);
$rainTpl->assign('link_next_page',$link_next_page);
$rainTpl->assign('link_pre_page',$link_pre_page);

$page_title = t('Khang.vn - Trang thuốc, danh sách thuốc y dược | Trang ' . $iPage);


$db_query_1 = new db_query("SELECT pha_id,pha_name, pha_image, pha_gia_le,cat_name
                            FROM pharma,categories WHERE pha_cat_id = cat_id
               ORDER BY pha_id DESC LIMIT ".$limit_start.",".$limit_size);
while($row = mysqli_fetch_assoc($db_query_1->result)){
    $row['linkSeo'] = generate_tuthuoc_detail($row);
    $row['pha_image'] = get_picture_path($row['pha_image']);
    $list_new_thuoc[] = $row;
}

$count_new = count($list_new_thuoc);
$rainTpl->assign('list_new_thuoc',$list_new_thuoc);
$rainTpl->assign('count_new',$count_new);
