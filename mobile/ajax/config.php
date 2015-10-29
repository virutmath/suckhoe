<?
if(!isset($version_number)){
    $version_number = 2;
}
if($version_number > 1){
    $_version = '_v' . $version_number;
}else{
    $_version = '';
}

ob_start();
require_once '../../classes/database.php';
require_once '../../classes/generate_form.php';
require_once '../../classes/rain.tpl.class.php';
require_once '../../classes/simple_html_dom.php';
require_once '../../functions/functions.php';
require_once '../../functions/mobile_custom_function.php';
require_once '../../functions/function_translate.php';
require_once '../../functions/rewrite_functions.php';
require_once '../../functions/date_functions.php';

require_once '../../includes/inc_constant.php';


RainTpl::configure("base_url", null );
RainTpl::configure("tpl_dir", "../../templates".$_version."/ajax/" );
RainTpl::configure("cache_dir", "../../caches/" );
RainTPL::configure("path_replace_list",array());
