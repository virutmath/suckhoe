<?
header("Cache-Control: no-cache");
header("Pragma: no-cache");
ob_clean();
$page = getValue('page');
$page = $page > 1 ? $page : 1;
$limit = 10;
$limit_string = (int)(($page -1) * $limit) . ',' .$limit;

$cat_id = getValue('id');
if($cat_id){
    $db_query = new db_query('SELECT que_id,que_title,que_question_content,que_image,cat_name
                          FROM questions
                          LEFT JOIN categories ON que_cat_id = cat_id
                          WHERE que_cat_id = '.$cat_id.'
                                AND que_status = 1
                                AND que_type = 0
                                AND que_date <= '.TIMESTAMP.'
                          ORDER BY que_date DESC
                          LIMIT '.$limit_string);
}else{
    $db_query = new db_query('SELECT que_id,que_title,que_question_content,que_image,cat_name
                          FROM questions
                          LEFT JOIN categories ON que_cat_id = cat_id
                          WHERE que_status = 1
                                AND que_type = 0
                                AND que_date <= '.TIMESTAMP.'
                          ORDER BY que_date DESC
                          LIMIT '.$limit_string);
}

while($row = mysqli_fetch_assoc($db_query->result)){
    prepare_hoidap_record($row,'mobile_small');
    ?>
    <li class="fade-out">
        <a class="catehot" href="<?=$row['link_detail']?>" title="<?=$row['que_title']?>">
            <img class="catehot-thumbnail" src="<?=$row['que_image_low']?>" alt="<?=$row['que_title']?>" data-src="<?=$row['que_image']?>"/>
            <h2 class="catehot-title"><?=$row['que_title']?></h2>
            <p class="catehot-sapo"><?=$row['que_question_content']?></p>
        </a>
    </li>
<?
}?>