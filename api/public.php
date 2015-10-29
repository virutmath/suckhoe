<?
$db_query = new db_query('SELECT new_id, new_title, cat_name
                          FROM news LEFT JOIN categories ON cat_id = new_cat_id
                          WHERE new_active = 1
                          ORDER BY new_date DESC LIMIT 10');
$return_json = array();
while($row = mysqli_fetch_assoc($db_query->result)){
    $return_json[] = DOMAIN_URL . generate_news_detail_url($row);
}
$api_result = array('success'=>1,'urls'=>$return_json);

