<?
require_once 'inc_security.php';
checkPermission('add');

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
    'label'=>'Tên quảng cáo',
    'name'=>'adv_name',
    'id'=>'adv_name',
    'value'=>getValue('adv_name','str','POST',''),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên quảng cáo'
));
$html_page .= $form->text(array(
    'label'=>'Link',
    'name'=>'adv_link',
    'id'=>'adv_link',
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh',
    'name'=>'adv_image',
    'id'=>'adv_image',
    'browse_id'=>'browse_id',
    'viewer_id'=>'viewer_id'
));
$html_page .= $form->select(array(
    'label'=>'Vị trí',
    'name'=>'adv_position',
    'id'=>'adv_position',
    'option'=>$array_position
));
$html_page .= $form->checkbox(array(
    'label'=>'Kích hoạt',
    'name'=>'adv_active',
    'id'=>'adv_active',
    'value'=>1,
    'currentValue'=>0
));


$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');