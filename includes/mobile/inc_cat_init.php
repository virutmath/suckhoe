<?
//lấy bài hot nhất đầu tiên của category
$db_query = new db_query('SELECT new_id,new_title,cat_name,new_picture,new_teaser
                          FROM news
                          LEFT JOIN categories ON new_cat_id = cat_id
                          WHERE new_cat_id = '.$record_id.'
                                AND new_date <= '.TIMESTAMP.'
                                AND new_date >= '.MIN_TIME_NEWS_HOT.'
                          ORDER BY new_view DESC
                          LIMIT 1');
$top_list = mysqli_fetch_assoc($db_query->result);unset($db_query);
if(!$top_list){
    //nếu không có tin trong 2 ngày gần đây thì lấy từ đầu
    $db_query = new db_query('SELECT new_id,new_title,cat_name,new_picture,new_teaser
                              FROM news
                              LEFT JOIN categories ON new_cat_id = cat_id
                              WHERE new_cat_id = '.$record_id.'
                                    AND new_date <= '.TIMESTAMP.'
                              ORDER BY new_view DESC
                              LIMIT 1');
    $top_list = mysqli_fetch_assoc($db_query->result);unset($db_query);
}
prepare_news_record($top_list);
$rainTpl -> assign('top_list',$top_list);

//lấy danh sách các bài
$page = getValue('page','int','GET',0);
$page = $page > 1 ? $page : 1;
$limit = 10;
$limit_string = (int)(($page -1) * $limit) . ',' .$limit;
$list_news = array();
$db_query = new db_query('SELECT new_id, new_title, cat_name, new_picture, new_teaser
                          FROM news
                          LEFT JOIN categories ON new_cat_id = cat_id
                          WHERE new_cat_id = '.$record_id.'
                                AND new_date <= '.TIMESTAMP.'
                          ORDER BY new_date DESC
                          LIMIT '.$limit_string);
while($row = mysqli_fetch_assoc($db_query->result)){
    prepare_news_record($row,'mobile_small');
    $list_news[] = $row;
}
$rainTpl->assign('list_news',$list_news);