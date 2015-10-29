<?
require_once 'inc_security.php';
checkPermission('edit');
$record_id = getValue('record_id');

//danh sách vùng bộ phận
$array_section = array();
$db_query = new db_query('SELECT * FROM sections WHERE sec_parent_id = 0 ORDER BY sec_id ASC');
while($row = mysqli_fetch_assoc($db_query->result)){
    $array_section[$row['sec_id']] = $row['sec_name'];
    $db_child = new db_query('SELECT * FROM sections WHERE sec_parent_id = '.$row['sec_id'].' ORDER BY sec_id ASC');
    while($row_child = mysqli_fetch_assoc($db_child->result)){
        $array_section[$row_child['sec_id']] = ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$row_child['sec_name'];
    }
}

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);

/**
 * Something here ...
 * insert, update...
 */
$myform->add('ana_sec_id','ana_sec_id',1,0,0,1,'Bạn chưa chọn bộ phận');
$myform->add('ana_title','ana_title',0,0,'');
$myform->add('ana_alt','ana_alt',0,0,'');
$myform->add('ana_coords','ana_coords',0,0,'',1,'Bạn chưa nhập tọa độ');
$myform->add('ana_type','ana_type',1,0,0);
$myform->add('ana_sex','ana_sex',1,0,0);

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
$html_page .= $form->select(array(
    'label'=>'Chọn bộ phận',
    'name'=>'ana_sec_id',
    'id'=>'ana_sec_id',
    'require'=>1,
    'errorMsg'=>'Chưa chọn bộ phận',
    'option'=>$array_section,
    'selected'=>getValue('ana_sec_id','int','POST',$ana_sec_id)
));
$html_page .= $form->text(array(
    'label'=>'Title',
    'name'=>'ana_title',
    'id'=>'ana_title',
    'value'=>getValue('ana_title','str','POST',$ana_title)
));
$html_page .= $form->text(array(
    'label'=>'Alt text',
    'name'=>'ana_alt',
    'id'=>'ana_alt',
    'value'=>getValue('ana_alt','str','POST',$ana_alt)
));
$html_page .= $form->text(array(
    'label'=>'Coords',
    'name'=>'ana_coords',
    'id'=>'ana_coords',
    'require'=>1,
    'errorMsg'=>'Chưa nhập tọa độ vùng map',
    'value'=>getValue('ana_coords','str','POST',$ana_coords)
));
$html_page .= $form->select(array(
    'label'=>'Giới tính',
    'name'=>'ana_sex',
    'id'=>'ana_sex',
    'option'=>$array_sex,
    'selected'=>getValue('ana_sex','int','POST',$ana_sex)
));
$html_page .= $form->select(array(
    'label'=>'Loại',
    'name'=>'ana_type',
    'id'=>'ana_type',
    'option'=>$array_type,
    'selected'=>getValue('ana_type','int','POST',$ana_type)
));

$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Cập nhật','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');