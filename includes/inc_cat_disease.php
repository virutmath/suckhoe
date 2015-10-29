<?
$filter_doituong = array(
    DOITUONG_TREEM => 'Trẻ em',
    DOITUONG_NAMGIOI => 'Nam giới',
    DOITUONG_NUGIOI => 'Nữ giới',
    DOITUONG_NGUOICAOTUOI => 'Người cao tuổi'
);
$filter_dotuoi = array(
    DOTUOI_TRE_SO_SINH => '0 - 6 tháng',
    DOTUOI_NHI_DONG => '1 - 6 tuổi',
    DOTUOI_THIEU_NIEN => '6 - 18 tuổi',
    DOTUOI_TRUONG_THANH => '19 - 51 tuổi',
    DOTUOI_CAO_TUOI => 'Trên 51 tuổi'
);
$filter_theomua = array(
    BENH_THEO_MUA_XUAN => 'Xuân',
    BENH_THEO_MUA_HA => 'Hạ',
    BENH_THEO_MUA_THU => 'Thu',
    BENH_THEO_MUA_DONG => 'Đông'
);
$filter_hecoquan = array(
    HE_VAN_DONG => 'Hệ vận động',
    HE_THAN_KINH => 'Hệ thần kinh',
    HE_TIEU_HOA => 'Hệ tiêu hóa',
    HE_TUAN_HOAN => 'Hệ tuần hoàn',
    HE_HO_HAP => 'Hệ hô hấp',
    HE_BAI_TIET => 'Hệ bài tiết',
    HE_NOI_TIET => 'Hệ nội tiết',
    HE_GIAC_QUAN => 'Hệ giác quan',
    HE_SINH_DUC => 'Hệ sinh dục',
    HE_MIEN_DICH => 'Hệ miễn dịch',
    HE_BACH_HUYET => 'Hệ bạch huyết',
    HE_VO_BOC => 'Hệ vỏ bọc'
);


$rainTpl->assign('filter_doituong', $filter_doituong);
$rainTpl->assign('filter_dotuoi', $filter_dotuoi);
$rainTpl->assign('filter_theomua', $filter_theomua);
$rainTpl->assign('filter_hecoquan', $filter_hecoquan);


if ($sec_id) {
    $db_query = new db_query('SELECT sec_desc,sec_parent_id,sec_name,sec_type,sec_picture FROM sections WHERE sec_id = ' . $sec_id);
    if ($row = mysqli_fetch_assoc($db_query->result)) {
        $section_exist = true;
        $sec_desc = $row['sec_desc'];
        $sec_name = $row['sec_name'];
        $sec_type = $row['sec_type'];
        $sec_picture = get_picture_path($row['sec_picture']);
        if ($row['sec_parent_id']) {
            //Day la bo phan child
            $is_section_child = true;
            $sec_parent_id = $row['sec_parent_id'];
        } else {
            $is_section_child = false;
        }
    } else {
        //chua co section nao duoc goi
        $section_exist = false;
    }
    unset($db_query);
} else {
    $section_exist = false;
}
//chi hien thi 1 group section
$list_section = array();
if ($section_exist) {
    if ($is_section_child) {
        //day la bo phan cap 2 - yeu cau lay bo phan cha va cac bo phan anh em
        $sql_section = 'SELECT
                            t3.sec_name,
                            t3.sec_id,
                            t2.sec_name AS sec_parent_name,
                            t2.sec_id AS sec_parent_id,
                            t2.sec_type AS sec_type
                        FROM
                            sections AS t1 STRAIGHT_JOIN sections AS t2 ON (t1.sec_parent_id = t2.sec_id) STRAIGHT_JOIN sections AS t3 ON (
                                t1.sec_parent_id = t3.sec_parent_id
                            )
                        WHERE
                            t1.sec_id = ' . $sec_id;
        $db_query = new db_query($sql_section);
        while ($row = mysqli_fetch_assoc($db_query->result)) {
            if($sec_id == $row['sec_parent_id']){
                $list_section['is_active'] = 1;
            }
            if($sec_id == $row['sec_id']){
                $row['is_active'] = 1;
            }
            $list_section['sec_name']       = $row['sec_parent_name'];
            $list_section['sec_id']         = $row['sec_parent_id'];
            $list_section['sec_type']       = $row['sec_type'];
            $list_section['link_detail']    = generate_section_detail(array('sec_id'=>$row['sec_parent_id'],'sec_name'=>$row['sec_parent_name']));
            $row['link_detail']             = generate_section_detail($row);
            $list_section['sec_child'][]    = $row;
        }
        unset($db_query);
    } else {
        //day la bo phan cap 1, lay ra cac bo phan con cua no
        $sql_section = 'SELECT
                            sec_name,sec_id
                        FROM sections
                        WHERE sec_parent_id = '.$sec_id;
        $db_query = new db_query($sql_section);
        $list_section['is_active'] = 1;
        $list_section['sec_name'] = $sec_name;
        $list_section['sec_type'] = $sec_type;
        $list_section['sec_id'] = $sec_id;
        $list_section['link_detail']    = generate_section_detail(array('sec_id'=>$sec_id,'sec_name'=>$sec_name));
        $list_section['sec_desc'] = $sec_desc;
        while ($row = mysqli_fetch_assoc($db_query->result)) {
            $row['link_detail']             = generate_section_detail($row);
            $list_section['sec_child'][]    = $row;
        }
        unset($db_query);
    }
} else {
    //neu khong co section
    $db_query = new db_query('SELECT * FROM sections WHERE sec_parent_id = 0 LIMIT 1');
    if ($row = mysqli_fetch_assoc($db_query->result)) {
        $list_section['sec_id']         = $row['sec_id'];
        $list_section['sec_name']       = $row['sec_name'];
        $sec_name                       = $row['sec_name'];
        $sec_desc                       = $row['sec_desc'];
        $sec_picture                    = get_picture_path($row['sec_picture']);
        $list_section['link_detail']    = generate_section_detail($list_section);
        $list_section['sec_child']      = array();
        $db_child                       = new db_query('SELECT * FROM sections WHERE sec_parent_id = ' . $row['sec_id']);
        while ($row_child = mysqli_fetch_assoc($db_child->result)) {
            $row_child['link_detail'] = generate_section_detail($row_child);
            $list_section['sec_child'][] = $row_child;
        }
    }
    unset($db_query);
}

$rainTpl->assign('section_exits', $section_exist);
if ($section_exist) {
    $rainTpl->assign('is_section_child', $is_section_child);
}
$sec_id = $sec_id ? $sec_id : $list_section['sec_id'];
$rainTpl->assign('sec_id',$sec_id);
$rainTpl->assign('sec_name',$sec_name);
$rainTpl->assign('sec_desc',$sec_desc);
$rainTpl->assign('list_section', $list_section);

//query ra các bệnh thường gặp ở bộ phận này
$db_disease = new db_query('SELECT
                                cdi_name,
                                cdi_id,
                                sec_name
                            FROM
                                cat_disease
                            LEFT JOIN disease_section ON dse_disease_id = cdi_id
                            LEFT JOIN sections ON sec_id = dse_section_id
                            WHERE
                                dse_section_id = '.$sec_id.'
                            ORDER BY
                                cdi_popular DESC
                            LIMIT 10');
$list_disease = array();
while($row = mysqli_fetch_assoc($db_disease->result)){
    $row['link_detail'] = generate_disease_detail($row);
    $list_disease[] = $row;
}unset($db_disease);

//khối sơ đồ cơ thể
$anatomy_sex        = get_cookie_anatomy_sex();
$anatomy_sex_str    = getValue('anatomy-sex','str','COOKIE','male',3);
$anatomy_type       = isset($list_section['sec_type']) ? $list_section['sec_type'] : SECTION_TYPE_FRONT;
$back_active        = $anatomy_type == SECTION_TYPE_BACK ? 'active' : '';
$front_active       = $anatomy_type == SECTION_TYPE_FRONT ? 'active' : '';
$sex_male_active    = $anatomy_sex == DOITUONG_NAMGIOI ? 'color-base' : 'text-muted';
$sex_female_active  = $anatomy_sex == DOITUONG_NUGIOI ? 'color-base' : 'text-muted';
$anatomy_data       = get_anatomy_data($anatomy_sex, $anatomy_type);


$rainTpl->assign('list_disease',$list_disease);
$rainTpl->assign('anatomy_data', $anatomy_data);
$rainTpl->assign('anatomy_sex_str',$anatomy_sex_str);
$rainTpl->assign('front_active', $front_active);
$rainTpl->assign('back_active', $back_active);
$rainTpl->assign('sex_male_active',$sex_male_active);
$rainTpl->assign('sex_female_active',$sex_female_active);