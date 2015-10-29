<?
ob_clean();
$page = getValue('page');
$page = $page > 1 ? $page : 1;
$limit = 10;
$limit_string = (int)(($page -1) * $limit) . ',' .$limit;
$cat_id = getValue('id');
if($cat_id){
    $db_query = new db_query('SELECT new_id, new_title, cat_name, new_picture, new_teaser
                          FROM news
                          LEFT JOIN categories ON new_cat_id = cat_id
                          WHERE new_cat_id = '.$cat_id.'
                                AND new_active = 1
                                AND new_date <= '.TIMESTAMP.'
                          ORDER BY new_date DESC
                          LIMIT '.$limit_string);
}else{
    $db_query = new db_query('SELECT new_id, new_title, cat_name, new_picture, new_teaser
                          FROM news
                          LEFT JOIN categories ON new_cat_id = cat_id
                          WHERE new_active = 1
                                AND new_date <= '.TIMESTAMP.'
                          ORDER BY new_date DESC
                          LIMIT '.$limit_string);
}

while($row = mysqli_fetch_assoc($db_query->result)){
    prepare_news_record($row,'mobile_small');
    ?>
    <li class="fade-out">
        <a class="catehot" href="<?=$row['link_detail']?>" title="<?=$row['new_title']?>">
            <img class="catehot-thumbnail" src="<?=$row['new_picture_low']?>" alt="<?=$row['new_title']?>" data-src="<?=$row['new_picture']?>"/>
            <h2 class="catehot-title"><?=$row['new_title']?></h2>
            <p class="catehot-sapo"><?=$row['new_teaser']?></p>
        </a>
    </li>
<?
}?>