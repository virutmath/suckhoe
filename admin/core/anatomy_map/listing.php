<?
require_once 'inc_security.php';
#some config
$ana_sex = $array_sex;
$ana_type = $array_type;

$ana_sec_id = array();
$db_query = new db_query('SELECT sec_id,sec_name FROM sections WHERE sec_parent_id = 0');
while($row = mysqli_fetch_assoc($db_query->result)){
    $ana_sec_id[$row['sec_id']] = $row['sec_name'];
    $db_child = new db_query('SELECT * FROM sections WHERE sec_parent_id = '.$row['sec_id'].' ORDER BY sec_id ASC');
    while($row_child = mysqli_fetch_assoc($db_child->result)){
        $ana_sec_id[$row_child['sec_id']] = ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$row_child['sec_name'];
    }
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
$list->add('ana_title','Title','string',1,1);
$list->add('ana_alt','Alt text', 'string',1,1);
$list->add('ana_sec_id','Bộ phận', 'array',1,0);
$list->add('ana_sex','Sex','array',1,0);
$list->add('ana_type','Type','array',1,0);
$list->add('','Edit','edit');
$list->add('','Delete','delete');

$db_count = new db_count('SELECT count(*) as count
                            FROM '.$bg_table.'
                            LEFT JOIN sections ON sec_id = ana_sec_id
                            WHERE 1 '.$list->sqlSearch().'
                            ');
$total = $db_count->total;unset($db_count);

$db_listing = new db_query('SELECT *
                            FROM '.$bg_table.'
                            LEFT JOIN sections ON sec_id = ana_sec_id
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
        '<td>'.$row['ana_title'].'</td>',
        '<td>'.$row['ana_alt'].'</td>',
        '<td>'.$row['sec_name'].'</td>',
        '<td class="center">'.$array_sex[$row['ana_sex']].'</td>',
        '<td class="center">'.$array_type[$row['ana_type']].'</td>',
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

