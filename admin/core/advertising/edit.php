<?
require_once 'inc_security.php';
checkPermission('edit');
$record_id = getValue('record_id');

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
$myform->add('adv_name','adv_name',0,0,'',1,'Bạn chưa nhập tên quảng cáo');
$myform->add('adv_link','adv_link',0,0,'');
$myform->add('adv_position','adv_position',1,0,0);
$myform->add('adv_active','adv_active',1,0,0);
/**
 * Something here ...
 * insert, update...
 */

$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    //up ảnh
    $adv_image = getValue('adv_image','str','POST','');
    if($adv_image){
        $myform->add('adv_image','adv_image',0,0,'');
        module_upload_picture($adv_image);
    }
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
$html_page .= $form->text(array(
    'label'=>'Tên quảng cáo',
    'name'=>'adv_name',
    'id'=>'adv_name',
    'value'=>getValue('adv_name','str','POST',$adv_name),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên quảng cáo'
));
$html_page .= $form->text(array(
    'label'=>'Link',
    'name'=>'adv_link',
    'id'=>'adv_link',
    'value'=>getValue('adv_link','str','POST',$adv_link)
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh',
    'name'=>'adv_image',
    'id'=>'adv_image',
    'browse_id'=>'browse_id',
    'viewer_id'=>'viewer_id',
    'value'=>get_picture_path($adv_image)
));
$html_page .= $form->select(array(
    'label'=>'Vị trí',
    'name'=>'adv_position',
    'id'=>'adv_position',
    'option'=>$array_position,
    'selected'=>$adv_position
));
$html_page .= $form->checkbox(array(
    'label'=>'Kích hoạt',
    'name'=>'adv_active',
    'id'=>'adv_active',
    'value'=>1,
    'currentValue'=>$adv_active
));


$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Cập nhật','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');