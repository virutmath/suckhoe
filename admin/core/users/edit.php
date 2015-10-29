<?php
require 'inc_security.php';

$record_id = getValue('record_id');

$listGender = array();
$listGender[0] = '-- Giới tính --';
$listGender[1] = 'Nam';
$listGender[2] = 'Nữ';
$listGender[3] = 'Khác';

$use_birthday = getValue('use_birthday','str','POST','');
$use_birthday = convertDateTime($use_birthday);


$myform	=	new generate_form();
$myform->removeHTML(0);

$myform->add('use_email','use_email',0,0,'',1,'Lỗi nhập email',0,'Trùng email');
$myform->add('use_name','use_email',0,0,'',1,'Lỗi nhập email',0,'Trùng email');
$myform->add('use_firstname','use_firstname',0,0,'',1,'Bạn chưa nhập họ',0);
$myform->add('use_lastname','use_lastname',0,0,'',1,'Bạn chưa nhập tên',0);
$myform->add('use_birthday','use_birthday',0,1,'',1,'Bạn chưa nhập ngày sinh',0);
$myform->add('use_phone','use_phone',1,0,0,1,'Bạn chưa nhập số điện thoại',0);
$myform->add('use_contact','use_contact',0,0,'',1,'Bạn chưa nhập địa chỉ',0);
$myform->add('use_gender', 'use_gender', 1, 0, 0, 0, '', 0, '');
$myform->add('use_date', 'use_date', 1, 1, 0, 0, '', 0, '');
$myform->add('use_active', 'use_active', 1, 0, 0, 0, '', 0, '');
$myform->add('use_group', 'use_group', 1, 1, 0, 0, '', 0, '');
$myform->removeHTML(0);
$myform->addTable($bg_table);

$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg .= $myform->checkdata();
    $upload = new upload('use_avatar',$bg_filepath,$bg_extension,$limit_size);
    $filename = $upload->file_name;
    if($filename){
        $myform->add('use_avatar','filename',0,1,'');
        foreach($arr_resize as $type => $arr){
			resize_image($bg_filepath, $filename, $arr["width"], $arr["height"], $arr["quality"], $type);
		}
		delete_file($bg_table,$id_field,$record_id,"use_avatar",$bg_filepath);
    }
    $bg_errorMsg .= $upload->show_warning_error();
    if($bg_errorMsg == ''){
        $db_insert = new db_execute($myform->generate_update_SQL($id_field,$record_id));
        redirect('listing.html');
    }
}

//lấy dữ liệu record cần sửa đổi
$db_data 	= new db_query("SELECT * FROM " . $bg_table . " WHERE " . $id_field . " = " . $record_id);
if($row 		= mysqli_fetch_assoc($db_data->result)){
	foreach($row as $key=>$value){
		$$key = $value;
	}
}else{
		exit();
} 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=$load_header?>
</head>
<body>
<div class="module_header bold fix"><?=$module_name?></div>
<div id="wrapper">
    <?print_error_msg($bg_errorMsg)?>
	<?php $form = new form();
	?>
    <script>
    var News = new News();
    </script>
	<?=$form->form_open()?>
    <?=$form->textnote('Các trường có dấu (<span class="form-asterick">*</span>) là bắt buộc nhập')?>
	
    <?=$form->textnote('Các trường có dấu (<span class="form-asterick">*</span>) là bắt buộc nhập')?>
	<?=$form->text(array('label'=>'Email','name'=>'use_email','id'=>'use_email','value'=>getValue('use_email','str','POST',$use_email),'require'=>1, 'errorMsg'=>'Bạn chưa nhập email', 'placeholder'=> 'Email không dài quá 255 ký tự'),0,'span6')?>
    <?=$form->text(array('label'=>'Họ','name'=>'use_firstname','id'=>'use_firstname','value'=>getValue('use_firstname','str','POST',$use_firstname),'require'=>1, 'errorMsg'=>'Bạn chưa nhập họ', 'placeholder'=> 'Họ'),0,'span6')?>
    <?=$form->text(array('label'=>'Tên','name'=>'use_lastname','id'=>'use_lastname','value'=>getValue('use_lastname','str','POST',$use_lastname),'require'=>1, 'errorMsg'=>'Bạn chưa nhập tên', 'placeholder'=> 'Tên'),0,'span6')?>
    <?=$form->getFile(array('label'=>'Ảnh đại diện','title'=>'Ảnh đại diện','name'=>'use_avatar','id'=>'use_avatar'))?>
    <?=$form->text(array('label'=>'Ngày sinh','name'=>'use_birthday','id'=>'use_birthday','isdatepicker'=>1,'value'=>getValue('use_birthday','str','POST',date('d/m/Y',$use_birthday))))?>
    <?=$form->text(array('label'=>'Điện thoại','name'=>'use_phone','id'=>'use_phone','value'=>getValue('use_phone','str','POST',$use_phone),'require'=>1, 'errorMsg'=>'Bạn chưa nhập điện thoại', 'placeholder'=> 'Điện thoại'),0,'span6')?>
    <?=$form->text(array('label'=>'Địa chỉ','name'=>'use_contact','id'=>'use_contact','value'=>getValue('use_contact','str','POST',$use_contact),'require'=>1, 'errorMsg'=>'Bạn chưa nhập địa chỉ', 'placeholder'=> 'Địa chỉ'),0,'span6')?>
    <?=$form->select(array('label'=>'Giới tính','name'=>'use_gender', 'id'=>'use_gender','option'=>$listGender,'selected'=>getValue('use_gender','str','POST',$use_gender)))?>
    <?=$form->checkbox(array('label'=> 'Kích hoạt', 'name'=> 'use_active', 'id'=> 'use_active', 'value'=>1 ,'currentValue'=>getValue('use_active','int','POST',$use_active), 'helptext'=> 'Kích hoạt thành viên'))?>
	
    <?=$form->form_action(array('label'=>array('Cập nhật','Nhập lại'),'type'=>array('submit','reset')))?>
	<?=$form->form_close()?>
</div>
</body>
</html>