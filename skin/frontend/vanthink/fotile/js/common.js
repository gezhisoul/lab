(function(jQuery){jQuery.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=jQuery.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){jQuery(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev])}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev])};var handleHover=function(e){var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t)}if(e.type=="mouseenter"){pX=ev.pageX;pY=ev.pageY;jQuery(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob)},cfg.interval)}}else{jQuery(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob)},cfg.timeout)}}};return this.bind('mouseenter',handleHover).bind('mouseleave',handleHover)}})(jQuery);
jQuery(function() {
    var url=window.location.href;
    var urls=url.substr(url.length-5,url.length);
    var a1=jQuery.browser.msie&&(jQuery.browser.version == "6.0") && urls!='/noIe' ;
    var a2=jQuery.browser.msie&&(jQuery.browser.version == "7.0") && urls!='/noIe' ;
    // if(a1 || a2 || a3){
    //     window.location.href='/noIe';
    // }
    var dropdown = jQuery('nav ul li');
    var topdrop = jQuery('section .posr');
    dropdown.hoverIntent({
        sensitivity: 3,
        interval: 200,
        over: makeTall,
        timeout: 300,
        out: makeShort
    });
    function makeTall(){
        jQuery(this).children('div').stop().slideDown(200);
    }
    function makeShort(){
        jQuery(this).children('div').stop().hide(100);
    }
    var searchArea=jQuery('#search_mini_form input');
    searchArea.click(function(){
        if(searchArea.text()!=null){
            searchArea.attr('placeholder','');
        }
        searchArea.blur(function(){
            if(searchArea.text()==''){
                searchArea.attr('placeholder','请输入关键词...'); }
        })
    })
    var compareSide=jQuery('.block-compare');
    var compareSideLi=jQuery('.block-compare p');
    if(compareSideLi.hasClass('empty')){
        compareSide.hide();
    }
    jQuery('.bill').hover(function(){
        jQuery('.iCart').show();
    },function(){
        jQuery('.iCart').hide();
    })
    var proBor=jQuery('.products-grid li img');
    proBor.hover(function(){
        jQuery(this).addClass('borye');
    },function(){
        jQuery(this).removeClass('borye');
    })
    jQuery('input').placeholder();
    topdrop.hover(function() {
        jQuery(this).addClass('drop-otherlogin');
    }, function() {
        jQuery(this).removeClass('drop-otherlogin');
    });
    topdrop.find('dd').hover(function() {
        jQuery(this).css('background', '#000');
    }, function() {
        jQuery(this).css('background', '#212121');
    });
    jQuery('.sorts li').hover(function(){
        jQuery(this).addClass('orderFoucs');
    },function(){
        jQuery(this).removeClass('orderFoucs');
    })
    var choseAttr=jQuery('.proChosen #narrow-by-list li');
    choseAttr.hover(function(){
        jQuery(this).addClass('hoverFocus')
    },function(){
        jQuery(this).removeClass('hoverFocus')
    })
    var registerForm = jQuery('.fieldset .form-list li')
    registerForm.hover(function(){
        jQuery(this).css('background', '#f6f6f6');
    }, function() {
        jQuery(this).css('background', '#ffffff');
    });
    jQuery('.close-to').toggle(function(){
        jQuery('.cus-ser').hide()
        jQuery(this).addClass('open-to');
    },function(){
        jQuery('.cus-ser').show();
        jQuery(this).removeClass('open-to');
    });


    // advanced search form js

    jQuery('#enable-set-22').addClass('focus');
    jQuery('.enable-set-22').show();

    var set_tab=jQuery('.set-tab li');
    set_tab.click(function(){
        jQuery(this).addClass('focus')
            .siblings().removeClass('focus');
        var show_id=jQuery(this).attr('id');
        jQuery('#advanced-search-list li').hide();
        jQuery('#enable-search-attributes li').hide();
        jQuery('#enable-search-attributes li input').each(function(i, input) {
            jQuery(input).prop("checked",false);
        });

        jQuery('.'+show_id).show();
    });

    jQuery('#enable-search-attributes li input').click(function() {
        var id = jQuery(this).attr('data-id');
        if (jQuery(this).prop('checked')==true) {
            jQuery('#'+id).parent().parent().show();
        } else {
            jQuery('#'+id).parent().parent().hide();
        }
    });

    // end advanced search form js

    var myLi=jQuery('#mycarousel li');
    myLi.eq(0).find('img').addClass('focusOn');
    myLi.find('img').click(function(){
        myLi.find('img').removeClass('focusOn');
        jQuery(this).addClass('focusOn');
    });
    //  jQuery('#tax_class_id').parent().parent().remove();

    // lazy load init
    jQuery('img.lazy').lazyload({
        load: function(){
            var self = this;
            var jQueryself = jQuery(this);
            jQueryself.removeClass('loading-img');
            var img = new Image();
            img.onload = function(){
                jQueryself.css({
                    'width': this.width,
                    'height': this.height
                });
            };
            img.src = jQueryself.attr('src');
        }
    });
});
