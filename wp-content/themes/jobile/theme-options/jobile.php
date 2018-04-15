<?php
function jobile_options_init(){
 register_setting( 'theme_options', 'jobile_theme_options','jobile_options_validate');
} 
add_action( 'admin_init', 'jobile_options_init' );
function jobile_options_validate($input)
{
	$input['logo'] = jobile_image_validation1(esc_url_raw( $input['logo']));
	$input['favicon'] = jobile_image_validation1(esc_url_raw( $input['favicon'] ));
	$input['footertext'] = sanitize_text_field( $input['footertext'] );
	
    return $input;
}
function jobile_image_validation1($jobile_imge_url) {
    $jobile_filetype = wp_check_filetype($jobile_imge_url);
    $jobile_supported_image = array('gif', 'jpg', 'jpeg', 'png', 'ico');
    if (in_array($jobile_filetype['ext'], $jobile_supported_image)) {
	return $jobile_imge_url;
  } else {
	return '';
  }
}
function jobile_framework_load_scripts($hook){
	if($GLOBALS['jobile_menu'] == $hook){
		wp_enqueue_media();
		wp_enqueue_style( 'jobile_framework', get_template_directory_uri(). '/theme-options/css/jobile_framework.css' ,false, '1.0.0');
		// Enqueue custom option panel JS
		wp_enqueue_script( 'jobile-options-custom', get_template_directory_uri(). '/theme-options/js/jobile-custom.js', array( 'jquery' ) );
		wp_enqueue_script( 'jobile-media-uploader', get_template_directory_uri(). '/theme-options/js/media-uploader.js', array( 'jquery') );		
	}
}
function jobile_framework_menu_settings() {
	$jobile_menu = array(
		'page_title' => __( 'jobile Options', 'jobile'),
		'menu_title' => __('Theme Options', 'jobile'),
		'capability' => 'edit_theme_options',
		'menu_slug' => 'jobile_framework',
		'callback' => 'jobile_framework_page'
		);
	return apply_filters( 'jobile_framework_menu', $jobile_menu );
}
add_action( 'admin_menu', 'jobile_options_add_page' ); 
function jobile_options_add_page() {
	$jobile_menu = jobile_framework_menu_settings();
   	$GLOBALS['jobile_menu']=add_theme_page($jobile_menu['page_title'],$jobile_menu['menu_title'],$jobile_menu['capability'],$jobile_menu['menu_slug'],$jobile_menu['callback']);
   	add_action( 'admin_enqueue_scripts', 'jobile_framework_load_scripts' );
} 
function jobile_framework_page(){ 
		global $select_options; 
		if ( ! isset( $_REQUEST['settings-updated'] ) ) 
		$_REQUEST['settings-updated'] = false; ?>
<div class="jobile-themes">
	<form method="post" action="options.php" id="form-option" class="theme_option_ft">
	<div class="jobile-header">
    <div class="logo">
      <?php $jobile_image=get_template_directory_uri().'/theme-options/images/logo.png';
		echo "<a href='http://fasterthemes.com' target='_blank'><img src='".$jobile_image."' alt='FasterThemes' /></a>"; ?>
    </div>
    <div class="header-right">
      <?php echo "<h1>". __( 'Theme Options', 'jobile' ) . "</h1>";
			echo "<div class='btn-save'><input type='submit' class='button-primary' value='".__('Save Options','jobile')."' /></div>"; ?>
    </div>
  </div>
	<div class="jobile-details">
    <div class="jobile-options">
      <div class="right-box">
        <div class="nav-tab-wrapper">
          <ul>
            <li><a id="options-group-1-tab" class="nav-tab generalsettings-tab" title="<?php _e('General Settings','jobile'); ?>" href="#options-group-1"><?php _e('General Settings','jobile'); ?></a></li>
            <li><a id="options-group-2-tab" class="nav-tab profeatures-tab" title="Pro Settings" href="#options-group-2"><?php _e('PRO Theme Features','jobile'); ?></a></li>
 		  </ul>
        </div>
      </div>
      <div class="right-box-bg"></div>
      <div class="postbox left-box"> 
        <!--  F I N A L - - T H E M E - - O P T I O N  -->
          <?php settings_fields( 'theme_options' );  
		$jobile_options = get_option( 'jobile_theme_options' ); ?>
            <!--  First group  -->
          <div id="options-group-1" class="group jobile-inner-tabs">
			<div class="section theme-tabs theme-logo">
            <a class="heading jobile-inner-tab active" href="javascript:void(0)"><?php _e('Site Logo','jobile'); ?></a>
            <div class="jobile-inner-tab-group active">
            	<div class="explain"><?php _e('Size of logo should be exactly 245x25px for best results. Leave blank to use text heading.','jobile'); ?></div>
              	<div class="ft-control">
                <input id="logo-img" class="upload" type="text" name="jobile_theme_options[logo]" 
                            value="<?php if(!empty($jobile_options['logo'])) { echo esc_url($jobile_options['logo']); } ?>" placeholder="<?php _e('No file chosen','jobile'); ?>" />
                <input id="1upload_image_button" class="upload-button button" type="button" value="<?php _e('Upload','jobile'); ?>" />
                <div class="screenshot" id="logo-image">
                  <?php if(!empty($jobile_options['logo'])){echo "<img src='".esc_url($jobile_options['logo'])."' /><a class='remove-image'></a>"; } ?>
                </div>
              </div>
            </div>
          </div>
          	<div class="section theme-tabs theme-favicon">
              <a class="heading jobile-inner-tab" href="javascript:void(0)"><?php _e('Favicon','jobile'); ?></a>
              <div class="jobile-inner-tab-group">
              	<div class="explain"><?php _e('Size of favicon should be exactly 32x32px for best results.','jobile'); ?></div>
                <div class="ft-control">
                  <input id="favicon-img" class="upload" type="text" name="jobile_theme_options[favicon]" value="<?php if(!empty($jobile_options['favicon'])) { echo esc_url($jobile_options['favicon']); } ?>" placeholder="<?php _e('No file chosen','jobile'); ?>" />
                  <input id="upload_image_button1" class="upload-button button" type="button" value="<?php _e('Upload','jobile'); ?>" />
                  <div class="screenshot" id="favicon-image">
                    <?php  if(!empty($jobile_options['favicon'])) { echo "<img src='".esc_url($jobile_options['favicon'])."' /><a class='remove-image'></a>"; } ?>
                  </div>
                </div>
              </div>
            </div>
             <div id="section-footertext" class="section theme-tabs"> <a class="heading jobile-inner-tab" href="javascript:void(0)"><?php _e('Copyright Text', 'jobile'); ?></a>
              <div class="jobile-inner-tab-group">
                <div class="ft-control">
                  <div class="explain"><?php _e('Some text regarding copyright of your site, you would like to display in the footer.', 'jobile'); ?></div>
                  <input type="text" id="footertext" class="of-input" name="jobile_theme_options[footertext]" size="46" maxlength="200"  value="<?php if(!empty($jobile_options['footertext'])) { echo esc_attr($jobile_options['footertext']); } ?>">
                </div>
              </div>
            </div>
		  </div>
           <div id="options-group-2" class="group jobile-inner-tabs fasterthemes-pro-image">
              <a href="https://fasterthemes.com/wordpress-themes/jobile" target="_blank">
                <img src="<?php echo get_template_directory_uri(); ?>/theme-options/images/jobile_pro_features.png" />
              </a>
          </div> 
        <!--  F I N A L - - T H E M E - - O P T I O N S --> 
      </div>
     </div>
	</div>
	<div class="jobile-footer">
      	<ul>
	       <li class="btn-save"><input type="submit" class="button-primary" value="<?php _e('Save Options','jobile'); ?>" /></li>
        </ul>
    </div>
    </form>    
</div>
<div class="save-options"><h2><?php _e('Options saved successfully.','jobile'); ?></h2></div>
<?php } ?>