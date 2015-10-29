<?
$keyword = getValue('search','str','GET','');
$title_check = getValue('title_check');
$cat_array = getValue('cat_name','arr','GET',array());
$check_manifest = getValue('check_manifest');
$check_pharma = getValue('check_pharma');

//Check xem keyword thuộc dạng nào
$keyword_match = $keyword;
$match_thuoc = 0;
$match_benh = 0;
$match_trieuchung = 0;

//nếu chuỗi tìm kiếm bắt đầu bằng thuoc hoặc thuốc thì từ khóa nhập vào là thuốc, tìm kiếm trong bảng thuốc
if(string_start_with($keyword_match,'thuoc') || string_start_with($keyword_match,'thuốc')){
    $match_thuoc = 1;
    $list_thuoc_match = array();
    $keyword_thuoc = str_replace(array('thuoc','thuốc'),'',$keyword_match);
    $keyword_thuoc = mb_strtolower($keyword_thuoc,'utf8');
    $keyword_thuoc = trim($keyword_thuoc);
    $rainTpl->assign('keyword_thuoc',$keyword_thuoc);
    //lấy ra 3 thuốc đúng nhất
    $db_query = new db_query('SELECT pha_name,pha_title,pha_id,pha_image,cat_name,
                                    IF(LOWER(pha_name) = "'.$keyword_thuoc.'", 1, 0) AS check_match
                              FROM pharma
                              LEFT JOIN categories ON pha_cat_id = cat_id
                              WHERE LOWER(pha_name) = "'.$keyword_thuoc.'" OR pha_name LIKE ("%'.$keyword_thuoc.'%")
                              ORDER BY check_match DESC
                              LIMIT 3');
    while($row = mysqli_fetch_assoc($db_query->result)){
        prepare_pharma_record($row);
        $list_thuoc_match[] = $row;
    }
    unset($db_query);
    $rainTpl->assign('list_thuoc_match',$list_thuoc_match);
    //đếm số thuốc tìm kiếm ứng với từ khóa trên
    $db_count = new db_count('SELECT count(pha_id) AS count 
                              FROM pharma 
                              WHERE LOWER(pha_name) = "'.$keyword_thuoc.'" OR pha_name LIKE ("%'.$keyword_thuoc.'%")');
    $count_thuoc = $db_count->total;unset($db_count);
    $rainTpl->assign('count_thuoc',$count_thuoc);
}


$rainTpl->assign('match_thuoc',$match_thuoc);