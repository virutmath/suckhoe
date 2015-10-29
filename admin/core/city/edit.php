<?
require_once 'inc_security.php';
checkPermission('edit');
$record_id = getValue('record_id');

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);

/**
 * Something here ...
 * insert, update...
 */
$myform->add('cit_name','cit_name',0,0,'',1,'Bạn chưa nhập tên');

$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        $db_update = new db_execute($myform->generate_update_SQL($id_field,$record_id));
        unset($db_update);


        /**
         * something code here
         */


        //redirect
        redirect($form_redirect);
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
//Tạo form input để nhập tên thành phố
$html_page .= $form->text(array(
    'label'=> 'Tên thành phố', //tên của input
    'name'=>'cit_name', //tên form của input
    'id'=>'cit_name',//id html của input
    'value'=>$cit_name, //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg'=>'Bạn chưa nhập tên thành phố', //lỗi khi ko nhập khi require = 1 thì alert lên
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));





$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Cập nhật','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');