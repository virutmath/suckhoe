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
$myform->add('cat_name','cat_name',0,0,'',1,'Bạn chưa nhập tên danh mục');
$myform->add('cat_type','cat_type',1,0,0,0);
$myform->add('cat_title','cat_title',0,0,'');
$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        $cat_picture = getValue('cat_picture','str','POST','');
        if($cat_picture){
            $myform->add('cat_picture','cat_picture',0,1,'');
            //move ảnh
            $path_upload = '../../..'.get_picture_dir($cat_picture).'/'.$cat_picture;
            rename('../../../temp/'.$cat_picture,$path_upload);
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
    'label'=>'Tên danh mục',
    'name'=>'cat_name',
    'id'=>'cat_name',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên danh mục'
));
$html_page .= $form->text(array(
    'label'=>'Tiêu đề SEO',
    'name'=>'cat_title',
    'id'=>'cat_title',
    'value'=>getValue('cat_title','str','POST','')
));
$html_page .= $form->select(array(
    'label'=>'Loại danh mục',
    'name'=>'cat_type',
    'id'=>'cat_type',
    'option'=>$array_type
));
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh danh mục',
    'name'=>'cat_picture',
    'id'=>'cat_picture',
    'viewer_id'=>'viewer_id',
    'browse_id'=>'browse_id'
));
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');