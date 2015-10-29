<div class="row col-lg-12">
    <div class="brand-wrapper fl">
        <div id="toggleMenu"><i class="fa fa-bars"></i></div>
        <span class="page-brand"><?=WEBSITE_NAME?> <?=date('Y',time())?></span>
    </div>
    <div class="user-wrapper fr">
        <ul>
            <li class="dropdown fl">
                <a href="#" role="button" data-toggle="dropdown" class="dropdown-toggle">
                    <div class="img_thumb fl" style=""><i class="fa fa-user" style="font-size: 36px;color: #f0f0f0;"></i></div>
                    <span class="fl user_name">Quản trị viên</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right ">
                    <li><a href="#">Tài khoản của bạn <i class="fa fa-user pull-right"></i></a></li>
                    <li><a href="#" id="infoacc">Thiết lập tài khoản <i class="fa fa-pencil pull-right"></i></a></li>
                    <li><a href="#">Giúp đỡ <i class="fa fa-question-circle pull-right"></i></a></li>
                    <li><a href="#" id="websetting">Cài đặt hệ thống<i class="fa fa-cog pull-right"></i></a></li>
                    <li><a href="logout.php">Thoát đăng nhập <i class="fa fa-sign-out pull-right"></i></a></li>
                </ul>
            </li>
            <li>

            </li>
        </ul>
    </div>
    <div class="fr" id="cmsfunc">
        <?php
        //kiem tra xem neu la o tren localhost thi moi co quyen cau hinh
        $url = $_SERVER['SERVER_NAME'];
        if($isAdmin==1 && ($url == "localhost" || strpos($url,"192.168.1")!==false)){
            ?>
            <a href="#" id="websetting"><i class="icon-wrench icon-black"></i></a>
        <?php }?>
    </div>
</div>
