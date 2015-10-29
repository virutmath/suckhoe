<?php
function notifydie($str){
    $noti = $str ? $str : 'Loi truy van CSDL';
    session_unset();
    session_destroy();
    die($noti);
}

function str_debase($encodedStr=""){
    $returnStr = "";
    if(!empty($encodedStr)) {
        $dec = str_rot13($encodedStr);
        $dec = base64_decode($dec);
        $returnStr = $dec;
    }
    return $returnStr;
}
function print_error_msg($errorMsg){
    if($errorMsg) return '<div class="alert alert-error"><span class="close">&times;</span>'.$errorMsg.'</div>';
    else return '';
}
function module_upload_picture($picture_name){
    generate_dir_upload($picture_name,'organic');
    $path_upload = '../../..'.get_picture_dir($picture_name).'/'.$picture_name;
    return rename('../../../temp/'.$picture_name,$path_upload);
}
?>