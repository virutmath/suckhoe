$(document).ready(function () {

    $('.bottom-pharma ul li').on('click', function () {
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
        if ($(this).hasClass('ref1')) {
            $('#reference1').addClass('onActive');
            $('#reference1').siblings().removeClass('onActive');
        } else if ($(this).hasClass('ref2')) {
            $('#reference2').addClass('onActive');
            $('#reference2').siblings().removeClass('onActive');
        } else {
            $('#reference3').addClass('onActive');
            $('#reference3').siblings().removeClass('onActive');
        }
    });
    $('.button-filter').click(function () {
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).css('height', '31px');
        } else {
            $(this).css('height', '29px');
        }
        $('.dropdown-search').toggleClass('active');
    });
    $('.checkbox-closed').click(function () {
        $('.dropdown-search').removeClass('active');
    });

});