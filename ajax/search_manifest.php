<?
ob_clean();
$keyword = getValue('query','str','GET','',2);
if($keyword){
    $db_query = new db_query('SELECT * FROM manifest WHERE man_name LIKE "%'.$keyword.'%" ORDER BY man_name LIMIT 10');
    $array_return = array('suggestions'=>array());
    $array_return['query'] = $keyword;
    while($row = mysqli_fetch_assoc($db_query->result)){
        $array_return['suggestions'][] = $row['man_name'];
        $array_return['data'][] = $row;
    }
    echo json_encode($array_return);
    exit();
}