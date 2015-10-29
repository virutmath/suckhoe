<?php if(!class_exists('raintpl')){exit;}?><div id="footer">
    <div id="footer-main">
        <h3 class="text-thin text-uppercase color-base no-margin">khang.vn - trang thông tin y tế sức khỏe, tư vấn khám
            chữa bệnh, tra cứu dữ liệu y tế hàng đầu Việt Nam</h3>

        <p class="text-left">
            Khang.vn mang đến thông tin thời sự về sức khỏe, đời sống y tế cập nhật trong ngày. Ngoài ra khang.vn
            còn cung cấp một thư viện kiến thức về các bệnh thường gặp, bệnh truyền nhiễm, bệnh nhiệt đới, trang bị cho
            bạn
            những hiểu biết cơ bản để phòng tránh một số bệnh thường gặp, giúp bạn giao tiếp và nhận được tư vấn từ các
            bác sĩ
            chuyên môn cũng như những chia sẻ kinh nghiệm từ cộng đồng người dùng khang.vn
        </p>
    </div>
    <div id="footer-footer">
        <div id="footer-footer-main">
            <div class="footer-top">
                <em class="text-left pull-left">2007 - 2014 &copy; Khang Team </em>
                <ul class="pull-right list-inline">
                    <li>
                        <a href="<?php echo $tpl_constants['fanpage_link'];?>"><span class="icon-facebook"><i
                                class="fa fa-facebook"></i></span></a>
                    </li>
                    <li>
                        <a href="#"><span class="icon-twitter"><i class="fa fa-twitter"></i></span></a>
                    </li>
                    <li>
                        <a href="#"><span class="icon-youtube"><i class="fa fa-youtube"></i></span></a>
                    </li>
                </ul>
            </div>
            <hr/>
            <div class="footer-bottom">
                <span>Cẩm nang sức khỏe Khang.vn</span>

                <div class="info-khang">
                    <span>Liên hệ : hotro.khang.vn@gmail.com</span>
                    <span>Trang thông tin điện tử đang chờ giấy phép của Bộ VHTT</span>
                </div>

            </div>
        </div>
    </div>

    <div id="anatomy-image-preload" style="width:1px;height:1px;overflow: hidden">
        <img src="/themes/pc/img/nam-truoc.jpg" alt=""/>
        <img src="/themes/pc/img/nam-sau.jpg" alt=""/>
        <img src="/themes/pc/img/nu-truoc.jpg" alt=""/>
        <img src="/themes/pc/img/nu-sau.jpg" alt=""/>
    </div>
</div>
<?php if( $myuser->logged() ){ ?>
<div id="form-add-question">
    <div class="form-content-wrap">
        <div class="form-content">
            <form class="form-horizontal" method="post" role="form">
                <div class="form-header">Thông tin bệnh nhân</div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-8">
                        <input type="email" class="form-control" readonly/>
                        <span class="help-block"><small>Email của bạn sẽ được giữ bí mật</small></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Họ tên</label>

                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="patient_name"/>
                        <span class="help-block"><small>Phần này sẽ được hiển thị trong câu hỏi của bạn</small></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Địa chỉ</label>

                    <div class="col-sm-8">
                        <input type="email" class="form-control" name="patient_contact"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Tuổi</label>

                    <div class="col-sm-3">
                        <input type="email" class="form-control" name="patient_age"/>
                    </div>
                    <label class="col-sm-2 control-label">Điện thoại</label>

                    <div class="col-sm-3">
                        <input type="phone" class="form-control" name="patient_phone"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Cân nặng</label>

                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="email" class="form-control text-right" name="patient_weight"/>
                            <span class="input-group-addon">kg</span>
                        </div>
                    </div>
                    <label class="col-sm-2 control-label">Chiều cao</label>

                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="email" class="form-control text-right" name="patient_height"/>
                            <span class="input-group-addon">cm</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Chọn bệnh</label>

                    <div class="col-sm-3">
                        <select name="que_cat_id" class="form-control">
                            <?php $counter1=-1; if( isset($list_category_hoidap) && is_array($list_category_hoidap) && sizeof($list_category_hoidap) ) foreach( $list_category_hoidap as $key1 => $value1 ){ $counter1++; ?>
                            <option value="<?php echo $value1["cat_id"];?>"><?php echo $value1["cat_name"];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label class="col-sm-2 control-label">Đối tượng</label>

                    <div class="col-sm-3">
                        <select class="form-control" name="que_doituong">
                            <?php $counter1=-1; if( isset($filter_doituong) && is_array($filter_doituong) && sizeof($filter_doituong) ) foreach( $filter_doituong as $key1 => $value1 ){ $counter1++; ?>
                            <option value="<?php echo $key1;?>"><?php echo $value1;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Bộ phận</label>

                    <div class="col-sm-8">
                        <select class="form-control" name="que_sec_id">
                            <option value=""> -- Chọn bộ phận --</option>
                            <?php $counter1=-1; if( isset($filter_section) && is_array($filter_section) && sizeof($filter_section) ) foreach( $filter_section as $key1 => $value1 ){ $counter1++; ?>
                            <option value="<?php echo $key1;?>"><?php echo $value1;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Triệu chứng</label>

                    <div class="col-sm-8">
                        <input type="text" name="search_man_id" id="search_man_id" class="form-control auto-search-input"
                               placeholder="Nhập triệu chứng để tìm kiếm..." data-onselect="callback_manifest"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-sm-10">
                        <div id="wrap-list-manifest"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>
<div id="overlay"></div>
<div id="fb-root"></div>
<script lang="javascript">
    (function() {var _h1= document.getElementsByTagName("title")[0] || false;
        var product_name = ""; if(_h1){product_name= _h1.textContent || _h1.innerText;}var ga = document.createElement("script"); ga.type = "text/javascript";
        ga.src = "//live.vnpgroup.net/js/web_client_box.php?hash=5fae10239172918a62dab2e4d330c339&data=eyJoYXNoIjoiODY5ZmViOWVhOWYxOGViZDNlNDhhNmZhMDQ3NjdkMWMiLCJzc29faWQiOjExM30-&pname="+product_name;
        var s = document.getElementsByTagName("script");s[0].parentNode.insertBefore(ga, s[0]);})();
</script>
<div id="fbl-btn" style="position: absolute;width : 5px;height: 5px;overflow: hidden">
    <iframe id="idfacebook" style="position: absolute;left:-105px;top:-32px;"
            src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/suckhoeankhang&amp;width&amp;layout=button&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=35&amp;appId=1561038610796934"
            scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:35px;"
            allowTransparency="true"></iframe>
</div>
<script>
    window.fbAsyncInit = function () {
        // init the FB JS SDK
        FB.init({
            appId: '1561038610796934',                        // App ID from the app dashboard
            status: true,                                 // Check Facebook Login status
            xfbml: true,                                  // Look for social plugins on the page
            version    : 'v2.0'
        });
        FB.getLoginStatus(function (response) {
            if (response.status == 'not_authorized' || response.status == 'connected') {
                showlike();
                //console.log(response.status);
            }
        });
    };


    function showlike() {
        var opacity = 0;
        var faceLike = $.cookie("fVisitor");
        var likes = $("#fbl-btn");
        if (faceLike == 1) {

        } else {
            $(document).mousemove(function (e) {
                likes.css({'left': (e.pageX - 3) + 'px', 'top': (e.pageY - 3) + 'px', 'opacity':opacity})
                if ($(document.activeElement).attr('id') == "idfacebook") {
                    $.cookie("fVisitor", 1, {expires: 1, path: '/'});
                    likes.remove();
                    if (window.addEventListener) {
                        document.removeEventListener("mousemove", mouse, false);
                    }
                    else if (window.attachEvent) {
                        document.detachEvent("onmousemove", mouse);
                    }
                }
            });
        }
    }
</script>