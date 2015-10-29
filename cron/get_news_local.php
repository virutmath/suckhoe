<?php
require_once 'config.php';
$users = array('admin' => 'test1234');
$realm	= $_SERVER['HTTP_HOST'];
check_authen();
// analyze the PHP_AUTH_DIGEST variable
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])){
    header('HTTP/1.1 401 Unauthorized');
    unset($_SERVER['PHP_AUTH_DIGEST']);
    check_authen();
    exit("Xin loi ban ko co quyen");
}
// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

if (@$data['response'] != $valid_response){
    header('HTTP/1.1 401 Unauthorized');
    unset($_SERVER['PHP_AUTH_DIGEST']);
    check_authen();
    exit("Xin loi ban ko co quyen");
}
//authen valid - get data and save post
//var_dump($_FILES['data_picture']);
$myform = new generate_form();
$myform->addTable('news');
$myform->add('new_title','new_title',0,0,'',1,'Tiêu đề trống');
$myform->add('new_title_md5','new_title_md5',0,0,'',1,'');
$myform->add('new_cat_id','new_cat_id',1,0,0,1);
$myform->add('new_lin_id','new_lin_id',1,0,0,1);
$myform->add('new_picture','new_picture',0,0,'');
$myform->add('new_teaser','new_teaser',0,0,'',1);
$myform->add('new_tags','new_tags',0,0,'');
$myform->add('new_date','new_date',1,0,0,1);
$myform->add('new_active','new_active',1,0,0,1);

if(!$myform->checkdata()){
    $db_insert = new db_execute_return();
    $last_id = $db_insert->db_execute($myform->generate_insert_SQL());unset($db_insert);
    //lưu ảnh
    if($last_id){
        $path_picture = generate_dir_upload($_POST['new_picture'],'organic') . $_POST['new_picture'];
        move_uploaded_file($_FILES['data_picture']['tmp_name'],$path_picture);
        //lưu chi tiết tin
        $myform_dt = new generate_form();
        $myform_dt->addTable('news_detail');
        $myform_dt->add('ndt_id','last_id',1,1,0);
        $myform_dt->add('ndt_content','ndt_content',0,0,'');
        $myform_dt->removeHTML(0);
        $db_insert = new db_execute($myform_dt->generate_insert_SQL());
        $total = $db_insert->total;
        unset($db_insert);
        if($total){
            echo $last_id;
        }else{
            echo 0;
        }
    }
}