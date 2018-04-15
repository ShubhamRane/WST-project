(function($){$(document).ready(function(){$('.cssmenu li.has-sub>a').on('click',function(){$(this).removeAttr('href');var element=$(this).parent('li');if(element.hasClass('open')){element.removeClass('open');element.find('li').removeClass('open');element.find('ul').slideUp();}
else{element.addClass('open');element.children('ul').slideDown();element.siblings('li').children('ul').slideUp();element.siblings('li').removeClass('open');element.siblings('li').find('li').removeClass('open');element.siblings('li').find('ul').slideUp();}});$('.cssmenu>ul>li.has-sub>a').append('<span class="holder"></span>');});})(jQuery);
jQuery(document).ready(function(e) {
	jQuery('.jobile-tag-list a:even',this).addClass('blue-btn');
	jQuery('.jobile-tag-list a:odd',this).addClass('black-btn');
	jQuery('.pagination').removeClass('pagination').addClass('col-md-6 no-padding-lr right-pagination pull-right');
	jQuery('.footer-column2 .menu').addClass('left-column');
	jQuery('.footer-column3 .menu').addClass('left-column');
	jQuery('.current-menu-item a').addClass('active');
	jQuery('.jobile-nav .menu ul, .navbar-collapse.collapse ul').addClass('jobile-menu');
	jQuery('.jobile-nav .menu').addClass('navbar-collapse collapse no-padding-lr');
    jQuery('#post-sorting-option').change(function() {
        jQuery('#post-sorting-form').submit();
    });
});