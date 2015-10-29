<?
require_once 'inc_security.php';
$action = getValue('action','str','POST','');
switch($action){
    case 'add_manifest' :
        $man_name = getValue('man_name','str','POST','',3);
        $man_name = trim($man_name);
        $man_name = mb_strtolower($man_name,'utf8');
        if(!$man_name){
            exit();
        }
        $db_query = new db_query('SELECT * FROM manifest WHERE man_name = "'.$man_name.'"');
        if(!$row = mysqli_fetch_assoc($db_query->result)){
            $db_insert = new db_execute_return();
            $last_id = $db_insert->db_execute('INSERT INTO manifest(man_name) VALUE("'.$man_name.'")');
            echo json_encode(array('success'=>1,'man_id'=>$last_id,'man_name'=>$man_name));
            exit();
        }
        break;
}