<?
require_once '../security/security.php';
checkLogged();
$keyword = getValue('query','str','GET','',2);
if($keyword){
    $db_query = new db_query('SELECT pro_id,pro_name,pro_price,pro_price_in,pro_code_number
                                FROM products
                                WHERE pro_name LIKE "%'.$keyword.'%"
                                ORDER BY pro_name ASC
                                LIMIT 10');
    $array_return = array('suggestions'=>array());
    $array_return['query'] = $keyword;
    while($row = mysqli_fetch_assoc($db_query->result)){
        $array_return['suggestions'][] = $row['pro_name'] . ' - ' . $row['pro_code_number'];
        $data = array(
            'id' => $row['pro_id'],
            'price' => $row['pro_price'],
            'code' => $row['pro_code_number'],
            'price_in'=>$row['pro_price_in']
        );
        $array_return['data'][] = $data;
    }
    echo json_encode($array_return);
}
