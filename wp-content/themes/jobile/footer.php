<?php
/**
 * Footer For Jobile Theme.
 */
$jobile_options = get_option('jobile_theme_options'); ?>
<footer class="footer-main">
    <div class="container jobile-container">
        <div class="row">
            <div class="col-md-3 footer-column1 clearfix col-xs-12 col-sm-6 ">
		<?php if (is_active_sidebar('footer-area-1')) : dynamic_sidebar('footer-area-1');
		endif; ?>
            </div>
            <div class="col-md-3 footer-column2 clearfix col-xs-12 col-sm-6 ">
<?php if (is_active_sidebar('footer-area-2')) : dynamic_sidebar('footer-area-2');
endif; ?>
            </div>
            <div class="col-md-3 footer-column3 clearfix col-xs-12 col-sm-6 ">
		<?php if (is_active_sidebar('footer-area-3')) : dynamic_sidebar('footer-area-3');
		endif; ?>
            </div>
            <div class="col-md-3 footer-column4 clearfix col-xs-12 col-sm-6 ">
<?php if (is_active_sidebar('footer-area-4')) : dynamic_sidebar('footer-area-4');
endif; ?>
        </div>
        </div>
    </div>
    <div class="col-md-12 no-padding-lr footer-bottom">
        <div class="container jobile-container">
	   <p class="text-left"> <?php printf( __( 'Powered by %1$s.', 'jobile' ), '<a href="http://fasterthemes.com/wordpress-themes/jobile" target="_blank">Jobile WordPress Theme</a>' ); ?>
	   </p>
	   <p class="text-right"><?php if (!empty($jobile_options['footertext'])) {
		echo esc_attr($jobile_options['footertext']);
	    } ?></p>
        </div>    
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>