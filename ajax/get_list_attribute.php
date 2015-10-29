<?
$cat_id = getValue('cat_id','int','POST',0);
$db = new db_query('SELECT *
                    FROM attributes
                    WHERE att_cat_id = '.$cat_id);
while($row = mysqli_fetch_assoc($db->result)){
    switch($row['att_type']){
        case ATTRIBUTE_TYPE_CHECKBOX:
            $list = array();
            //select ra value cua attribute nay
            $db_value = new db_query('SELECT * FROM attribute_values WHERE atv_attribute_id = '.$row['att_id']);
            while($row_v = mysqli_fetch_assoc($db_value->result)){
                $list[] = array(
                    'name'=>'atv_'.$row_v['atv_id'],
                    'id'=>'atv_'.$row_v['atv_id'],
                    'value'=>1,
                    'label'=>$row_v['atv_value'],
                    'is_check'=>0
                );
            }
            $attribute = array(
                'label'=>$row['att_name'],
                'name'=>'att_'.$row['att_id'],
                'id'=>'att_'.$row['att_id'],
                'require'=>1,
                'errorMsg'=>'',
                'list'=>$list
            );
            $form = new form();
            echo $form->list_checkbox($attribute);
            break;
        case ATTRIBUTE_TYPE_DROPDOWN :
            $list = array();
            //select ra value cua attribute nay
            $db_value = new db_query('SELECT * FROM attribute_values WHERE atv_attribute_id = '.$row['att_id']);
            $option = array();
            while($row_v = mysqli_fetch_assoc($db_value->result)){
                $option[$row_v['atv_id']] = $row_v['atv_value'];
            }
            $form = new form();
            echo $form->select(array(
                'label'=>$row['att_name'],
                'name'=>'att_'.$row['att_id'],
                'id'=>'att_'.$row['att_id'],
                'require'=>1,
                'option'=>$option
            ));
            break;
    }

}