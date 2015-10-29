<?
require_once 'inc_security.php';
#some config
$adv_position = $array_position;

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
$list->add('adv_name','Tên QC','string',1,0);
$list->add('adv_position','Vị trí','array',1,0);
$list->add('adv_link','Đường dẫn','string',1,0);
$list->add('','Ảnh','string',1,0);
$list->add('','Active','string',0,0);
$list->add('','Edit','edit');
$list->add('','Delete','delete');

$db_count = new db_count('SELECT count(*) as count
                            FROM '.$bg_table.'
                            WHERE 1 '.$list->sqlSearch().'
                            ');
$total = $db_count->total;unset($db_count);

$db_listing = new db_query('SELECT *
                            FROM '.$bg_table.'
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
        '<td>'.$row['adv_name'].'</td>',
        '<td>'.$array_position[$row['adv_position']].'</td>',
        '<td>'.$row['adv_link'].'</td>',
        '<td><img src="'.get_picture_path($row['adv_image'],'small').'"/></td>',
        $list->showCheckbox('adv_active',$row['adv_active'],$row[$id_field]),
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

