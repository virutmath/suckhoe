<?
require_once '../../includes/inc_constant.php';
$css_global = '';
$css_global .= '<meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />';
$css_global .= '<meta name="robots" content="noodp,index,follow" />';
$css_global .= '<meta http-equiv="content-language" content="vi" />';

$css_global .= '<link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC_MOBILE.'/themes'.$_version.'/mobile/css/font-awesome.css"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC_MOBILE.'/themes'.$_version.'/mobile/css/main.css"/>';
$css_global .= '<!--[if IE]><link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC_MOBILE.'/themes'.$_version.'/mobile/css/fix_ie.css" /><![endif]-->';

$js_global = '';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC_MOBILE.'/themes'.$_version.'/mobile/js/lazy.min.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC_MOBILE.'/themes'.$_version.'/mobile/js/main.js"></script>';
//GA
if(!DEBUG_LOCAL){
    $js_global .= '<script>
      (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,"script","//www.google-analytics.com/analytics.js","ga");

      ga("create", "UA-55614065-2", "auto");
      ga("send", "pageview");
    </script>';
}

//template constans
$tpl_constants = array(
    'css_global'=>$css_global,
    'js_global'=>$js_global,
    'string_time'=>date('d/m/Y | H:i',TIMESTAMP),
    'global_page'=>getValue('page') > 1 ? getValue('page') : 1
);