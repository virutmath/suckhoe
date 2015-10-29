<?php
	include("inc_security.php");
	$returnurl 		= base64_decode(getValue("returnurl","str","GET",base64_encode("listing.html")));
	$record_id		= getValue("record_id","str","POST","0");
	$arr_record 	= explode(",", $record_id);
	$total 			= 0;
	foreach($arr_record as $i=>$record_id){
		$record_id = intval($record_id);
		//Delete data with ID
		$db_del = new db_execute("DELETE FROM ". $bg_table ." WHERE " . $id_field . " IN(" . $record_id . ")");
		if($db_del->total>0){
			$total +=  $db_del->total;
            //Xóa ảnh
            delete_file($bg_table,$id_field,$record_id,'use_avatar',$bg_filepath);
		}
		unset($db_del);
	}
	echo "Có " . $total . " bản ghi đã được xóa !";
?>