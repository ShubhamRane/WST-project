<?php 
/*
 * 404 Template File.
 */
get_header(); ?>
    <section>
    	<!--website-breadcrumbs-->
        <div class="col-md-12 bread-row">
            <div class="container jobile-container">
            	<div class="col-md-6 no-padding-lr bread-left">
                    <h2><?php _e('404 Page not found','jobile'); ?></h2>
                </div>
                <div class="col-md-6 no-padding-lr font-14 breadcrumb site-breadcumb">
               		<?php if(function_exists('jobile_custom_breadcrumbs')) { jobile_custom_breadcrumbs(); } ?>
                </div>    
            </div>
        </div>
        <!--breadcrumbs end-->
        <div class="container jobile-container"> 
        <div class="clearfix"></div>
    	<article class="about-article clearfix">	
            <h4><?php _e('Epic 404 - Article Not Found.','jobile'); ?></h4>
         <section class="post_content col-md-12">
			<h5><?php _e("This is embarassing. We can't find what you were looking for.",'jobile'); ?></h5>
			<div class="search-form-404"><?php echo get_search_form(); ?></div>
		</section>
         </article>
		</div>
    </section>
<?php get_footer(); ?>