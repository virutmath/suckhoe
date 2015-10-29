var $page;
//jquery.cookie.js
/*!
 * jQuery Cookie Plugin v1.4.0
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2013 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // CommonJS
        factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (value !== undefined && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {};

        // To prevent the for loop in the first place assign an empty array
        // in case there are no cookies at all. Also prevents odd result when
        // calling $.cookie().
        var cookies = document.cookie ? document.cookie.split('; ') : [];

        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');

            if (key && key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) === undefined) {
            return false;
        }

        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

}));
function load_image_slide(title,link,src){
    var slideViewer = $('.news-slide-viewer');
    var loading = slideViewer.find('.fa-refresh').removeClass('hidden');
    var h1_title = slideViewer.find('h1');
    var img_viewer = slideViewer.find('img');
    h1_title.html('<a href="'+link+'">'+title+'</a>').removeClass('hidden');
    img_viewer.css('opacity',0).attr({src:src,alt:title}).removeClass('hidden').animate({
        opacity : 1
    }).closest('a').attr('href',link);
    loading.addClass('hidden');
}
function get_first_slide(){
    var first_li = $('.news-slide-listing>ul>li').first();
    first_li.addClass('item-visible');
    return {title : first_li.data('title'),link:first_li.data('link'),src:first_li.data('img')}
}
function section_description_expand(){
    $('.section-group-desc').toggleClass('expand');
}
function run_slide_home(){
    setInterval(function(){
        //lấy li đang được active
        var li_visible = $('.news-slide-listing>ul').find('li.item-visible');
        var item_next = li_visible.next();
        if(!item_next.length) item_next = $('.news-slide-listing>ul>li').first();
        li_visible.removeClass('item-visible');
        item_next.addClass('item-visible');
        load_image_slide(item_next.data('title'),item_next.data('link'),item_next.data('img'));
    },5000)
}
function anatomy_human_show(item){
    var ele = $(item);
    var params = {
        action : 'get_section',
        id_map : ele.data('id')
    }
    $page = $('.wrapper-main').attr('id');
    switch ($page){
        case 'cat-disease-page':
            var link_dt = ele.data('link-detail');
            if(link_dt){
                window.location.replace(link_dt);
            }else{
                //load cac section trong tung group section
                $.ajax({
                    type : 'post',
                    url : '/ajax/catAnatomy',
                    data : params,
                    dataType : 'html',
                    success : function(html){
                        $('.list-section').html(html);
                    }
                })
            }

            break;
        default :
            var sidebar_anatomy_detail = $('#sidebar-anatomy-detail');
            var overlay = $('#overlay');
            overlay.show();
            $.ajax({
                type : 'post',
                url : '/ajax/sidebarAnatomy',
                data : params,
                dataType : 'html',
                success : function(html){
                    sidebar_anatomy_detail.html(html).addClass('active');
                },
                beforeSend : function(){
                    sidebar_anatomy_detail.html('Loading...');
                }
            })
            break;
    }


}
function load_anatomy_image (param){
    var map_sex = $('#map-anatomy-sex');
    var map_type = $('#map-anatomy-view');
    switch (param){
        case 'male':
        case 'female' :
            var ana_image_sex = $('.ana-image-sex');
            ana_image_sex.find('.fa.color-base').removeClass('color-base').addClass('text-muted');
            ana_image_sex.find('.fa-'+param).removeClass('text-muted').addClass('color-base');
            map_sex.val(param);
            $.cookie('anatomy-sex',param);
            break;
        case 'front':
        case 'back':
            var ana_image_view = $('.ana-image-view');
            ana_image_view.find('span').removeClass('active');
            ana_image_view.find('.ana-image-view-'+param).addClass('active');
            map_type.val(param);
            break;
    }
    var sex_value = map_sex.val();
    var type_value = map_type.val();
    $.ajax({
        type : 'post',
        url : '/ajax/sidebarAnatomy',
        data : {action : 'get_image', sex : sex_value, type : type_value},
        success : function(html){
            if($page == 'cat-disease-page'){
                $('.img-anatomy').html(html);
            }else{
                $('#home-anatomy').html(html);
            }
            addMapper();
        }
    });
}
function generate_page(){
    var current_page = $('#current_page');
    var base_url = $('#base_url');
    var btn = $('#cat-load-more-btn');
    var page_next = parseInt(current_page.val()) + 1;
    var link_next = base_url.val() + '?page=' + page_next;
    btn.attr('href',link_next);
    current_page.val(page_next);
}
function close_popup_anatomy(){
    $('#sidebar-anatomy-detail').removeClass('active');
    $('#overlay').hide();
}
function show_popup_question(){
    var overlay = $('#overlay');
    overlay.show();
    var form_add = $('#form-add-question');
    var scrollTop = $(document).scrollTop();
    form_add.show();
    form_add.css({
        top : scrollTop + 50
    });
    overlay.click(function(){
        overlay.hide();
        form_add.hide();
    })
}
function callback_manifest(value,data){
    var wrap_list = $('#wrap-list-manifest');
    if($('#que_man_id'+data.man_id).length){
        return true;
    }
    wrap_list.append('<div class="item-manifest" role="alert">' +
                        '<input type="hidden" name="que_man_id[]" value="'+data.man_id+'" id="que_man_id'+data.man_id+'"/>' +
                        value.value+' <a href="#" class="close" data-dismiss="alert">&times;</a></div>');
}
$(document).ready(function(){
    $page = $('.wrapper-main').attr('id');
    var first_slide = get_first_slide();
    load_image_slide(first_slide.title,first_slide.link,first_slide.src);
    run_slide_home();
    $(document).pjax('a');
    //log lại ảnh bị lỗi
    $('img').bind('error',function(){
        var name_img = $(this).attr('src'), image_error;
        var storage = $.localStorage;
        if(storage.isSet('image_error')){
            image_error = storage.get('image_error');
            if(image_error.indexOf(name_img) == -1){
                image_error.push(name_img);
                storage.set('image_error',image_error);
                //gửi ajax lưu lại ảnh lỗi
                $.ajax({
                    type : 'get',
                    url : '/ajax/logImageError',
                    data : {img : name_img}
                })
            }else{
                //ảnh đã tồn tại trong localstorage
                return false;
            }
        }else{
            //chưa tồn tại image_error
            image_error = [name_img];
            storage.set('image_error',image_error);
            //gửi ajax lưu lại ảnh lỗi
            $.ajax({
                type : 'get',
                url : '/ajax/logImageError',
                data : {img : name_img}
            })
        }
    })
    //tab
    $('.list-tab>span').click(function(){
        var $this = $(this);
        var $target = $this.data('target');
        if($this.hasClass('active'))
            return false;
        else{
            $('.list-tab span').removeClass('active');
            $this.addClass('active');
            $('.list-qaa-sidebar').addClass('hidden');
            $('#'+$target).removeClass('hidden');
            var caret_left = $('.list-tab').width() - parseInt($('.list-tab').find('.caret').css('left'));
            $('.list-tab').find('.caret').css('left',caret_left);
        }
    });
    //auto search
    $('.auto-search-input').autocomplete({
        serviceUrl : '/ajax/searchManifest',
        onSelect : function(value,data){
            var select_fn = $(this).data('onselect');
            if(select_fn){
                window[select_fn](value,data);
            }
        }
    });
    $('.button-filter').click(function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            $(this).css('height','31px');
        }else{
            $(this).css('height','29px');
        }
        $('.dropdown-search').toggleClass('active');
    });
    $('.checkbox-closed').click(function(){
        $('.dropdown-search').removeClass('active');
    });

})