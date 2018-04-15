<?php

/*
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 * For more information on hooks, actions, and filters, see https://codex.wordpress.org/ 
 */

/*********************************************************************************************************
* Basic
**********************************************************************************************************/

	function classified_ads_add_editor_styles() {
			add_editor_style( get_template_directory_uri() . 'css/editor-style.css' );		
		}

		if ( ! isset( $content_width ) ) $content_width = 600;
	
	function classifiedads_setup() {
		add_action( 'admin_init', 'classified_ads_add_editor_styles' );
		add_theme_support('title-tag');
		add_theme_support('automatic-feed-links');
		add_theme_support('post-thumbnails');
	}
	
/*********************************************************************************************************
* Register Sidebar
**********************************************************************************************************/

	function classified_ads_widgets_init() {
		register_sidebar( array(
			'id'          => ('sidebar'),
			'name'        => __( 'Sidebar', 'classified-ads'),
			'description' => __( 'This is Sidebar.', 'classified-ads' ),
		) );
}

		add_action( 'widgets_init', 'classified_ads_widgets_init' );	
	
	add_action( 'after_setup_theme', 'classifiedads_setup' );
	
		function classified_ads_scripts() {
		if (is_singular() && comments_open()) {wp_enqueue_script('comment-reply');}
	}

	add_action( 'wp_enqueue_scripts', 'classified_ads_scripts' );

/*********************************************************************************************************
* Sticky
**********************************************************************************************************/
 
	function classified_ads_sticky () {
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 1,
			'post__in'  => $sticky,
			'category__in' => $sticky,
			'ignore_sticky_posts' => 1
		);
		$query = new WP_Query( $args );
		if ( isset($sticky[0]) ) {
		}
	}	
	
/*********************************************************************************************************
* Register Nav Menu
**********************************************************************************************************/

		register_nav_menus(array(
			'menu-top' => __('Menu top', 'classified-ads')
		));

/*********************************************************************************************************
* Pagination. 
**********************************************************************************************************/

		if ( ! function_exists( 'classified_ads_mb_pagination' ) ) :

		function classified_ads_mb_pagination() {
			global $wp_query;
			$current = max( 1, get_query_var('paged') );

			$pagination_return = paginate_links( array(
				'format' => '?paged=%#%',
				'current' => $current,
				'total' => $wp_query->max_num_pages,
				'next_text' => '&raquo;',
				'prev_text' => '&laquo;'
			) );
			if ( ! empty( $pagination_return ) ) {
				echo '<div class="pagination">';
				echo '<div class="total-pages">';
				echo '</div>';
				echo $pagination_return;
				echo '</div>';
			}

		}
		endif; 

 	$classifiedads_page = array(
		'before'           => '<p>' . __( 'Pages:', 'classified-ads' ),
		'after'            => '</p>',
		'link_before'      => '',
		'link_after'       => '',
		'next_or_number'   => 'number',
		'separator'        => ' ',
		'nextpagelink'     => __( 'Next', 'classified-ads' ),
		'previouspagelink' => __( 'Previous', 'classified-ads' ),
		'pagelink'         => '%',
		'echo'             => 1
	);
 
        wp_link_pages( $classifiedads_page);

/*********************************************************************************************************
* Load CSS
**********************************************************************************************************/

		function classified_ads_css() {		   
				wp_enqueue_style('classifiedads_style', get_stylesheet_uri());
			}

		add_action('wp_enqueue_scripts', 'classified_ads_css');

		function classified_ads_google_fonts() {

				wp_enqueue_style( 'font-oswald', '//fonts.googleapis.com/css?family=Oswald:400,300,700', false, 1.0, 'screen' );

			}
		add_action( 'wp_enqueue_scripts', 'classified_ads_google_fonts' );
		
/*********************************************************************************************************
* Custom header
**********************************************************************************************************/

function classified_ads_header_setup(){

		$classifiedads_custom_header_logo  = array(
			'width'					 => 1300,
			'height'               => 330,
			'default-image'   		 => get_template_directory_uri() . '/img/classified-ads.png',
			'random-default'         => true,
			'flex-height'            => true,
			'flex-width'             => false,
			'header-text'            => false,
		);

		add_theme_support( 'custom-header', $classifiedads_custom_header_logo );
	
	register_default_headers( array(
    'Classified' => array(
    'url'   => get_template_directory_uri() . '/img/classified-ads.png',
    'thumbnail_url' => get_template_directory_uri() . '/img/classified-ads.png',
    'description'   => _x( 'Classified img', 'Header image Classified img', 'classified-ads' )),
));
}
		add_action( 'after_setup_theme', 'classified_ads_header_setup' );
		
/*********************************************************************************************************
* Custom Colors Customize
**********************************************************************************************************/

		function classified_ads_colors($wp_customize) {

/********************************************
* Hover color
*********************************************/ 

		$wp_customize->add_setting('classifiedads_hover_color', array(        
  	      'default' => '#CE0000',
		    'sanitize_callback' => 'sanitize_hex_color'
  	  ));  
	
		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'classifiedads_hover_color', array(
		'label' => __('Hover Color', 'classified-ads'),       
  	      'section' => 'colors',
  	      'settings' => 'classifiedads_hover_color'
  	  )));

 /********************************************
* Header Color
*********************************************/

		$wp_customize->add_setting('classifiedads_header_color', array(         
		'default'     => '#FFFFFF',
		 'sanitize_callback' => 'sanitize_hex_color'
		)); 	

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'classifiedads_header_color', array(
		'label' => __('Header Color', 'classified-ads'),        
		 'section' => 'colors',
		'settings' => 'classifiedads_header_color'
		)));

 /********************************************
* Nav Hover Color
*********************************************/

		$wp_customize->add_setting('classifiedads_nav_hover_color', array(         
		'default'     => '#FFFFFF',
		'sanitize_callback' => 'sanitize_hex_color'
		)); 	

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'classifiedads_nav_hover_color', array(
		'label' => __('Nav Hover Color', 'classified-ads'),        
		'section' => 'colors',
		'settings' => 'classifiedads_nav_hover_color'
		)));
			
 /********************************************
* Footer Background
*********************************************/

		$wp_customize->add_setting('classifiedads_footer_background_color', array(         
		'default'     => '#960000',
		'sanitize_callback' => 'sanitize_hex_color'
		)); 	

		$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'classifiedads_footer_background_color', array(
		'label' => __('Footer Background Color', 'classified-ads'),        
		'section' => 'colors',
		'settings' => 'classifiedads_footer_background_color'
		)));
		
}
		add_action('customize_register', 'classified_ads_colors');
	
?><?php
		function classifiedads_customize_css() {
    ?>
		<style type="text/css">
		header, header p, header h1 {color:<?php echo esc_html(get_theme_mod('classifiedads_header_color')); ?>;}   
		a:hover, details a:hover {color:<?php echo esc_html(get_theme_mod('classifiedads_hover_color')); ?>;}
		nav ul li a:hover, nav ul ul li a:hover {color:<?php echo esc_html(get_theme_mod('classifiedads_nav_hover_color')); ?>;}     
 		footer {background:<?php echo esc_html(get_theme_mod('classifiedads_footer_background_color')); ?>;}
 		.option-con {border:<?php echo esc_html(get_theme_mod('classifiedads_footer_background_color')); ?>;} 
 		body, main, input {background:<?php echo esc_html(get_theme_mod('classifiedads_background_color')); ?>;}    
		</style>
    <?php
	
}
		add_action('wp_head', 'classifiedads_customize_css');
	
/*********************************************************************************************************
* Custom Background Color
**********************************************************************************************************/

		$custom_background = array(
			'default-color'          => '#FFFFFF',
			'wp-head-callback'       => '_custom_background_cb',
		);
		add_theme_support( 'custom-background', $custom_background );		

/*********************************************************************************************************
* Excerpt
**********************************************************************************************************/

		function classified_ads_new_excerpt_more( $more ) {
			return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'classified-ads') . '</a>';
		}
			add_filter( 'excerpt_more', 'classified_ads_new_excerpt_more' );

		function classified_ads_custom_excerpt_length( $length ) {
			return 50;
		}
		add_filter( 'excerpt_length', 'classified_ads_custom_excerpt_length', 999 );

/*********************************************************************************************************
* Ad button
**********************************************************************************************************/

if ( ! function_exists( 'classified_ads_ad' ) ) :
	function classified_ads_ad( $wp_customize ) {


		$wp_customize->add_section('classifiedads_post_ad', array(
		'title' => __('Ad button', 'classified-ads'),
		'priority' => 2,
		'type' => 'option'		
	));
	$wp_customize->add_setting('classified_ads_post_ad', array(
		'sanitize_callback' => 'classified_ads_text'
	)); 	
	$wp_customize->add_control('classified_ads_heading_control', array(
	        'label' => __('Post an ad button text', 'classified-ads'),
	        'section' => 'classifiedads_post_ad',
	        'settings' => 'classified_ads_post_ad',
	        'type' => 'text',
	    )
	);
	function classified_ads_text($input) {
    	return wp_kses_post(force_balance_tags($input));
	}	

	}
endif;
		add_action('customize_register', 'classified_ads_ad');
		
/***********************************************************************************
 * Buy premium
***********************************************************************************/

		function classified_ads_buy($wp_customize){
			class Classified_Ads_Customize extends WP_Customize_Control {
				public function render_content() { ?>
				<div class="seos_business-info"> 
					<button class="button media-button button-primary button-large media-button-select">
						<a href="<?php echo esc_url( 'http://seosthemes.com/wordpress-theme-classified-ads/' ); ?>" title="<?php esc_attr_e( 'Buy Premium', 'classified-ads' ); ?>" target="_blank">
						<?php _e( 'Buy Premium', 'classified-ads' ); ?>
						</a>
					</button>
				</div>
				<?php
				}
			}
		}
		add_action('customize_register', 'classified_ads_buy');

		function customize_styles_seos_business( $input ) { ?>
			<style type="text/css">
				#customize-theme-controls #accordion-section-classified_ads_buy_section .accordion-section-title,
				#customize-theme-controls #accordion-section-classified_ads_buy_section > .accordion-section-title {
					background: #960000;
					-webkit-box-shadow: inset 0px 17px 56px -13px rgba(91,91,91,1);
					-moz-box-shadow: inset 0px 17px 56px -13px rgba(91,91,91,1);
					box-shadow: inset 0px 17px 56px -13px rgba(91,91,91,1);
					color: #FFFFFF;
				}

				.seos_business-info button a {
					color: #FFFFFF;
				}	
			</style>
		<?php }
		
		add_action( 'customize_controls_print_styles', 'customize_styles_seos_business');

		if ( ! function_exists( 'seos_classified_ads_buy' ) ) :
			function seos_classified_ads_buy( $wp_customize ) {
			$wp_customize->add_section( 'classified_ads_buy_section', array(
				'title'			=> __('Buy Premium Theme', 'classified-ads'),
				'description'	=> __('	Learn more about Classified Ads Theme. ','classified-ads'),
				'priority'		=> 1,
			));
			$wp_customize->add_setting( 'classified_ads_setting', array(
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'wp_filter_nohtml_kses',
			));
			$wp_customize->add_control(
				new Classified_Ads_Customize(
					$wp_customize,'classified_ads_setting', array(
						'label'		=> __('Classified Ads how to use', 'classified-ads'),
						'section'	=> 'classified_ads_buy_section',
						'settings'	=> 'classified_ads_setting',
					)
				)
			);
		}
		endif;
		 
		add_action('customize_register', 'seos_classified_ads_buy');		
