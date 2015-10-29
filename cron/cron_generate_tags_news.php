<?
require 'config.php';
$db = new db_query('SELECT new_id,new_title,new_teaser FROM news WHERE new_tags = "" OR new_tags IS NULL ORDER BY new_id DESC LIMIT 1');
$tags = mysqli_fetch_assoc($db->result);unset($db);
var_dump($tags);
if($tags){
    $title = $tags['new_title'];
    $teaser = $tags['new_teaser'];
    $db = new db_query('SELECT ndt_content FROM news_detail WHERE ndt_id = '.$tags['new_id']);
    $detail = mysqli_fetch_assoc($db->result);unset($db);
    $detail = $detail['ndt_content'];
    $tag_string = TagsGenerate($detail,$title,$teaser)->generate(10,2);
    $tag_string = implode(',',$tag_string);
    //update lại tag_string

    if(!$tag_string){
        echo 'Tag bị lỗi do kết nối';
        reload(100);
    }
    $db_update = new db_execute('UPDATE news SET new_tags = "'.$tag_string.'" WHERE new_id = '.$tags['new_id']);
    echo 'Tin : '.$title.'<br>ID : '.$tags['new_id'].'<br>';
    echo 'Tags : '.$tag_string;
    reload(20);
}