<?
require_once 'config.php';
function get_api_function_name($function)
{
    $action = explode('.', $function);
    $action = end($action);
    return $action;
}

function result_prepare($result, $type = 'json')
{
    if ($type == 'json') {
        ob_clean();
        if (!is_array($result)) {
            $result = array($result);
        }
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($result);
        exit();
    }
}
$function = getValue('function', 'str', 'GET', '');
$api_result = array('error' => 1, 'msg' => 'No callback return');

$users = array('admin' => 'test1234');
$realm = $_SERVER['HTTP_HOST'];

if($function == 'public'){
    include_once 'public.php';
    result_prepare($api_result);
    die();
}

//check_authen();
// analyze the PHP_AUTH_DIGEST variable
/*
if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
    !isset($users[$data['username']])
) {
    header('HTTP/1.1 401 Unauthorized');
    unset($_SERVER['PHP_AUTH_DIGEST']);
    check_authen();
    exit("Xin loi ban ko co quyen");
}
// generate the valid response
$A1 = md5($data['username'] . ':' . $realm . ':' . $users[$data['username']]);
$A2 = md5($_SERVER['REQUEST_METHOD'] . ':' . $data['uri']);
$valid_response = md5($A1 . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $A2);

if (@$data['response'] != $valid_response) {
    header('HTTP/1.1 401 Unauthorized');
    unset($_SERVER['PHP_AUTH_DIGEST']);
    check_authen();
    exit("Xin loi ban ko co quyen");
}
*/
switch ($function) {
    case 'cron.getAlobacsiCatID':
    case 'cron.getAnswerContentEmpty':
    case 'cron.getDiseaseSongKhoeActive':
    case 'cron.getDiseaseSongKhoeDetail':
    case 'cron.getLawActive':
    case 'cron.getLawDetail':
    case 'cron.getSongKhoeCatID':
    case 'cron.resetLaw':
    case 'cron.setLawStatusTemp':
    case 'cron.setDiseaseSongKhoeStatus':
    case 'cron.updateAnswerContentEmpty':
    case 'cron.uploadNews':
    case 'cron.uploadPharma':
    case 'cron.uploadPharmaSecond':
    case 'cron.uploadPharmaCompany':
    case 'cron.uploadPharmaGroup':
    case 'cron.uploadPharmaBrand':
    case 'cron.uploadQuestion':
        $action = get_api_function_name($function);
        include_once 'api_cron.php';
        break;
}
result_prepare($api_result);
