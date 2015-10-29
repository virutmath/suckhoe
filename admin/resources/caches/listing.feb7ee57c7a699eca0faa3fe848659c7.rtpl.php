<?php if(!class_exists('raintpl')){exit;}?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi" xmlns:og="http://ogp.me/ns#"
      xmlns:fb="https://www.facebook.com/2008/fbml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <?php echo $load_header;?>
</head>
<body>
<div class="module_header bold fix"><?php echo $module_name;?></div>
<div id="wrapper">
    <?php echo $table_header;?>
    <?php $counter1=-1; if( isset($table_listing) && is_array($table_listing) && sizeof($table_listing) ) foreach( $table_listing as $key1 => $value1 ){ $counter1++; ?>
        <?php echo $value1["start_tr"];?>
        <?php $counter2=-1; if( isset($value1["array_td"]) && is_array($value1["array_td"]) && sizeof($value1["array_td"]) ) foreach( $value1["array_td"] as $key2 => $value2 ){ $counter2++; ?>
            <?php echo $value2;?>
        <?php } ?>
        <?php echo $value1["end_tr"];?>
    <?php } ?>
    <?php echo $table_footer;?>
</div>
</body>
</html>