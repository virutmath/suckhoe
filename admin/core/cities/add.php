<?
require_once 'inc_security.php';
checkPermission('add');

#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
$myform->add('cit_name','cit_name',0,0,'',1,'Bạn chưa nhập tên tỉnh - thành phố');
$myform->add('cit_tw','cit_tw',1,0,'');
$myform->add('cit_static_fee','cit_static_fee',1,0,'');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    if(!$bg_errorMsg){
        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute($myform->generate_insert_SQL());
        //insert quận huyện nếu có
        $array_district = getValue('array_district','arr','POST','');
        if($array_district){
            $sql_district = 'INSERT INTO '.$bg_table_district.'(dis_city_id,dis_name) VALUES';
            foreach($array_district as $district){
                if(!$district) continue;
                $district = remove_magic_quote($district);
                $district = removeScript($district);
                $district = removeHTML($district);
                $sql_district .= '('.$last_id.',"'.$district.'"),';
            }
            $sql_district = rtrim($sql_district,',');
            //insert
            $db_insert = new db_execute($sql_district);unset($db_insert);
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

$html_page .= $form->text(array(
    'label'=>'Tỉnh - thành phố',
    'name'=>'cit_name',
    'id'=>'cit_name',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên tỉnh - thành phố'
));
$html_page .= $form->form_group_custom('Quận - huyện - thị xã');
$row_template = new RainTPL();
$row_template->assign('input_name','array_district[]');
$row_template->assign('input_value','');
$row_template->assign('add_btn_label','Thêm giá trị');
$row_template->assign('remove_btn_label','Loại bỏ');
$row_template->assign('row_list');
$html_page .= $row_template->draw('row_insert',1);
$html_page .= $form->form_group_custom('close');
$html_page .= $form->checkbox(array(
    'label'=>'Trực thuộc TW',
    'name'=>'cit_tw',
    'id'=>'cit_tw',
    'value'=>1,
    'currentValue'=>0
));
$html_page .= $form->select(array(
    'label'=>'Phí ship cố định',
    'name'=>'cit_static_fee',
    'id'=>'cit_static_fee',
    'option'=>$array_ship_level
));
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');