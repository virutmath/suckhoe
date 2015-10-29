<?
$db_query = new db_query('SELECT *
                          FROM questions
                          LEFT JOIN categories ON cat_id = que_cat_id
                          WHERE que_type = 0
                              AND que_status = 1
                              AND que_id = '.$que_id.'
                          LIMIT 1');
$question_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
if(!$question_data){
    error_404_document();
}
prepare_hoidap_record($question_data);

//lấy ra câu hỏi cùng chuyên mục
$list_cat_news = get_list_question_same_category($question_data,5,true);

//tin hot trong ngày
$list_hot_day = array();
$db_news_hot_day =  new db_query('SELECT que_id, que_title, cat_name
                                  FROM questions
                                  LEFT JOIN categories ON cat_id = que_cat_id
                                  WHERE que_status = 1
                                        AND que_type = 0
                                        AND que_date >= '.(TIMESTAMP - 86400). '
                                        AND que_date <= '.TIMESTAMP.'
                                        AND que_id <> '.$que_id.'
                                  ORDER BY que_view DESC
                                  LIMIT 0,5');
while($row = mysqli_fetch_assoc($db_news_hot_day->result)){
    prepare_hoidap_record($row);
    $list_hot_day[] = $row;
}
unset($db_news_hot_day);