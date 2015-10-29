<?
require_once 'inc_security.php';
checkPermission('add');
$hcq = array(''=>' -- Hệ cơ quan --');
$array_he_co_quan = $hcq + $array_he_co_quan;
$group_section = array(0=>' -- Chọn nhóm bộ phận --');
$db_query = new db_query('SELECT sec_id,sec_name FROM sections WHERE sec_parent_id = 0');
while($row = mysqli_fetch_assoc($db_query->result)){
    $group_section[$row['sec_id']] = $row['sec_name'];
}
unset($db_query);
#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
/**
 * Something here ...
 * insert, update...
 */
$myform->add('sec_name','sec_name',0,0,'',1,'Bạn chưa nhập tên bộ phận',1,'Bộ phận đã tồn tại');
$myform->add('sec_parent_id','sec_parent_id',1,0,0,0,'');
$myform->add('sec_type','sec_type',1,0,0);
$myform->add('sec_body_system','sec_body_system',1,0,0);
$myform->add('sec_desc','sec_desc',0,0,'');
$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        //lưu ảnh
        $sec_picture = getValue('sec_picture','str','POST','');
        if($sec_picture){
            $myform->add('sec_picture','sec_picture',0,1,'');
            module_upload_picture($sec_picture);
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
    'label'=>'Tên bộ phận',
    'name'=>'sec_name',
    'id'=>'sec_name',
    'require'=>1,
    'value'=>getValue('sec_name','str','POST',''),
    'errorMsg'=>'Bạn chưa nhập tên bộ phận'
));
$html_page .= $form->select(array(
    'label'=>'Thuộc nhóm bộ phận',
    'name'=>'sec_parent_id',
    'id'=>'sec_parent_id',
    'option'=>$group_section,
    'selected'=>getValue('sec_parent_id','int','POST',0)
));
$html_page .= $form->select(array(
    'label'=>'Thuộc loại',
    'name'=>'sec_type',
    'id'=>'sec_type',
    'option'=>$array_type,
    'selected'=>getValue('sec_type','int','POST',0)
));
$html_page .= $form->select(array(
    'label'=>'Thuộc hệ cơ quan',
    'name'=>'sec_body_system',
    'id'=>'sec_body_system',
    'option'=>$array_he_co_quan,
    'selected'=>getValue('sec_body_system','int','POST',0)
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh đại diện',
    'name'=>'sec_picture',
    'id'=>'sec_picture',
    'browse_id'=>'browse_pic',
    'viewer_id'=>'view_pic',
    'value'=>''
));
$html_page .= $form->textarea(array(
    'label'=>'Mô tả về bộ phận',
    'name'=>'sec_desc',
    'id'=>'sec_desc',
    'value'=>getValue('sec_desc','str','POST','')
));
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');