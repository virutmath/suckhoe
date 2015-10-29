<?
require_once 'inc_security.php';
#some config
$new_cat_id = array();
$db_query = new db_query('SELECT * FROM categories');
while($row = mysqli_fetch_assoc($db_query->result)){
    $new_cat_id[$row['cat_id']] = $row['cat_name'];
}
#Phần hiển thị
$rainTpl = new RainTPL();
$rainTpl->assign('load_header',$load_header);
$rainTpl->assign('module_name',$module_name);

#Bắt đầu với datagrid
$list = new dataGrid($id_field,30);
#something config for list dataGrid
/**
 * $list->add('')...etc
 *
 */
$list->add('new_id','ID','string',1,1);
$list->add('new_title','Tiêu đề tin','string',1,1);
$list->add('new_picture','Picture','string',1,0);
$list->add('new_date','Ngày public','date',1);
$list->add('new_cat_id','Danh mục','array',1,1);
$list->add('','Active');
$list->add('','Edit','edit');
$list->add('','Delete','delete');

$db_count = new db_count('SELECT count(*) as count
                            FROM '.$bg_table.'
                            LEFT JOIN categories ON cat_id = new_cat_id
                            WHERE 1 '.$list->sqlSearch().'
                            ');
$total = $db_count->total;unset($db_count);

$db_listing = new db_query('SELECT *
                            FROM '.$bg_table.'
                            LEFT JOIN categories ON cat_id = new_cat_id
                            WHERE 1 '.$list->sqlSearch().'
                            ORDER BY '.$list->sqlSort().' '.$id_field.' DESC
                            '.$list->limit($total));
$total_row = mysqli_num_rows($db_listing->result);
$table_header = $list->showHeader($total_row);
$rainTpl->assign('table_header',$table_header);
$table_footer = $list->showFooter();
$rainTpl->assign('table_footer',$table_footer);
$table_listing = array();
$i = 0;
while($row = mysqli_fetch_assoc($db_listing->result)){
    $i++;
    $array_td = array(
        #some other td missing - put yours here
        '<td class="center">'.$row[$id_field].'</td>',
        '<td>'.$row['new_title'].'</td>',
        '<td>'.$row['new_picture'].'</td>',
        '<td>'.$row['new_date'].' - '. date('d/m/Y H:i',$row['new_date']) .'</td>',
        '<td>'.$new_cat_id[$row['new_cat_id']].'</td>',
        $list->showCheckbox('new_active',$row['new_active'],$row[$id_field]),
        $list->showEdit($row[$id_field]),
        $list->showDelete($row[$id_field])
    );
    $table_listing[] = array(
        'start_tr' => $list->start_tr($i,$row[$id_field]),
        'end_tr'=>$list->end_tr(),
        'array_td'=>$array_td
    );
}
$rainTpl->assign('table_listing',$table_listing);
$rainTpl->draw('listing');

