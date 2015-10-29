<?
function prepare_news_record(&$row_news, $type_image = 'mobile'){
    if(isset($row_news['new_title']) && $row_news['new_title'])
        $row_news['new_title'] = htmlspecialbo($row_news['new_title']);
    if(isset($row_news['new_picture']) && $row_news['new_picture']){
        $row_news['new_picture_low'] = get_picture_path($row_news['new_picture'], $type_image . '_low');
        $row_news['new_picture'] = get_picture_path($row_news['new_picture'], $type_image);
    }

    if(isset($row_news['new_teaser']) && $row_news['new_teaser']){
        $row_news['new_teaser'] = removeHTML($row_news['new_teaser']);
        $row_news['full_teaser'] = $row_news['new_teaser'];
        $row_news['new_teaser'] = cut_string($row_news['new_teaser'],50);
    }
    if(isset($row_news['new_date']) && $row_news['new_date']){
        $row_news['post_time'] = date('d/m/Y | H:i',$row_news['new_date']);
    }


    $row_news['link_detail'] = generate_news_detail_url($row_news);
    return $row_news;
}
function prepare_hoidap_record(&$row_news, $type_image = 'mobile'){
    if(isset($row_news['que_title']) && $row_news['que_title'])
        $row_news['que_title'] = htmlspecialbo($row_news['que_title']);
    if(isset($row_news['que_image']) && $row_news['que_image']){
        $row_news['que_image_low'] = get_picture_path($row_news['que_image'], $type_image . '_low');
        $row_news['que_image'] = get_picture_path($row_news['que_image'], $type_image);
    }

    if(isset($row_news['que_question_content']) && $row_news['que_question_content']){
        $row_news['full_question_content'] = $row_news['que_question_content'];
        $row_news['que_question_content'] = removeHTML($row_news['que_question_content']);
        $row_news['que_question_content'] = cut_string($row_news['que_question_content'],50);
    }
    if(isset($row_news['que_date']) && $row_news['que_date']){
        $row_news['post_time'] = date('d/m/Y | H:i',$row_news['que_date']);
    }


    $row_news['link_detail'] = generate_hoidap_detail($row_news);
    return $row_news;
}
function get_list_news_same_category($news_data,$limit = 5, $prepare = true){
    $db_query = new db_query('SELECT new_id,
                                     new_title,
                                     new_teaser,
                                     new_picture,
                                     new_view,
                                     new_date,
                                     "'.$news_data['cat_name'].'" AS cat_name
                              FROM news
                              WHERE new_cat_id = '.$news_data['new_cat_id'].'
                                    AND new_date <= '.$news_data['new_date'].'
                                    AND new_active = 1
                                    AND new_id <> '.$news_data['new_id'].'
                              ORDER BY new_date DESC
                              LIMIT '.$limit);
    $list_news = array();
    while($row = mysqli_fetch_assoc($db_query->result)){
        if($prepare)
            prepare_news_record($row,'mobile_small');
        $list_news[] = $row;
    }
    return $list_news;
}
function get_list_question_same_category($news_data,$limit = 5, $prepare = true){
    $db_query = new db_query('SELECT que_id,
                                     que_title,
                                     que_question_content,
                                     que_image,
                                     que_view,
                                     que_date,
                                     "'.$news_data['cat_name'].'" AS cat_name
                              FROM questions
                              WHERE que_cat_id = '.$news_data['que_cat_id'].'
                                    AND que_date <= '.$news_data['que_date'].'
                                    AND que_status = 1
                                    AND que_type = 0
                                    AND que_id <> '.$news_data['que_id'].'
                              ORDER BY que_date DESC
                              LIMIT '.$limit);
    $list_news = array();
    while($row = mysqli_fetch_assoc($db_query->result)){
        if($prepare)
            prepare_hoidap_record($row,'mobile_small');
        $list_news[] = $row;
    }
    return $list_news;
}