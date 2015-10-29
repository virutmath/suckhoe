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
 *
 */
$list->add('cdi_id','ID','string',1,1);
$list->add('cdi_name','Tên bệnh','string',1,1);
$list->add('','Hệ cơ quan');
$list->add('','Danh mục hỏi đáp');
$list->add('','Đối tượng');
$list->add('','Độ tuổi');
$list->add('','Theo mùa');
$list->add('','Truyền nhiễm');
$list->add('','Thường gặp');
$list->add('','Edit','edit');
$list->add('','Delete','delete');
$extra_search = '';
$cdi_parent_id = getValue('cdi_parent_id','int','GET',0);
if($cdi_parent_id){
    $extra_search .= ' AND cdi_parent_id = '.$cdi_parent_id;
}

$db_count = new db_count('SELECT count(*) as count
                            FROM '.$bg_table.'
                            WHERE 1 '.$list->sqlSearch(). $extra_search .'
                            ');
$total = $db_count->total;unset($db_count);

$db_listing = new db_query('SELECT *
                            FROM '.$bg_table.'
                            WHERE 1 '.$list->sqlSearch(). $extra_search .'
                            ORDER BY '.$list->sqlSort().' '.$id_field.' ASC
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
    //lấy ra category hỏi đáp
    $cat_hoidap = array();
    if($row['cdi_cat_hoidap_id']){
        $db_cat_hoidap = new db_query('SELECT cat_name FROM categories WHERE cat_id IN ('.$row['cdi_cat_hoidap_id'].')');
        while($row_cat_hoidap = mysqli_fetch_assoc($db_cat_hoidap->result)){
            $cat_hoidap[] = $row_cat_hoidap['cat_name'];
        }
        $cat_hoidap = implode(', ',$cat_hoidap);
    }else{
        $cat_hoidap = '';
    }
    //lấy ra đối tượng
    $row_doi_tuong = $row['cdi_doi_tuong'] ? explode(',',$row['cdi_doi_tuong']) : array();
    $cat_doi_tuong = array();
    foreach($row_doi_tuong as $dt_int){
        $cat_doi_tuong[] = $array_doi_tuong[$dt_int];
    }
    $cat_doi_tuong = implode(', ',$cat_doi_tuong);
    //lấy ra độ tuổi
    $row_do_tuoi = $row['cdi_do_tuoi'] ? explode(',',$row['cdi_do_tuoi']) : array();
    $cat_do_tuoi = array();
    foreach($row_do_tuoi as $dt_int){
        $cat_do_tuoi[] = $array_do_tuoi[$dt_int];
    }
    $cat_do_tuoi = implode(', ',$cat_do_tuoi);
    //lấy ra bệnh theo mùa
    $row_theo_mua = $row['cdi_theo_mua'] ? explode(',',$row['cdi_theo_mua']) : array();
    $cat_theo_mua = array();
    foreach($row_theo_mua as $dt_int){
        $cat_theo_mua[] = $array_theo_mua[$dt_int];
    }
    $cat_theo_mua = implode(', ',$cat_theo_mua);

    $array_td = array(
        #some other td missing - put yours here
        '<td class="center">'.$row['cdi_id'].'</td>',
        '<td>'.$row['cdi_name'].'</td>',
        '<td>'.(isset($array_he_co_quan[$row['cdi_body_system']]) ? $array_he_co_quan[$row['cdi_body_system']] : '').'</td>',
        '<td style="max-width:200px;">'.$cat_hoidap.'</td>',
        '<td>'.$cat_doi_tuong.'</td>',
        '<td>'.$cat_do_tuoi.'</td>',
        '<td>'.$cat_theo_mua.'</td>',
        $list->showCheckbox('cdi_truyen_nhiem',$row['cdi_truyen_nhiem'],$row[$id_field]),
        $list->showCheckbox('cdi_popular',$row['cdi_popular'],$row[$id_field]),
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

