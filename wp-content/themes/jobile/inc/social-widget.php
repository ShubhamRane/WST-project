<?php
add_action( 'widgets_init', 'jobile_social_widget' );
function jobile_social_widget() {
    register_widget( 'jobile_social_widget' );
}
class jobile_social_widget extends WP_Widget {

    function __construct() {
        $jobile_widget_ops = array( 'classname' => 'jobile_social', 'description' => __('A widget that displays social icon.', 'jobile') );      
        $jobile_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'jobile-social-widget' );       
        parent::__construct( 'jobile-social-widget', __('Jobial Social Icon', 'jobile'), $jobile_widget_ops, $jobile_control_ops );
    }   
    function widget( $jobile_social_args, $jobile_social_instance ) {
        extract( $jobile_social_args );

        //Our variables from the widget settings.
        $jobile_social_title = apply_filters('widget_title', $jobile_social_instance['title'] );

        echo $before_widget;
        //Display widget ?>
<div class="social-icon">
	<label><?php echo $jobile_social_instance['title']; ?></label>
    <ul>
        <?php if(!empty($jobile_social_instance['facebook'])) { ?><li><a href="<?php echo esc_url($jobile_social_instance['facebook']); ?>"><i class="social_facebook_circle fb"></i></a></li><?php } ?>
        <?php if(!empty($jobile_social_instance['twitter'])) { ?><li><a href="<?php echo esc_url($jobile_social_instance['twitter']); ?>"><i class="social_twitter_circle twitt"></i></a></li><?php } ?>
        <?php if(!empty($jobile_social_instance['linkedin'])) { ?><li><a href="<?php echo esc_url($jobile_social_instance['linkedin']); ?>"><i class="social_linkedin_circle linkin"></i></a></li><?php } ?>
        <?php if(!empty($jobile_social_instance['google'])) { ?><li><a href="<?php echo esc_url($jobile_social_instance['google']); ?>"><i class="social_googleplus_circle gplus"></i></a></li><?php } ?>
    </ul>
</div>      
<?php        
        echo $after_widget;
    }
    //Update the widget 
    function update( $new_social_instance, $old_social_instance ) {
        $jobile_social_instance = $old_social_instance;

        //Strip tags from title and name to remove HTML
        $jobile_social_instance['title'] = strip_tags( $new_social_instance['title'] );
        $jobile_social_instance['facebook'] = strip_tags( $new_social_instance['facebook'] );
        $jobile_social_instance['twitter'] = strip_tags( $new_social_instance['twitter'] );
		$jobile_social_instance['linkedin'] = strip_tags( $new_social_instance['linkedin'] );
		$jobile_social_instance['google'] = strip_tags( $new_social_instance['google'] );

        return $jobile_social_instance;
    } function form( $jobile_social_instance ) { ?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:','jobile') ?></label>
    <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if(!empty($jobile_social_instance['title'])) { echo $jobile_social_instance['title']; } ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e('Facebook url:','jobile') ?></label>
    <input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php if(!empty($jobile_social_instance['facebook'])) { echo esc_url($jobile_social_instance['facebook']); } ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e('Twitter url:','jobile') ?></label>
    <input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php if(!empty($jobile_social_instance['twitter'])) { echo esc_url($jobile_social_instance['twitter']); } ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e('Linkedin url:','jobile') ?></label>
    <input id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php if(!empty($jobile_social_instance['linkedin'])) { echo esc_url($jobile_social_instance['linkedin']); } ?>" style="width:100%;" />
</p>
<p>
    <label for="<?php echo $this->get_field_id( 'google' ); ?>"><?php _e('Google+ url:','jobile') ?></label>
    <input id="<?php echo $this->get_field_id( 'google' ); ?>" name="<?php echo $this->get_field_name( 'google' ); ?>" value="<?php if(!empty($jobile_social_instance['google'])) { echo esc_url($jobile_social_instance['google']); } ?>" style="width:100%;" />
</p>     
<?php } } ?>
