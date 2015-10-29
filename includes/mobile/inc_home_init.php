<?
//lấy ra 9 bài hot nhất
$db_news_hot =  new db_query('SELECT new_id,new_picture, new_title, cat_name
                              FROM news
                              LEFT JOIN categories ON cat_id = new_cat_id
                              WHERE new_active = 1  AND new_date >= '.MIN_TIME_NEWS_HOT. ' AND new_date <= '.TIMESTAMP.'
                              ORDER BY new_view DESC
                              LIMIT 0,9');
$list_featured = array();
$list_hot = array();
$i_count = 0;

while($row = mysqli_fetch_assoc($db_news_hot->result)){
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['link_detail'] = generate_news_detail_url($row);
    $i_count ++;
    if($i_count <= 3) {
        $row['new_picture_low'] = get_picture_path($row['new_picture'],'mobile_low');
        $row['new_picture'] = get_picture_path($row['new_picture'],'mobile');
        $list_featured[] = $row;
    }else{
        $row['new_picture_low'] = get_picture_path($row['new_picture'],'mobile_medium_low');
        $row['new_picture'] = get_picture_path($row['new_picture'],'mobile_medium');
        $list_hot[] = $row;
    }
}unset($db_news_hot);
//nếu không đủ 9 tin thì lấy tiếp
if($i_count < 9) {
    $db_news_hot = new db_query('SELECT new_id,new_picture, new_title, cat_name
                                  FROM news
                                  LEFT JOIN categories ON cat_id = new_cat_id
                                  WHERE new_active = 1 AND new_date <= '.TIMESTAMP.'
                                  ORDER BY new_view DESC
                                  LIMIT '.$i_count.',9');
    while($row = mysqli_fetch_assoc($db_news_hot->result)){
        $row['new_title'] = htmlspecialbo($row['new_title']);
        $row['link_detail'] = generate_news_detail_url($row);
        $i_count ++;
        if($i_count <= 3) {
            $row['new_picture_low'] = get_picture_path($row['new_picture'],'mobile_low');
            $row['new_picture'] = get_picture_path($row['new_picture'],'mobile');
            $list_featured[] = $row;
        }else{
            $row['new_picture_low'] = get_picture_path($row['new_picture'],'mobile_medium_low');
            $row['new_picture'] = get_picture_path($row['new_picture'],'mobile_medium');
            $list_hot[] = $row;
        }
    }unset($db_news_hot);
}


$rainTpl -> assign('list_featured',$list_featured);
$rainTpl -> assign('list_hot',$list_hot);

$list_id_unique = '';
foreach($list_featured as $key=>$value){
    $list_id_unique .= $value['new_id'] . ',';
}
foreach($list_hot as $key=>$value){
    $list_id_unique .= $value['new_id'] . ',';
}
$list_id_unique = rtrim($list_id_unique,',');

//tin hot trong ngày
$list_hot_day = array();
$db_news_hot_day =  new db_query('SELECT new_id, new_title, cat_name
                                  FROM news
                                  LEFT JOIN categories ON cat_id = new_cat_id
                                  WHERE new_active = 1  AND new_date >= '.(TIMESTAMP - 86400). ' AND new_date <= '.TIMESTAMP.'
                                  AND new_id NOT IN ('.$list_id_unique.')
                                  ORDER BY new_view DESC
                                  LIMIT 0,5');
while($row = mysqli_fetch_assoc($db_news_hot_day->result)){
    $row['new_title'] = htmlspecialbo($row['new_title']);
    $row['link_detail'] = generate_news_detail_url($row);
    $list_hot_day[] = $row;
}
$rainTpl->assign('list_hot_day',$list_hot_day);

//lấy theo category, các bài
$list_news_cat = array();
$array_cat = get_category_news();
foreach($array_cat as $cat_item) {
    $db_query = new db_query('SELECT new_id, new_title, cat_name, new_picture
                              FROM news
                              LEFT JOIN categories ON cat_id = new_cat_id
                              WHERE new_active = 1 AND new_date <= '.TIMESTAMP .'
                                    AND new_cat_id = '.$cat_item['cat_id'].'
                              ORDER BY new_date DESC
                              LIMIT 0,5');
    $list_temp = array();
    $first_news_temp = array();
    $temp_count = 0;
    while($row = mysqli_fetch_assoc($db_query->result)){
        prepare_news_record($row,'mobile');
        $temp_count++;
        if($temp_count == 1)
            $first_news_temp = $row;
        else
            $list_temp[] = $row;
    }
    $list_news_cat[] = array(
        'cat_id'=>$cat_item['cat_id'],
        'cat_name'=>$cat_item['cat_name'],
        'link_cat'=>generate_cat_url($cat_item),
        'first_news'=>$first_news_temp,
        'list_news'=>$list_temp
    );
    unset($db_query);
}
$rainTpl->assign('list_news_cat',$list_news_cat);
