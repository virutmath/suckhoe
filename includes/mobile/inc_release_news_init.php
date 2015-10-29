<?
$db_query = new db_query('SELECT new_id,
                                 new_title,
                                 new_picture,
                                 new_teaser,
                                 cat_name
                          FROM news
                          LEFT JOIN categories ON cat_id = new_cat_id
                          WHERE new_active = 1 AND new_date <= '.TIMESTAMP.'
                          ORDER BY new_date DESC
                          LIMIT '.$limit_string);
$list_news = array();
while($row = mysqli_fetch_assoc($db_query->result)){
    prepare_news_record($row);
    $list_news[] = $row;
}
unset($db_query);
$rainTpl->assign('list_news',$list_news);