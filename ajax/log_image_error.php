<?
$img = getValue('img','str','GET','',3);
$img = explode('/',$img);
$img = end($img);
$myform = new generate_form();
$myform->add('lei_image','img',0,1,'',1,'error',1,'trùng ảnh');
$myform->addTable('log_error_image');
if(!$myform->checkdata()){
    $db = new db_execute($myform->generate_insert_SQL());
    unset($db);
}