<?php
add_action( 'widgets_init', 'jobile_image_widget' );
function jobile_image_widget() {
    register_widget( 'jobile_image_widget' );
}
class jobile_image_widget extends WP_Widget {

    function __construct() {
        $jobile_widget_ops = array( 'classname' => 'jobile_image', 'description' => __('A widget that displays the image and description.', 'jobile') );      
        $jobile_control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'jobile-image-widget' );       
        parent::__construct( 'jobile-image-widget', __('Jobile Image Description', 'jobile'), $jobile_widget_ops, $jobile_control_ops );
    }  
    function widget( $jobile_image_args, $jobile_image_instance ) {
        extract( $jobile_image_args );
        //Our variables from the widget settings.
        $jobile_image_name = $jobile_image_instance['content'];
		$jobile_image_image = $jobile_image_instance['image'];
        echo $before_widget;
        //Display widget
?>   
<img src="<?php if($jobile_image_instance['image']) { echo esc_url($jobile_image_instance['image']); } else { echo get_template_directory_uri().'/images/default-user.png'; } ?>"  class="img-responsive" width="87" height="23" alt="logo">
<p><?php echo $jobile_image_instance['content']; ?></p>
 
<?php echo $after_widget; }
    //Update the widget   
    function update( $new_image_instance, $old_image_instance ) {
        $jobile_image_instance = $old_image_instance;
        //Strip tags from title and name to remove HTML
        $jobile_image_instance['content'] = strip_tags( $new_image_instance['content'] );
		$jobile_image_instance['image'] = strip_tags( $new_image_instance['image'] );
        return $jobile_image_instance;
    }
    function form( $jobile_image_instance ) { ?>
    <p class="section">
        <label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e('Image:','jobile') ?></label><br />
        <input id="<?php echo $this->get_field_id( 'image' ); ?>"  type="text" class="widefat jobile_media_url upload" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php if(!empty($jobile_image_instance['image'])) { echo $jobile_image_instance['image']; } ?>" placeholder="No file chosen" style="width:75%;" />
        <input id="jobile_image_uploader"  class="upload-button button" type="button" value="<?php _e('Upload','jobile') ?>" /><br /><br />
		<?php if(!empty($jobile_image_instance['image'])) { ?><img src="<?php echo esc_url($jobile_image_instance['image']); ?>" style='max-width:100%;' /><?php } ?>         
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'content' ); ?>"><?php _e('Content:','jobile') ?></label>
        <textarea id="<?php echo $this->get_field_id( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" style="width:100%;"><?php if(!empty($jobile_image_instance['content'])) { echo $jobile_image_instance['content']; } ?></textarea>
    </p>  
<?php }} ?>