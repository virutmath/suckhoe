<?php
require_once 'inc_security.php';
checkPermission('edit');
$action = getValue('action','str','POST','');
switch($action){
    case 'search_relate':
        $keyword = getValue('keyword','str','POST','');
        if(!$keyword){
            break;
        }
        echo $newsBase->Admin_search_relate($keyword);
    break;
}
?>