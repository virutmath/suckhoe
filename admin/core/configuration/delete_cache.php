<?
include_once 'inc_security.php';
checkPermission('add');

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
$html_page .= $form->checkbox(array(
    'label'=>'Cache website từ template',
    'name'=>'cache_tpl',
    'id'=>'cache_tpl',

));

$html_page .= $form->form_redirect();
$html_page .= $form->form_action(array(
    'label'=>array('Xóa cache'),
    'type'=>array('submit')
));
$html_page .= $form->form_close();
$rainTpl->assign('html_page',$html_page);
$rainTpl->draw('add');