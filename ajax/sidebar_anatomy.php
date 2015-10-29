<?
$action = getValue('action','str','POST','');
switch($action){
    case 'get_section':
        $id_map = getValue('id_map','int','POST',0,3);
        if($id_map){
            $db_query = new db_query('SELECT sec_id,sec_name,sec_desc FROM sections LEFT JOIN anatomy_map ON ana_sec_id = sec_id WHERE ana_id = '.$id_map);
            $sec_data = mysqli_fetch_assoc($db_query->result);unset($db_query);
            //cắt bớt mô tả
            $sec_data['sec_desc'] = cut_string($sec_data['sec_desc'],100);
            //query các bộ phận con
            $db_query = new db_query('SELECT sec_id,sec_name FROM sections WHERE sec_parent_id = '.$sec_data['sec_id']);
            $sec_data['list_sec_child'] = array();
            $cdi_sec_id = array($sec_data['sec_id']);
            while($row = mysqli_fetch_assoc($db_query->result)){
                $row['link_detail'] = generate_section_detail($row);
                $sec_data['list_sec_child'][] = $row;
                $cdi_sec_id[]  = $row['sec_id'];
            }
            unset($db_query);
            //query các bệnh thường gặp
            $sec_data['list_sec_disease'] = array();
            $list_manifest = array();
            $string_sec_id = implode(',',$cdi_sec_id);
            if($string_sec_id){
                $db_query = new db_query('SELECT DISTINCT cdi_id,cdi_name,cdi_man_id
                                      FROM disease_section
                                      LEFT JOIN cat_disease ON cdi_id = dse_disease_id
                                      WHERE dse_section_id IN('.$string_sec_id.')
                                      LIMIT 10');
                while($row = mysqli_fetch_assoc($db_query->result)){
                    $row['link_detail'] = generate_disease_detail($row);
                    $sec_data['list_sec_disease'][] = $row;
                    if($row['cdi_man_id']){
                        $list_manifest[] = $row['cdi_man_id'];
                    }
                }
            }


            //query các triệu chứng thường gặp
            $sec_data['list_sec_manifest'] = array();
            $list_manifest = implode(',',$list_manifest);
            if($list_manifest){
                $db_query = new db_query('SELECT DISTINCT man_id,man_name
                                      FROM manifest
                                      WHERE man_id IN ('.$list_manifest.')
                                      LIMIT 10');
                while($row = mysqli_fetch_assoc($db_query->result)){
                    $row['link_detail'] = generate_cat_disease_url();
                    $sec_data['list_sec_manifest'][] = $row;
                }
            }


            //assign to template
            $rainTpl = new RainTPL();
            $rainTpl->assign('sec_data',$sec_data);
            ob_clean();
            echo $rainTpl->draw('section_detail',1);
        }
        break;
    case 'get_image' :
        $sex = getValue('sex','str','POST','',3);
        $type = getValue('type','str','POST','',3);
        $sex = $sex == 'male' ? DOITUONG_NAMGIOI : DOITUONG_NUGIOI;
        $type = $type == 'front' ? SECTION_TYPE_FRONT : SECTION_TYPE_BACK;

        $anatomy_data = get_anatomy_data($sex,$type);
        $rainTpl = new RainTPL();
        $rainTpl->assign('anatomy_data',$anatomy_data);
        ob_clean();
        echo $rainTpl->draw('anatomy_image',1);
        break;
}