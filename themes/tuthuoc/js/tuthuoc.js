$(document).ready(function() {
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
  });