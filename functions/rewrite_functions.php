<?
function removeTitle($string, $keyReplace = "/")
{
    $string = removeAccent($string);
    $string = trim(preg_replace("/[^A-Za-z0-9]/i", " ", $string)); // khong dau
    $string = str_replace(" ", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace($keyReplace, "-", $string);
    return strtolower($string);
}
function generate_cat_url($cat_data = array('cat_id'=>'','cat_name'=>''), $page = 0){
    $ipage = $page > 1 ? '?page='.$page : '';
    return '/'.removeTitle($cat_data['cat_name']).'-'.$cat_data['cat_id'].'.html' . $ipage;
}
function generate_news_detail_url($news_data = array('new_id'=>'', 'new_title'=>'', 'cat_name'=>'')){
    return '/'.removeTitle($news_data['cat_name']).'/'.removeTitle($news_data['new_title']).'-'.$news_data['new_id'].'.html';
}
//link hỏi đáp
function generate_qaa_url($row = array(), $page = 1){
    $page_str = $page > 0 ? '?page='.$page : '';
    if($row){
        return '/hoidap/'.removeTitle($row['cat_name']).'-'.$row['cat_id'].'.html'.$page_str;
    }
    return '/hoidap/'.$page_str;
}
function generate_mbox_url($row = array(), $page = 1){
    $page_str = $page > 0 ? '?page='.$page : '';
    if($row){
        return '/tuthuoc'.removeTitle($row['cat_name']).'-'.$row['cat_id'].'.html'.$page_str;
    }
    return '/tuthuoc'.$page_str;
}
function generate_mbox_cat($row = array(), $page = 1){
    $page_str = $page > 0 ? '?page='.$page : '';
    if($row){
        return '/tuthuoc/'.removeTitle($row['cat_name']).'-'.$row['cat_id'].'.html'.$page_str;
    }else{
        return '/tuthuoc/'.removeTitle($row['cat_name']).'.html';
    }
}
function generate_base_search_url(){
    return '/search';
}
function generate_search_url($page=1,$searchkey,$moreQueryString=''){
    $searchkey = str_replace(' ','+',$searchkey);
    $page_str = '';
   $page_point = $page > 0 ? '&page='.$page : '';
   $page_str .= '/home/search.php?search='.$searchkey;
    if($moreQueryString != ''){
        $page_str .= '&'.$moreQueryString;
    }
    return $page_str.$page_point;
}
//link chi tiet hỏi đáp
function generate_hoidap_detail($row = array()){
    return '/hoidap/'.removeTitle($row['cat_name']).'/'.removeTitle($row['que_title']).'-'.$row['que_id'].'.html';
}
//link tủ thuốc
function generate_medicine_box_url(){
    return '/tuthuoc';
}
function generate_tuthuoc_detail($row = array()){
    return '/tuthuoc/'.removeTitle($row['cat_name']).'/'.removeTitle($row['pha_name']).'-'.$row['pha_id'].'.html';
}
function generate_tuthuoc_cat($row = array()){
    return '/tuthuoc/'.removeTitle($row['cat_name']).'-'.$row['cat_id'].'.html';
}
function generate_cat_disease_url(){
    return '/bat-benh.html';
}
//link đến chi tiết bệnh
function generate_disease_detail($array){
    return '#';
}

//link đến chi tiết triệu chứng
function generate_manifest_detail($array){
    return '#';
}

//link đến chi tiết bộ phận
function generate_section_detail($array){
    return '/bat-benh-benh-ve-'.removeTitle($array['sec_name']).'-'.$array['sec_id'];
}