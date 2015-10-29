$(document).ready(function(){
    var _w = $(window).width();
    var _h = $(window).height();
    var _frame = $('#main_frame');
    var home_left = $('#home_left');
    var menu_list = $('#menu_list');
    _frame.width(_w - 250);
    _frame.height(_h - 100);
    menu_list.height(_h - 92);
    menu_list.find('.module_link a').click(function(){
        var link = $(this).attr('href');
        _frame.attr('src',link);
        menu_list.find('.module_link label').removeClass('active');
        $(this).closest('label').addClass('active');
        return false;
    });
    $('#infoacc').click(function(){
        _frame.attr('src','resources/config/infoacc.php');
        return false;
    });
    $('#websetting').click(function(){
        _frame.attr('src','resources/config/websetting.php');
        return false;
    });
    $('#configsite').click(function(){
        _frame.attr('src','resources/config/websetting.php');
        return false;
    });
    $('#reloadFrame').click(function(){
        _frame.attr('src',$('iframe#main_frame').attr('src'));
    });
    $('#viewHomePage').click(function(){
        _frame.attr('src','../../../home');
    });
    $('#toggleMenu').click(function(){
        home_left.toggleClass('hidden');
        if(home_left.hasClass('hidden')){
            _frame.width(_w);
        }else{
            _frame.width(_w - 250);
        }
    });
    //scroll
    menu_list.enscroll({
        showOnHover: true,
        minScrollbarLength: 28
    });
    //menu dropdown hover
    $('.dropdown').hover(function(){
        $(this).addClass('open');
    },function(){
        $(this).removeClass('open');
    });
});