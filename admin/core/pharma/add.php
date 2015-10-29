<?
require_once 'inc_security.php';
checkPermission('add');

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
/**
 * Something here ...
 * insert, update...
 */
$myform->add('pha_name','pha_name',0,0,'',1);
$myform->add('pha_title','pha_title',0,0,'',1);
$myform->add('pha_description','pha_description',0,0,'',0);
$myform->add('pha_content','pha_content',0,0,'',0);
$myform->add('pha_so_dang_ky','pha_so_dang_ky',0,0,'',1);
$myform->add('pha_dang_bao_che','pha_dang_bao_che',0,0,'',0);
$myform->add('pha_dong_goi','pha_dong_goi',0,0,'',0);
$myform->add('pha_gia_buon','pha_gia_buon',0,0,'',0);
$myform->add('pha_gia_le','pha_gia_le',0,0,'',0);
$pha_nha_sx_name = getValue('pha_nha_sx_name','str','POST','');
$check_id_nsx = new db_query('SELECT phc_id 
                              FROM pharma_company 
                              WHERE phc_name = "'.$pha_nha_sx_name.'" 
                              LIMIT 1');
$check_id_nsx = mysqli_fetch_assoc($check_id_nsx->result);
if($check_id_nsx && $check_id_nsx['phc_id']){
    $check_id_nsx = $check_id_nsx['phc_id'];
    $myform->add('pha_nha_sx_id','check_id_nsx',1,1,0);
}else{
    //insert tên công ty vào bảng pharma_company
    $insert_id_nsx = new db_execute_return();
    $id_nsx = $insert_id_nsx->db_execute('INSERT INTO pharma_company (phc_name) 
                                          VALUES("'.$pha_nha_sx_name.'")');
    $myform->add('pha_nha_sx_id','id_nsx',1,1,0);
}

$pha_nha_dk_name = getValue('pha_nha_dk_name','str','POST','');
$check_id_ndk = new db_query('SELECT phc_id 
                              FROM pharma_company 
                              WHERE phc_name = "'.$pha_nha_dk_name.'" 
                              LIMIT 1');
$check_id_ndk = mysqli_fetch_assoc($check_id_ndk->result);
if($check_id_ndk && $check_id_ndk['phc_id']){
    $check_id_ndk = $check_id_ndk['phc_id'];
    $myform->add('pha_nha_dk_id','check_id_ndk',1,1,0);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    
    $myform->add('pha_nha_dk_name','pha_nha_dk_name',0,1,
        '');
}else{
    //insert tên công ty vào bảng pharma_company
    $insert_id_ndk = new db_execute_return();
    $id_ndk = $insert_id_ndk->db_execute('INSERT INTO pharma_company (phc_name) 
                                          VALUES("'.$pha_nha_sx_name.'")');
    $myform->add('pha_nha_dk_id','id_ndk',1,1,0);
    $myform->add('pha_nha_dk_name','pha_nha_dk_name',0,1,
        '');
}

$pha_nhom_duoc_ly = getValue('pha_nhom_duoc_ly','str','POST','');
$check_id_ndl = new db_query('SELECT phg_id 
                              FROM pharma_group 
                              WHERE phg_name = "'.$pha_nhom_duoc_ly.'" 
                              LIMIT 1');
$check_id_ndl = mysqli_fetch_assoc($check_id_ndl->result);

if($check_id_ndl && $check_id_ndl['phg_id']){
    $check_id_ndl = $check_id_ndl['phg_id'];
    $myform->add('pha_nhom_duoc_ly_id','check_id_ndl',1,1,0);


}else{
    $insert_id_ndl = new db_execute_return();
    $id_ndl = $insert_id_ndl->db_execute('INSERT INTO pharma_group (phg_name) 
                                          VALUES("'.$pha_nhom_duoc_ly.'")');
    $myform->add('pha_nhom_duoc_ly_id','id_ndl',1,1,0);
}
$myform->add('pha_thanh_phan','pha_thanh_phan',0,0,'',1);
$myform->add('pha_ham_luong','pha_ham_luong',0,0,'',0);
$myform->add('pha_chi_dinh','pha_chi_dinh',0,0,'',1);
$myform->add('pha_chong_chi_dinh','pha_chong_chi_dinh',0,0,'',0);
$myform->add('pha_tuong_tac_thuoc','pha_tuong_tac_thuoc',0,0,'',0);
$myform->add('pha_tac_dung_phu','pha_tac_dung_phu',0,0,'',0);
$myform->add('pha_chu_y_de_phong','pha_chu_y_de_phong',0,0,'',0);
$myform->add('pha_lieu_luong','pha_lieu_luong',0,0,'',0);
$myform->add('pha_bao_quan','pha_bao_quan',0,0,'',0);
$myform->add('pha_bestseller','pha_bestseller',1,0,'',0);



$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    var_dump($myform->generate_insert_SQL());
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        //update ảnh
        $pha_image = getValue('pha_image','str','POST','');
        if($pha_image){
            $myform->add('pha_image','pha_image',0,1,'');
            //move ảnh
            generate_dir_upload($pha_image,'organic');
            $path_upload = '../../..'.get_picture_dir($pha_image).'/'.$pha_image;
            rename('../../../temp/'.$pha_image,$path_upload);
        }
        $db_insert = new db_execute_return();

        $last_id = $db_insert->db_execute($myform->generate_insert_SQL());unset($db_insert);

        /**
         * something code here
         */


        //redirect
        if($last_id){
            redirect($form_redirect);
        }
    }
}


#Phần hiển thị
$rainTpl = new RainTPL();
$rainTpl->assign('load_header',$load_header);
$rainTpl->assign('module_name',$module_name);
$rainTpl->assign('error_msg',print_error_msg($bg_errorMsg));

$html_page = '';
$form = new form();
$html_page .= $form->form_open();
$html_page .= $form->textnote('Các trường có dấu (<span class="form-asterick">*</span>) là bắt buộc nhập');



/**
 * something here
 */
$html_page .= $form->text(array(
    'label'=>'Tên thuốc', //tên của input
    'name'=>'pha_name', //tên form của input
    'id'=>'pha_name',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg'=>'Bạn chưa nhập tên thuốc', //lỗi khi ko nhập khi require = 1 thì alert lên
    'placeholder'=>'tên thuốc', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Tiêu đề thuốc', //tên của input
    'name'=>'pha_title', //tên form của input
    'id'=>'pha_title',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg'=>'Bạn chưa nhập tiêu đề thuốc', //lỗi khi ko nhập khi require = 1 thì alert lên
    'placeholder'=>'tiêu đề thuốc', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));

$html_page .= $form->tinyMCE('Mô tả','pha_description','pha_description',getValue('pha_description','str','POST',''));
$html_page .= $form->tinyMCE('Chi tiết thuốc','pha_content','pha_content',getValue('pha_content','str','POST',''));
$html_page .= $form->text(array(
    'label'=>'Mã đăng ký', //tên của input
    'name'=>'pha_so_dang_ky', //tên form của input
    'id'=>'pha_so_dang_ky',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg' => 'Bạn chưa nhập mã đăng ký',
    'placeholder'=>'Mã đăng ký', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Dạng bào chế', //tên của input
    'name'=>'pha_dang_bao_che', //tên form của input
    'id'=>'pha_dang_bao_che',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg' => 'Bạn chưa nhập dạng bào chế',
    'placeholder'=>'Dạng bào chế', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Đóng gói', //tên của input
    'name'=>'pha_dong_goi', //tên form của input
    'id'=>'pha_dong_goi',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'Pha đóng gói', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Giá bán buôn', //tên của input
    'name'=>'pha_gia_buon', //tên form của input
    'id'=>'pha_gia_buon',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Giá bán lẻ', //tên của input
    'name'=>'pha_gia_le', //tên form của input
    'id'=>'pha_gia_le',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Nhà sản xuất', //tên của input
    'name'=>'pha_nha_sx_name', //tên form của input
    'id'=>'pha_nha_sx_name',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Nhà đăng ký', //tên của input
    'name'=>'pha_nha_dk_name', //tên form của input
    'id'=>'pha_nha_dk_name',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Nhóm dược lý', //tên của input
    'name'=>'pha_nhom_duoc_ly', //tên form của input
    'id'=>'pha_nhom_duoc_ly',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg' => 'Bạn chưa nhập nhóm dược lý',
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));

$html_page .= $form->textarea(array(
    'label'=>'Thành phần', //tên của input
    'name'=>'pha_thanh_phan', //tên form của input
    'id'=>'pha_thanh_phan',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg' => 'Bạn chưa nhập thành phần',
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Hàm lượng', //tên của input
    'name'=>'pha_ham_luong', //tên form của input
    'id'=>'pha_ham_luong',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Chỉ định', //tên của input
    'name'=>'pha_chi_dinh', //tên form của input
    'id'=>'pha_chi_dinh',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>1, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg' => 'Bạn chưa nhập chỉ định thuốc',
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Chống chỉ định', //tên của input
    'name'=>'pha_chong_chi_dinh', //tên form của input
    'id'=>'pha_chong_chi_dinh',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Tương tác thuốc', //tên của input
    'name'=>'pha_tuong_tac_thuoc', //tên form của input
    'id'=>'pha_tuong_tac_thuoc',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Tác dụng phụ', //tên của input
    'name'=>'pha_tac_dung_phu', //tên form của input
    'id'=>'pha_tac_dung_phu',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Chú ý đề phòng', //tên của input
    'name'=>'pha_chu_y_de_phong', //tên form của input
    'id'=>'pha_chu_y_de_phong',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Liều lượng', //tên của input
    'name'=>'pha_lieu_luong', //tên form của input
    'id'=>'pha_lieu_luong',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->textarea(array(
    'label'=>'Bảo quản', //tên của input
    'name'=>'pha_bao_quan', //tên form của input
    'id'=>'pha_bao_quan',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh sản phẩm',
    'name'=>'pha_image',
    'id'=>'pha_image',
    'browse_id'=>'btn_picture',
    'viewer_id'=>'viewer_picture',
    'value'=>''
));
$html_page .= $form->text(array(
    'label'=>'Tag', //tên của input
    'name'=>'pha_tag', //tên form của input
    'id'=>'pha_tag',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));
$html_page .= $form->text(array(
    'label'=>'Bán chạy', //tên của input
    'name'=>'pha_bestseller', //tên form của input
    'id'=>'pha_bestseller',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));

$html_page .= file_get_contents('script.html');
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');