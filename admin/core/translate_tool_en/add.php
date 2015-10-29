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
$myform->add('dic_key','key',0,0,'',1,'Bạn chưa nhập nội dung cần dịch');
$myform->add('dic_translate_en','translate_en',0,0,'',1,'Bạn chưa nhập bản dịch tiếng Anh');
$form_redirect = getValue('form_redirect','str','POST','');
$action = getValue('action','str','POST','');
if($action == 'execute'){
    $bg_errorMsg = $myform->checkdata();
    /**
     * something code here
     */

    //upload file ở đây
    //upload voice giọng nam
    $file_name = 'audio_'.time().'.wav';
    $file_path = '../../../sounds/'.$file_name;
    $upload_voice_en = upload_file('voice_en',$file_path);
    if($upload_voice_en['success']){
        //upload thành công
        $file_name = $upload_voice_en['file_name'];
        $myform->add('dic_voice_en','file_name',0,1,'');
    }else{
        //không thành công, tìm file trong thư mục ghi âm
        $output_recorder = '../../resources/js/recorder/temp/output.wav';
        if(file_exists($output_recorder)){
            //đã ghi âm giọng nam - copy sang thư mục sounds
            if(rename($output_recorder,$file_path)){
                //thêm vào myform
                $myform->add('dic_voice_en','file_name',0,1,'');
            }else{
                $bg_errorMsg .= '&bull;Không thể di chuyển file ghi âm';
            }
        }else{
            $bg_errorMsg .= '&bull;Không tìm thấy file ghi âm';
        }
    }

    //ghi âm giọng nữ
    $file_name_wm = 'audio_woman_'.time().'.wav';
    $file_path = '../../../sounds/'.$file_name_wm;
    $upload_voice_en_wm = upload_file('voice_en_woman',$file_path);
    if($upload_voice_en_wm['success']){
        //upload thành công
        $file_name_wm = $upload_voice_en_wm['file_name'];
        $myform->add('dic_voice_en_woman','file_name_wm',0,1,'');
    }else{
        //không thành công, tìm file trong thư mục ghi âm
        $output_recorder = '../../resources/js/recorder/temp/output_woman.wav';
        if(file_exists($output_recorder)){
            //đã ghi âm giọng nam - copy sang thư mục sounds
            if(rename($output_recorder,$file_path)){
                //thêm vào myform
                $myform->add('dic_voice_en_woman','file_name_wm',0,1,'');
            }else{
                $bg_errorMsg .= '&bull;Không thể di chuyển file ghi âm';
            }
        }else{
            $bg_errorMsg .= '&bull;Không tìm thấy file ghi âm';
        }
    }


    if(!$bg_errorMsg){

        /**
         * something code here
         */

        $db_insert = new db_execute_return();
        $last_id = $db_insert->db_execute($myform->generate_insert_SQL());unset($db_insert);
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
$html_page .= $form->textarea(array(
    'label'=>'Tiếng Việt',
    'name'=>'key',
    'id'=>'key',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập nội dung cần dịch',
    'value'=>getValue('key','str','POST','')
));
$html_page .= $form->textarea(array(
    'label'=> 'Tiếng Anh',
    'name'=>'translate_en',
    'id'=>'translate_en',
    'require'=>1,
    'errorMsg'=>'Bạn chưa nhập bản dịch tiếng Anh',
    'value'=>getValue('translate_en','str','POST','')
));
$html_page .= $form->getFile(array(
    'label'=>'File âm thanh giọng nam',
    'name'=>'voice_en',
    'id'=>'voice_en'
));
$html_page .= $form->getFile(array(
    'label'=>'File âm thanh giọng nữ',
    'name'=>'voice_en_woman',
    'id'=>'voice_en_woman'
));
//ghi âm
$html_page .= $form->form_group_custom('open');
$html_page .= 'hoặc';
$html_page .= $form->form_group_custom('close');
$html_page .= $form->form_group_custom('Ghi âm giọng nam');
$html_page .= '<a class="btn btn-default" onclick="loadModalRecorder(1)">Nhấn nút để bắt đầu</a>';
$html_page .= $form->form_group_custom('close');
$html_page .= $form->form_group_custom('Ghi âm giọng nữ');
$html_page .= '<a class="btn btn-default" onclick="loadModalRecorder(2)">Nhấn nút để bắt đầu</a>';
$html_page .= $form->form_group_custom('close');
$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Thêm mới','Nhập lại'),
    'type'=>array('submit','reset')
));
$html_page .= $form->form_close();
//modal recorder
$html_page .= '<div id="modal-recorder" class="hidden">
                    <div id="modal-iframe">
                        <iframe id="iframe-recorder"></iframe>
                        <button type="button" class="close" onclick="closeModalRecorder()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                </div>';
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');