<?
require_once '../home/config.php';
require_once '../classes/CurlClient.php';
require_once '../classes/MyLog.php';
$db_query = new db_query('SELECT * FROM news
                          LEFT JOIN news_detail ON new_id = ndt_id
                          WHERE new_uploaded = 0 LIMIT 1');
$news_data = mysqli_fetch_assoc($db_query->result);
if(!$news_data){
    reload(3600 * 8);
    die('Hết tin để lấy');
}
$news_data['data_picture'] = '@'.$_SERVER['DOCUMENT_ROOT'].get_picture_path($news_data['new_picture']);

$CurlClient = new CurlClient(10);
$username = 'admin';
$password = 'test1234';
$url_post = 'http://khang.vn/cron/get_news_local.php';
$CurlClient->setAuthenDigest($username,$password);
$response = $CurlClient->post($url_post,$news_data);
if($response){
    echo 'Up thành công tin '.$response;
    //update tin đã upload thành công
    $db_ex = new db_execute('UPDATE news SET new_uploaded = 1 WHERE new_id = '.$news_data['new_id']);
}else{
    echo 'Lỗi';
}
reload(3);