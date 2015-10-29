<?php
include('../classes/images.class.php');
include('../classes/rain.tpl.class.php');
include '../functions/functions.php';
RainTpl::configure("base_url", null );
RainTpl::configure("tpl_dir", "../templates/pc/" );
RainTpl::configure("cache_dir", "../caches/" );
RainTPL::configure("path_replace_list",array());

//kich thuoc anh
//large : 480x360 - medium : 240x180 - small 106x80 - crop vuong thumb : 50x50
//mobile 640x400 - mobile medium 320x200 mobile small 120x75
function resizeImage(){
    //lay duong dan file duoc request
    $request = $_SERVER['REQUEST_URI'];
    //lay ten file
    $tmp_request = explode('/',$request);
    $case = count($tmp_request);
    $image_name = $tmp_request[$case - 1];
    //type resize
    $resize_type = $tmp_request[$case - 2];
    //echo $image_name;
    $resource_img = get_picture_dir($image_name) . '/' . $image_name;
    $resource_img = '..' . $resource_img;
    if(!file_exists($resource_img)){
        error_404_document();
    };
    //echo file_get_contents($resource_img);exit();
    $images = new Image($resource_img);
    $imageinfo = $images->getImageInfo();
    if($imageinfo['height'] == null || $imageinfo['height'] == 0){
        error_404_document();
    }
    //kich thuoc resize
    $array_resize = array(
        'large'=>array(480,360),
        'medium'=>array(240,180),
        'medium2'=>array(145,95),
        'small'=>array(106,80),
        'thumb'=>array(50,50),
        'mobile'=>array(640,400),
        'mobile_medium'=>array(320,200),
        'mobile_small'=>array(120,75),
        'mobile_low'=>array(640,400,30),
        'mobile_medium_low'=>array(320,200,30),
        'mobile_small_low'=>array(120,75,30),
    );
    if(!isset($array_resize[$resize_type])){
        error_404_document();
    }
    //image name file no extension
    $filesavename = explode('.', $image_name);
    $count3 = count($filesavename);
    if($count3 > 1){
        unset($filesavename[$count3-1]);
    }
    $filesavename = implode('.', $filesavename);
    $pathsave = '..'.get_picture_dir($image_name,$resize_type);
    //nếu thư mục ảnh không tồn tại thì tạo mới
    if(!file_exists($pathsave)){
        mkdir($pathsave,0755,1);
    }
    //echo $pathsave;die();
    //kich thuoc resize ok -> tao file voi kich thuoc phu hop
    $r_width = $array_resize[$resize_type][0];
    $r_height = $array_resize[$resize_type][1];
    if(isset($array_resize[$resize_type][2])){
        $r_quality = $array_resize[$resize_type][2];
    }else{
        $r_quality = 100;
    }
    if($resize_type == 'organic'){
        $images->resize($r_width, $r_height, 'fit', 'c', 'c', $r_quality);
    }else{
        $images->resize($r_width, $r_height, 'crop', 'c', 'c', $r_quality);
    }

    $images->save($filesavename, $pathsave);
    header("HTTP/1.0 200 OK");
    $images->display();
}
resizeImage();