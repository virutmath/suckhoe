<?
require_once 'inc_security.php';
#some config


#Phần hiển thị
$rainTpl = new RainTPL();
$rainTpl->assign('load_header',$load_header);
$rainTpl->assign('module_name',$module_name);

#Bắt đầu với datagrid
$list = new dataGrid($id_field,30);
$list->add('cit_name','Tỉnh/thành phố','string',1,1);
$list->add('','Quận/huyện');
$list->add('cit_tw','Trực thuộc TW','string');
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
    //Quận huyện tương ứng
    $db_district = new db_query('SELECT * FROM '.$bg_table_district.' WHERE dis_city_id = '.$row['cit_id'].' ORDER BY dis_name ASC');
    $array_district = array();
    while($row_d = mysqli_fetch_assoc($db_district->result)){
        $array_district[$row_d['dis_id']] = $row_d['dis_name'];
    }
    unset($db_district);
    if(!$array_district){
        $array_district = array(''=>'Chưa có');
    }
    $array_td = array(
        '<td>'.$row['cit_name'].'</td>',
        '<td>'.form_dropdown('',$array_district).'</td>',
        $list->showCheckbox('cit_tw',$row['cit_tw'],$row[$id_field]),
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

