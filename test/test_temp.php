<?
require_once '../home/config.php';
$listPhg = new db_query('SELECT phg_id,phg_cat_id FROM pharma_group');
$dataSetPhg = array();
while($row = mysqli_fetch_assoc($listPhg->result)){
    $dataSetPhg[] = $row;
}
foreach($dataSetPhg as $value){
    $listPha = new db_query('UPDATE pharma SET pha_cat_id = '.$value['phg_cat_id'].' WHERE pha_nhom_duoc_ly_id = '.$value['phg_id']);
}
