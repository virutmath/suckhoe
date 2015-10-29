<?
require_once 'inc_security.php';
checkPermission('edit');
$record_id = getValue('record_id');
$array_cat_hoidap = array(''=>' -- Danh mục hỏi đáp -- ');
$db_query = new db_query('SELECT * FROM categories WHERE cat_type = '.CATEGORY_TYPE_HOIDAP);
while($row = mysqli_fetch_assoc($db_query->result)){
    $array_cat_hoidap[$row['cat_id']] = $row['cat_name'];
}

//danh sách vùng bộ phận
$array_section = array(''=>' -- Bộ phận -- ');
$db_query = new db_query('SELECT * FROM sections WHERE sec_parent_id = 0 ORDER BY sec_id ASC');
while($row = mysqli_fetch_assoc($db_query->result)){
    $array_section[$row['sec_id']] = $row['sec_name'];
    $db_child = new db_query('SELECT * FROM sections WHERE sec_parent_id = '.$row['sec_id'].' ORDER BY sec_id ASC');
    while($row_child = mysqli_fetch_assoc($db_child->result)){
        $array_section[$row_child['sec_id']] = ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$row_child['sec_name'];
    }
}
unset($db_query);
#Phần code xử lý
$que_status = 1;
$myform = new generate_form();
$myform->addTable($bg_table);
$myform->add('que_title','que_title',0,0,'',1,'Bạn chưa nhập tiêu đề');
$myform->add('que_cat_id','que_cat_id',1,0,0,1,'Bạn chưa chọn danh mục hỏi đáp');
$myform->add('que_sec_id','que_sec_id',1,0,0,1,'Bạn chưa chọn bộ phận ảnh hưởng');
$myform->add('que_username','que_username',0,0,'',1,'Bạn chưa nhập tên người hỏi');
$myform->add('que_question_content','que_question_content',0,0,'',1,'Bạn chưa nhập nội dung câu hỏi');
$myform->add('que_answer_content','que_answer_content',0,0,'','Bạn chưa nhập nội dung câu trả lời');
$myform->add('que_professional','que_professional',0,0,'');
$myform->add('que_disease','que_disease',0,0,'');
$myform->add('que_status','que_status',1,1,0);
$myform->add('que_type','que_type',1,0,0);
$myform->removeHTML(0);
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
    //up ảnh
    $que_image = getValue('que_image','str','POST','');
    if($que_image){
        $myform->add('que_image','que_image',0,0,'');
        module_upload_picture($que_image);
    }

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
/**
 * something here
 */
$html_page .= $form->text(array(
    'label'=>'Tiêu đề',
    'name'=>'que_title',
    'id'=>'que_title',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tiêu đề',
    'value'=>getValue('que_title','str','POST',$que_title)
));
$html_page .= $form->text(array(
    'label'=>'Người hỏi',
    'name'=>'que_username',
    'id'=>'que_username',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên người hỏi',
    'value'=>getValue('que_username','str','POST',$que_username)
));
$html_page .= $form->select(array(
    'label'=>'Danh mục hỏi đáp',
    'name'=>'que_cat_id',
    'id'=>'que_cat_id',
    'option'=>$array_cat_hoidap,
    'selected'=>getValue('que_cat_id','int','POST',$que_cat_id),
    'require'=>1,
    'errorMsg'=>'Bạn chưa chọn danh mục hỏi đáp'
));
$html_page .= $form->select(array(
    'label'=>'Bộ phận',
    'name'=>'que_sec_id',
    'id'=>'que_sec_id',
    'option'=>$array_section,
    'selected'=>getValue('que_sec_id','int','POST',$que_sec_id),
    'require'=>1,
    'errorMsg'=>'Bạn chưa chọn bộ phận liên quan'
));
//ảnh đại diện
$html_page .= $form->ajaxUploadFile(array(
    'label'=>'Ảnh đại diện',
    'name'=>'que_image',
    'id'=>'que_image',
    'browse_id'=>'browse_id',
    'viewer_id'=>'viewer_id',
    'value'=>get_picture_path($que_image)
));

$html_page .= $form->textarea(array(
    'label'=>'Nội dung câu hỏi',
    'name'=>'que_question_content',
    'id'=>'que_question_content',
    'value'=>getValue('que_question_content','str','POST',$que_question_content),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập nội dung câu hỏi'
));
$html_page .= $form->tinyMCE('Nội dung trả lời','que_answer_content','que_answer_content',$que_answer_content);



$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Cập nhật','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');