<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html lang="vi" prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-language" content="vi"/>
    <meta name="description" content="<?php echo $meta_description;?>"/>
    <meta name="keyword" content="<?php echo $meta_keyword;?>"/>
    <?php echo $tpl_constants['css_global'];?>
    <?php echo $tpl_constants['js_global'];?>
    <title><?php echo $page_title;?></title>

</head>
<body>
<div id="header">
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("header") . ( substr("header",-1,1) != "/" ? "/" : "" ) . basename("header") );?>
</div>
<div id="wrapper">
    <div id="adv_top" style="padding : 10px 10px 0 10px;">
        <a href="<?php echo $adv_top['adv_link'];?>" target="_blank"><img src="<?php echo $adv_top['adv_image'];?>" alt="<?php echo $adv_top['adv_link'];?>" style="width:100%"/></a>
    </div>
    <div class="wrapper-main">
        <div class="main-content-left pull-left">
            <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("home_left") . ( substr("home_left",-1,1) != "/" ? "/" : "" ) . basename("home_left") );?>
        </div>
        <div class="clearfix"></div>
        <div class="main-content-bottom"></div>
    </div>
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("adv_large_banner") . ( substr("adv_large_banner",-1,1) != "/" ? "/" : "" ) . basename("adv_large_banner") );?>
</div>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("footer") . ( substr("footer",-1,1) != "/" ? "/" : "" ) . basename("footer") );?>
</body>
</html>