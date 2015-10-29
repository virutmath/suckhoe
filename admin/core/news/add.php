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
$myform->add('new_title','new_title',0,0,'',1,'Bạn chưa nhập tiêu đề');
$myform->add('new_active','new_active',1,0,0,0);

$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        //update ảnh
        $new_picture = getValue('new_picture','str','POST','');
        if($new_picture){
            $myform->add('new_picture','new_picture',0,1,'');
            //move ảnh
            $path_upload = '../../..'.get_picture_dir($new_picture).'/'.$new_picture;
            rename('../../../temp/'.$new_picture,$path_upload);
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
    'label'=>'Tiêu đề tin',
    'name'=>'new_title',
    'id'=>'new_title',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tiêu đề tin'
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh đại diện',
    'name'=>'new_picture',
    'id'=>'new_picture',
    'browse_id'=>'btn_picture',
    'viewer_id'=>'viewer_picture',
    'value'=>''
));
$html_page .= $form->checkbox(array(
    'name'=>'new_active',
    'id'=>'new_active',
    'label'=>'Active',
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