<?
//Cần có 1 mảng config các bảng được check unique và các field được check unique
$table_allow = array(
    //'name'=>'list_field'
    'manufacturers'=>array('man_name'=>1),
    'brands'=>array('bra_name'=>1,'bra_code'=>1)
);
ob_clean();
$table = getValue('table','str','POST','',3);
if(!isset($table_allow[$table])) exit(json_encode(array('unique'=>0)));
$field = getValue('field','str','POST','',3);
if(!isset($table_allow[$table][$field])) exit(json_encode(array('unique'=>0)));
$value = getValue('value','str','POST','',3);
if(!$table || !$field || !$value) exit(json_encode(array('unique'=>0)));
#check unique
$value = trim($value,' ');
$value = str_replace(';','',$value);
$db_query = new db_query('SELECT '.$field.' FROM '.$table.' WHERE '.$field.'="'.$value.'" LIMIT 1');
if($row = mysqli_fetch_assoc($db_query->result)){
    ob_clean();
    echo json_encode(array('unique'=>1));
}else{
    exit(json_encode(array('unique'=>0)));
}
