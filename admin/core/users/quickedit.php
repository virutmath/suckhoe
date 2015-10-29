<?php
require_once("inc_security.php");
$returnurl = base64_decode(getValue("url","str","GET",base64_encode("listing.html")));
$errorMsg = '';
$errorMsgAll	=	"";

$iQuick = getValue("iQuick","str","POST","");
$record_id = getValue("record_id", "arr", "POST", "");
if(!$record_id){
    redirect('listing.html');
}
if($iQuick == 'update'){
	$total_record	=	count($record_id);
	if($total_record > 0){
		for($i = 0; $i < $total_record; $i++){
			//Call Class generate_form();
			$myform = new generate_form();
			//Insert to database
            $myform->add('use_email', "use_email" . $record_id[$i], 0, 0, '', 0, '', 0, '');
            $myform->add('use_name', "use_email" . $record_id[$i], 0, 0, '', 0, '', 0, '');
            $myform->add('use_phone', "use_phone" . $record_id[$i], 1, 0, '', 0, '', 0, '');
            $myform->add('use_contact', "use_contact" . $record_id[$i], 0, 0, '', 0, '', 0, '');
            
			//Add table
			$myform->addTable($bg_table);
			
			$upload_pic = new upload("use_avatar" . $record_id[$i], $bg_filepath, $bg_extension, $limit_size);
			$file_name	=	$upload_pic->file_name;
			//echo	$file_name;
			if($file_name != ""){
				$myform->add("use_avatar","file_name", 0, 1, "", 0, "", 0, "");
				foreach($arr_resize as $type => $arr){
					resize_image($bg_filepath, $file_name, $arr["width"], $arr["height"], $arr["quality"], $type);
				}
				delete_file($bg_table,$id_field,$record_id[$i],"use_avatar",$bg_filepath);
			}

			//Check Error!
			$errorMsg .= $upload_pic->show_warning_error();			
			$errorMsg .= $myform->checkdata($id_field, $record_id[$i]);
			//Check loi cua tat ca cac ban ghi duoc sua
			$errorMsgAll	.=	$errorMsg;
			
			if($errorMsg == ""){
				$db_ex = new db_execute($myform->generate_update_SQL($id_field, $record_id[$i]));
				unset($db_ex);
			}else{
				echo $record_id[$i] . " : " . $errorMsg . "</br>";
			}
			unset($myform);
		}
	}
	echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
	echo "Đang cập nhật dữ liệu !";
	if($errorMsgAll == ""){
		redirect($returnurl);
	}
}
?>