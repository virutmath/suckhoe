<?php if(!class_exists('raintpl')){exit;}?><h1>Hỏi đáp mới nhất tại Khang.vn</h1>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("paging_order_hoidap") . ( substr("paging_order_hoidap",-1,1) != "/" ? "/" : "" ) . basename("paging_order_hoidap") );?>
<div class="list-question">
    <ul class="list-unstyled">
        <?php $counter1=-1; if( isset($list_hoidap) && is_array($list_hoidap) && sizeof($list_hoidap) ) foreach( $list_hoidap as $key1 => $value1 ){ $counter1++; ?>
        <li>
            <?php if( $value1["que_image"] ){ ?>
            <div class="imgthumb pull-left">
                <a href="<?php echo $value1["link_detail"];?>" title="<?php echo $value1["que_title"];?>"><img src="<?php echo $value1["que_image"];?>" alt="<?php echo $value1["que_title"];?>" width="106" height="80"/></a>
            </div>
            <?php } ?>
            <div class="que-info">
                <h3><a href="<?php echo $value1["link_detail"];?>" title="<?php echo $value1["que_title"];?>"><?php echo $value1["que_title"];?></a></h3>
                <time datetime="<?php echo $value1["que_date"];?>"><?php echo $value1["que_date_str"];?></time>
                <p><?php echo $value1["que_question_content"];?></p>
                <span class="read-more pull-right"><a href="<?php echo $value1["link_detail"];?>" title="<?php echo $value1["que_title"];?>">Xem tiếp</a></span>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("paging_order_hoidap") . ( substr("paging_order_hoidap",-1,1) != "/" ? "/" : "" ) . basename("paging_order_hoidap") );?>