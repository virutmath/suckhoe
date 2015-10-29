<?
require_once '../home/config.php';
$key = 'a';
$sphinx = new sphinx_keyword($key);
$array_data = $sphinx->search_data(1,10);
var_dump($array_data);