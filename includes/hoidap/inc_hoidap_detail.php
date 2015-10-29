<?
if(!$que_id){
    error_404_document();
}
$sql = 'SELECT *
        FROM questions
        STRAIGHT_JOIN categories ON cat_id = que_cat_id
        WHERE que_id = '.$que_id.' AND que_type = 0 AND que_status = 1';
$db_query = new db_query($sql);
$detail_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
if(!$detail_data){
    error_404_document();
}
$detail_data['link_hoidap'] = generate_qaa_url();
$detail_data['link_cat'] = generate_qaa_url($detail_data);
$detail_data['que_question_content'] = nl2br($detail_data['que_question_content']);
$detail_data['que_title'] = htmlspecialbo($detail_data['que_title']);
$datetime_facebook = $detail_data['que_date'];
$detail_data['que_date'] = date('d/m/Y H:i',$detail_data['que_date']);
$detail_data['que_image'] = get_picture_path($detail_data['que_image']);
//phân tag ra thành link search
if($detail_data['que_tags']){
    $detail_data['array_tag_search'] = array();
    $array_tag = explode(',',$detail_data['que_tags']);
    $array_tag = array_slice($array_tag,0,6);
    foreach($array_tag as $key=>$value){
        $detail_data['array_tag_search'][] = array('tag_link'=>'#','tag_name'=>$value);
    }
}

$detail_data['facebook_share_link'] = 'http://khang.vn'.generate_hoidap_detail($detail_data);
$detail_data['facebook_social'] = array();
$detail_data['facebook_social']['like'] = get_facebook_like_button($detail_data['facebook_share_link']);
$detail_data['facebook_social']['comment'] = get_facebook_comment_frame($detail_data['facebook_share_link']);
$detail_data['facebook_social']['embed'] = get_facebook_embedded_post($detail_data['facebook_share_link']);

$rainTpl->assign('detail_data',$detail_data);
//update view
$db_update = new db_execute('UPDATE questions SET que_view = que_view + 1 WHERE que_id = '.$que_id);
unset($db_update);

//tin cùng chuyên mục
$list_question_cat = array();
$db_query = new db_query('SELECT *
                          FROM questions
                          WHERE que_cat_id = '.$detail_data['cat_id'].'
                          AND que_status = 1 AND que_type = 0
                          AND que_id <> '.$detail_data['que_id'].'
                          ORDER BY que_date DESC
                          LIMIT 0,4');
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['cat_name'] = $detail_data['cat_name'];
    $row['que_title'] = htmlspecialbo($row['que_title']);
    $row['que_date'] = date('H:i - d/m/Y',$row['que_date']);
    $row['link_detail'] = generate_hoidap_detail($row);
    $list_question_cat[] = $row;
}
$rainTpl->assign('list_question_cat',$list_question_cat);
//câu hỏi liên quan
$array_question_relate = array();
if($detail_data['que_relate']){
    //nếu đã có trong relate thì lấy ra
    $db_relate = new db_query('SELECT que_id, que_title, cat_name, que_date
                                FROM questions
                                LEFT JOIN categories ON cat_id = que_cat_id
                                WHERE que_id IN('.$detail_data['que_relate'].')');
    while($row = mysqli_fetch_assoc($db_relate->result)){
        $row['que_title'] = htmlspecialbo($row['que_title']);
        $row['que_date'] = date('d/m',$row['que_date']);
        $row['link_detail'] = generate_hoidap_detail($row);
        $array_question_relate[] = $row;
    }
}else{
    $array_question_relate = get_question_relate($detail_data['que_tags'],5,$detail_data['que_id'],$detail_data['cat_id']);
}
$rainTpl->assign('array_question_relate',$array_question_relate);



