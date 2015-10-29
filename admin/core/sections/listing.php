<?
require_once 'inc_security.php';
#some config
$sec_type = $array_type;
$sec_body_system = $array_he_co_quan;
$db_query = new db_query('SELECT sec_id,sec_name FROM sections WHERE sec_parent_id = 0');
while($row = mysqli_fetch_assoc($db_query->result)){
    $sec_parent_id[$row['sec_id']] = $row['sec_name'];
}
unset($db_query);

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
$list->add('','');
$list->add('sec_name','Tên bộ phận','string',1,1);
$list->add('sec_parent_id','Nhóm bộ phận','array',1,0);
$list->add('sec_type','Loại','array',1,0);
$list->add('sec_body_system','Hệ cơ quan','array',1,0);
$list->add('','Mô tả');
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
    $row['sec_picture'] = get_picture_path($row['sec_picture'],'small');
    $array_td = array(
        #some other td missing - put yours here
        '<td class="center" width="150"><img src="'.$row['sec_picture'].'" /></td>',
        '<td class="center">'.$row['sec_name'].'</td>',
        '<td class="center">'.($row['sec_parent_id'] ? $sec_parent_id[$row['sec_parent_id']] : '').'</td>',
        '<td class="center">'.$array_type[$row['sec_type']].'</td>',
        '<td class="center">'.($row['sec_body_system'] ? $array_he_co_quan[$row['sec_body_system']] : '').'</td>',
        '<td width="500">'.$row['sec_desc'].'</td>',
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

