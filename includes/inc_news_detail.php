<?
$sql_detail = 'SELECT new_id,
                      new_title,
                      new_picture,
                      new_teaser,
                      cat_id,
                      cat_name,
                      new_date,
                      new_tags,
                      new_view
               FROM news
               LEFT JOIN categories ON cat_id = new_cat_id
               WHERE new_id = '.$iNews;
$db_detail = new db_query($sql_detail);
$detail_data = mysqli_fetch_assoc($db_detail->result);unset($db_detail);
if(!$detail_data){
    error_404_document();
}

//tăng view cho tin
$db_update_view = new db_execute('UPDATE news SET new_view = new_view + 1 WHERE new_id = '.$iNews);
unset($db_update_view);

//lấy chi tiết tin
$sql_news_content = 'SELECT ndt_content FROM news_detail WHERE ndt_id = '.$iNews;
$db_content = new db_query($sql_news_content);
$row = mysqli_fetch_assoc($db_content->result);unset($db_content);
$detail_data['new_detail'] = $row['ndt_content'];
$datetime_facebook = $detail_data['new_date'];
$datetime_detail_timestamp = $detail_data['new_date'];
$detail_data['new_date'] = getDateTime(1,1,1,1,'', $detail_data['new_date']);
$detail_data['link_cat'] = generate_cat_url($detail_data);
$detail_data['new_picture'] = get_picture_path($detail_data['new_picture'],'large');

$detail_data['facebook_share_link'] = 'http://khang.vn'.generate_news_detail_url($detail_data);
$detail_data['facebook_social'] = array();
$detail_data['facebook_social']['like'] = get_facebook_like_button($detail_data['facebook_share_link']);
$detail_data['facebook_social']['comment'] = get_facebook_comment_frame($detail_data['facebook_share_link']);
$detail_data['facebook_social']['embed'] = get_facebook_embedded_post($detail_data['facebook_share_link']);


$detail_data['new_teaser'] = $detail_data['new_teaser'] ? $detail_data['new_teaser'] : cut_string(removeHTML($detail_data['new_detail']),200,'...');
$color_cat = get_color_category($detail_data['cat_id']);

$rainTpl->assign('color_cat',$color_cat);
$rainTpl->assign('page_title',$detail_data['new_title']);
$rainTpl->assign('detail_data',$detail_data);

//query ra các tin cùng chuyên mục
$sql_cat_list_news = 'SELECT new_id,
                             new_picture,
                             new_title,
                             cat_name
                      FROM news
                      LEFT JOIN categories ON cat_id = new_cat_id
                      WHERE new_cat_id = '.$detail_data['cat_id'].' AND new_active = 1 AND new_id <> '.$iNews.'
                      AND new_date <= '.$datetime_detail_timestamp.'
                      ORDER BY new_date DESC
                      LIMIT 3';
$db_cat_news = new db_query($sql_cat_list_news);
$cat_list_news = array();
$array_link_see_also = array();
while($row = mysqli_fetch_assoc($db_cat_news->result)){
    $row['new_picture'] = get_picture_path($row['new_picture'],'medium');
    $row['link_detail'] = generate_news_detail_url($row);
    $cat_list_news[] = $row;
    $array_link_see_also[] = 'http://khang.vn'.$row['link_detail'];
}
unset($db_cat_news);
$rainTpl->assign('cat_list_news',$cat_list_news);


//khối tin tức bên phải
$news_xem_nhieu = get_news_xem_nhieu(8);
$rainTpl->assign('news_xem_nhieu',$news_xem_nhieu);
$news_random = get_news_random(8);
$rainTpl->assign('news_random',$news_random);

//khôi tin bạn có biết
$box_cat_right = get_news_ban_co_biet(4);
$rainTpl->assign('box_cat_right',$box_cat_right);


//khối sơ đồ cơ thể
$anatomy_sex = get_cookie_anatomy_sex();
$sex_male_active    = $anatomy_sex == DOITUONG_NAMGIOI ? 'color-base' : 'text-muted';
$sex_female_active  = $anatomy_sex == DOITUONG_NUGIOI ? 'color-base' : 'text-muted';
$anatomy_type = SECTION_TYPE_FRONT;
$anatomy_data = get_anatomy_data($anatomy_sex,$anatomy_type);
$rainTpl->assign('anatomy_data',$anatomy_data);
$rainTpl->assign('sex_male_active',$sex_male_active);
$rainTpl->assign('sex_female_active',$sex_female_active);
$rainTpl->assign('link_catch_disease',generate_cat_disease_url());
