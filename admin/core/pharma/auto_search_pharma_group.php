<?
require 'inc_security.php';
$keyword = getValue('query','str','GET','',2);
if($keyword){
    $array_return = array();
    $array_return['suggestions'] = array();
    $array_return['query'] = $keyword;
    $unique_id = array(0);
    $db_query = new db_query('SELECT * FROM pharma_group WHERE phg_name = "'.$keyword.'" ORDER BY phg_name LIMIT 1');
    while($row = mysqli_fetch_assoc($db_query->result)){
        $array_return['suggestions'][] = $row['phg_name'];
        $unique_id[] = $row['phg_id'];
        $array_return['data'][] = $row;
    }unset($db_query);
    $unique_str = implode(',',$unique_id);
    $db_query = new db_query('SELECT * FROM pharma_group WHERE phg_id NOT IN ('.$unique_str.') AND phg_name LIKE "'.$keyword.'%" ORDER BY phg_name LIMIT 10');
    while($row = mysqli_fetch_assoc($db_query->result)){
        $array_return['suggestions'][] = $row['phg_name'];
        $unique_id[] = $row['phg_id'];
        $array_return['data'][] = $row;
    }unset($db_query);
    $unique_str = implode(',',$unique_id);
    $db_query = new db_query('SELECT * FROM pharma_group WHERE phg_id NOT IN ('.$unique_str.') AND phg_name LIKE "%'.$keyword.'%" ORDER BY phg_name LIMIT 10');
    while($row = mysqli_fetch_assoc($db_query->result)){
        $array_return['suggestions'][] = $row['phg_name'];
        $array_return['data'][] = $row;
    }unset($db_query);
    $array_return['suggestions'] = array_unique($array_return['suggestions']);
    $array_return['suggestions'] = array_values($array_return['suggestions']);

    echo json_encode($array_return);
    exit();
}