<?
require_once 'inc_security.php';
$action = getValue('action','str','POST','');
switch($action){
    case 'load_news_url':
        $return_json = array();
        $url = getValue('url','str','POST','');
        if(!filter_var($url,FILTER_VALIDATE_URL)){
            break;
        }
        $domain = get_domain($url);
        //tìm kiếm domain trong bảng law
        $db_query = new db_query('SELECT * FROM law WHERE law_link_cat LIKE "'.$domain.'%" LIMIT 1');
        $law_detail = mysqli_fetch_assoc($db_query->result);unset($db_query);
        if(!$law_detail){
            break;
        }
        //lấy tin theo luật này
        $news_data = pre_cron_news_detail(array(
            'lin_id'=>0,
            'lin_url'=>$url,
            'lin_cat_id'=>0,
            'law_detail_title'=>$law_detail['law_detail_title'],
            'law_detail_content'=>$law_detail['law_detail_content'],
            'law_detail_teaser'=>$law_detail['law_detail_teaser'],
            'law_detail_tag'=>$law_detail['law_detail_tag'],
            'law_detail_remove'=>$law_detail['law_detail_remove']
        ),1);
        if(!$news_data['success']){
            $return_json['success'] = 0;
            $return_json['error'] = $news_data['error'];
        }else{
            $return_json['success'] = 1;
            $return_json['title'] = $news_data['title'];
            $return_json['content'] = $news_data['content'];
            $return_json['teaser'] = $news_data['teaser'];
            $return_json['picture'] =  $news_data['image'];
            $return_json['link_picture'] = get_picture_path($news_data['image']);
        }

        $return_json = json_encode($return_json);
        echo $return_json;
        break;
    case 'loadCatChild':
        $cat_id = getValue('value','int','POST',0);
        $db = new db_query('SELECT * FROM cat_disease WHERE cdi_parent_id = '.$cat_id);
        while($row = mysqli_fetch_assoc($db->result)){
            echo '<option value="'.$row['cdi_id'].'">'.$row['cdi_name'].'</option>';
        }
        break;
}
exit();