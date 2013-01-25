/**
 * 用来控制 在线客服效果的JS
 * @author wangxianbin@vanthink.net
 * @date 2013-01-24 16:17
 */

(function($, window, document) {
    var resetPostion = function() {
        var pos_left_offset = -20;
        var main_width = $('.main').width();
        var online_service_width = $('#online-service').width();
        var window_width = $(window).width();
        var pos_left = 0;
        if (window_width > main_width) {
            pos_left = main_width - online_service_width + (window_width-main_width)/2 + pos_left_offset;
        } else {
            pos_left = window_width - online_service_width + pos_left_offset;
        }
        $('#online-service').css('left', pos_left);
    };

    $(window).scroll(function() {
        if ($(document).scrollTop() > $('#header').height()) {
            $('#online-service').show();
        }
        if ($(document).scrollTop() < $('#header').height()) {
            $('#online-service').hide();
        }
    });

    $(window).resize(function() {
        resetPostion();
    });

    $(document).ready(function() {
        resetPostion();

        $('#online-service-more').click(function() {
            $('#online-service').show();
        });
    });
})(jQuery, window, document);