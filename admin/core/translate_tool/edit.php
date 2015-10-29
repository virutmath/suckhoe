<?
require_once 'inc_security.php';
checkPermission('edit');
$record_id = getValue('record_id');
die('<br><br>Chức năng đang được hoàn thiện!');
#Phần code xử lý
$myform = new generate_form();
$myform->addTable($bg_table);

/**
 * Something here ...
 * insert, update...
 */
$myform->add('dic_key','key',0,0,'',1,'Bạn chưa nhập nội dung cần dịch');
$myform->add('dic_translate_ci','translate_ci',0,0,'',1,'Bạn chưa nhập bản dịch tiếng Trung');

$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */
    $file_name = getValue('file_name','str','POST','');
    if(!$file_name){
        $file_name = 'audio_recording_'.time().'.mp3';
        $file_path = '../../../mp3/'.$file_name;
        $upload_file = upload_file('voice_ci',$file_path);
        if($upload_file){
            $myform->add('dic_voice_ci','file_name',0,1,'',0,'');
        }
    }else{
        $file_path = '../../../mp3/'.$file_name;
        rename('../../resources/js/recordmp3js/recordings/'.$file_name,$file_path);
        $myform->add('dic_voice_ci','file_name',0,1,'',0,'');
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
$html_page .= $form->text(array(
    'label'=>'Tiếng Việt',
    'name'=>'key',
    'id'=>'key',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập nội dung cần dịch',
    'value'=>getValue('key','str','POST',$dic_key)
));
$html_page .= $form->text(array(
    'label'=> 'Tiếng Trung',
    'name'=>'translate_ci',
    'id'=>'translate_ci',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập bản dịch tiếng Trung',
    'value'=>getValue('translate_ci','str','POST',$dic_translate_ci)
));

$html_page .= $form->getFile(array(
    'label'=>'File âm thanh',
    'name'=>'voice_ci',
    'id'=>'voice_ci'
));
$html_page .= $form->form_group_custom('open');
$html_page .= 'hoặc';
$html_page .= $form->form_group_custom('close');
$html_page .= $form->form_group_custom('Ghi âm');
$html_page .= '<button class="btn btn-default" onclick="loadRecorder()" type="button">Nhấn nút để bắt đầu</button>';
$html_page .= $form->form_group_custom('close');
$html_page .= $form->form_group_custom('open');
$html_page .= '<div id="load-record-voice" class="hidden">';
$load_record_tpl = new RainTPL();
$html_page .= $load_record_tpl->draw('loadRecorder',1);
$html_page .= $form->form_margin(20);
$html_page .= '<ul id="recordingslist"></ul>';
$html_page .= $form->form_margin(20);
$html_page .= '<pre id="log"></pre>';
$html_page .= '</div>';
$html_page .= $form->form_group_custom('close');

$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Cập nhật','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');