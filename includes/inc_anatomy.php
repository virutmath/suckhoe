<?
//lấy ra list các danh mục bệnh
$db_cat_disease = new db_query('SELECT * FROM cat_disease WHERE cdi_parent_id = 0 AND cdi_id <> '.OTHER_DISEASE);
$cat_disease = $db_cat_disease->resultArray();unset($db_cat_disease);
$rainTpl->assign('cat_disease',$cat_disease);