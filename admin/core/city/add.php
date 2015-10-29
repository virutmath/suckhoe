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
/**
    *1). $data_field                 : Ten truong
    *2). $data_value                 : Ten form
    *3). $data_type              : Kieu du lieu , 0 : string , 1 : kieu int, 2 : kieu email, 3 : kieu double, 4 : kieu hash password
    *4). $data_store                 : Noi luu giu data  0 : post, 1 : variable
    *5). $data_default_value         : Gia tri mac dinh, neu require thi phai lon hon hoac bang default
    *6). $data_require           : Du lieu nay co can thiet hay khong
    *7). $data_error_message         : Loi dua ra man hinh
    *8). $data_unique            : Chi co duy nhat trong database
    *9). $data_error_message2     : Loi dua ra man hinh neu co duplicate
    *10). $type_form: kiểu form   : 1 text ; 2 textarea; 3 kiểu checkbook
    */
    //function add($data_field, $data_value, $data_type, $data_store, $data_default_value, $data_require=0, $data_error_message="", $data_unique=0, $data_error_message2="",$type_form = 0){

$myform->add('cit_name','cit_name',0,0,'',1,'Bạn chưa nhập tên');


$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
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


//Tạo form input để nhập tên thành phố
$html_page .= $form->text(array(
    'label'=> 'Tên thành phố', //tên của input
    'name'=>'cit_name', //tên form của input
    'id'=>'cit_name',//id html của input
    'value'=>'', //giá trị hiện thời của input
    'require'=>0, //yêu cầu nhập hay ko - cái này khai báo thì check = javascript
    'errorMsg'=>'Bạn chưa nhập tên thành phố', //lỗi khi ko nhập khi require = 1 thì alert lên
    'placeholder'=>'', //placeholder của html,
    'isdatepicker'=>0, //hiển thị lịch để chọn ngày tháng năm
    'helpblock'=>'', //đoạn text hướng dẫn hiển thị ngay dưới input
));







$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');