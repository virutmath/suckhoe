<?
require_once 'config.php';
//link cat
$db_link_cat = new db_query('SELECT law_id, law_link_cat, law_cat_id,law_detail_link FROM law WHERE law_status_temp = 0 LIMIT 1');
$link_cat = mysqli_fetch_assoc($db_link_cat->result);unset($db_link_cat);
//nếu không còn link nào thì cập nhật hết luật về trạng thái 0 và lấy lại từ đầu
if(!$link_cat){
    $db_update = new db_execute('UPDATE law SET law_status_temp = 0 WHERE law_status_temp = 1');
    echo 'Các link đã được lấy hết. Chuẩn bị reset luật !';
    reload(6000);
    die();
}
$domain = get_domain($link_cat['law_link_cat']);
//check link hỏng
if(!check_url_status($link_cat['law_link_cat'],array(200,301,304,302))){
    //update link hỏng
    $db_update = new db_execute('UPDATE law SET law_status_temp = 2 WHERE law_id = '.$link_cat['law_id']);
    unset($db_update);
    echo 'Link hỏng';
    reload(10);
    die();
}
//lấy link
$string_html = curl_get_content($link_cat['law_link_cat']);
$string_html = str_get_html($string_html);
$sql_insert = 'INSERT IGNORE links (lin_url_md5,lin_url,lin_status,lin_cat_id,lin_law_id) VALUES ';
foreach($string_html->find($link_cat['law_detail_link']) as $link){
    $link_href = trim($link->href);
    if(!trim($link_href))   continue;
    if(in_array($link_href, array('/','#', ' ','&nbsp;'))) continue;
    $parse = parse_url($link_href);
    //neu link ko co domain thi lap them domain vao
    if(!$parse['scheme']){
        $link_href = $domain . $link_href;
    }
    //check link trung
    $md5_link = md5($link_href);
    $db_check_unique_link = new db_query('SELECT lin_id FROM links WHERE lin_url_md5 = "'.$md5_link.'"');
    if(mysqli_num_rows($db_check_unique_link->result))   continue;
    $sql_insert .= '("'.$md5_link.'","'.$link_href.'",0,'.$link_cat['law_cat_id'].','.$link_cat['law_id'].'),';
}
$sql_insert = rtrim($sql_insert,',');
$db = new db_execute($sql_insert);
echo '<br>lấy được'.$db->total.' link';
//update status temp thành 1
$db_update = new db_execute('UPDATE law SET law_status_temp = 1 WHERE law_id = '.$link_cat['law_id']);
unset($db_update);
reload(3);