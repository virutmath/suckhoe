<?
/* List tin ở top là tin mới dựa vào số view */
$sql_news_release = 'SELECT new_id,
                        new_title,
                        new_date,
                        new_picture,
                        new_view,
                        cat_id,
                        cat_name
                 FROM news
                 LEFT JOIN categories ON cat_id = new_cat_id
                 WHERE new_active = 1
                 AND new_picture <> ""
                 AND new_date <= '.TIMESTAMP.'
                 ORDER BY new_date DESC
                 LIMIT 5';
$db_news_release = new db_query($sql_news_release);
$news_release = array();
while($row = mysqli_fetch_assoc($db_news_release->result)){
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['new_picture'] = get_picture_path($row['new_picture'],'large');
    $row['new_date'] = date('d \T\h m, Y, h:i a',$row['new_date']);
    $row['new_view'] = number_format($row['new_view']);
    $row['link_cat'] = generate_cat_url($row);
    $row['link_detail'] = generate_news_detail_url($row);
    $news_release[] = $row;
}
unset($db_news_release);


$rainTpl->assign('news_release',$news_release);

//6 tin đọc nhiều nhất
$sql_list_home = 'SELECT new_id,
                         new_title,
                         new_date,
                         new_picture,
                         cat_id,
                         cat_name,
                         new_view
                  FROM news
                  LEFT JOIN categories ON cat_id = new_cat_id
                  WHERE new_active = 1  AND new_date >= '.MIN_TIME_NEWS_HOT. '
                  ORDER BY new_view DESC
                  LIMIT 0,6';

$db_list_home = new db_query($sql_list_home);
$list_home = array();
while($row = mysqli_fetch_assoc($db_list_home->result)){
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['new_picture'] = get_picture_path($row['new_picture'],'small');
    $row['new_date'] = date('d \T\h m, Y, h:i a',$row['new_date']);
    $row['new_view'] = number_format($row['new_view']);
    $row['link_cat'] = generate_cat_url($row);
    $row['color_cat'] = get_color_category($row['cat_id']);
    $row['link_detail'] = generate_news_detail_url($row);
    $list_home[] = $row;
}
$rainTpl->assign('list_home',$list_home);

//lấy ra các category, mỗi category 3 tin mới nhất - trừ mục tin sức khỏe
$list_news_category = array();
$cat_tsk = $list_category[1];
foreach($list_category as $cat_temp){
    //bỏ qua tin sức khỏe
    if($cat_tsk['cat_id'] == $cat_temp['cat_id'] || $cat_tsk['cat_id'] == 0) continue;
    $db_query = new db_query('SELECT new_id,
                                     new_title,
                                     new_picture,
                                     new_date,
                                     new_view
                              FROM news 
                              WHERE new_active = 1 AND new_cat_id = '.$cat_temp['cat_id'].'
                              ORDER BY new_date DESC
                              LIMIT 3');
    $list_temp = array();
    $i = 0;
    while($row = mysqli_fetch_assoc($db_query->result)){
        $i++;
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['new_picture'] = get_picture_path($row['new_picture'],'medium');
        $row['new_date'] = date('d \T\h m, Y, h:i a',$row['new_date']);
        $row['new_view'] = number_format($row['new_view']);
        $row['cat_name'] = $cat_temp['cat_name'];
        //first news of this cat
        $row['is_first'] = ($i == 1? 1 : 0);
        $row['link_detail'] = generate_news_detail_url($row);
        $list_temp[] = $row;
    }
    if(!$list_temp) continue;
    $list_news_category[] = array(
        'cat_id'=>$cat_temp['cat_id'],
        'cat_name'=>$cat_temp['cat_name'],
        'link_cat'=>generate_cat_url($cat_temp),
        'array_news'=>$list_temp
    );
    unset($db_query);
}
if(!$list_news_category){
    echo 'Trang đang cập nhật';
    exit();
}
//lấy ra list tin sức khỏe hot
$list_news_tsk = array(
    'cat_name'=>$cat_tsk['cat_name'],
    'link_cat'=>$cat_tsk['link_cat'],
    'array_news'=>array()
);
$db_news_tsk_hot = new db_query('SELECT new_id,
                                        new_title,
                                        new_picture
                                 FROM   news
                                 WHERE  new_active = 1
                                    AND new_cat_id = '.$cat_tsk['cat_id'].'
                                    AND new_date >= '.MIN_TIME_NEWS_HOT.'
                                    AND new_view >= '.MIN_NEWS_VIEW.'
                                 ORDER BY new_view DESC
                                 LIMIT 3');
//biến check query rỗng
$check_i = 0;
while($row = mysqli_fetch_assoc($db_news_tsk_hot->result)){
    $check_i++;
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['cat_name'] = $cat_tsk['cat_name'];
    $row['link_detail'] = generate_news_detail_url($row);
    $row['new_picture'] = get_picture_path($row['new_picture'],'medium');
    $list_news_tsk['array_news'][] = $row;
}

if(!$check_i){
    //tin hot mục sức khỏe không có tin mới trong khoảng thời gian MIN_TIME_NEWS_HOT hoặc chưa thỏa mãn MIN_NEWS_VIEW
    $db_news_tsk_hot = new db_query('SELECT new_id,
                                            new_title,
                                            new_picture
                                     FROM   news
                                     WHERE  new_active = 1
                                        AND new_cat_id = '.$cat_tsk['cat_id'].'
                                     ORDER BY new_view DESC
                                     LIMIT 3');
    while($row = mysqli_fetch_assoc($db_news_tsk_hot->result)){
        $check_i++;
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['cat_name'] = $cat_tsk['cat_name'];
        $row['link_detail'] = generate_news_detail_url($row);
        $row['new_picture'] = get_picture_path($row['new_picture'],'medium');
        $list_news_tsk['array_news'][] = $row;
    }
}
shuffle($list_news_category);
array_pop($list_news_category);
$rainTpl->assign('list_news_category',$list_news_category);
$rainTpl->assign('list_news_tsk',$list_news_tsk);

//list câu hỏi và bệnh khối hỏi đáp bên phải
$list_qaa_sidebar = get_qaa_listing_sidebar();
$rainTpl->assign('list_qaa_sidebar',$list_qaa_sidebar);
//khối sơ đồ cơ thể
$anatomy_sex = get_cookie_anatomy_sex();
$anatomy_sex_str = getValue('anatomy-sex','str','COOKIE','male',3);
$sex_male_active    = $anatomy_sex == DOITUONG_NAMGIOI ? 'color-base' : 'text-muted';
$sex_female_active  = $anatomy_sex == DOITUONG_NUGIOI ? 'color-base' : 'text-muted';
$anatomy_type = SECTION_TYPE_FRONT;
$anatomy_data = get_anatomy_data($anatomy_sex,$anatomy_type);
$rainTpl->assign('anatomy_data',$anatomy_data);
$rainTpl->assign('anatomy_sex_str',$anatomy_sex_str);
$rainTpl->assign('sex_male_active',$sex_male_active);
$rainTpl->assign('sex_female_active',$sex_female_active);


$rainTpl->assign('link_catch_disease',generate_cat_disease_url());