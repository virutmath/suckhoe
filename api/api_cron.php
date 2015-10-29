<?
/**
 * biến toàn cục
 * @var $action - lưu trữ tên thao tác với dữ liệu
 * @var $api_result - lưu trữ kết quả cuối cùng trả về của lời gọi api
 * @var $array_code_error - lưu trữ mảng thông điệp lỗi trả về
 * */

if(!isset($action))
    die();
switch($action){
    case 'getAlobacsiCatID':
        $cat_source = getValue('cat_id','int','GET',0,1);
        $db_query = new db_query('SELECT cat_id FROM categories WHERE cat_alobacsi_id LIKE "%'.$cat_source.'%"');
        $cat_id = mysqli_fetch_assoc($db_query->result);unset($db_query);
        if($cat_id){
            $cat_dist = $cat_id['cat_id'];
            $api_result = array('success'=>1,'id'=>$cat_dist);
        }else{
            $api_result = array('error'=>0,'msg'=>'Không tồn tại record này');
        }
        break;

    case 'getAnswerContentEmpty':
        $db = new db_query('SELECT que_id,que_link_origin
                            FROM questions
                            WHERE que_answer_content = "" AND que_type = 0 AND que_status = 1
                            LIMIT 1');
        $data  = mysqli_fetch_assoc($db->result);unset($db);
        if($data){
            $api_result = array('success'=>1,'id'=>$data['que_id'],'link'=>$data['que_link_origin']);
        }else{
            $api_result = array('error'=>0,'msg'=>'Không tồn tại record này');
        }
        break;

    case 'getDiseaseSongKhoeActive':
        $cat_id = getValue('cat_id');
        $db_query = new db_query('SELECT * FROM disease_songkhoe WHERE dis_link_status = 0 LIMIT 1');
        $data_link = mysqli_fetch_assoc($db_query->result);
        if(!$data_link){
            //reset link
            $db_update = new db_execute('UPDATE disease_songkhoe SET dis_link_status = 0 WHERE dis_link_status = 1');
            $api_result = array('error'=>1,'code'=>101,'msg'=>'Đã hết link cần lấy - reset!');
        }else{
            $api_result = array('success'=>1,'data'=>$data_link);
        }
        break;
    case 'getDiseaseSongKhoeDetail':
        $id = getValue('id');
        $db = new db_query('SELECT * FROM disease_songkhoe WHERE dis_id = '.$id);
        $data = mysqli_fetch_assoc($db->result);unset($db);
        if(!$data){
            $api_result = array('error'=>1,'code'=>404,'msg'=>'Link không tồn tại');
        }else{
            $api_result = array('success'=>1,'data'=>$data);
        }
        break;
    case 'getLawActive':
        $db = new db_query('SELECT * FROM law WHERE law_status_temp = 0 LIMIT 1');
        $law_detail = mysqli_fetch_assoc($db->result);unset($db);
        if($law_detail){
            $api_result = $law_detail;
        }else{
            $api_result = array('error'=>1, 'code'=>101, 'msg'=>$array_code_error[101]);
        }
        break;
    case 'getLawDetail':
        $law_id = getValue('id','int','GET',0);
        $db = new db_query('SELECT * FROM law WHERE law_id = '.$law_id);
        $law_detail = mysqli_fetch_assoc($db->result);unset($db);
        if($law_detail){
            $api_result = $law_detail;
        }else{
            $api_result = array('error'=>1, 'code'=>404, 'msg'=>$array_code_error[404]);
        }
        break;
    case 'getSongKhoeCatID':
        $cat_source = getValue('cat_id','int','GET',0,1);
        $db_query = new db_query('SELECT cat_id FROM categories WHERE cat_songkhoe_id LIKE "%'.$cat_source.'%"');
        $cat_id = mysqli_fetch_assoc($db_query->result);unset($db_query);
        if($cat_id){
            $cat_dist = $cat_id['cat_id'];
            $api_result = array('success'=>1,'id'=>$cat_dist);
        }else{
            $api_result = array('error'=>0,'msg'=>'Không tồn tại record này');
        }
        break;
    case 'resetLaw':
        $db = new db_execute('UPDATE law SET law_status_temp = 0');
        $api_result = array('success'=>1);
        unset($db);
        break;
    case 'setLawStatusTemp':
        $law_id = getValue('id','int','GET',0);
        $status = getValue('status','int','GET',0);
        if($law_id){
            $db = new db_execute('UPDATE law SET law_status_temp = '.$status.' WHERE law_id = '.$law_id);
            $api_result = array('success'=>1);
        }else{
            $api_result = array('error'=>1,'code'=>404, 'msg'=>$array_code_error[404]);
        }
        break;

    case 'setDiseaseSongKhoeStatus':
        $status = getValue('status');
        $id = getValue('id');
        $db_ex = new db_execute('UPDATE disease_songkhoe SET dis_link_status = '.$status.' WHERE dis_id = '.$id);unset($db_ex);
        break;
    case 'updateAnswerContentEmpty':
        $answer_content = getValue('answer_content','str','POST','');
        $que_id = getValue('id');
        if(!$answer_content){
            $api_result = array('error'=>0,'msg'=>'Dữ liệu rỗng');
            break;
        }
        if($answer_content){
            $answer_content = str_replace("\'", "'", $answer_content);
            $answer_content = str_replace("'", "''", $answer_content);
        }

        //upload ảnh
        foreach($_FILES as $key=>$image_file){
            $path_picture = generate_dir_upload($image_file['name'],'organic') . $image_file['name'];
            move_uploaded_file($image_file['tmp_name'],$path_picture);
        }
        $sql = "UPDATE questions SET que_answer_content = '".$answer_content."' WHERE que_id = ".$que_id;
        $db_update = new db_execute($sql);
        if($db_update->total){
            $api_result = array('success'=>1,'msg'=>'Update thành công ' . $sql);
        }else{
            $api_result = array('error'=>0,'msg'=>'Lỗi update : '.$sql);
        }
        break;
    case 'uploadNews':
        //check xem content có ngắn quá không
        $check_content = getValue('content','str','POST','');
        $check_content = removeHTML($check_content);
        $check_content = cut_string($check_content,300);
        if(strlen($check_content) < 10){
            //tin quá ngắn
            $api_result = array('error'=>1,'msg'=>'Tin quá ngắn :'.$check_content);
            break;
        }
        //$new_title = getValue('title','string','POST','');
        //$new_title_md5 = trim($new_title);
        //$new_title_md5 = trim($new_title, '.');
        //$new_title_md5 = md5($new_title_md5);
        $new_date = time();
        $new_active = 1;
        $myform = new generate_form();
        $myform->addTable('news');
        $myform->add('new_title','title',0,0,'',1,'Tiêu đề trống');
        $myform->add('new_title_md5','title_md5',0,0,'',1,'Tiêu đề trùng',1,'Tiêu đề trùng');
        $myform->add('new_cat_id','category',1,0,0,1,'Danh mục không có');
        $myform->add('new_lin_id','link_id',1,0,0,1,'Không nhận ID link');
        $myform->add('new_lin_url','link_url',0,0,0,1,'Không nhận được URL');
        $myform->add('new_picture','image',0,0,'',1,'Tin không có ảnh');
        $myform->add('new_teaser','teaser',0,0,'',1,'Tin không có mô tả ngắn');
        $myform->add('new_tags','tags_string',0,0,'');
        $myform->add('new_date','new_date',1,1,0,1);
        $myform->add('new_active','new_active',1,1,0,1);
        /*$api_result = $_POST;*/
        if(!$myform->checkdata()){
            $db = new db_execute_return();
            $last_id = $db->db_execute($myform->generate_insert_SQL());unset($db);
            if($last_id){
                //upload detail
                $myform_detail = new generate_form();
                $myform_detail->addTable('news_detail');
                $myform_detail->add('ndt_id','last_id',1,1,0,1);
                $myform_detail->add('ndt_content','content',0,0,'',1);
                $myform_detail->removeHTML(0);
                $db_insert = new db_execute($myform_detail->generate_insert_SQL());unset($db_insert);
                //upload ảnh đại diện và ảnh chi tiết tin
                //đếm ảnh, nếu tin có nhiều hơn 4 ảnh (kể cả ảnh đại diện) thì update loại tin là tin ảnh
                $count_image = 0;
                foreach($_FILES as $key=>$image_file){
                    $path_picture = generate_dir_upload($image_file['name'],'organic') . $image_file['name'];
                    move_uploaded_file($image_file['tmp_name'],$path_picture);
                    $count_image ++;
                }
                if($count_image >= 4){
                    //update tin là tin ảnh
                    $db_update = new db_execute('UPDATE news SET new_type_image = 1 WHERE new_id = '.$last_id);
                }
                $api_result = array('success'=>1,'id'=>$last_id);

            }else{
                $api_result = array('error'=>1,'msg'=>'Truy vấn lỗi :'.$myform->generate_insert_SQL());
            }
        }else{
            $api_result = array('error'=>1, 'msg'=>'Dữ liệu lỗi : ' . $myform->checkdata() . $myform->generate_insert_SQL());
        }
        break;
    case 'uploadPharma':
        $myform = new generate_form();
        $myform->addTable('pharma');
        $myform->add('pha_name','pha_name',0,0,'',1,'Tên thuốc trống',1,'Tên thuốc đã tồn tại');
        $myform->add('pha_title','pha_title',0,0,'');
        $myform->add('pha_url_origin','pha_url_origin',0,0,'');
        $myform->add('pha_so_dang_ky','pha_so_dang_ky',0,0,'');
        $myform->add('pha_dang_bao_che','pha_dang_bao_che',0,0,'');
        $myform->add('pha_dong_goi','pha_dong_goi',0,0,'');
        $myform->add('pha_gia_buon','pha_gia_buon',0,0,'');
        $myform->add('pha_gia_le','pha_gia_le',0,0,'');
        $myform->add('pha_nha_sx_name','pha_nha_sx_name',0,0,'');
        $myform->add('pha_nha_sx_id','pha_nha_sx_id',1,0,'');
        $myform->add('pha_nha_dk_name','pha_nha_dk_name',0,0,'');
        $myform->add('pha_nha_dk_id','pha_nha_dk_id',1,0,'');
        $myform->add('pha_nhom_duoc_ly_id','pha_nhom_duoc_ly_id',1,0,'');
        $myform->add('pha_thanh_phan','pha_thanh_phan',0,0,'');
        $myform->add('pha_thuoc_goc_list_id','pha_thuoc_goc_list_id',0,0,'');
        $myform->add('pha_ham_luong','pha_ham_luong',0,0,'');
        $myform->add('pha_chi_dinh','pha_chi_dinh',0,0,'');
        $myform->add('pha_chong_chi_dinh','pha_chong_chi_dinh',0,0,'');
        $myform->add('pha_tuong_tac_thuoc','pha_tuong_tac_thuoc',0,0,'');
        $myform->add('pha_tac_dung_phu','pha_tac_dung_phu',0,0,'');
        $myform->add('pha_chu_y_de_phong','pha_chu_y_de_phong',0,0,'');
        $myform->add('pha_lieu_luong','pha_lieu_luong',0,0,'');
        $myform->add('pha_bao_quan','pha_bao_quan',0,0,'');
        $myform->add('pha_image','pha_image',0,0,'');
        $myform->add('pha_tag','pha_tag',0,0,'');
        $myform->removeHTML(0);
        if(!$myform->checkdata()){
            $image = getValue('pha_image','str','POST','');
            if($image){
                $image_path = $_FILES['pha_image_path'];
                $path_picture = generate_dir_upload($image_path['name'],'organic') . $image_path['name'];
                move_uploaded_file($image_path['tmp_name'],$path_picture);
            }
            $db = new db_execute_return();
            $last_id = $db->db_execute($myform->generate_insert_SQL());unset($db);
            if($last_id){
                $api_result = array('success'=>1,'id'=>$last_id);
            }else{
                $api_result = array('error'=>1,'msg'=>'SQL: ' .$myform->generate_insert_SQL() . '<br>');
            }
        }else{
            $api_result = array('error'=>1,'msg'=>'Dữ liệu lỗi : ' . $myform->checkdata());
        }

        break;
    case 'uploadPharmaSecond':
        $myform = new generate_form();
        $myform->addTable('pharma');
        $myform->add('pha_name','pha_name',0,0,'',1,'Tên thuốc trống');
        $myform->add('pha_title','pha_title',0,0,'');
        $myform->add('pha_url_origin','pha_url_origin',0,0,'');
        $myform->add('pha_description','pha_description',0,0,'');
        $myform->add('pha_content','pha_content',0,0,'');
        $myform->add('pha_dong_goi','pha_dong_goi',0,0,'');
        $myform->add('pha_nha_sx_name','pha_nha_sx_name',0,0,'');
        $myform->add('pha_nha_sx_id','pha_nha_sx_id',1,0,'');
        $myform->add('pha_nhom_duoc_ly_id','pha_nhom_duoc_ly_id',1,0,'');
        $myform->add('pha_thanh_phan','pha_thanh_phan',0,0,'');
        $myform->add('pha_chi_dinh','pha_chi_dinh',0,0,'');
        $myform->add('pha_chong_chi_dinh','pha_chong_chi_dinh',0,0,'');
        $myform->add('pha_tac_dung_phu','pha_tac_dung_phu',0,0,'');
        $myform->add('pha_chu_y_de_phong','pha_chu_y_de_phong',0,0,'');
        $myform->add('pha_lieu_luong','pha_lieu_luong',0,0,'');
        $myform->add('pha_image','pha_image',0,0,'');
        $myform->removeHTML(0);
        if(!$myform->checkdata()){
            $image = getValue('pha_image','str','POST','');
            if($image){
                $image_path = $_FILES['pha_image_path'];
                $path_picture = generate_dir_upload($image_path['name'],'organic') . $image_path['name'];
                move_uploaded_file($image_path['tmp_name'],$path_picture);
            }
            $db = new db_execute_return();
            $last_id = $db->db_execute($myform->generate_insert_SQL());unset($db);
            if($last_id){
                $api_result = array('success'=>1,'id'=>$last_id);
            }else{
                $api_result = array('error'=>1,'msg'=>'SQL: ' .$myform->generate_insert_SQL() . '<br>');
            }
        }else{
            $api_result = array('error'=>1,'msg'=>'Dữ liệu lỗi : ' . $myform->checkdata());
        }
        break;
    case 'uploadPharmaBrand':
        $array_data = getValue('array_data','arr','POST',array());
        $list_id = array();
        if($array_data){
            foreach($array_data as $pharma){
                //check xem brand có chưa nếu chưa có thì insert, có rồi bỏ qua
                $phb_name = $pharma['brand_name'];
                $db_check = new db_query('SELECT phb_id FROM pharma_brand WHERE phb_name ="'.$phb_name.'" LIMIT 1');
                $row = mysqli_fetch_assoc($db_check->result);unset($db_check);
                if($row){
                    //đã có brand
                    $list_id[] = $row['phb_id'];
                }else{
                    $phb_detail_url = $pharma['brand_link'];
                    //chưa có brand - insert trả về id
                    $db_insert = new db_execute_return();
                    $last_id = $db_insert->db_execute('INSERT INTO pharma_brand(phb_name,phb_detail_url) VALUES("'.$phb_name.'","'.$phb_detail_url.'")');
                    $list_id[] = $last_id;
                }
            }
        }
        $api_result = array('success'=>1,'list_id'=>$list_id);

        break;
    case 'uploadPharmaCompany':
        $phc_name = getValue('name','str','POST','',3);
        //check xem company ton tai chua, neu ton tai roi thi tra ve id
        $db_query = new db_query('SELECT phc_id FROM pharma_company WHERE phc_name = "'.$phc_name.'"');
        if($row = mysqli_fetch_assoc($db_query->result)){
            $api_result = array('success'=>1,'id'=>$row['phc_id']);
            break;
        }unset($db_query);
        //insert company
        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute('INSERT INTO pharma_company(phc_name) VALUES("'.$phc_name.'")');
        $api_result = array('success'=>1,'id'=>$last_id);
        break;
    case 'uploadPharmaGroup':
        $phg_name = getValue('name','str','POST','',3);
        //check xem company ton tai chua, neu ton tai roi thi tra ve id
        $db_query = new db_query('SELECT phg_id FROM pharma_group WHERE phg_name = "'.$phg_name.'"');
        if($row = mysqli_fetch_assoc($db_query->result)){
            $api_result = array('success'=>1,'id'=>$row['phg_id']);
            break;
        }unset($db_query);
        //insert company
        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute('INSERT INTO pharma_group(phg_name) VALUES("'.$phg_name.'")');
        $api_result = array('success'=>1,'id'=>$last_id);
        break;
    case 'uploadQuestion':
        $time = time();
        $myform = new generate_form();
        $myform->addTable('questions');
        $myform->add('que_title','que_title',0,0,'',1,'Tiêu đề trống',1,'Tiêu đề trùng');
        $myform->add('que_username','que_username',0,0,'',1,'User trống');
        $myform->add('que_cat_id','que_cat_id',1,0,0);
        $myform->add('que_question_content','que_question_content',0,0,'',1,'Nội dung câu hỏi trống');
        $myform->add('que_answer_content','que_answer_content',0,0,'');
        $myform->add('que_professional','que_professional',0,0,'');
        $myform->add('que_disease','que_disease',0,0,'',0,'Tên bệnh trống');
        $myform->add('que_disease_id_local','que_disease_id_local',1,0,0,0,'ID check bệnh local trống');
        $myform->add('que_disease_link','que_disease_link',0,0,'',0,'Link đến list bài viết về bệnh trống');
        $myform->add('que_link_origin','que_link_origin',0,0,'',1,'Link gốc của tin trống');
        $myform->add('que_image','que_image',0,0,'');
        $myform->add('que_image_profess','que_image_profess',0,0,'');
        $myform->add('que_type','que_type',1,0,0);
        $myform->add('que_status','que_status',1,0,0);
        $myform->add('que_date','time',1,1,0);
        $myform->removeHTML(0);
        $error_msg = $myform->checkdata();
        if(!$error_msg){
            foreach($_FILES as $key=>$image_file){
                $path_picture = generate_dir_upload($image_file['name'],'organic') . $image_file['name'];
                move_uploaded_file($image_file['tmp_name'],$path_picture);
            }
            $db_insert = new db_execute_return();
            $last_id = $db_insert->db_execute($myform->generate_insert_SQL());
            unset($db_insert);
            $api_result = array('success'=>1,'id'=>$last_id,'sql'=>$myform->generate_insert_SQL());
        }else{
            $api_result = array('error'=>1,'msg'=>$myform->checkdata() . $myform->generate_insert_SQL());
        }
        break;
}
