<?php if(!class_exists('raintpl')){exit;}?><div class="header-wrapper">
    <div class="header-main">
        <a href="/"><div id="logo" class="pull-left">Khang.vn</div></a>
        <div id="header-search-wrapper" class="pull-left">
            <form action="/search">
                <div class="group-input-search pull-left">
                    <span class="fa fa-search"></span>
                    <input name='search' type="search" placeholder="Gõ tin tức, triệu chứng, bệnh lý, thuốc bạn muốn tìm..." class="form-control"/>
                    <div class="search-filter">
                        <div class="button-filter">
                            <span class="fa fa-filter"></span>
                            <span class="caret"></span>
                        </div>
                        <div class="dropdown-search">
                            <form action="#">
                                <div class="search-title-only">
                                    <div class="checkbox-title-only">
                                        <label><input type="checkbox" name="title_check" value="1">Chỉ tìm tiêu đề</label>
                                    </div>
                                    <a class="checkbox-closed" href="#">Đóng</a>
                                </div>
                                <div class="search-in-list">
                                    <h3>Tìm kiếm trong danh mục</h3>
                                    <ul>
                                        <?php $counter1=-1; if( isset($list_categories_slice) && is_array($list_categories_slice) && sizeof($list_categories_slice) ) foreach( $list_categories_slice as $key1 => $value1 ){ $counter1++; ?>
                                        <?php if( $value1["cat_id"] != 0 ){ ?>
                                        <li><label><input type="checkbox" name="cat_name[]" value="<?php echo $value1["cat_id"];?>"/><?php echo $value1["cat_name"];?></label> </li>
                                        <?php } ?>
                                        <?php } ?>
                                        <li><label><input type="checkbox" name="check_hoidap"  value="1"/>Hỏi đáp</label> </li>

                                    </ul>
                                </div>
                                <div class="search-in-relation">
                                    <h3>Tìm kiếm liên quan</h3>
                                    <ul>
                                        <li class="col-md-8 row"><label><input type="checkbox"  name="check_manifest" value="1"/>Triệu chứng, bệnh lý</label> </li>
                                        <li class="col-md-4"><label><input type="checkbox"  name="check_pharma" value="1"/>Thuốc</label> </li>
                                    </ul>
                                </div>
                                <div class="search-bottom-button">
                                    <button type="submit">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button class="button-input-search pull-left">
                    Tìm kiếm
                </button>
            </form>
            <div class="clearfix"></div>
            <div class="header-tag-link">
                <a href="#">Dịch Ebola</a>
                <a href="#">Đau mắt đỏ</a>
                <a href="#">Cảm cúm</a>
                <a href="#">Nhức đầu</a>
                <a href="#">Sổ mũi</a>
            </div>
        </div>
        <div class="header-right pull-right">
            <div class="header-user">
                <a id="header-login" href="#" class="text-muted">Đăng ký&nbsp;</a>
                <em>|</em>
                <a id="header-register" href="#" class="text-muted">&nbsp;Đăng nhập</a>
            </div>
            <div class="header-go-mobile text-right">
                <span class="fa fa-mobile"></span>
                <abbr title="View on mobile">Bản mobile</abbr>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div class="menu-wrapper">
    <div class="menu-main">
        <ul class="list-inline">
            <?php $counter1=-1; if( isset($list_categories) && is_array($list_categories) && sizeof($list_categories) ) foreach( $list_categories as $key1 => $value1 ){ $counter1++; ?>
            <li class="<?php echo $value1["is_active"]? 'active' : '';?>">
                <a href="<?php echo $value1["link_cat"];?>"><?php echo $value1["cat_name"];?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>