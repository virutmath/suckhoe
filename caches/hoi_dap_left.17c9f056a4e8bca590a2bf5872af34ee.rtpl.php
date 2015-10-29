<?php if(!class_exists('raintpl')){exit;}?><div class="hoidap-left">
    <div id="disease-filter">
        <div class="list-filter">
            <div class="filter-section">
                <div class="filter-name text-uppercase text-thin">
                    <b>Danh mục</b>
                </div>
                <ul class="list-unstyled">
                    <?php $counter1=-1; if( isset($list_category_hoidap) && is_array($list_category_hoidap) && sizeof($list_category_hoidap) ) foreach( $list_category_hoidap as $key1 => $value1 ){ $counter1++; ?>
                    <li>
                        <label>
                            <a href="<?php echo $value1["link_cat"];?>">
                                <?php if( $value1["is_checked"] == 'checked' ){ ?>
                                <b class="checked"><?php echo $value1["cat_name"];?></b>
                                <?php }else{ ?>
                                <b><?php echo $value1["cat_name"];?></b>
                                <?php } ?>
                            </a>
                        </label>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div id="widget-section-left">
        <div id="easycare">
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
    </div>
</div>
