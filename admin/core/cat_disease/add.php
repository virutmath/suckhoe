<?
require_once 'inc_security.php';
checkPermission('add');

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
//danh sách danh mục hỏi đáp
$array_cat_hoidap = array();
$db_query = new db_query('SELECT * FROM categories WHERE cat_type = '.CATEGORY_TYPE_HOIDAP);
while($row = mysqli_fetch_assoc($db_query->result)){
    $array_cat_hoidap[$row['cat_id']] = $row['cat_name'];
}unset($db_query);


$list_checkbox_dotuoi = array();
foreach($array_do_tuoi as $key=>$value){
    $list_checkbox_dotuoi[] = array(
        'name'=>'cdi_do_tuoi[]',
        'id'=>'cdi_do_tuoi'.$key,
        'value'=>$key,
        'label'=>$value
    );
}
$list_checkbox_doituong = array();
foreach($array_doi_tuong as $key=>$value){
    $list_checkbox_doituong[] = array(
        'name'=>'cdi_doi_tuong[]',
        'id'=>'cdi_doi_tuong'.$key,
        'value'=>$key,
        'label'=>$value
    );
}
$list_checkbox_mua = array();
foreach($array_theo_mua as $key=>$value){
    $list_checkbox_mua[] = array(
        'name'=>'cdi_theo_mua[]',
        'id'=>'cdi_theo_mua'.$key,
        'value'=>$key,
        'label'=>$value
    );
}
#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);
/**
 * Something here ...
 * insert, update...
 */
$myform->add('cdi_name','cdi_name',0,0,'',1,'Bạn chưa nhập tên bệnh',1,'Bệnh đã tồn tại');
$myform->add('cdi_name_alias','cdi_name_alias',0,0,'');
$myform->add('cdi_tag','cdi_tag',0,0,'');
$myform->add('cdi_body_system','cdi_body_system',1,0,0);
$myform->add('cdi_popular','cdi_popular',1,0,0);
$myform->add('cdi_truyen_nhiem','cdi_truyen_nhiem',1,0,0);


$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $cdi_sec_id = getValue('cdi_sec_id','arr','POST',array());
    $cdi_sec_id = array_unique($cdi_sec_id);
    $cdi_sec_id = implode(',',$cdi_sec_id);
    $myform->add('cdi_sec_id','cdi_sec_id',0,1,'');

    $cdi_cat_hoidap_id = getValue('cdi_cat_hoidap_id','arr','POST',array());
    $cdi_cat_hoidap_id = array_unique($cdi_cat_hoidap_id);
    $cdi_cat_hoidap_id = implode(',',$cdi_cat_hoidap_id);
    $myform->add('cdi_cat_hoidap_id','cdi_cat_hoidap_id',0,1,'');

    $cdi_man_id = getValue('cdi_man_id','arr','POST',array());
    $cdi_man_id = array_unique($cdi_man_id);
    $cdi_man_id = implode(',',$cdi_man_id);
    $myform->add('cdi_man_id','cdi_man_id',0,1,'');

    $cdi_do_tuoi = getValue('cdi_do_tuoi','arr','POST',array());
    $cdi_do_tuoi = array_unique($cdi_do_tuoi);
    $cdi_do_tuoi = implode(',',$cdi_do_tuoi);
    $myform->add('cdi_do_tuoi','cdi_do_tuoi',0,1,'');

    $cdi_doi_tuong = getValue('cdi_doi_tuong','arr','POST',array());
    $cdi_doi_tuong = array_unique($cdi_doi_tuong);
    $cdi_doi_tuong = implode(',',$cdi_doi_tuong);
    $myform->add('cdi_doi_tuong','cdi_doi_tuong',0,1,'');

    $cdi_theo_mua = getValue('cdi_theo_mua','arr','POST',array());
    $cdi_theo_mua = array_unique($cdi_theo_mua);
    $cdi_theo_mua = implode(',',$cdi_theo_mua);
    $myform->add('cdi_theo_mua','cdi_theo_mua',0,1,'');

    //update trường keyword search
    $cdi_search = '';
    $field_search = getValue('cdi_name','str','POST','',3);
    $cdi_search .= $field_search;

    $field_search = getValue('cdi_name_alias','str','POST','',3);
    $cdi_search .= $field_search;

    $field_search = getValue('cdi_tag','str','POST','',3);
    $cdi_search .= $field_search;

    $cdi_search = mb_strtolower($cdi_search,'utf8');
    $cdi_search = removeSpecialChar($cdi_search);
    $cdi_search = $cdi_search . ' ' . removeAccent($cdi_search);

    $myform->add('cdi_search','cdi_search',0,1,'');


    //Count word và count char từ trường tên
    $cdi_name = getValue('cdi_name','str','POST','', 3);
    $cdi_count_word = count(explode(' ',$cdi_name));
    $cdi_count_char = strlen($cdi_name);

    $myform->add('cdi_count_word','cdi_count_word',1,1,0);
    $myform->add('cdi_count_char','cdi_count_char',1,1,0);

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
        //insert to disease_section
        $array_sec = getValue('cdi_sec_id','arr','POST',array());
        if($array_sec){
            $sql_dis_sec = 'INSERT INTO disease_section(dse_disease_id,dse_section_id) VALUES';
            foreach($array_sec as $sec_id){
                $sql_dis_sec .= '('.$last_id.','.$sec_id.'),';
            }
            $sql_dis_sec = rtrim($sql_dis_sec,',');
            $db_insert = new db_execute($sql_dis_sec);unset($sql_dis_sec);
        }

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

$html_page .= $form->text(array(
    'label'=>'Tên bệnh',
    'name'=>'cdi_name',
    'id'=>'cdi_name',
    'value'=>getValue('cdi_name','str','POST',''),
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập tên bệnh'
));
$html_page .= $form->text(array(
    'label'=>'Tên gọi khác(nếu có)',
    'name'=>'cdi_name_alias',
    'id'=>'cdi_name_alias',
    'value'=>getValue('cdi_name_alias','str','POST','')
));
$html_page .= $form->text(array(
    'label'=>'Từ khóa tìm kiếm',
    'name'=>'cdi_tag',
    'id'=>'cdi_tag',
    'value'=>getValue('cdi_tag','str','POST','')
));
//bộ phận liên quan
$html_page .= $form->select(array(
    'label'=>'Bộ phận liên quan',
    'name'=>'cdi_sec_id[]',
    'id'=>'cdi_sec_id',
    'option'=>$array_section
));
$html_page .= $form->form_group_custom('open');
$html_page .= '<div id="wrap-add-cat" class="row col-sm-3"></div>';
$html_page .= $form->form_group_custom('close');

$html_page .= $form->form_group_custom('open');
$html_page .= '<button type="button" class="btn btn-default" id="add-cat">Thêm lựa chọn</button>';
$html_page .= $form->form_group_custom('close');

//Category hỏi đáp
$html_page .= $form->select(array(
    'label'=>'Danh mục hỏi đáp',
    'name'=>'cdi_cat_hoidap_id[]',
    'id'=>'cdi_cat_hoidap_id',
    'option'=>$array_cat_hoidap
));
$html_page .= $form->form_group_custom('open');
$html_page .= '<div id="wrap-add-cat-hoidap" class="row col-sm-3"></div>';
$html_page .= $form->form_group_custom('close');

$html_page .= $form->form_group_custom('open');
$html_page .= '<button type="button" class="btn btn-default" id="add-cat-hoidap">Thêm lựa chọn</button>';
$html_page .= $form->form_group_custom('close');

//Bệnh theo hệ cơ quan
$html_page .= $form->select(array(
    'label'=>'Hệ cơ quan',
    'name'=>'cdi_body_system',
    'id'=>'cdi_body_system',
    'option'=>$array_he_co_quan,
    'selected'=>getValue('cdi_body_system','int','POST',0)
));

//thêm triệu chứng bệnh
$html_page .= $form->text(array(
    'label'=>'Triệu chứng',
    'name'=>'search_man_id',
    'id'=>'search_man_id',
    'placeholder'=>'Nhập triệu chứng để tìm kiếm...'
));
$html_page .= $form->form_group_custom('open');
$html_page .= '<div id="wrap-list-manifest" class="row col-sm-10"></div>';
$html_page .= $form->form_group_custom('close');

$html_page .= $form->form_group_custom('open');
$html_page .= '<button type="button" class="btn btn-default" id="add-manifest">Thêm nhanh triệu chứng</button>';
$html_page .= $form->form_group_custom('close');


//Độ tuổi
$html_page .= $form->list_checkbox(array(
    'label'=>'Độ tuổi',
    'list'=>$list_checkbox_dotuoi
));
//đối tượng
$html_page .= $form->list_checkbox(array(
    'label'=>'Đối tượng',
    'list'=>$list_checkbox_doituong
));
//theo mùa
$html_page .= $form->list_checkbox(array(
    'label'=>'Bệnh theo mùa',
    'list'=>$list_checkbox_mua
));
//truyền nhiễm
$html_page .= $form->checkbox(array(
    'label'=>'Bệnh truyền nhiễm',
    'name'=>'cdi_truyen_nhiem',
    'id'=>'cdi_truyen_nhiem',
    'value'=>1,
    'currentValue'=>0
));
//thường gặp
$html_page .= $form->checkbox(array(
    'label'=>'Bệnh thường gặp',
    'name'=>'cdi_popular',
    'id'=>'cdi_popular',
    'value'=>1,
    'currentValue'=>0
));

$html_page .= file_get_contents('script.html');
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');