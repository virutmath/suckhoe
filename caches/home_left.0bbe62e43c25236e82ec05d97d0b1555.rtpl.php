<?php if(!class_exists('raintpl')){exit;}?><div class="news-slide-top">
    <div class="news-slide-viewer pull-left">
        <?php echo $tpl_constants['loading_image'];?>
        <a href="#">
            <img src="" alt="Loadding..." class="hidden"/>
        </a>
        <h1 id="home-h1" class="hidden"></h1>
    </div>
    <div class="news-slide-listing pull-left">
        <h4 class="text-muted">
            <em><?php echo $tpl_constants['string_wday'];?></em>
            <b><?php echo $tpl_constants['string_date'];?></b>
        </h4>
        <ul>
            <?php $counter1=-1; if( isset($news_release) && is_array($news_release) && sizeof($news_release) ) foreach( $news_release as $key1 => $value1 ){ $counter1++; ?>
            <li data-link="<?php echo $value1["link_detail"];?>" data-img="<?php echo $value1["new_picture"];?>" data-title="<?php echo $value1["new_title"];?>">
                <span class="caret-control-slide"></span>
                <a href="<?php echo $value1["link_detail"];?>">
                    <span class="fa fa-square color-base"></span>
                    <h3><?php echo $value1["new_title"];?></h3>
                </a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<div class="clearfix"></div>
<div class="list-hot-tsk">
    <h3></h3>
    <ul class="list-inline">
        <?php $counter1=-1; if( isset($list_news_tsk['array_news']) && is_array($list_news_tsk['array_news']) && sizeof($list_news_tsk['array_news']) ) foreach( $list_news_tsk['array_news'] as $key1 => $value1 ){ $counter1++; ?>
        <li>
            <a href="<?php echo $value1["link_detail"];?>" title="<?php echo $value1["new_title"];?>"><img src="<?php echo $value1["new_picture"];?>" alt="<?php echo $value1["new_title"];?>"/></a>
            <h3 class="h3-title">
                <a href="<?php echo $value1["link_detail"];?>" title="<?php echo $value1["new_title"];?>"><?php echo $value1["new_title"];?></a>
            </h3>
        </li>
        <?php } ?>
    </ul>
</div><!-- Ket thuc phan tin tuc thoi su -->
<div class="section-fullwidth">
    <div id="easycare" class="pull-left">
        <script type="text/javascript">
            var maJsHost = "http://easycare.vn/";
            var maJsKey = "";
            var maJsWidth = "";
            var maJsHeight = "";
            document.write(
                    unescape(
                            '%3Cscript src="'+maJsHost+'assets/easycare_frontend/js/widget.js" type="text/javascript"%3E%3C/script%3E'
                    )
            );
        </script>
    </div>
    <div id="catch-disease" class="pull-left">
        <div class="pull-left">
            <h3><a href="<?php echo $link_catch_disease;?>">Bắt bệnh</a></h3>
            <span class="text-muted">Các bệnh thường gặp</span>
        </div>
        <div id="sidebar-anatomy-detail"></div>
        <div id="home-anatomy">
            <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("anatomy_image") . ( substr("anatomy_image",-1,1) != "/" ? "/" : "" ) . basename("anatomy_image") );?>
        </div>
        <div id="sidebar-anatomy-control">
            <div>
                <div class="ana-image-sex">
                    <span class="fa fa-female <?php echo $sex_female_active;?>" onclick="load_anatomy_image('female')"></span>
                    <span class="fa fa-male <?php echo $sex_male_active;?>" onclick="load_anatomy_image('male')"></span>
                    <input type="hidden" id="map-anatomy-sex" value="<?php echo $anatomy_sex_str;?>"/>
                </div>
            </div>
            <div>
                <div class="ana-image-view">
                    <span class="ana-image-view-front active" onclick="load_anatomy_image('front')">Chính diện</span>
                    <span class="ana-image-view-back" onclick="load_anatomy_image('back')">Đằng sau</span>
                    <input type="hidden" id="map-anatomy-view" value="front"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-fullwidth">
    <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("box_qaa") . ( substr("box_qaa",-1,1) != "/" ? "/" : "" ) . basename("box_qaa") );?>
</div>
<div class="list-news-category">
    <?php $counter1=-1; if( isset($list_news_category) && is_array($list_news_category) && sizeof($list_news_category) ) foreach( $list_news_category as $key1 => $value1 ){ $counter1++; ?>
    <div class="news-category-home">
        <h3><a href="<?php echo $value1["link_cat"];?>"><?php echo $value1["cat_name"];?></a></h3>
        <ul>
            <?php $counter2=-1; if( isset($value1["array_news"]) && is_array($value1["array_news"]) && sizeof($value1["array_news"]) ) foreach( $value1["array_news"] as $key2 => $value2 ){ $counter2++; ?>
            <?php if( $value2["is_first"] ){ ?>
            <li>
                <div class="thumb">
                    <a href="<?php echo $value2["link_detail"];?>" title="<?php echo $value2["new_title"];?>"><img src="<?php echo $value2["new_picture"];?>" alt="<?php echo $value2["new_title"];?>"/></a>
                </div>
                <a href="<?php echo $value2["link_detail"];?>" title="<?php echo $value2["new_title"];?>"><h3><?php echo $value2["new_title"];?></h3></a>
            </li>
            <?php }else{ ?>
            <li>
                <a href="<?php echo $value2["link_detail"];?>">
                    <span class="fa fa-square color-base"></span>
                    <h3>
                    <?php echo $value2["new_title"];?>
                    </h3>
                </a>
            </li>
            <?php } ?>
            <?php } ?>
        </ul>
    </div>
    <?php } ?>
</div>