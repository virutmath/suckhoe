<?
$action = getValue('action','str','POST','');
switch($action){
    case 'get_section':
        $id_map = getValue('id_map','int','POST',0);
        $db_query = new db_query('SELECT sec_id,sec_name,sec_desc FROM sections LEFT JOIN anatomy_map ON ana_sec_id = sec_id WHERE ana_id = '.$id_map);
        $list_section = mysqli_fetch_assoc($db_query->result);unset($db_query);
        $list_section['link_detail'] = generate_section_detail($list_section);
        //query các bộ phận con
        $db_query = new db_query('SELECT sec_id,sec_name FROM sections WHERE sec_parent_id = '.$list_section['sec_id']);
        $list_section['sec_child'] = array();
        $cdi_sec_id = array($sec_data['sec_id']);
        while($row = mysqli_fetch_assoc($db_query->result)){
            $row['link_detail'] = generate_section_detail($row);
            $list_section['sec_child'][] = $row;
        }
        unset($db_query);

        //assign to template
        $rainTpl = new RainTPL();
        $rainTpl->assign('list_section',$list_section);
        ob_clean();
        echo $rainTpl->draw('cat_section_list',1);
        break;
}