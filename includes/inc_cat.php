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
                 AND new_cat_id = '.$iCat.'
                 ORDER BY new_date DESC
                 LIMIT 5';
$db_news_release = new db_query($sql_news_release);
$news_release = array();
//xử lý để không lấy trùng tin so với list tin ở dưới
$string_query_unique = '';
if(mysqli_num_rows($db_news_release->result)){
    $string_query_unique = ' AND new_id NOT IN (';
    while($row = mysqli_fetch_assoc($db_news_release->result)){
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['new_picture'] = get_picture_path($row['new_picture'],'large');
        $row['new_date'] = date('d \T\h m, Y, h:i a',$row['new_date']);
        $row['new_view'] = number_format($row['new_view']);
        $row['link_cat'] = generate_cat_url($row);
        $row['link_detail'] = generate_news_detail_url($row);
        $news_release[] = $row;
        $string_query_unique .= $row['new_id'] . ',';
    }
}
if($string_query_unique){
    $string_query_unique = rtrim($string_query_unique, ',') . ') ';
}
unset($db_news_release);


$rainTpl->assign('news_release',$news_release);

//query ra tin hot ở cột bên phải của list tin danh mục
$sql_hot = 'SELECT new_id,
                    new_title,
                    cat_name
            FROM news
            LEFT JOIN categories ON cat_id = new_cat_id
            WHERE new_active = 1
                AND new_picture <> ""
                AND new_date <= '.TIMESTAMP.'
                AND new_date >= '.MIN_TIME_NEWS_HOT.'
                AND new_cat_id = '.$iCat.
                $string_query_unique.'
            ORDER BY new_view DESC
            LIMIT 10';
$db_hot = new db_query($sql_hot);
$top_list_right = array();
while($row = mysqli_fetch_assoc($db_hot->result)){
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['link_detail'] = generate_news_detail_url($row);
    $top_list_right[] = $row;
}
if(!$top_list_right){
    $sql_hot = 'SELECT new_id,
                    new_title,
                    cat_name
            FROM news
            LEFT JOIN categories ON cat_id = new_cat_id
            WHERE new_active = 1
                AND new_picture <> ""
                AND new_date <= '.TIMESTAMP.'
                AND new_date >= '.(MIN_TIME_NEWS_HOT - 7*86400).'
                AND new_cat_id = '.$iCat.
        $string_query_unique.'
            ORDER BY new_view DESC
            LIMIT 10';
    $db_hot = new db_query($sql_hot);
    while($row = mysqli_fetch_assoc($db_hot->result)){
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['link_detail'] = generate_news_detail_url($row);
        $top_list_right[] = $row;
    }
}
if(!$top_list_right){
    $sql_hot = 'SELECT new_id,
                    new_title,
                    cat_name
            FROM news
            LEFT JOIN categories ON cat_id = new_cat_id
            WHERE new_active = 1
                AND new_picture <> ""
                AND new_date <= '.TIMESTAMP.'
                AND new_cat_id = '.$iCat.
        $string_query_unique.'
            ORDER BY new_view DESC
            LIMIT 10';
    $db_hot = new db_query($sql_hot);
    while($row = mysqli_fetch_assoc($db_hot->result)){
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['link_detail'] = generate_news_detail_url($row);
        $top_list_right[] = $row;
    }
}
unset($db_hot);
$rainTpl->assign('top_list_right',$top_list_right);

//query ra list tin theo thời gian
$limit_start = isset($iPage) ? intval(($iPage - 1) * $limit_size) : 0;
if($limit_start < 0){
    $iPage = 1;
    $limit_start = 0;
}
$sql_list_news = 'SELECT new_id,
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
$db_list_news = new db_query($sql_list_news);
$top_list_left = array();
$category_list_news = array();
$count_i = 0;
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
    $count_i ++;
    if($count_i <= 4) {
        //add vào list trên
        $top_list_left[] = $row;
    }else{
        $category_list_news[] = $row;
    }
}
$rainTpl->assign('category_list_news',$category_list_news);
$rainTpl->assign('top_list_left',$top_list_left);
//truyền thêm tham số vào pjax
$pjax_params = array('query_unique'=>$string_query_unique);
$rainTpl->assign('pjax_params_base64',pjax_param_create($pjax_params));

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