<?php if(!class_exists('raintpl')){exit;}?><div class="adv_large_banner">
    <?php $counter1=-1; if( isset($adv_banner_list) && is_array($adv_banner_list) && sizeof($adv_banner_list) ) foreach( $adv_banner_list as $key1 => $value1 ){ $counter1++; ?>
    <a href="<?php echo $value1["adv_link"];?>" target="_blank"><img src="<?php echo $value1["adv_image"];?>" alt="<?php echo $value1["adv_name"];?>" style="width:100%"/></a>
    <?php } ?>
</div>
<script>
    //fix khối banner ad
    $(function(){
        var windowHeight = $(window).height();
        var bannerItem = $('.adv_large_banner');
        var footerPage = $('#footer');
        var footerPos = 0;
        var bannerHeight = 0;
        var bannerWidth = 0;
        var bannerPos = 0;
        var scrollPos;
        $(document).scroll(function(e){
            if(!footerPos){
                footerPos = footerPage.offset().top;
            }
            if(!bannerWidth){
                bannerWidth = bannerItem.width();
            }
            if(!bannerPos) {
                bannerPos = bannerItem.offset().top;
            }
            if(!bannerHeight) {
                bannerHeight = bannerItem.height();
            }
            scrollPos = $(window).scrollTop();
            if(scrollPos > bannerPos && scrollPos < footerPos - bannerHeight){
                bannerItem.css({
                    position : 'fixed',
                    top : 0,
                    width : bannerWidth + 20
                });
            }else if(scrollPos >= footerPos - bannerHeight) {
                bannerItem.css({
                    position : 'absolute',
                    top : footerPos - bannerHeight - 20
                })
            }else{
                bannerItem.removeAttr('style');
            }

        })
    })

</script>