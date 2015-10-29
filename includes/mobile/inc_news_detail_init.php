<?
$db_query = new db_query('SELECT *
                          FROM news
                          LEFT JOIN news_detail ON ndt_id = new_id
                          LEFT JOIN categories ON cat_id = new_cat_id
                          WHERE new_id = '.$record_id.'
                                AND new_active = 1
                                AND new_date <= '.TIMESTAMP.'
                          LIMIT 1');
$news_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
if(!$news_data){
    error_404_document();
}
//tăng view cho tin
$db_update_view = new db_execute('UPDATE news SET new_view = new_view + 1 WHERE new_id = '.$record_id);
unset($db_update_view);
prepare_news_record($news_data);

//lấy các tin cùng chuyên mục
$list_cat_news = get_list_news_same_category($news_data,5,true);
$rainTpl->assign('list_cat_news',$list_cat_news);

//tin hot trong ngày
$list_hot_day = array();
$db_news_hot_day =  new db_query('SELECT new_id, new_title, cat_name
                                  FROM news
                                  LEFT JOIN categories ON cat_id = new_cat_id
                                  WHERE new_active = 1  AND new_date >= '.(TIMESTAMP - 86400). ' AND new_date <= '.TIMESTAMP.'
                                  AND new_id <> '.$record_id.'
                                  ORDER BY new_view DESC
                                  LIMIT 0,5');
while($row = mysqli_fetch_assoc($db_news_hot_day->result)){
    prepare_news_record($row);
    $list_hot_day[] = $row;
}
unset($db_news_hot_day);
$rainTpl->assign('list_hot_day',$list_hot_day);
