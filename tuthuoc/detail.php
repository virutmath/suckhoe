<?
require 'config.php';
//echo unicode("Ngày mai là ngày đẹp trời");

//list category
$list_category = get_all_categories('mbox');
$pha_id = getValue('pha_id');
$db_query = new db_query('SELECT * FROM pharma WHERE pha_id = '.$pha_id);

$pha_item = mysqli_fetch_assoc($db_query->result);

if($pha_item['pha_content'] != ''){
	$pha_item['pha_so_dang_ky'] = '';
	$pha_item['pha_dang_bao_che'] = '';
	$pha_item['pha_dong_goi'] = '';
	$pha_item['pha_nha_dk_name'] = '';
	$pha_item['pha_thanh_phan'] = '';
	$pha_item['pha_ham_luong'] = '';
	$pha_item['pha_chi_dinh'] = '';
	$pha_item['pha_chong_chi_dinh'] = '';
	$pha_item['pha_tuong_tac_thuoc'] = '';
	$pha_item['pha_tac_dung_phu'] = '';
	$pha_item['pha_chu_y_de_phong'] = '';
	$pha_item['pha_bao_quan'] = '';
}
$cat_id = $pha_item['pha_cat_id'];
$list_relation = array();
$count_list_relation = 0;
if($cat_id != 0){
    $db_query = new db_query('SELECT pha_id,pha_name, pha_image, pha_gia_le,cat_name
                              FROM pharma INNER JOIN categories
                              ON pha_cat_id = cat_id WHERE pha_id > '.$pha_id.' AND pha_cat_id = '.$cat_id.'
                              LIMIT 8');
    while($row = mysqli_fetch_assoc($db_query->result)){
        if($row['pha_id'] == $pha_item['pha_id']){
            continue;
        }
        $row['linkSeo'] = generate_tuthuoc_detail($row);
        $row['pha_image'] = get_picture_path($row['pha_image']);
        $list_relation[] = $row;
    }
    unset($db_query);
}

if($count_list_relation < 8){
    $count_list_relation = count($list_relation);
    if($count_list_relation < 8 && $cat_id != 0){
        $count_list_relation = 8 - $count_list_relation;
        $db_query = new db_query('
          SELECT pha_id,pha_name, pha_image, pha_gia_le,cat_name
          FROM pharma INNER JOIN categories
          ON pha_cat_id = cat_id WHERE pha_id < '.$pha_id.' AND pha_cat_id = '.$cat_id.'
          LIMIT '.$count_list_relation.'
        ');
        while($row = mysqli_fetch_assoc($db_query->result)){
            if($row['pha_id'] == $pha_item['pha_id']){
                continue;
            }
            $row['linkSeo'] = generate_tuthuoc_detail($row);
            $row['pha_image'] = get_picture_path($row['pha_image']);
            $list_relation[] = $row;
        }
        unset($db_query);
    }
}
$rainTpl->assign('count_list_relation',$count_list_relation);
$rainTpl->assign('list_relation',$list_relation);


//list category tủ thuốc
$page_title = t('Khang.vn - Trang thuốc, danh sách thuốc ');
$list_category_tuthuoc = array();
$db_query = new db_query('SELECT cat_id, cat_name,cat_title FROM categories WHERE cat_type = '.CATEGORY_TYPE_THUOC);
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['link_cat'] = generate_tuthuoc_cat($row);
    $list_category_tuthuoc[] = $row;
}

$rainTpl->assign('list_category_tuthuoc',$list_category_tuthuoc);

$rainTpl->assign('css_global',$css_global);
$rainTpl->assign('js_global',$js_global);
$rainTpl->assign('page_title',$page_title);
$rainTpl->assign('list_categories',$list_category);
$rainTpl->assign('pha_item',$pha_item);

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

$rainTpl->draw('detail');
