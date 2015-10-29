<?php if(!class_exists('raintpl')){exit;}?><div id="qaa-sidebar">
    <div class="list-tab">
        <span>Hỏi đáp</span>
        <a href="<?php echo $link_hoidap;?>" class="tab-more-qaa">Xem toàn bộ &raquo;</a>
        <i class="caret"></i>
    </div>
    <div class="clearfix"></div>
    <div class="qaa-disease">
        <ul class="list-inline">
            <?php $counter1=-1; if( isset($list_qaa_sidebar['list_disease']) && is_array($list_qaa_sidebar['list_disease']) && sizeof($list_qaa_sidebar['list_disease']) ) foreach( $list_qaa_sidebar['list_disease'] as $key1 => $value1 ){ $counter1++; ?>
            <li>
                <a href="<?php echo $value1["link_detail"];?>"><?php echo $value1["cdi_name"];?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <ul class="list-qaa-sidebar list-unstyled">
        <?php $counter1=-1; if( isset($list_qaa_sidebar['list_qaa']) && is_array($list_qaa_sidebar['list_qaa']) && sizeof($list_qaa_sidebar['list_qaa']) ) foreach( $list_qaa_sidebar['list_qaa'] as $key1 => $value1 ){ $counter1++; ?>
        <li class="col-xs-4">
            <span class="fa fa-square color-base"></span>
            <h3><a href="<?php echo $value1["link_detail"];?>"><?php echo $value1["que_title"];?></a></h3>
        </li>
        <?php } ?>
    </ul>
</div>