<?
if(!isset($version_number)){
    $version_number = 1;
}
if($version_number > 1){
    $_version = '_v' . $version_number;
}else{
    $_version = '';
}


include("initsession.php");
ob_start();
require_once '../classes/database.php';
require_once '../classes/user.php';
require_once '../classes/sphinx/sphinx_keyword.php';
require_once '../classes/generate_form.php';
require_once '../classes/rain.tpl.class.php';
require_once '../functions/functions.php';
require_once '../functions/mobile_custom_function.php';
require_once '../functions/function_translate.php';
require_once '../functions/rewrite_functions.php';
require_once '../functions/date_functions.php';

require_once '../includes/mobile/inc_config_mobile.php';

$is_pjax = isset($_SERVER["HTTP_X_PJAX"]) && strtolower($_SERVER["HTTP_X_PJAX"]) == 'true';
$pjax_container = $is_pjax && isset($_SERVER['HTTP_X_PJAX_CONTAINER']) ? $_SERVER['HTTP_X_PJAX_CONTAINER'] : '';

$tpl_constants = isset($tpl_constants) ? $tpl_constants : array();
RainTpl::configure("base_url", null );
RainTpl::configure("tpl_dir", "../templates".$_version."/mobile/" );
RainTpl::configure("cache_dir", "../caches/" );
RainTPL::configure("path_replace_list",array());
RainTPL::configure("tpl_constants",$tpl_constants);
$rainTpl = new RainTPL();
