<?
if($cat_id){
    //lấy bài hot nhất đầu tiên của category
    $db_query = new db_query('SELECT que_id,que_title,cat_name,que_image,que_question_content
                          FROM questions
                          LEFT JOIN categories ON que_cat_id = cat_id
                          WHERE que_cat_id = '.$cat_id.'
                                AND que_status = 1
                                AND que_type = 0
                                AND que_image <> ""
                                AND que_image IS NOT NULL
                                AND que_date <= '.TIMESTAMP.'
                                AND que_date >= '.MIN_TIME_NEWS_HOT.'
                          ORDER BY que_view DESC
                          LIMIT 1');
    $top_list = mysqli_fetch_assoc($db_query->result);unset($db_query);
    if(!$top_list){
        //nếu không có tin trong 2 ngày gần đây thì lấy từ đầu
        $db_query = new db_query('SELECT que_id,que_title,cat_name,que_image,que_question_content
                          FROM questions
                          LEFT JOIN categories ON que_cat_id = cat_id
                          WHERE que_cat_id = '.$cat_id.'
                                AND que_status = 1
                                AND que_image <> ""
                                AND que_image IS NOT NULL
                                AND que_type = 0
                                AND que_date <= '.TIMESTAMP.'
                          ORDER BY que_view DESC
                          LIMIT 1');
        $top_list = mysqli_fetch_assoc($db_query->result);unset($db_query);
    }
    prepare_hoidap_record($top_list);
    $rainTpl -> assign('top_list',$top_list);

//lấy danh sách các bài
    $page = getValue('page','int','GET',0);
    $page = $page > 1 ? $page : 1;
    $limit = 10;
    $limit_string = (int)(($page -1) * $limit) . ',' .$limit;
    $list_news = array();
    $db_query = new db_query('SELECT que_id, que_title, cat_name, que_image,que_question_content
                          FROM questions
                          LEFT JOIN categories ON que_cat_id = cat_id
                          WHERE que_cat_id = '.$cat_id.'
                                AND que_status = 1
                                AND que_type = 0
                                AND que_date <= '.TIMESTAMP.'
                          ORDER BY que_date DESC
                          LIMIT '.$limit_string);
    while($row = mysqli_fetch_assoc($db_query->result)){
        prepare_hoidap_record($row,'mobile_small');
        $list_news[] = $row;
    }
    $rainTpl->assign('list_news',$list_news);
}else{

}
