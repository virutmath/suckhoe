<?
define ('DIRSEP', DIRECTORY_SEPARATOR);
$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP;
define ('SITE_PATH', $site_path);
require 'config.php';
$xmlpath = 'ajax_mapping.xml';
$module_name = getValue('name','str','GET','');
$hash        = getValue('hash','int','POST');
if($module_name){
	$xml = new XMLReader;
	$xml->open($xmlpath);
	while($xml->read()){
		if($xml->getAttribute('name')==$module_name){
			$path = $xml->getAttribute('path');
		}	
	}
	if(isset($path)){
	    if($hash == 1) $path = base64_decode($path);
        include SITE_PATH.$path.'.php';
 	}
    else echo 'missing module';     
}
ob_end_flush();