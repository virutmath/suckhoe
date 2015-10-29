<?
$list_hoidap = array();
$db_query = new db_query('SELECT que_id,que_title, que_image, que_date,cat_name,que_question_content
                            FROM questions
                            LEFT JOIN categories ON cat_id = que_cat_id
                            WHERE que_date <= '.TIMESTAMP.' AND que_type = 0 AND que_status = 1
                            ORDER BY que_date DESC LIMIT '.$limit_start.','.$limit_size);
while($row = mysqli_fetch_assoc($db_query->result)){
    $row['cat_name'] = $row['cat_name'] ? $row['cat_name'] : 'Tư vấn';
    $row['link_detail'] = generate_hoidap_detail($row);
    $row['que_title'] = htmlspecialbo($row['que_title']);
    $row['que_date_str'] = getDateTime(1,1,1,1,'',$row['que_date']);
    $row['que_date'] = date('d/m/Y H:i',$row['que_date']);
    $row['que_image'] = $row['que_image'] ? get_picture_path($row['que_image'],'small') : '';
    $list_hoidap[] = $row;
}
if(!$list_hoidap && $iPage > 1){
    redirect(generate_qaa_url(),1);
}
$rainTpl->assign('list_hoidap',$list_hoidap);
