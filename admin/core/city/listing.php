<?
require_once 'inc_security.php';
#some config


#Phần hiển thị
$rainTpl = new RainTPL();
$rainTpl->assign('load_header',$load_header);
$rainTpl->assign('module_name',$module_name);

#Bắt đầu với datagrid
$list = new dataGrid($id_field,30);
#something config for list dataGrid
/**
 * $list->add('')...etc
 *  tham số đầu tiên là form name gửi lên server để cần sắp xếp hoặc search thì get về xử lý
 *  tham số thứ 2 là label -> tên của cột
 *  tham số thứ 3 là kiểu cột : có các kiểu string, edit, delete, checkbox, mặc định là kiểu string
*   tham số thứ 4 là is_search : có cho sắp xếp hay ko, tham số thứ 5 là is_sort có cho tạo khung tìm kiếm theo trường hay ko
 */
$list->add('cit_name','Tên thành phố','string',1,1);
$list->add('','Edit','edit');
$list->add('','Delete','delete');
//$list->addSearch()

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
        '<td>'.$row['cit_name'].'</td>',
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

