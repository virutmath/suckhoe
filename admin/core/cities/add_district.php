<?
require_once 'inc_security.php';
checkPermission('add');
//list thành phố
$array_city = array(0=>'Chọn tỉnh/thành phố');
$db_city = new db_query('SELECT cit_id,cit_name FROM cities ORDER BY cit_name');
while($row = mysqli_fetch_assoc($db_city->result)){
    $array_city[$row['cit_id']] = $row['cit_name'];
}
#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table_district);
$myform->add('dis_city_id','dis_city_id',1,0,0,1,'Bạn chưa chọn tỉnh/thành phố');
$myform->add('dis_name','dis_name',0,0,'',1,'Bạn chưa nhập tên quận/huyện');
$myform->add('dis_static_fee','dis_static_fee',1,0,0);
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    if(!$bg_errorMsg){
        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute($myform->generate_insert_SQL());
        $form_redirect = getValue('form_redirect','str','POST','');
        redirect($form_redirect);
    }
}
#Phần hiển thị
$rainTpl = new RainTPL();
$rainTpl->assign('load_header',$load_header);
$rainTpl->assign('module_name',$module_name);
$rainTpl->assign('error_msg',print_error_msg($bg_errorMsg));

$html_page = '';
$form = new form();
$html_page .= $form->form_open('add_new');
$html_page .= $form->textnote('Các trường có dấu (<span class="form-asterick">*</span>) là bắt buộc nhập');

$html_page .= $form->select(array(
    'label'=>'Chọn tỉnh/thành phố',
    'name'=>'dis_city_id',
    'id'=>'dis_city_id',
    'require'=>1,
    'option'=>$array_city,
    'selected'=>getValue('dis_city_id','int','POST',0),
    'errorMsg'=>'Bạn chưa chọn tỉnh - thành phố'
));
$html_page .= $form->text(array(
    'label'=>'Nhập tên quận - huyện',
    'name'=>'dis_name',
    'id'=>'dis_name',
    'value'=>getValue('dis_name','str','POST',''),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên quận - huyện'
));

$html_page .= $form->number(array(
    'label'=>'Phí ship cố định',
    'name'=>'dis_static_fee',
    'id'=>'dis_static_fee',
    'addon'=>'VNĐ',
    'value'=>getValue('dis_static_fee','int','POST',0)
));
$html_page .= $form->form_redirect(array(
    'list'=>array('Thêm mới'=>'add_district.php','Danh sách'=>'listing.php')
));
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');