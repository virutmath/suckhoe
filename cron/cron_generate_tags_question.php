<?
require 'config.php';
$db = new db_query('SELECT que_id,que_title,que_question_content,que_answer_content
                    FROM questions
                    WHERE (que_tags = "" OR que_tags IS NULL) AND que_status = 1 AND que_type = 0
                    ORDER BY que_id DESC
                    LIMIT 1');
$tags = mysqli_fetch_assoc($db->result);unset($db);
//var_dump($tags);
if($tags){
    $title = $tags['que_title'];
    $teaser = $tags['que_question_content'];
    $detail = $tags['que_answer_content'];
    $tag_string = TagsGenerate($detail,$title,$teaser)->generate(10,2);
    $tag_string = implode(',',$tag_string);
    //update lại tag_string
    if(!$tag_string){
        echo 'Tag bị lỗi do kết nối';
        reload(100);
    }
    $db_update = new db_execute('UPDATE questions SET que_tags = "'.$tag_string.'" WHERE que_id = '.$tags['que_id']);
    echo 'Tin : '.$title.'<br>ID : '.$tags['que_id'].'<br>';
    echo 'Tags : '.$tag_string;
    reload(20);
}