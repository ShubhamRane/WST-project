<?php
/**
 * The template for displaying Comments.
 */
if ( post_password_required() )
	return; ?>
<div class="clearfix"></div>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : 	?>
         <div class="col-md-12 comment-content-area no-padding-lr clearfix"> 
            <h2><span class="recent-posts-title"><?php echo get_comments_number(). __('Comments','jobile'); ?></span></h2>
         </div>
        <ul class="jobile-comment-list">
            <?php wp_list_comments( array(  'short_ping' => true, 'style' => 'ul' ) ); ?>
        </ul>
       <?php paginate_comments_links();
	       endif; // have_comments()
	       comment_form(); ?>
</div><!-- #comments .comments-area -->
