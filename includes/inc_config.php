<?
include_once 'inc_constant.php';
$cache_version = 2;
$css_global = '';
$css_global .= '<meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />';
$css_global .= '<meta name="robots" content="noodp,index,follow" />';
$css_global .= '<meta http-equiv="content-language" content="vi" />';
$css_global .= '<link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/css/bootstrap.min.css"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/css/font-awesome.css"/>';
$css_global .= '<link rel="stylesheet" type="text/css" href="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/css/main.css?v='.$cache_version.'"/>';

$js_global = '';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/jquery.min.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/bootstrap.min.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/jquery.autocomplete.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/jquery.storageapi.min.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/jquery.pjax.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/mapper.js"></script>';
$js_global .= '<script type="text/javascript" src="'.DOMAIN_STATIC.'/themes'.$_version.'/pc/js/main.js?v='.$cache_version.'"></script>';
//google analytics
if(!DEBUG_LOCAL){
    $js_global .= '<script>
                (function(i,s,o,g,r,a,m){i["GoogleAnalyticsObject"]=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,"script","//www.google-analytics.com/analytics.js","ga");
                ga("require","displayfeatures");
                ga("create", "UA-55614065-1", "auto");
                ga("send", "pageview");
            </script>';

    $js_global .=  '<script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&appId=1561038610796934&version=v2.0";
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, "script", "facebook-jssdk"));</script>';

}



$tpl_constants = array(
    'css_global'=>$css_global,
    'js_global'=>$js_global,
    'loading_image'=>'<span class="fa fa-refresh fa-spin"></span>',
    'string_time'=>getDateTime(),
    'string_wday'=> getDateTime(1,1,0,0,''),
    'string_date'=>'Ngày '.date('d/m'),
    'fanpage_link'=>'https://www.facebook.com/suckhoeankhang',
    'global_page'=>getValue('page') > 1 ? getValue('page') : 1
);
