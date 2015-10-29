<?require_once("email_template.php");function send_mailer($a,$b,$c,$d="",$e="",$f="",$g=""){if(file_exists("../classes/mailer/class.phpmailer.php")){require_once("../classes/mailer/class.phpmailer.php");}$c=eregi_replace("[\]",'',$c);$i=translate("Thông báo t&#7915; hott.vn");$j=new PHPMailer();$k=array(1=>"mta8.mailmytour.com",2=>"mta6.mailmytour.com");$m=array_rand($k);$j->IsSMTP();$j->SMTPAuth=true;$j->Host=$k[$m];$j->Port=25;$j->From="noreply@mailmytour.com";$j->FromName=$i;$j->Username="noreply@mailmytour.com";$j->Password="0L6r2XJcyK9JxjQbnRLo";$j->CharSet="UTF-8";$j->ContentType="text/html";$j->Subject=$b;$j->AddAddress($a);$j->Body=$c;if($d!=""){$j->AddAttachment($d);}$j->IsHTML(true);$j->SMTPDebug=1;$n=$j->Send();$o=array();$o["Host"]=$j->Host;$o["From"]=$j->FromName;$o["Email"]=$a;$o["subject"]=$j->Subject;$o["Error"]=$j->ErrorInfo;saveLog1("all_email",json_encode($o));if(!$n){if(strlen($e)<=3){}saveLog1("error_email","Loi: ".$j->ErrorInfo);return false;}else{return true;}}function create_voucher_file($p,$q,$c,$b="Mytour Voucher",$r="Mytour.vn",$t="Mytour.vn",$u="mytour, mytour.vn, voucher"){global $v;$z=new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);$z->SetCreator(PDF_CREATOR);$z->SetAuthor($r);$z->SetTitle($b);$z->SetSubject($t);$z->SetKeywords($u);$z->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);$z->SetMargins(5,10,5);$z->SetHeaderMargin(-10);$z->SetFooterMargin(10);$z->SetAutoPageBreak(TRUE,10);$z->setImageScale(PDF_IMAGE_SCALE_RATIO);$z->setLanguageArray($v);$z->setFontSubsetting(true);$z->addFont('DejaVuSerif','','dejavuserif.php');$z->SetFont('DejaVuSerif','',9,'','true');$z->AddPage();$z->writeHTMLCell($aa=0,$bb=0,$cc='',$dd='',$c,$ee=0,$ff=1,$gg=0,$hh=true,$ii='',$jj=true);$z->Output($p.$q.'.pdf','F');}function booking_mail_customer_order_info($kk){global $ll;global $mm;global $nn;global $oo;global $pp;$c="";$qq=new db_query("SELECT booking_hotel.*, hot_name, hot_address
																 FROM booking_hotel
																 STRAIGHT_JOIN ".$oo." ON(boo_hotel = hot_hotel_id)
																 WHERE boo_id = ".intval($kk));if($rr=mysqli_fetch_assoc($qq->result)){$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr["boo_bill_code"].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr["boo_customer_name"].'</b></p>';$c.='<p style="margin-bottom: 10px;">'.translate("C&#7843;m &#417;n quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t phòng c&#7911;a Mytour. Sau &#273;ây là thông tin &#273;&#7863;t phòng c&#7911;a quý khách.").'</p>';$c.='<p style="margin-bottom: 20px; font-weight: bold;"><span style="color: #ff0000;">'.translate("Quý khách l&#432;u ý").':</span> '.translate("Vi&#7879;c thanh toán ch&#7881; &#273;&#432;&#7907;c ti&#7871;n hành sau khi quý khách nh&#7853;n &#273;&#432;&#7907;c xác nh&#7853;n phòng tr&#7889;ng t&#7915; Mytour. Xác nh&#7853;n &#273;&#7863;t phòng thành công s&#7869; &#273;&#432;&#7907;c g&#7917;i &#273;&#7871;n Quý khách khi Mytour nh&#7853;n &#273;&#432;&#7907;c thanh toán &#273;&#7847;y &#273;&#7911; cho &#273;&#417;n phòng.").'</p>';$ss=new db_query("SELECT adm_name, adm_email, adm_phone
																		FROM admin_user
																		WHERE adm_id = ".$rr['boo_admin_divide_allow']);if($tt=mysqli_fetch_assoc($ss->result)){$c.='<p style="margin-bottom: 20px;"><b>Nhân viên t&#432; v&#7845;n &#273;&#417;n phòng c&#7911;a Quý khách là:</b> '.$tt['adm_name'].'. <b>Email:</b> '.$tt['adm_email'].'. <b>&#272;T:</b> '.$tt['adm_phone'].'</p>';}unset($ss);$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t phòng").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr["boo_customer_name"].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["boo_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr["boo_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr["boo_customer_email"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t phòng:").'</td>';$c.='<td>'.$rr["boo_bill_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Khách s&#7841;n").':</td>';$c.='<td><a style="font-weight: bold;" href="'.$pp.url_hotel_detail(array('hot_id'=>$rr['boo_hotel'],'hot_name'=>$rr['hot_name'])).'">'.$rr["hot_name"].'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["hot_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin phòng").':</td>';$c.='<td>';$uu=json_decode($rr['boo_book_info'],true);if(count($uu)>0){$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';foreach($uu as $ww=>$xx){if(isset($xx['numroom'])&&isset($xx['adults'])&&isset($xx['children'])&&isset($xx['money'])&&isset($xx['extra'])){$yy=new db_query("SELECT rom_id, rom_name
																						 FROM rooms
																						 WHERE rom_id = ".intval($ww));if($tt=mysqli_fetch_assoc($yy->result)){$c.='<tr>
																 <td rowspan="4" width="120" align="center"'.$vv.'><b>'.$tt['rom_name'].'</b></td>
																 <td'.$vv.'>'.translate("S&#7889; l&#432;&#7907;ng").'</td>
																 <td'.$vv.'><b>'.$xx['numroom'].'</b></td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("S&#7889; ng&#432;&#7901;i").'</td>
																 <td'.$vv.'><b>'.$xx['adults'].'</b> '.translate("ng&#432;&#7901;i l&#7899;n").', <b>'.$xx['children'].'</b> '.translate("tr&#7867; em").'</td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
																 <td'.$vv.'><b style="color: #FF0000;">'.format_number($xx['money']).' VN&#272;</b></td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("Thêm gi&#432;&#7901;ng").'</td>
																 <td'.$vv.'>
																		<p style="margin: 0;">'.($xx['extra']==0?'<b>'.translate("Không").'</b>':'<b>'.$xx['extra'].'</b> '.translate("gi&#432;&#7901;ng").'').'</p>
																 </td>
															</tr>';}unset($yy);}}$c.='</table>';}$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Ngày nh&#7853;n phòng").':</td>';$c.='<td>'.date($mm,$rr["boo_time_start"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Ngày tr&#7843; phòng").':</td>';$c.='<td>'.date($mm,$rr["boo_time_finish"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("T&#7893;ng s&#7889; ti&#7873;n").':</td>';$c.='<td><b style="color: #FF0000;">'.format_number($rr['boo_total_money']).' VN&#272;</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr['boo_payment_method']])?$nn[$rr['boo_payment_method']]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr["boo_customer_comment"].'</td>';$c.='</tr>';$c.='<tr valign="top">';$c.='<td>'.translate("Ghi chú").':</td>';$c.='<td>'.$rr["boo_service_info"].'</td>';$c.='</tr>';$c.='</table>';$c.='<p style="margin-bottom: 10px;">'.translate("Quý khách vui lòng ki&#7875;m tra l&#7841;i các thông tin trên. N&#7871;u có sai sót, vui lòng liên h&#7879; ngay v&#7899;i Mytour &#273;&#7875; c&#7853;p nh&#7853;t l&#7841;i thông tin cho &#273;&#417;n &#273;&#7863;t phòng c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-top: 2px;">'.translate("Chân thành c&#7843;m &#417;n").'!</p>';$c.=$ll;$c.="</div>";if(send_mailer($rr['boo_customer_email'],translate("Thông tin &#273;&#7863;t phòng trên website Mytour"),$c)){return true;}}unset($qq);return false;}function booking_mail_customer_success_info($kk){global $ll;global $nn;global $oo;global $pp;global $zz;$mm="d/m/Y";$c="";$aaa=150;$bbb="booking@mytour.vn";$qq=new db_query("SELECT booking_hotel.*, hot_name, hot_address, adm_email, adm_name, adm_phone
																 FROM booking_hotel
																 STRAIGHT_JOIN ".$oo." ON(boo_hotel = hot_hotel_id)
																 STRAIGHT_JOIN admin_user ON(boo_admin_check = adm_id)
																 WHERE boo_id = ".intval($kk));if($rr=mysqli_fetch_assoc($qq->result)){if($rr['boo_customer_email']!=""){if($rr['adm_email']!="")$bbb=$rr['adm_email'];$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr["boo_bill_code"].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr["boo_customer_name"].'</b></p>';$c.='<p style="margin-bottom: 5px;">'.translate("C&#7843;m &#417;n Quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t phòng c&#7911;a Mytour").'.</p>';$c.='<p style="margin-bottom: 20px;">'.translate("Chúng tôi g&#7917;i Email xác nh&#7853;n &#273;&#417;n &#273;&#7863;t phòng c&#7911;a Quý khách &#273;ã &#273;&#432;&#7907;c x&#7917; lý thành công.").'</p>';$c.='<p style="margin-bottom: 20px;"><b>Nhân viên t&#432; v&#7845;n &#273;&#417;n phòng c&#7911;a Quý khách là:</b> '.$rr['adm_name'].'. <b>Email:</b> '.$rr['adm_email'].'. <b>&#272;T:</b> '.$rr['adm_phone'].'</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t phòng").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr["boo_customer_name"].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["boo_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr["boo_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr["boo_customer_email"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t phòng:").'</td>';$c.='<td>'.$rr["boo_bill_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Khách s&#7841;n").':</td>';$c.='<td><a style="font-weight: bold;" href="'.$zz.url_hotel_detail(array('hot_id'=>$rr['boo_hotel'],'hot_name'=>$rr['hot_name'])).'">'.$rr["hot_name"].'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["hot_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin phòng").':</td>';$c.='<td>';$uu=json_decode($rr['boo_book_info'],true);if(count($uu)>0){$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';foreach($uu as $ww=>$xx){if(isset($xx['numroom'])&&isset($xx['adults'])&&isset($xx['children'])&&isset($xx['money'])&&isset($xx['extra'])){$yy=new db_query("SELECT rom_id, rom_name
																								FROM rooms
																								WHERE rom_id = ".intval($ww));if($tt=mysqli_fetch_assoc($yy->result)){$c.='<tr>
																		<td rowspan="4" width="120" align="center"'.$vv.'><b>'.$tt['rom_name'].'</b></td>
																		<td'.$vv.'>'.translate("S&#7889; l&#432;&#7907;ng").'</td>
																		<td'.$vv.'><b>'.$xx['numroom'].'</b></td>
																 </tr>
																 <tr>
																		<td'.$vv.'>'.translate("S&#7889; ng&#432;&#7901;i").'</td>
																		<td'.$vv.'><b>'.$xx['adults'].'</b> '.translate("ng&#432;&#7901;i l&#7899;n").', <b>'.$xx['children'].'</b> '.translate("tr&#7867; em").'</td>
																 </tr>
																 <tr>
																		<td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
																		<td'.$vv.'><b style="color: #FF0000;">'.format_number($xx['money']).' VN&#272;</b></td>
																 </tr>
																 <tr>
																		<td'.$vv.'>'.translate("Thêm gi&#432;&#7901;ng").'</td>
																		<td'.$vv.'>
																			 <p style="margin: 0;">'.($xx['extra']==0?'<b>'.translate("Không").'</b>':'<b>'.$xx['extra'].'</b> '.translate("gi&#432;&#7901;ng").'').'</p>
																		</td>
																 </tr>';}unset($yy);}}$c.='</table>';}$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Ngày nh&#7853;n phòng").':</td>';$c.='<td>'.date($mm,$rr["boo_time_start"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Ngày tr&#7843; phòng").':</td>';$c.='<td>'.date($mm,$rr["boo_time_finish"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("T&#7893;ng s&#7889; ti&#7873;n").':</td>';$c.='<td><b style="color: #FF0000;">'.format_number($rr['boo_total_money']).' VN&#272;</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr['boo_payment_method']])?$nn[$rr['boo_payment_method']]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr["boo_customer_comment"].'</td>';$c.='</tr>';$c.='<tr valign="top">';$c.='<td>'.translate("Ghi chú").':</td>';$c.='<td>'.$rr["boo_service_info"].'<p style="margin: 0;">'.$rr["boo_voucher_note"].'</p></td>';$c.='</tr>';$c.='<tr>';$c.='<td width="'.$aaa.'" valign="top">'.translate("Chính sách h&#7911;y").':</td>';$c.='<td>'.$rr["boo_voucher_cancel"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td width="'.$aaa.'" valign="top">'.translate("Link down voucher").':</td>';$c.='<td><p style="margin: 0px;"><a href="'.($zz.'/vouchers/hotel/'.$rr["boo_bill_code"].'.pdf').'">Download</a></p><p style="margin: 0px;">('.translate("Quý khách vui lòng mang theo Voucher này khi &#273;&#7871;n khách s&#7841;n").')</td>';$c.='</tr>';$c.='</table>';$c.='<p><b>'.translate("Quý khách mu&#7889;n xu&#7845;t hóa &#273;&#417;n ti&#7873;n phòng vui lòng g&#7917;i thông tin cho Mytour").' <a href="mailto:'.$bbb.'">'.translate("t&#7841;i &#273;ây").'</a></b></p>';$c.='<p style="margin-bottom: 2px;">'.translate("Chúc Quý khách có nh&#7919;ng ngày ngh&#7881; th&#7853;t vui v&#7867;").'.</p>';$c.=$ll;$c.="</div>";save_log_info("booking/bk_hotel_sent_customer",$rr['boo_customer_email']);if(send_mailer($rr['boo_customer_email'],translate("Xác nh&#7853;n &#273;&#7863;t phòng thành công t&#7915; Mytour"),$c)){save_log_info("booking/bk_hotel_sent_customer_success",$rr['boo_customer_email']);return true;}else{save_log_info("booking/bk_hotel_sent_customer_error",$rr['boo_customer_email']);}}}else{save_log_info("booking/bk_hotel_sent_customer_no_result","Booking ID:".$kk);}unset($yy);return false;}function booking_mail_hotel_success_info($kk){global $ll;global $nn;global $zz;global $ccc;global $ddd;global $eee;global $oo;$bbb="booking@mytour.vn";$c='';$yy=new db_query("SELECT booking_hotel.*, hot_id, hot_name, hot_email, hot_address, adm_email, adm_name, adm_phone
																 FROM booking_hotel
																 STRAIGHT_JOIN hotels ON(boo_hotel = hot_id)
																 STRAIGHT_JOIN ".$oo." ON(boo_hotel = hot_hotel_id)
																 STRAIGHT_JOIN admin_user ON(boo_admin_check = adm_id)
																 WHERE boo_id = ".intval($kk));if($rr=mysqli_fetch_assoc($yy->result)){if($rr['hot_email']!=""){if($rr['adm_email']!="")$bbb=$rr['adm_email'];$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444">';$c.="<p align='right' style='border-bottom: 1px solid #C8D6FF; font-weight: bold;'>".$rr["boo_bill_code"]."</p>";$c.="<p>Xin chào, <b>".$rr["hot_name"]."</b></p>";$c.='<p style="margin-bottom: 20px;">Quý khách s&#7841;n có m&#7897;t &#273;&#417;n &#273;&#7863;t phòng m&#7899;i trên h&#7879; th&#7889;ng &#273;&#7863;t phòng c&#7911;a Mytour.</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">Thông tin &#273;&#7863;t phòng</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>H&#7885; tên ng&#432;&#7901;i &#273;&#7863;t:</td>';$c.='<td>'.$rr["boo_customer_name"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>&#272;&#7883;a ch&#7881;:</td>';$c.='<td>'.$rr["boo_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>S&#7889; &#273;i&#7879;n tho&#7841;i:</td>';$c.='<td>'.$rr["boo_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Mã &#273;&#417;n &#273;&#7863;t phòng:</td>';$c.='<td>'.$rr["boo_bill_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Thông tin phòng:</td>';$c.='<td>';$uu=json_decode($rr['boo_book_info'],true);if(count($uu)>0){$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';foreach($uu as $ww=>$xx){$fff=new db_query("SELECT rom_id, rom_name
																					FROM rooms
																					WHERE rom_id = ".intval($ww));if($tt=mysqli_fetch_assoc($fff->result)){$c.='<tr>
																 <td rowspan="3" width="120" align="center"'.$vv.'><b>'.$tt['rom_name'].'</b></td>
																 <td'.$vv.'>S&#7889; l&#432;&#7907;ng</td>
																 <td'.$vv.'><b>'.$xx['numroom'].'</b></td>
															</tr>
															<tr>
																 <td'.$vv.'>S&#7889; ng&#432;&#7901;i</td>
																 <td'.$vv.'><b>'.$xx['adults'].'</b> ng&#432;&#7901;i l&#7899;n, <b>'.$xx['children'].'</b> tr&#7867; em</td>
															</tr>
															<tr>
																 <td'.$vv.'>Thêm gi&#432;&#7901;ng</td>
																 <td'.$vv.'>
																		<p style="margin: 0;">'.($xx['extra']==0?'<b>Không</b>':'<b>'.$xx['extra'].'</b> gi&#432;&#7901;ng').'</p>
																 </td>
															</tr>';}unset($fff);}$c.='</table>';}$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Ngày nh&#7853;n phòng:</td>';$c.='<td>'.date("d/m/Y",$rr["boo_time_start"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Ngày tr&#7843; phòng:</td>';$c.='<td>'.date("d/m/Y",$rr["boo_time_finish"]).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Ghi chú:</td>';$c.='<td>'.$rr["boo_service_info"].'<p style="margin: 0;">'.$rr["boo_voucher_note"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Thanh toán:</td>';$c.='<td>'.$nn[$rr["boo_payment_method"]].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>Mytour thanh toán cho khách s&#7841;n:</td>';$c.='<td><b style="color: #FF0000;">'.format_number($rr["boo_hotel_amount"]).' VN&#272;</b></td>';$c.='</tr>';$c.='</table>';$c.='<p><b>T&#432; v&#7845;n viên:</b> '.$rr['adm_name'].'. <b>Email:</b> '.$rr['adm_email'].'. <b>&#272;T:</b> '.$rr['adm_phone'].'</p>';$c.='<p><b>Quý khách s&#7841;n vui lòng xu&#7845;t hóa &#273;&#417;n và g&#7917;i v&#7873; &#273;&#7883;a ch&#7881; sau:</b></p>';$c.='<p style="margin: 2px 0px;"><b>CÔNG TY TNHH MYTOUR VI&#7878;T NAM</b></p>';$c.='<p style="margin: 2px 0px;"><b>Tr&#7909; s&#7903;:</b> T&#7847;ng 4, TTTM Vân H&#7891;, 51 Lê &#272;&#7841;i Hành, p. Lê &#272;&#7841;i Hành, q. Hai Bà Tr&#432;ng, Hà N&#7897;i</p>';$c.='<p style="margin: 2px 0px;"><b>MS thu&#7871;:</b> 0105983269</p>';$c.='<p style="margin-top: 20px;">-----------------------------------------------------------------------</p>';$c.='<p style="font-weight: bold; margin-bottom: 0px;">'.$ddd.'</p>';$c.='<p style="margin: 2px 0px;"><b>Hotline:</b> '.$eee.'</p>';$c.='<p style="margin: 2px 0px;"><b>Email:</b> '.$ccc.'</p>';$c.='</div>';save_log_info("booking/bk_hotel_sent_hotel",$rr['hot_email']);if(send_mailer($rr['hot_email'],"Thông tin &#273;&#7863;t phòng trên website Mytour",$c,"",$bbb,"Xác nh&#7853;n &#273;&#417;n phòng")){save_log_info("booking/bk_hotel_sent_hotel_success",$rr['hot_email']);return true;}else{save_log_info("booking/bk_hotel_sent_hotel_error",$rr['hot_email']);}}}else{save_log_info("booking/bk_hotel_sent_hotel_no_result","Booking ID:".$kk);}unset($yy);return false;}function invite_rate_mailing($ggg,$rr){global $ll;$c="";if($rr!=array()){$c.="<div style='border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444'>";$c.="<p>Thân g&#7917;i <b>".$rr["orderName"].",</b></p>";$c.='<p>Hi v&#7885;ng Quý khách &#273;ã có kho&#7843;ng th&#7901;i gian vui v&#7867; và tho&#7843;i mái t&#7841;i khách s&#7841;n '.$rr['hotelName'].'. Quý khách vui lòng dành ít phút &#273;&#7875; chia s&#7867; kinh nghi&#7879;m, nh&#7853;n xét c&#7911;a mình v&#7873; khách s&#7841;n v&#7899;i hàng tr&#259;m nghìn thành viên trên website c&#7911;a Mytour b&#7857;ng cách click vào link d&#432;&#7899;i &#273;ây:</p>';$c.='<p><a title="&#272;&#7871;n trang vi&#7871;t &#273;ánh giá cho khách s&#7841;n" href="'.$rr['rateLink'].'" target="_blank">'.$rr['rateLink'].'</a></p>';$c.='<p>N&#7871;u Quý khách không truy c&#7853;p &#273;&#432;&#7907;c vào link trên, vui lòng sao chép và dán vào trình duy&#7879;t &#273;ang dùng.</p>';$c.='<p>Quý khách s&#7869; &#273;&#432;&#7907;c th&#432;&#7903;ng 100 &#273;i&#7875;m khi Quý khách &#273;&#259;ng nh&#7853;p và có m&#7897;t bài nh&#7853;n xét &#273;&#7847;y &#273;&#7911; v&#7873; khách s&#7841;n t&#7841;i Mytour. S&#7889; &#273;i&#7875;m th&#432;&#7903;ng s&#7869; &#273;&#432;&#7907;c quy ra ti&#7873;n th&#432;&#7903;ng &#273;&#7875; Quý khách tích l&#361;y và có c&#417; h&#7897;i &#273;&#7863;t &#273;&#432;&#7907;c phòng mi&#7877;n phí trên h&#7879; th&#7889;ng c&#7911;a Mytour</p>';$c.='<p>C&#7843;m &#417;n Quý khách r&#7845;t nhi&#7873;u và mong r&#7857;ng Mytour s&#7869; luôn là ng&#432;&#7901;i b&#7841;n &#273;&#7891;ng hành &#273;áng tin c&#7853;y c&#7911;a Quý khách trong t&#432;&#417;ng lai.</p>';$c.='<p>Chân thành c&#7843;m &#417;n.</p>';$c.=$ll;$c.="</div>";if(send_mailer($ggg,"Nh&#7853;n ngay 100 &#273;i&#7875;m th&#432;&#7903;ng t&#7915; Mytour cho bài vi&#7871;t &#273;ánh giá khách s&#7841;n ".$rr['hotelName'],$c)){return true;}}return false;}function confirm_transaction_mailing_customer($hhh){global $ll;$iii="&#273;&#7863;t phòng";if($hhh['type']=="tour")$iii="&#273;&#7863;t tour";if($hhh['type']=="deal")$iii="&#273;&#7863;t deal";$c="";$c.="<div style='border:3px double #94c7ff; padding: 10px; line-height: 19px; color: #444'>";$c.=translate("Xin chào").", <b>".$hhh["customName"]."</b><br />";$c.=translate("B&#7841;n &#273;ã thanh toán thành công &#273;&#417;n"." ".$iii." v&#7899;i mã &#273;&#417;n là").": <b>".$hhh["billCode"]."</b><br />";$c.=translate("T&#7893;ng s&#7889; ti&#7873;n &#273;ã thanh toán").": <font color='red'>".format_number($hhh["amountPayment"])."</font>"." VN&#272;<br /><br />";$c.=translate("C&#7843;m &#417;n b&#7841;n &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; c&#7911;a chúng tôi. Chúc b&#7841;n s&#7869; có nh&#7919;ng ngày ngh&#7881; vui v&#7867;!")."<br /><br />";$c.=$ll;$c.="</div>";if(send_mailer($hhh["customEmail"],translate("Thông tin thanh toán d&#7883;ch v&#7909; ".$iii." trên website Mytour"),$c)){return true;}else{return false;}}function confirm_transaction_mailing_merchant($hhh){global $ll;$iii='&#273;&#7863;t phòng';if($hhh['type']=="tour")$iii='&#273;&#7863;t tour';if($hhh['type']=="deal")$iii='&#273;&#7863;t deal';$c='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444">';$c.='<p>Xin chào,</p>';$c.='<p>B&#7841;n v&#7915;a có m&#7897;t giao d&#7883;ch thanh toán thành công cho &#273;&#417;n '.$iii.' có mã  <b>'.$hhh["billCode"].'</b> t&#7915; khách hàng <b>'.$hhh["customName"].'</b></p>';$c.='<p>S&#7889; ti&#7873;n giao d&#7883;ch: <font color="red">'.format_number($hhh["amountPayment"]).' VN&#272;</font></p>';$c.=$ll;$c.='</div>';if(send_mailer($hhh["merchantEmail"],"Thông tin thanh toán d&#7883;ch v&#7909; ".$iii." trên website Mytour",$c)){return true;}else{return false;}}function mail_cancel_booking($kk){global $ll;$bbb="booking@mytour.vn";global $oo;global $pp;global $zz;$mm="d/m/Y";$yy=new db_query("SELECT booking_hotel.*, hot_name, hot_email, hot_address, hot_phone
																 FROM booking_hotel
																 STRAIGHT_JOIN hotels ON(boo_hotel = hot_id)
																 STRAIGHT_JOIN ".$oo." ON(boo_hotel = hot_hotel_id)
																 WHERE boo_id = ".$kk);if($rr=mysqli_fetch_assoc($yy->result)){$jjj='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$jjj.='<tr>';$jjj.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t phòng").'</h3></td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("H&#7885; tên").':</td>';$jjj.='<td><b>'.$rr["boo_customer_name"].'</b></td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$jjj.='<td>'.$rr["boo_customer_address"].'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$jjj.='<td>'.$rr["boo_customer_phone"].'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Email").':</td>';$jjj.='<td>'.$rr["boo_customer_email"].'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Khách s&#7841;n").':</td>';$jjj.='<td><a style="font-weight: bold;" href="'.$zz.url_hotel_detail(array('hot_id'=>$rr['boo_hotel'],'hot_name'=>$rr['hot_name'])).'">'.$rr["hot_name"].'</a></td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$jjj.='<td>'.$rr["hot_address"].'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Thông tin phòng").':</td>';$jjj.='<td>';$uu=json_decode($rr['boo_book_info'],true);if(count($uu)>0){$vv=' style="border-color: #AAAAAA;"';$jjj.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';foreach($uu as $ww=>$xx){if(isset($xx['numroom'])&&isset($xx['adults'])&&isset($xx['children'])&&isset($xx['money'])&&isset($xx['extra'])){$yy=new db_query("SELECT rom_id, rom_name
																						 FROM rooms
																						 WHERE rom_id = ".intval($ww));if($tt=mysqli_fetch_assoc($yy->result)){$jjj.='<tr>
																 <td rowspan="4" width="120" align="center"'.$vv.'><b>'.$tt['rom_name'].'</b></td>
																 <td'.$vv.'>'.translate("S&#7889; l&#432;&#7907;ng").'</td>
																 <td'.$vv.'><b>'.$xx['numroom'].'</b></td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("S&#7889; ng&#432;&#7901;i").'</td>
																 <td'.$vv.'><b>'.$xx['adults'].'</b> '.translate("ng&#432;&#7901;i l&#7899;n").', <b>'.$xx['children'].'</b> '.translate("tr&#7867; em").'</td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
																 <td'.$vv.'><b style="color: #FF0000;">'.format_number($xx['money']).' VN&#272;</b></td>
															</tr>
															<tr>
																 <td'.$vv.'>'.translate("Thêm gi&#432;&#7901;ng").'</td>
																 <td'.$vv.'>
																		<p style="margin: 0;">'.($xx['extra']==0?'<b>'.translate("Không").'</b>':'<b>'.$xx['extra'].'</b> '.translate("gi&#432;&#7901;ng").'').'</p>
																 </td>
															</tr>';}unset($yy);}}$jjj.='</table>';}$jjj.='</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Ngày nh&#7853;n phòng").':</td>';$jjj.='<td>'.date($mm,$rr["boo_time_start"]).'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Ngày tr&#7843; phòng").':</td>';$jjj.='<td>'.date($mm,$rr["boo_time_finish"]).'</td>';$jjj.='</tr>';$jjj.='<tr>';$jjj.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$jjj.='<td>'.$rr["boo_customer_comment"].'</td>';$jjj.='</tr>';$jjj.='</table>';$c='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444">
												<p>Thân g&#7917;i Quý khách '.$rr['boo_customer_name'].',</p>
												<p>C&#7843;m &#417;n Quý khách &#273;ã &#273;&#7863;t phòng trên website Mytour</p>';$kkk='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444">
																<p>Thân g&#7917;i Quý khách s&#7841;n '.$rr['hot_name'].',</p>';if($rr['boo_view']!=3){$c.='<p>
														Chúng tôi r&#7845;t ti&#7871;c ph&#7843;i thông báo r&#7857;ng th&#7901;i gian t&#7915; '.date("d/m/Y",$rr['boo_time_start']).' &#273;&#7871;n '.date("d/m/Y",$rr['boo_time_finish']).'
														không còn phòng tr&#7889;ng nào t&#7841;i khách s&#7841;n '.$rr['hot_name'].'.
												</p>';}else{$c.='<p>
														Mytour xin thông báo &#273;&#417;n phòng mã '.$rr['boo_bill_code'].' có các thông tin &#273;&#7863;t phòng nh&#432; d&#432;&#7899;i &#273;ây &#273;ã b&#7883; h&#7911;y.
												Voucher Mytour &#273;ã g&#7917;i cho Khách hàng và Khách s&#7841;n hi&#7879;n không còn giá tr&#7883; s&#7917; d&#7909;ng.
												</p>';$kkk.='<p>
																Mytour xin thông báo khách hàng &#273;ã h&#7911;y &#273;&#417;n phòng có mã '.$rr['boo_bill_code'].' v&#7899;i các thông tin &#273;&#7863;t phòng chi ti&#7871;t d&#432;&#7899;i &#273;ây.
													 Voucher Mytour &#273;ã g&#7917;i cho Khách hàng và Khách s&#7841;n hi&#7879;n không còn giá tr&#7883; s&#7917; d&#7909;ng.
														</p>';$c.=$jjj;$kkk.=$jjj;}$c.='<p>
														Hi v&#7885;ng r&#7857;ng Mytour có th&#7875; h&#7895; tr&#7907; Quý khách vào m&#7897;t d&#7883;p khác trong t&#432;&#417;ng lai.
												</p>
										 <p>Chân thành c&#7843;m &#417;n Quý khách!</p>
												'.$ll.'
										</div>';$kkk.=$ll.'
														</div>';if($rr['boo_view']!=3){if(send_mailer($rr['boo_customer_email'],"Thông báo h&#7871;t phòng t&#7841;i ".$rr['hot_name']." t&#7915; Mytour",$c,$bbb,"&#272;&#7863;t phòng Mytour")){return true;}}else{$lll=0;if(send_mailer($rr['boo_customer_email'],"Thông báo h&#7911;y &#273;&#417;n phòng t&#7841;i ".$rr['hot_name']." t&#7915; Mytour",$c,$bbb,"&#272;&#7863;t phòng Mytour")){$lll++;}if($rr['hot_email']!=""&&send_mailer($rr['hot_email'],"Thông báo h&#7911;y &#273;&#417;n phòng t&#7915; Mytour",$kkk,$bbb,"&#272;&#7863;t phòng Mytour")){$lll++;}if($lll>0)return true;}}return false;}function generate_voucher($mmm,$nnn="hotel",$ooo=1){global $nn;global $ccc;global $eee;global $ppp;global $ddd;global $qqq;global $oo;$rrr="";if($nnn=="deal"){$rrr="STRAIGHT_JOIN promotionals ON (boo_promotion_id = pro_id)";}$sss='';$ttt=' style="height: 5px; line-height: 5px;"';$uuu=' style="height: 7px; line-height: 7px;"';$vvv=' style="height: 1px; line-height: 1px;"';$yy=new db_query("SELECT *
																						FROM    booking_hotel
																						STRAIGHT_JOIN hotels ON(boo_hotel = hot_id)
																						".$rrr."
																 STRAIGHT_JOIN ".$oo." ON(boo_hotel = hot_hotel_id)
																 STRAIGHT_JOIN admin_user ON(boo_admin_check = adm_id)
																						WHERE boo_id = ".intval($mmm));if($tt=mysqli_fetch_assoc($yy->result)){$www='';$xxx='';if($tt['boo_voucher_note']!=""){$xxx='<p style="line-height: 5px;">'.$tt['boo_voucher_note'].'</p>';}$www.='<tr>
												<td colspan="2" width="700">
													 <p style="height: 0px; line-height: 0px;"></p>
													 <p style="height: 1px; line-height: 1px;"><b>Ghi chú:</b></p>
													 '.$xxx.'
													 <p style="line-height: 2px;">'.translate("Gi&#7901; nh&#7853;n phòng :").' '.($tt['hot_time_checkin']!=""?$tt['hot_time_checkin']:"14:00").'</p>
													 <p style="line-height: 2px;">'.translate("Gi&#7901; tr&#7843; phòng :").' '.($tt['hot_time_checkout']!=""?$tt['hot_time_checkout']:"11:30").'</p>
												</td>
										 </tr>';$yyy='<tr><td>&bull; Giá &#273;ã bao g&#7891;m VAT và phí d&#7883;ch v&#7909;.</td></tr>';foreach($qqq as $zzz=>$aaaa){$bbbb="col".$aaaa["col"];if(isset($tt[$bbbb])){if((intval($tt[$bbbb])&intval($aaaa['value']))!=0){$yyy.='<tr><td>&bull; '.$aaaa['title'].'.</td></tr>';}}}if($nnn=="deal"){$yyy.='<tr><td style="color: red">&bull;&#272;&#7863;t phòng khuy&#7871;n m&#7841;i : "'.$tt['pro_title'].'"</td></tr>';$yyy.='<tr><td>&bull;Áp d&#7909;ng &#273;&#7871;n : '.date("d/m/Y",$tt['pro_dateend']).'</td></tr>';}$cccc='<tr>
																		<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;Mã &#273;&#417;n</p></td>
																		<td><p'.$uuu.'>&nbsp;&nbsp;<b>'.$tt['boo_bill_code'].'</b></p></td>
																 </tr>';$dddd='';if($ooo==1){$dddd='<img style="height: 100px; line-height: 100px" src="/themes/images/mytour.png" />';}$uu=json_decode($tt['boo_book_info'],true);if(count($uu)>0){foreach($uu as $ww=>$xx){$fff=new db_query("SELECT rom_id, rom_name
																			 FROM rooms
																			 WHERE rom_id = ".intval($ww));if($eeee=mysqli_fetch_assoc($fff->result)){$cccc.='<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;Tên phòng</p></td>
																						<td>
																			 <table width="100%" border="0" cellpadding="1" cellspacing="1">
																				 <tr><td><p style="height: 5px; line-height: 5px;"><b>'.$eeee['rom_name'].'</b></p></td></tr>
																			 </table>
																		</td>
																				</tr>
																				<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;S&#7889; l&#432;&#7907;ng</p></td>
																						<td><p'.$uuu.'>&nbsp;&nbsp;<b>'.$xx['numroom'].'</b> phòng'.($xx['extra']>0?' (Thêm '.$xx['extra'].' gi&#432;&#7901;ng)':'').'</p></td>
																				</tr>
																				<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;S&#7889; ng&#432;&#7901;i</p></td>
																						<td><p'.$uuu.'>&nbsp;&nbsp;Ng&#432;&#7901;i l&#7899;n: <b>'.$xx['adults'].'</b>, Tr&#7867; em: <b>'.$xx['children'].'</b></p></td>
																				</tr>';}unset($fff);}}$cccc.='<tr>
																<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;<b>Ghi chú</b></p></td>
													 <td>
															<table width="100%" border="0" cellpadding="1" cellspacing="1">
																'.$yyy.'
															</table>
													 </td>
												</tr>';$sss='<div style="border-bottom: 3px solid #EBF5FF;">
						<table width="100%" border="0" style="border-collapse: collapse;">
								<tr>
										<td width="25%"><img border="0" src="/themes/images/logo_new.png" /></td>
										<td width="25%">'.$dddd.'</td>
										<td width="50%" align="right">
												<h1 style="color: #0099FF; font-size: 120px;">Hotel <span style="color: #C4BB95;">Voucher</span></h1>
										</td>
								</tr>
								<tr>
										<td colspan="3" align="right" style="font-style: inherit;">Hà N&#7897;i, '.date("d/m/Y").'</td>
								</tr>
						</table>
				</div>
				<div>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
								<tr>
										<td width="430">
												<table border="0" cellpadding="0" cellspacing="0" bordercolor="#C1C1C1" width="100%" style="border-collapse: collapse; margin: 0px;">

														<tr>
																<td width="25%"><p'.$ttt.'>Khách hàng:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['boo_customer_name'].'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>&#272;&#7883;a ch&#7881;:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['boo_customer_address'].'</b></p></td>
														</tr>
										 <tr><td colspan="2">&nbsp;</td></tr>
														<tr>
																<td width="25%"><p'.$ttt.'>Khách s&#7841;n:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['hot_name'].'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>&#272;&#7883;a ch&#7881;:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['hot_address'].'</b></p></td>
														</tr>
										 <tr>
																<td width="25%"><p'.$ttt.'>&#272;i&#7879;n tho&#7841;i:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['hot_phone'].'</b></p></td>
														</tr>
										 <tr><td colspan="2">&nbsp;</td></tr>
														<tr>
																<td width="25%"><p'.$ttt.'>Nh&#7853;n phòng:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.date("d/m/Y",$tt['boo_time_start']).'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>Tr&#7843; phòng:</p></td>
																<td width="60%"><p'.$ttt.'><b>'.date("d/m/Y",$tt['boo_time_finish']).'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>S&#7889; ti&#7873;n:</p></td>
																<td width="60%"><p'.$ttt.'><b style="color: #FF0000;">'.format_number($tt['boo_total_money']).' VN&#272;</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>Thanh toán:</p></td>
																<td width="60%">
																		<p'.$ttt.'>'.$nn[$tt['boo_payment_method']].'</p>
																</td>
														</tr>
												</table>
										</td>
										<td width="350">
												<table border="1" style="border-collapse: collapse; background-color: #F6F6F6;" cellpadding="0" cellspacing="0" width="100%">
										 '.$cccc.'
									</table>
										</td>
								</tr>
						'.$www.'
						<tr>
							 <td colspan="2" width="700">
									<p style="height: 1px; line-height: 1px;"></p>
									<p style="height: 1px; line-height: 1px;"><b>Chính sách h&#7911;y phòng:</b></p>
									<p style="height: 5px; line-height: 5px;">'.removeHTML($tt['boo_voucher_cancel']).'</p>
							 </td>
						</tr>
						</table>
				</div>

				<p style="height: 1px; line-height: 1px;"><b>&#272;&#432;&#7907;c &#273;&#7863;t b&#7903;i:</b></p>
				<table width="100%" border="0" cellpadding="2" cellspacing="2" style="border-collapse: collapse; background-color: #FFF; border: 1px solid #000000;">
						<tr>
								<td width="700">
										<table border="0" cellpadding="2" cellspacing="3">
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>CÔNG TY TNHH MYTOUR VI&#7878;T NAM</b></p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Tr&#7909; s&#7903; :</b> T&#7847;ng 9, TTTM Vân H&#7891;, 51 Lê &#272;&#7841;i Hành, p. Lê &#272;&#7841;i Hành, q. Hai Bà Tr&#432;ng, Hà N&#7897;i</p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>&#272;i&#7879;n tho&#7841;i :</b> '.$eee.'</p></td></tr>
									<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Fax :</b> 04.3974 7881</p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Email: <a style="text-decoration: none;" href="mailto:'.$ccc.'">'.$ccc.'</a> - Website: <a href="http://mytour.vn" style="text-decoration: none;">http://mytour.vn</a></b></p></td></tr>
										</table>
								</td>
						</tr>
				</table>

				<p'.$ttt.'></p>
				<table width="100%" border="0" cellpadding="2" cellspacing="2" style="border-collapse: collapse; border: 1px solid #000000;">
						<tr><td colspan="2" style="font-weight: bold;"><p'.$uuu.'>&nbsp;&nbsp;&nbsp;&nbsp;Ghi chú:</p></td></tr>
						<tr>
								<td width="30">&nbsp;&nbsp;&nbsp;&nbsp;-</td>
								<td width="660"><p style="line-height: 5px;"><b style="color: #FF0000;">QUAN TR&#7884;NG</b>: Khi checkin, Quý khách ph&#7843;i xu&#7845;t trình phi&#7871;u voucher này và gi&#7845;y Ch&#7913;ng minh th&#432; nhân dân. Tr&#432;&#7901;ng h&#7907;p Quý khách không xu&#7845;t trình &#273;&#432;&#7907;c có th&#7875; d&#7851;n &#273;&#7871;n vi&#7879;c khách s&#7841;n yêu c&#7847;u tr&#7843; thêm chi phí ho&#7863;c không cho quý khách checkin.</p></td>
						</tr>
						<tr>
								<td width="30">&nbsp;&nbsp;&nbsp;&nbsp;-</td>
								<td width="660"><p style="line-height: 5px;">T&#7845;t c&#7843; các phòng &#273;&#7863;t tr&#432;&#7899;c &#273;&#7873;u &#273;&#432;&#7907;c &#273;&#7843;m b&#7843;o còn tr&#7889;ng trong ngày khách &#273;&#7871;n. Trong tr&#432;&#7901;ng h&#7907;p Quý khách không &#273;&#7871;n, phòng &#273;&#7863;t s&#7869; &#273;&#432;&#7907;c gi&#7843;i phóng và &#273;&#432;&#7907;c x&#7917; lý theo quy &#273;&#7883;nh và &#273;i&#7873;u kho&#7843;n cho tr&#432;&#7901;ng h&#7907;p h&#7911;y / không &#273;&#7871;n &#273;ã &#273;&#432;&#7907;c ghi rõ &#7903; bên trên.</p></td>
						</tr>
						<tr>
								<td width="30">&nbsp;&nbsp;&nbsp;&nbsp;-</td>
								<td width="660"><p style="line-height: 5px;">T&#7893;ng s&#7889; ti&#7873;n cho &#273;&#417;n &#273;&#7863;t phòng này không bao g&#7891;m chi phí &#259;n u&#7889;ng t&#7841;i qu&#7847;y bar c&#7911;a khách s&#7841;n, chi phí &#273;i&#7879;n tho&#7841;i, d&#7883;ch v&#7909; gi&#7863;t là... Quý khách s&#7869; thanh toán tr&#7921;c ti&#7871;p v&#7899;i khách s&#7841;n.</p></td>
						</tr>
				</table>

				<p'.$ttt.'></p>
				<p style="height: 0px; line-height: 0px; border-top: 2px dashed #E2E2E2;"></p>
			<p align="right" style="color: #3399FF; line-height: 1px; height: 1px;">NV t&#432; v&#7845;n: '.$tt['adm_name'].' - &#272;T: '.$tt['adm_phone'].'</p>';}unset($yy);return $sss;}function booking_tour_order_mailing($kk){global $ll;global $mm;global $nn;global $oo;global $pp;$c="";$yy=new db_query("SELECT tour_booking.*, tou_id, tou_name
																 FROM tour_booking
																 STRAIGHT_JOIN tours ON(tbo_tour_id = tou_id)
																 WHERE tbo_id = ".$kk);if($rr=mysqli_fetch_assoc($yy->result)){$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr["tbo_code"].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr["tbo_customer_name"].'</b></p>';$c.='<p style="margin-bottom: 10px;">'.translate("C&#7843;m &#417;n quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t tour c&#7911;a Mytour. Sau &#273;ây là thông tin &#273;&#7863;t tour c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-bottom: 20px; font-weight: bold;">'.translate("Quý khách l&#432;u ý: D&#7883;ch v&#7909; v&#7851;n ch&#432;a &#273;&#432;&#7907;c xác nh&#7853;n cho t&#7899;i khi &#273;&#417;n &#273;&#7863;t tour &#273;&#432;&#7907;c thanh toán và nh&#7853;n &#273;&#432;&#7907;c thông báo &#273;&#7863;t tour thành công t&#7915; Mytour.").'</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr["tbo_customer_name"].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["tbo_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr["tbo_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr["tbo_customer_email"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t tour:").'</td>';$c.='<td>'.$rr["tbo_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Tên tour").':</td>';$c.='<td><a style="font-weight: bold;" href="'.$pp.url_tour_detail($rr).'">'.$rr["tou_name"].'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin &#273;&#7863;t tour").':</td>';$c.='<td>';$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';$c.='<tr>
												<td'.$vv.'>'.translate("S&#7889; ng&#432;&#7901;i").'</td>
												<td'.$vv.'><b>'.$rr['tbo_person'].'</b></td>
										 </tr>
										 <tr>
												<td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
												<td'.$vv.'><b style="color: #FF0000;">'.format_number($rr['tbo_total_money']).' VN&#272;</b></td>
										 </tr>
										 <tr>
												<td'.$vv.'>'.translate("Ngày kh&#7903;i hành").'</td>
												<td'.$vv.'><b>'.($rr['tbo_departure_time']>0?date($mm,$rr['tbo_departure_time']):"").'</b></td>
										 </tr>
									</table>';$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr['tbo_payment_method']])?$nn[$rr['tbo_payment_method']]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr["tbo_customer_comment"].'</td>';$c.='</tr>';$c.='</table>';$c.='<p style="margin-bottom: 10px;">'.translate("Quý khách vui lòng ki&#7875;m tra l&#7841;i các thông tin trên. N&#7871;u có sai sót, vui lòng liên h&#7879; ngay v&#7899;i Mytour &#273;&#7875; c&#7853;p nh&#7853;t l&#7841;i thông tin cho &#273;&#417;n &#273;&#7863;t tour c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-top: 2px;">'.translate("Chân thành c&#7843;m &#417;n").'!</p>';$c.=$ll;$c.="</div>";if(send_mailer($rr['tbo_customer_email'],translate("Thông tin &#273;&#7863;t tour trên website Mytour"),$c)){return true;}}unset($yy);return false;}function sendmail_tour_booking_customer_success($kk,$nnn="tour"){global $ll;global $nn;global $oo;global $zz;$mm="d/m/Y";$ffff="STRAIGHT_JOIN tours ON(tbo_tour_id = tou_id)";if($nnn=="deal"){$ffff="STRAIGHT_JOIN promotionals ON(tbo_promotion_id = pro_id)";}$c="";$aaa=150;$bbb="booking@mytour.vn";$qq=new db_query("SELECT *
																 FROM tour_booking
																 STRAIGHT_JOIN admin_user ON(tbo_admin_check = adm_id)
																 ".$ffff."
																 WHERE tbo_id = ".intval($kk));if($rr=mysqli_fetch_assoc($qq->result)){if($rr['tbo_customer_email']!=""){if($rr['adm_email']!="")$bbb=$rr['adm_email'];$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr["tbo_code"].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr["tbo_customer_name"].'</b></p>';$c.='<p style="margin-bottom: 5px;">'.translate("C&#7843;m &#417;n Quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t tour t&#7841;i Mytour").'.</p>';$c.='<p style="margin-bottom: 20px;">'.translate("Chúng tôi g&#7917;i Email xác nh&#7853;n &#273;&#417;n &#273;&#7863;t tour c&#7911;a Quý khách &#273;ã &#273;&#432;&#7907;c x&#7917; lý thành công.").'</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t tour").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr["tbo_customer_name"].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["tbo_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr["tbo_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr["tbo_customer_email"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t tour:").'</td>';$c.='<td>'.$rr["tbo_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.($nnn=="deal"?translate("Tên Tour khuy&#7871;n m&#7841;i"):translate("Tên tour")).':</td>';$c.='<td><a style="font-weight: bold;" href="'.$zz.($nnn=="deal"?url_deal_detail($rr):url_tour_detail($rr)).'">'.($nnn=="deal"?$rr['pro_title']:$rr["tou_name"]).'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin &#273;&#7863;t tour").':</td>';$c.='<td>';$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';$c.='<tr>
													 <td'.$vv.'>'.translate("S&#7889; ng&#432;&#7901;i").'</td>
													 <td'.$vv.'><b>'.$rr['tbo_person'].'</b></td>
												</tr>
												<tr>
													 <td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
													 <td'.$vv.'><b style="color: #FF0000;">'.format_number($rr['tbo_total_money']).' VN&#272;</b></td>
												</tr>
												<tr>
													 <td'.$vv.'>'.translate("Ngày kh&#7903;i hành").'</td>
													 <td'.$vv.'><b>'.($rr['tbo_departure_time']>0?date($mm,$rr['tbo_departure_time']):"").'</b></td>
												</tr>
										 </table>';$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr['tbo_payment_method']])?$nn[$rr['tbo_payment_method']]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr["tbo_customer_comment"].'</td>';$c.='</tr>';$c.='<tr valign="top">';$c.='<td>'.translate("Ghi chú").':</td>';$c.='<td>'.$rr["tbo_voucher_note"].'</td>';$c.='</tr>';$c.='<tr valign="top">';$c.='<td>'.translate("Chính sách h&#7911;y").':</td>';$c.='<td>'.$rr["tbo_voucher_cancel"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td valign="top">'.translate("Link down voucher").':</td>';$c.='<td><p style="margin: 0px;"><a href="'.($zz.'/vouchers/tour/'.$rr["tbo_code"].'.pdf').'">Download</a></p><p style="margin: 0px;">('.translate("Quý khách vui lòng mang theo Voucher này khi kh&#7903;i hành tour").')</td>';$c.='</tr>';$c.='</table>';$c.='<p style="margin-bottom: 10px;">'.translate("Quý khách vui lòng ki&#7875;m tra l&#7841;i các thông tin trên. N&#7871;u có sai sót, vui lòng liên h&#7879; ngay v&#7899;i Mytour &#273;&#7875; c&#7853;p nh&#7853;t l&#7841;i thông tin cho &#273;&#417;n &#273;&#7863;t tour c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-top: 2px;">'.translate("Chân thành c&#7843;m &#417;n").'!</p>';$c.='<p><b>'.translate("Quý khách mu&#7889;n xu&#7845;t hóa &#273;&#417;n ti&#7873;n &#273;&#7863;t tour vui lòng g&#7917;i thông tin cho Mytour").' <a href="mailto:'.$bbb.'">'.translate("t&#7841;i &#273;ây").'</a></b></p>';$ss=new db_query("SELECT adm_name, adm_phone
																			 FROM admin_user
																			 WHERE adm_id = ".intval($rr['tbo_admin_check']));if($gggg=mysqli_fetch_assoc($ss->result)){$c.='<p><b>'.translate("T&#432; v&#7845;n viên").':</b> '.$gggg['adm_name'].'. <b>&#272;T:</b> '.$gggg['adm_phone'].'</p>';}unset($ss);$c.='<p style="margin-bottom: 2px;">'.translate("Chúc Quý khách có nh&#7919;ng ngày ngh&#7881; th&#7853;t vui v&#7867;").'.</p>';$c.=$ll;$c.="</div>";save_log_info("booking/bk_tour_sent_customer",$rr['tbo_customer_email']);if(send_mailer($rr['tbo_customer_email'],translate("Xác nh&#7853;n &#273;&#7863;t tour thành công t&#7915; Mytour"),$c)){save_log_info("booking/bk_tour_sent_customer_success",$rr['tbo_customer_email']);return true;}else{save_log_info("booking/bk_tour_sent_customer_error",$rr['tbo_customer_email']);}}}else{save_log_info("booking/bk_tour_sent_customer_no_result","Booking ID:".$kk);}unset($yy);return false;}function generate_voucher_tour($hhhh,$nnn="tour",$ooo=1){global $nn;global $ccc;global $eee;global $ppp;global $ddd;global $iiii;global $oo;$sss='';$ffff="STRAIGHT_JOIN tours ON(tbo_tour_id = tou_id)";if($nnn=="deal"){$ffff="STRAIGHT_JOIN promotionals ON(tbo_promotion_id = pro_id)";}$ttt=' style="height: 5px; line-height: 5px;"';$uuu=' style="height: 7px; line-height: 7px;"';$vvv=' style="height: 1px; line-height: 1px;"';$yy=new db_query("SELECT *
																						FROM    tour_booking
																						".$ffff."
																 STRAIGHT_JOIN admin_user ON(tbo_admin_check = adm_id)
																						WHERE tbo_id = ".intval($hhhh));if($tt=mysqli_fetch_assoc($yy->result)){$www='';if($tt['tbo_voucher_note']!=""){$www.='<tr>
													 <td colspan="2" width="700">
															<p style="height: 0px; line-height: 0px;"></p>
															<p style="height: 1px; line-height: 1px;"><b>'.translate("Ghi chú").':</b></p>
															<p style="line-height: 5px;">'.$tt['tbo_voucher_note'].'</p>
													 </td>
												</tr>';}$yyy='';if($nnn=="tour"){if((intval($tt['col2'])&intval($iiii))!=0){$yyy.='<tr><td>&bull; '.translate("&#272;ã bao g&#7891;m thu&#7871; và phí d&#7883;ch v&#7909;").'.</td></tr>';}else{$yyy.='<tr><td>&bull; '.translate("Ch&#432;a bao g&#7891;m thu&#7871; và phí d&#7883;ch v&#7909;").'.</td></tr>';}}if($nnn=="deal"){$yyy.='<tr><td style="color: red;">&bull; '.translate("&#272;&#7863;t tour khuy&#7871;n m&#7841;i").'.</td></tr>';}$dddd='';if($ooo==1){$dddd='<img style="height: 100px; line-height: 100px" src="/themes/images/mytour.png" />';}$sss='<div style="border-bottom: 3px solid #EBF5FF;">
												<table width="100%" border="0" style="border-collapse: collapse;">
														<tr>
																<td width="25%"><img border="0" src="/themes/images/logo_new.png" /></td>
																<td width="25%">'.$dddd.'</td>
																<td width="50%" align="right">
																		<h1 style="color: #0099FF; font-size: 120px;">Tour <span style="color: #C4BB95;">Voucher</span></h1>
																</td>
														</tr>
														<tr>
																<td colspan="3" align="right" style="font-style: inherit;">Hà N&#7897;i, '.date("d/m/Y").'</td>
														</tr>
												</table>
										</div>
										<div>
												<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
														<tr>
																<td width="400">
																		<table border="0" cellpadding="0" cellspacing="0" bordercolor="#C1C1C1" width="100%" style="border-collapse: collapse; margin: 0px;">
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("Khách hàng").':</p></td>
																						<td width="60%"><p'.$ttt.'><b>'.$tt['tbo_customer_name'].'</b></p></td>
																				</tr>
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("&#272;&#7883;a ch&#7881;").':</p></td>
																						<td width="60%"><p'.$ttt.'><b>'.$tt['tbo_customer_address'].'</b></p></td>
																				</tr>
																		<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("&#272;i&#7879;n tho&#7841;i").':</p></td>
																						<td width="60%"><p'.$ttt.'><b>'.$tt['tbo_customer_phone'].'</b></p></td>
																				</tr>
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("S&#7889; ti&#7873;n").':</p></td>
																						<td width="60%"><p'.$ttt.'><b style="color: #FF0000;">'.format_number($tt['tbo_total_money']).' VN&#272;</b></p></td>
																				</tr>
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("Thanh toán").':</p></td>
																						<td width="60%" valign="top">'.$nn[$tt['tbo_payment_method']].'</td>
																				</tr>
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("Ngày kh&#7903;i hành").':</p></td>
																						<td width="60%" valign="top">
																								<b>'.($tt['tbo_departure_time']>0?date("d/m/Y",$tt['tbo_departure_time']):'').'</b>
																						</td>
																				</tr>
																				<tr>
																						<td width="25%"><p'.$ttt.'>'.translate("Ngày v&#7873;").':</p></td>
																						<td width="60%" valign="top">
																								<b>'.($tt['tbo_time_finish']>0?date("d/m/Y",$tt['tbo_time_finish']):'').'</b>
																						</td>
																				</tr>
																		</table>
																</td>
																<td width="350">
																		<table border="1" style="border-collapse: collapse; background-color: #F6F6F6;" cellpadding="0" cellspacing="0" width="100%">
																				<tr>
																										<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;Mã &#273;&#417;n</p></td>
																										<td><p'.$uuu.'>&nbsp;&nbsp;<b>'.$tt['tbo_code'].'</b></p></td>
																								</tr>
																		<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;'.($nnn=="deal"?translate("Tên Tour khuy&#7871;n m&#7841;i"):translate("Tên tour")).'</p></td>
																						<td>
																					<table width="100%" border="0" cellpadding="1" cellspacing="1">
																						<tr><td><p style="height: 5px; line-height: 5px;"><b>'.($nnn=="deal"?$tt['pro_title']:$tt['tou_name']).'</b></p></td></tr>
																					</table>
																			 </td>
																				</tr>
																				<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;'.translate("S&#7889; ng&#432;&#7901;i &#273;&#7863;t").'</p></td>
																						<td><p'.$uuu.'>&nbsp;&nbsp;<b>'.$tt['tbo_person'].'</b> '.translate("ng&#432;&#7901;i").'</p></td>
																				</tr>
																		<tr>
																						<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;<b>'.translate("Ghi chú").'</b></p></td>
																			 <td>
																					<table width="100%" border="0" cellpadding="1" cellspacing="1">
																						'.$yyy.'
																					</table>
																			 </td>
																		</tr>
																 </table>
																</td>
														</tr>
													 '.$www.'

												</table>
										</div>

										<p style="height: 1px; line-height: 1px;"><b>'.translate("&#272;&#432;&#7907;c &#273;&#7863;t b&#7903;i").':</b></p>
										<table width="100%" border="0" cellpadding="2" cellspacing="2" style="border-collapse: collapse; background-color: #FFF; border: 1px solid #000000;">
												<tr>
														<td width="700">
																<table border="0" cellpadding="2" cellspacing="3">
																		<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>CÔNG TY TNHH MYTOUR VI&#7878;T NAM</b></p></td></tr>
																		<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Tr&#7909; s&#7903; :</b> T&#7847;ng 9, TTTM Vân H&#7891;, 51 Lê &#272;&#7841;i Hành, p. Lê &#272;&#7841;i Hành, q. Hai Bà Tr&#432;ng, Hà N&#7897;i</p></td></tr>
																		<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>&#272;i&#7879;n tho&#7841;i :</b> '.$eee.'</p></td></tr>
																 <tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Fax :</b> 04.3974 7881</p></td></tr>
																		<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Email: <a style="text-decoration: none;" href="mailto:'.$ccc.'">'.$ccc.'</a> - Website: <a href="http://mytour.vn" style="text-decoration: none;">http://mytour.vn</a></b></p></td></tr>
																</table>
														</td>
												</tr>
										</table>

										<p'.$ttt.'></p>
										<p style="height: 0px; line-height: 0px; border-top: 2px dashed #E2E2E2;"></p>
										 <p align="right" style="color: #3399FF; line-height: 1px; height: 1px;">NV t&#432; v&#7845;n: '.$tt['adm_name'].' - &#272;T: '.$tt['adm_phone'].'</p>';}unset($yy);return $sss;}function getSmallLink($jjjj,$kkkk=0){$llll="http://api.bit.ly/shorten?version=2.0.1&longUrl=".$jjjj."&login=mytour&apiKey=R_db376e66a04df853ab47af1a931fc43b&format=json&history=1";$mmmm=curl_init();curl_setopt($mmmm,CURLOPT_URL,$llll);curl_setopt($mmmm,CURLOPT_HEADER,false);curl_setopt($mmmm,CURLOPT_RETURNTRANSFER,1);$nnnn=curl_exec($mmmm);curl_close($mmmm);$oooo=json_decode($nnnn,true);if(isset($oooo["results"][$jjjj]["shortUrl"])){return $oooo["results"][$jjjj]["shortUrl"];}else{$kkkk++;if($kkkk<=2){return getSmallLink($jjjj,$kkkk);}else{return $jjjj;}}}function send_mail_booking_deal_order($kk,$nnn){global $ll;global $mm;global $nn;global $zz;$c="";if($nnn=="deal_hotel"){$pppp="booking_hotel";$qqqq="boo_id";$rrrr="boo_promotion_id";$ssss="boo_customer_name";$tttt="boo_customer_address";$uuuu="boo_customer_phone";$vvvv="boo_customer_email";$wwww="boo_customer_comment";$xxxx="boo_bill_code";$yyyy="boo_total_money";$zzzz="boo_payment_method";}else{$pppp="tour_booking";$qqqq="tbo_id";$rrrr="tbo_promotion_id";$ssss="tbo_customer_name";$tttt="tbo_customer_address";$uuuu="tbo_customer_phone";$vvvv="tbo_customer_email";$wwww="tbo_customer_comment";$xxxx="tbo_code";$yyyy="tbo_total_money";$zzzz="tbo_payment_method";}$yy=new db_query("SELECT ".$pppp.".*, pro_title, pro_id
																 FROM ".$pppp."
																 STRAIGHT_JOIN promotionals ON(".$rrrr." = pro_id)
																 WHERE ".$qqqq." = ".$kk);if($rr=mysqli_fetch_assoc($yy->result)){$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr[$xxxx].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr[$ssss].'</b></p>';$c.='<p style="margin-bottom: 10px;">'.translate("C&#7843;m &#417;n quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t deal c&#7911;a Mytour. Sau &#273;ây là thông tin &#273;&#7863;t deal c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-bottom: 20px; font-weight: bold;">'.translate("Quý khách l&#432;u ý: D&#7883;ch v&#7909; v&#7851;n ch&#432;a &#273;&#432;&#7907;c xác nh&#7853;n cho t&#7899;i khi &#273;&#417;n &#273;&#7863;t &#273;&#432;&#7907;c thanh toán và nh&#7853;n &#273;&#432;&#7907;c thông báo &#273;&#7863;t thành công t&#7915; Mytour.").'</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t Deal").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr[$ssss].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr[$tttt].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr[$uuuu].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr[$vvvv].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t:").'</td>';$c.='<td>'.$rr[$xxxx].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Tên deal").':</td>';$c.='<td><a style="font-weight: bold;" href="'.$zz.url_deal_detail($rr).'">'.$rr["pro_title"].'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin &#273;&#7863;t Deal").':</td>';$c.='<td>';$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';$c.='
												<tr>
													 <td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
													 <td'.$vv.'><b style="color: #FF0000;">'.format_number($rr[$yyyy]).' VN&#272;</b></td>
												</tr>
										 </table>';$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr[$zzzz]])?$nn[$rr[$zzzz]]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr[$wwww].'</td>';$c.='</tr>';$c.='</table>';$c.='<p style="margin-bottom: 10px;">'.translate("Quý khách vui lòng ki&#7875;m tra l&#7841;i các thông tin trên. N&#7871;u có sai sót, vui lòng liên h&#7879; ngay v&#7899;i Mytour &#273;&#7875; c&#7853;p nh&#7853;t l&#7841;i thông tin cho &#273;&#417;n &#273;&#7863;t deal c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-top: 2px;">'.translate("Chân thành c&#7843;m &#417;n").'!</p>';$c.=$ll;$c.="</div>";if(send_mailer($rr[$vvvv],translate("Thông tin &#273;&#7863;t deal trên website Mytour"),$c)){return true;}}unset($yy);return false;}function sendmail_deal_booking_customer_success($kk){global $ll;global $nn;global $pp;global $zz;$mm="d/m/Y";$c="";$aaa=150;$qq=new db_query("SELECT *
																 FROM booking_deal
																 STRAIGHT_JOIN promotionals ON(bod_promotion_id = pro_id)
																 WHERE bod_id = ".intval($kk));if($rr=mysqli_fetch_assoc($qq->result)){$c.='<div style="border:3px double #94C7FF; padding: 10px; line-height: 19px; color: #444444;">';$c.='<p align="right" style="border-bottom: 1px solid #C8D6FF; font-weight: bold;">'.$rr["bod_code"].'</p>';$c.='<p>'.translate("Xin chào").', <b>'.$rr["bod_customer_name"].'</b></p>';$c.='<p style="margin-bottom: 5px;">'.translate("C&#7843;m &#417;n Quý khách &#273;ã s&#7917; d&#7909;ng d&#7883;ch v&#7909; &#273;&#7863;t deal t&#7841;i Mytour").'.</p>';$c.='<p style="margin-bottom: 20px;">'.translate("Chúng tôi g&#7917;i Email xác nh&#7853;n &#273;&#417;n &#273;&#7863;t deal c&#7911;a Quý khách &#273;ã &#273;&#432;&#7907;c x&#7917; lý thành công.").'.</p>';$c.='<table width="100%" cellspacing="0" cellpadding="1" style="border: 2px solid #C8D6FF; padding: 10px;" border="0">';$c.='<tr>';$c.='<td colspan="2"><h3 style="color: #FD7000; margin-top: 5px; border-bottom: 2px solid #C8D6FF; padding-bottom: 5px;">'.translate("Thông tin &#273;&#7863;t Deal").'</h3></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("H&#7885; tên").':</td>';$c.='<td><b>'.$rr["bod_customer_name"].'</b></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;&#7883;a ch&#7881;").':</td>';$c.='<td>'.$rr["bod_customer_address"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("&#272;i&#7879;n tho&#7841;i").':</td>';$c.='<td>'.$rr["bod_customer_phone"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Email").':</td>';$c.='<td>'.$rr["bod_customer_email"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Mã &#273;&#417;n &#273;&#7863;t khuy&#7871;n m&#7841;i:").'</td>';$c.='<td>'.$rr["bod_code"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Tên khuy&#7871;n m&#7841;i").':</td>';$c.='<td><a style="font-weight: bold;" href="'.$zz.url_deal_detail($rr).'">'.$rr["pro_title"].'</a></td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thông tin &#273;&#7863;t Deal").':</td>';$c.='<td>';$vv=' style="border-color: #AAAAAA;"';$c.='<table border="1" cellpadding="3" cellspacing="2" bordercolor="#E2E2E2" style="border-collapse: collapse; margin: 10px 0px; border-color: #AAAAAA;">';$c.='<tr>
												<td'.$vv.'>'.translate("S&#7889; l&#432;&#7907;ng").'</td>
												<td'.$vv.'><b>'.$rr['bod_quantity'].'</b></td>
										 </tr>
										 <tr>
												<td'.$vv.'>'.translate("S&#7889; ti&#7873;n").'</td>
												<td'.$vv.'><b style="color: #FF0000;">'.format_number($rr['bod_total_money']).' VN&#272;</b></td>
										 </tr>
									</table>';$c.='</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Thanh toán").':</td>';$c.='<td>'.(isset($nn[$rr['bod_payment_method']])?$nn[$rr['bod_payment_method']]:translate("Thanh toán t&#7841;i v&#259;n phòng c&#7911;a Mytour")).'</td>';$c.='</tr>';$c.='<tr>';$c.='<td>'.translate("Yêu c&#7847;u riêng").':</td>';$c.='<td>'.$rr["bod_customer_comment"].'</td>';$c.='</tr>';$c.='<tr valign="top">';$c.='<td>'.translate("Ghi chú").':</td>';$c.='<td>'.$rr["bod_voucher_note"].'</td>';$c.='</tr>';$c.='<tr>';$c.='<td valign="top">'.translate("Link down voucher").':</td>';$c.='<td><p style="margin: 0px;"><a href="'.($zz.'/vouchers/deal/'.$rr["bod_code"].'.pdf').'">Download</a></p><p style="margin: 0px;">('.translate("Quý khách vui lòng mang theo Voucher này khi &#273;i nh&#7853;n khuy&#7871;n m&#7841;i").')</td>';$c.='</tr>';$c.='</table>';$c.='<p style="margin-bottom: 10px;">'.translate("Quý khách vui lòng ki&#7875;m tra l&#7841;i các thông tin trên. N&#7871;u có sai sót, vui lòng liên h&#7879; ngay v&#7899;i Mytour &#273;&#7875; c&#7853;p nh&#7853;t l&#7841;i thông tin cho &#273;&#417;n &#273;&#7863;t deal c&#7911;a Quý khách.").'</p>';$c.='<p style="margin-top: 2px;">'.translate("Chân thành c&#7843;m &#417;n").'!</p>';$c.='<p><b>'.translate("Quý khách mu&#7889;n xu&#7845;t hóa &#273;&#417;n ti&#7873;n &#273;&#7863;t deal vui lòng g&#7917;i thông tin cho Mytour").' <a href="mailto:booking@mytour.vn">'.translate("t&#7841;i &#273;ây").'</a></b></p>';$ss=new db_query("SELECT adm_name, adm_phone
																		FROM admin_user
																		WHERE adm_id = ".intval($rr['bod_admin_check']));if($gggg=mysqli_fetch_assoc($ss->result)){$c.='<p><b>'.translate("T&#432; v&#7845;n viên").':</b> '.$gggg['adm_name'].'. <b>&#272;T:</b> '.$gggg['adm_phone'].'</p>';}unset($ss);$c.='<p style="margin-bottom: 2px;">'.translate("Chúc Quý khách có nh&#7919;ng ngày ngh&#7881; th&#7853;t vui v&#7867;").'.</p>';$c.=$ll;$c.="</div>";if(send_mailer($rr['bod_customer_email'],translate("Xác nh&#7853;n &#273;&#7863;t deal thành công t&#7915; Mytour"),$c)){return true;}}unset($yy);return false;}function generate_voucher_deal($mmm){global $nn;global $ccc;global $eee;global $ppp;global $ddd;global $iiii;$sss='';$ttt=' style="height: 5px; line-height: 5px;"';$uuu=' style="height: 7px; line-height: 7px;"';$vvv=' style="height: 1px; line-height: 1px;"';$yy=new db_query("SELECT *
																						FROM    booking_deal
																						STRAIGHT_JOIN promotionals ON(bod_promotion_id = pro_id)
																						WHERE bod_id = ".intval($mmm));if($tt=mysqli_fetch_assoc($yy->result)){$www='';if($tt['bod_voucher_note']!=""){$www.='<tr>
													 <td colspan="2" width="700">
															<p style="height: 0px; line-height: 0px;"></p>
															<p style="height: 1px; line-height: 1px;"><b>'.translate("Ghi chú").':</b></p>
															<p style="line-height: 5px;">'.$tt['bod_voucher_note'].'</p>
													 </td>
												</tr>';}$yyy=translate("&#272;ã bao g&#7891;m thu&#7871; và phí d&#7883;ch v&#7909;");$sss='<div style="border-bottom: 3px solid #EBF5FF;">
						<table width="100%" border="0" style="border-collapse: collapse;">
								<tr>
										<td width="50%"><img border="0" src="http://mytour.vn/themes/images/logo_new.png" /></td>
										<td width="50%" align="right">
												<h1 style="color: #0099FF; font-size: 120px;">Deal <span style="color: #C4BB95;">Voucher</span></h1>
										</td>
								</tr>
								<tr>
										<td colspan="2" align="right" style="font-style: inherit;">Hà N&#7897;i, '.date("d/m/Y").'</td>
								</tr>
						</table>
				</div>
				<div>
						<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">
								<tr>
										<td width="430">
												<table border="0" cellpadding="0" cellspacing="0" bordercolor="#C1C1C1" width="100%" style="border-collapse: collapse; margin: 0px;">

														<tr>
																<td width="25%"><p'.$ttt.'>'.translate("Khách hàng").':</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['bod_customer_name'].'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>'.translate("&#272;&#7883;a ch&#7881;").':</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['bod_customer_address'].'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>'.translate("S&#7889; l&#432;&#7907;ng").':</p></td>
																<td width="60%"><p'.$ttt.'><b>'.$tt['bod_quantity'].'</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>'.translate("S&#7889; ti&#7873;n").':</p></td>
																<td width="60%"><p'.$ttt.'><b style="color: #FF0000;">'.format_number($tt['bod_total_money']).' VN&#272;</b></p></td>
														</tr>
														<tr>
																<td width="25%"><p'.$ttt.'>'.translate("Thanh toán").':</p></td>
																<td width="60%">
																		<p'.$ttt.'>'.$nn[$tt['bod_payment_method']].'</p>
																</td>
														</tr>
												</table>
										</td>
										<td width="350">
												<table border="1" style="border-collapse: collapse; background-color: #F6F6F6;" cellpadding="0" cellspacing="0" width="100%">
										 <tr>
																<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;'.translate("Tên Deal").'</p></td>
																<td>
													 <table width="100%" border="0" cellpadding="1" cellspacing="1">
														 <tr><td><p style="height: 5px; line-height: 5px;"><b>'.$tt['pro_title'].'</b></p></td></tr>
													 </table>
												</td>
														</tr>
														<tr>
																<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;'.translate("Áp d&#7909;ng &#273;&#7871;n").'</p></td>
																<td><p'.$uuu.'>&nbsp;&nbsp;<b>'.date("d/m/Y",$tt['pro_dateend']).'</b></p></td>
														</tr>
										 <tr>
																<td width="30%"><p'.$uuu.'>&nbsp;&nbsp;<b>'.translate("Ghi chú").'</b></p></td>
												<td>
														 '.$yyy.'
												</td>
										 </tr>
									</table>
										</td>
								</tr>
						'.$www.'

						</table>
				</div>

				<p style="height: 1px; line-height: 1px;"><b>'.translate("&#272;&#432;&#7907;c &#273;&#7863;t b&#7903;i").':</b></p>
				<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse; background-color: #F6F6F6;">
						<tr>
								<td width="450">
										<table border="0" cellpadding="2" cellspacing="3">
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>Mytour.vn</b></p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>'.translate("&#272;&#7883;a ch&#7881;").':</b>51 Lê &#272;&#7841;i Hành, Hai Bà Tr&#432;ng, Hà N&#7897;i</p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>'.translate("&#272;i&#7879;n tho&#7841;i").':</b> '.$eee.'</p></td></tr>
									<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>'.translate("Fax").':</b> 04.3974 7881</p></td></tr>
												<tr><td><p style="height: 3px; line-height: 3px;">&nbsp;&nbsp;<b>'.translate("Email").': <a href="mailto:'.$ccc.'">'.$ccc.'</a> - Website: <a href="http://mytour.vn">http://mytour.vn</a></b></p></td></tr>
										</table>
								</td>
								<td>
										<p style="height: 7px; line-height: 7px; text-transform: uppercase;">&nbsp;&nbsp;<b>Công ty TNHH Bán l&#7867; Nhanh</b></p>
								</td>
						</tr>
				</table>

				<p'.$ttt.'></p>
				<p'.$ttt.'></p>
				<p style="height: 0px; line-height: 0px; border-top: 2px dashed #E2E2E2;"></p>
				<p align="right" style="color: #3399FF; line-height: 5px; height: 5px;">Mytour.vn - Holine: '.$eee.' - Email: '.$ccc.'</p>';}unset($yy);return $sss;}?>