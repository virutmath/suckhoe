<?
error_reporting(E_ERROR);
if(!isset($version_number)){
        $version_number = 2;
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
require_once '../classes/Mobile_Detect.php';
require_once '../classes/sphinx/sphinx_keyword.php';
require_once '../classes/generate_form.php';
require_once '../classes/rain.tpl.class.php';
require_once '../classes/simple_html_dom.php';
require_once '../functions/functions.php';
require_once '../functions/function_translate.php';
require_once '../functions/rewrite_functions.php';
require_once '../functions/date_functions.php';


require_once '../includes/inc_config.php';

//check mobile to redirect
$detect = new Mobile_Detect;

// Any mobile device (phones or tablets).
if ( $detect->isMobile() ) {
    move302(DOMAIN_MOBILE . $_SERVER['REQUEST_URI']);
}


$is_pjax = isset($_SERVER["HTTP_X_PJAX"]) && strtolower($_SERVER["HTTP_X_PJAX"]) == 'true';
$pjax_container = $is_pjax && isset($_SERVER['HTTP_X_PJAX_CONTAINER']) ? $_SERVER['HTTP_X_PJAX_CONTAINER'] : '';

$tpl_constants = isset($tpl_constants) ? $tpl_constants : array();
RainTpl::configure("base_url", null );
RainTpl::configure("tpl_dir", "../templates".$_version."/pc/" );
RainTpl::configure("cache_dir", "../caches/" );
RainTPL::configure("path_replace_list",array());
RainTPL::configure("tpl_constants",$tpl_constants);
$rainTpl = new RainTPL();
$rainTpl->assign('base_search_url',generate_base_search_url());
$myuser = new user();