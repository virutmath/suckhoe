<?
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '192.168.0.108'){
    define('DB_USER','root');
    define('DB_NAME','suckhoe');
    define('DB_PASS','');
}else{
    define('DB_USER','sql_vcamp');
    define('DB_NAME','db_vcamp');
    define('DB_PASS','cmYTgzcytBVz79D8FstWr7i79');
}