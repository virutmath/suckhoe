<?
$pjax_param = getValue('_params','str','GET','',3);
$pjax_param = pjax_param_parse($pjax_param);

$string_query_unique = $pjax_param['query_unique'];
$limit_start = isset($iPage) ? intval(($iPage - 1) * $limit_size) : 0;
if($limit_start < 0){
    $iPage = 1;
    $limit_start = 0;
}
//query ra list tin theo thời gian
$sql_list_news =    'SELECT new_id,
                            new_title,
                            new_picture,
                            new_teaser,
                            new_date,
                            cat_name
                    FROM news
                    LEFT JOIN categories ON cat_id = new_cat_id
                    WHERE new_active = 1
                        AND new_picture <> ""
                        AND new_date <= '.TIMESTAMP.'
                        AND new_cat_id = '.$iCat.
                        $string_query_unique.'
                    ORDER BY new_date DESC
                    LIMIT '.$limit_start.','.$limit_size;
//echo $sql_list_news;
$db_list_news = new db_query($sql_list_news);
while($row = mysqli_fetch_assoc($db_list_news->result)){
    //xử lý dữ liệu
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['new_picture'] = get_picture_path($row['new_picture'],'medium2');
    $row['new_teaser'] = htmlspecialbo($row['new_teaser']);
    $row['new_date'] = getDateTime(1,1,1,1,'',$row['new_date']);
    $row['link_detail'] = generate_news_detail_url($row);
    if(!$row['new_teaser']){
        //không có teaser - query từ detail tin
        $db_detail = new db_query('SELECT * FROM news_detail WHERE new_id = '.$row['new_id']);
        $row['new_teaser'] = mysqli_fetch_assoc($db_detail->result);unset($db_detail);
        $row['new_teaser'] = removeHTML($row['new_teaser']);
        $row['new_teaser'] = cut_string($row['new_teaser'],130);
        $row['new_teaser'] = htmlspecialbo($row['new_teaser']);
    }
    $category_list_news[] = $row;
}
$rainTpl->assign('category_list_news',$category_list_news);
$rainTpl->draw('pjax_cat_left');