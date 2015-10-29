<?
require_once 'config.php';
require_once '../functions/cron_news_functions.php';

//lay ra tin
$db = new db_query('SELECT lin_url,lin_id, lin_cat_id, law.*
                    FROM links
                    LEFT JOIN law ON law_id = lin_law_id
                    WHERE lin_status = '.LINK_STATUS_PENDING.' LIMIT 1');
$link_data = mysqli_fetch_assoc($db->result);
if(!$link_data){
    echo 'Hết link để lấy tin';die();
}
//xử lý dữ liệu
$array_data_news = pre_cron_news_detail($link_data);
if(!$array_data_news['success']){
    echo $array_data_news['error'];
    reload(5);
    die();
}
$title = $array_data_news['title'];
$title_md5 = $array_data_news['title_md5'];
$category = $array_data_news['category'];
$content = $array_data_news['content'];
$teaser = $array_data_news['teaser'];
$tag_string = $array_data_news['tag_string'];
$image = $array_data_news['image'];
$link_id = $array_data_news['link_id'];
$link_url = $array_data_news['link_url'];

$time = time();
$active = 1;
//myform
$myform = new generate_form();
$myform->addTable('news');
$myform->add('new_title','title',0,1,$title);
$myform->add('new_title_md5','title_md5',0,1,'',1,'Title md5 error',1,'Tiêu đề bị trùng');
$myform->add('new_cat_id','category',1,1,$category);
$myform->add('new_lin_id','link_id',1,1,$link_id);
$myform->add('new_picture','image',0,1,$image);
$myform->add('new_teaser','teaser',0,1,$teaser);
$myform->add('new_tags','tag_string',0,1,$tag_string);
$myform->add('new_date','time',1,1,$time);
$myform->add('new_active','active',1,1,$active);
$myform->removeHTML(0);

if(!$myform->checkdata()){
    $db_execute_return = new db_execute_return();
    $last_id = $db_execute_return->db_execute($myform->generate_insert_SQL());
    unset($db_execute_return);
    if($last_id){
        //cập nhật link lấy thành công
        $db_update = new db_execute('UPDATE links SET lin_status = '.LINK_STATUS_SUCCESS.' WHERE lin_id = '.$link_id);
        //insert content vào bảng news detail
        $myform2 = new generate_form();
        $myform2->addTable('news_detail');
        $myform2->add('ndt_id','last_id',1,1,0,1,'Không có ID bài viết');
        $myform2->add('ndt_content','content',0,1,'',1,'Content trống');
        $myform2->removeHTML(0);
        if(!$myform2->checkdata()){
            $db_insert = new db_execute($myform2->generate_insert_SQL());
            unset($db_insert);
            echo 'Lấy thành công tin : <a href="'.$link_url.'">'.$link_url.'</a>';
            reload(30);
            die();
        }else{
            $db_update = new db_execute('UPDATE links SET lin_status = '.LINK_STATUS_FAIL.' WHERE lin_id = '.$link_id);
            echo 'Dữ liệu trống';
            reload(30);
            die();
        }
    }else{
        $db_update = new db_execute('UPDATE links SET lin_status = '.LINK_STATUS_FAIL.' WHERE lin_id = '.$link_id);
        echo 'Không lấy tin <a href="'.$link_url.'">'.$link_url.'</a>';
        reload(30);
        die();
    }
}else{
    $db_update = new db_execute('UPDATE links SET lin_status = '.LINK_STATUS_FAIL.' WHERE lin_id = '.$link_id);
    echo 'Không lấy tin <a href="'.$link_url.'">'.$link_url.'</a>';
    reload(30);
    die();
}
