<?
require_once 'inc_security.php';
checkPermission('add');


$ndi_title_md5 = md5(getValue('ndi_title','str','POST',''));

$ndi_cat_id = getValue('ndi_cat_id','arr','POST','');
if($ndi_cat_id)
    $ndi_cat_id = array_unique($ndi_cat_id);
$ndi_cat_id = $ndi_cat_id ? implode(',',$ndi_cat_id) : '';

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
$myform->add('ndi_title','ndi_title',0,0,'',1,'Bạn chưa nhập tiêu đề tin');
$myform->add('ndi_title_md5','ndi_title_md5',0,1,'',1,'',1,'Tin đã tồn tại');
$myform->add('ndi_teaser','ndi_teaser',0,0,'',1,'Tin chưa có mô tả');
$myform->add('ndi_picture','ndi_picture',0,0,'',1,'Bạn chưa nhập ảnh');
$myform->add('ndi_cat_id','ndi_cat_id',0,1,'',1,'Bạn chưa chỉ định danh mục bệnh lý cho tin này');
/**
 * Something here ...
 * insert, update...
 */
$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    if(!$bg_errorMsg){
        //chuyển ảnh đại diện từ thư mục temp sang nếu là ảnh được upload
        $get_from_link = getValue('get_from_link','int','POST',0);
        if(!$get_from_link){
            $picture_temp = getValue('ndi_picture','str','POST',1);
            $path_upload = '../../..'.get_picture_dir($picture_temp).'/'.$picture_temp;
            rename('../../../temp/'.$picture_temp,$path_upload);
        }
        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute($myform->generate_insert_SQL());unset($db_insert);

        /**
         * something code here
         */


        //redirect
        if($last_id){
            //insert detail
            $myform_detail = new generate_form();
            $myform_detail->addTable('news_disease_detail');
            $myform_detail->add('ndi_id','last_id',1,1,0);
            $myform_detail->add('ndi_detail','ndi_detail',0,0,'',1);
            $myform_detail->removeHTML(0);
            $db_insert = new db_execute($myform_detail->generate_insert_SQL());
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
    'label'=>'Nhập tiêu đề tin/URL lấy tin',
    'name'=>'ndi_title',
    'id'=>'ndi_title',
    'value'=>getValue('ndi_title','str','POST',''),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tiêu đề'
));
$html_page .= $form->hidden(array(
    'name'=>'get_from_link',
    'id'=>'get_from_link',
    'value'=>0
));
$html_page .= $form->text(array(
    'name'=>'ndi_disease_id',
    'id'=>'ndi_disease_id',
    'placeholder'=>'Nhập tên bệnh để tìm kiếm'
));


/* Thêm triệu chứng */

$html_page .= $form->select(array(
    'label'=>'Chọn loại tin',
    'name'=>'ndi_type',
    'id'=>'ndi_type',
    'option'=>$array_type,
    'selected'=>getValue('ndi_type','int','POST',0)
));
$html_page .= $form->ajaxUploadForm(array(
    'label'=>'Ảnh đại diện',
    'name'=>'ndi_picture',
    'id'=>'ndi_picture',
    'value'=>'',
    'browse_id'=>'input_picture',
    'viewer_id'=>'view_picture'
));
$html_page .= $form->textarea(array(
    'label'=>'Nhập mô tả',
    'name'=>'ndi_teaser',
    'id'=>'ndi_teaser',
    'value'=>getValue('ndi_teaser','str','POST','')
));
$html_page .= $form->tinyMCE('Chi tiết tin','ndi_detail','ndi_detail',getValue('ndi_detail','str','POST',''));
$html_page .= file_get_contents('script.html');

$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');