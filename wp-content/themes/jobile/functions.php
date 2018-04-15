<?php
/*
 * Theme function file.
 */
if (!function_exists('jobile_setup')) :

    function jobile_setup() {

	global $content_width;
	if (!isset($content_width)) {
	    $content_width = 720;
	}
	/* 	
	 * Make jobile theme available for translation.
	 */
	load_theme_textdomain( 'jobile', get_template_directory() . '/languages' );

// This theme styles the visual editor to resemble the theme style.
	add_editor_style(array('css/editor-style.css', jobile_font_url()));
	// Add RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');
	add_theme_support('post-thumbnails');
	add_theme_support( 'title-tag' );
	set_post_thumbnail_size(672, 372, true);
	add_image_size('jobile-full-width', 1038, 576, true);
	add_image_size('jobile-blog-image', 100, 86, true);

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus(array(
	    'primary' => __('Header Menu', 'jobile'),
	));
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support('html5', array(
	    'search-form', 'comment-form', 'comment-list',
	));
	add_theme_support('custom-background', apply_filters('jobile_custom_background_args', array(
	    'default-color' => 'f5f5f5',
	)));
	// Add support for featured content.
	add_theme_support('featured-content', array(
	    'featured_content_filter' => 'jobile_get_featured_posts',
	    'max_posts' => 6,
	));
	// This theme uses its own gallery styles.
	add_filter('use_default_gallery_style', '__return_false');
    }

endif; // jobile_setup
add_action('after_setup_theme', 'jobile_setup');
/*
 * Register Lato Google font for jobile.
 */

function jobile_font_url() {
    $jobile_font_url = '';

    if ('off' !== _x('on', 'Lato font: on or off', 'jobile')) {
	$jobile_font_url = add_query_arg('family', urlencode('Lato:300,400,700,900,300italic,400italic,700italic'), "//fonts.googleapis.com/css");
    }

    return $jobile_font_url;
}
/*
 * Register widget areas.
 */

function jobile_widgets_init() {
    register_sidebar(array(
	'name' => __('Primary Sidebar', 'jobile'),
	'id' => 'sidebar-1',
	'description' => __('Main sidebar that appears on the left.', 'jobile'),
	'before_widget' => '<aside id="%1$s" class="widget accordion-inner jobs-sidebar-column aside-column2 clearfix %2$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
    ));

    register_sidebar(array(
	'name' => __('Footer Area One', 'jobile'),
	'id' => 'footer-area-1',
	'description' => __('Footer area one that appears in the footer.', 'jobile'),
	'before_widget' => '<div id="%1$s" class="widget %2$s col-md-12 left-column no-padding-lr">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title li-title">',
	'after_title' => '</h3>',
    ));
    register_sidebar(array(
	'name' => __('Footer Area Two', 'jobile'),
	'id' => 'footer-area-2',
	'description' => __('Footer area two that appears in the footer', 'jobile'),
	'before_widget' => '<div id="%1$s" class="widget %2$s col-md-12 left-column no-padding-lr">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title li-title">',
	'after_title' => '</h3>',
    ));
    register_sidebar(array(
	'name' => __('Footer Area Three', 'jobile'),
	'id' => 'footer-area-3',
	'description' => __('Footer area three that appears in the footer', 'jobile'),
	'before_widget' => '<div id="%1$s" class="widget %2$s col-md-12 left-column no-padding-lr">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title li-title">',
	'after_title' => '</h3>',
    ));
    register_sidebar(array(
	'name' => __('Footer Area Four', 'jobile'),
	'id' => 'footer-area-4',
	'description' => __('Footer area four that appears in the footer', 'jobile'),
	'before_widget' => '<div id="%1$s" class="widget %2$s col-md-12 left-column no-padding-lr">',
	'after_widget' => '</div>',
	'before_title' => '<h3 class="widget-title li-title">',
	'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'jobile_widgets_init');
/*
 * Enqueue scripts and styles for the front end.
 */

function jobile_scripts() {
    wp_enqueue_style('jobile-lato', jobile_font_url(), array(), null);
    wp_enqueue_style('jobile-bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '', '');
    wp_enqueue_style('jobile-font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.css', array(), '', '');
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '', '');
    wp_enqueue_style('jobile-media-css', get_stylesheet_directory_uri() . '/css/media.css', array(), '', '');
    wp_enqueue_script('jobile-script-js', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'));
    wp_enqueue_script('jobile-bootstrapjs', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('jobile-owl-carousel-script', get_stylesheet_directory_uri() . '/js/owl.carousel.js', array('jquery'), '1.3.3', true);
    if (is_singular())
	wp_enqueue_script("comment-reply");
}

add_action('wp_enqueue_scripts', 'jobile_scripts');
/*
 * TGM 
 */
require get_template_directory() . '/inc/tgm-plugins.php';
/*
 * image description widget 
 */
require get_template_directory() . '/inc/jobile-image-description.php';
/*
 * social icon widget 
 */
require get_template_directory() . '/inc/social-widget.php';
/*
 * theme options
 */
require get_template_directory() . '/theme-options/jobile.php';
/*
 * For class add in jobile Category list.
 */
add_filter('the_category', 'jobile_category_tag_meta');

function jobile_category_tag_meta($list) {
    $list = str_replace('rel="category tag"', 'rel="category tag" class="person-post"', $list);
    return $list;
}
add_filter('the_category', 'jobile_category_meta');

function jobile_category_meta($list_category) {
    $list_category = str_replace('rel="category"', 'rel="category" class="person-post"', $list_category);
    return $list_category;
}

/*
 * jobile Breadcrumbs
 */
function jobile_custom_breadcrumbs() {
    $jobile_showonhome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $jobile_delimiter = '/'; // jobile_delimiter between crumbs
    $jobile_home = __('Home', 'jobile'); // text for the 'Home' link
    $jobile_showcurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $jobile_before = ' '; // tag before the current crumb
    $jobile_after = ' '; // tag after the current crumb
    global $post;
    $jobile_homelink = esc_url(home_url());

    if (is_home() || is_front_page()) {

	if ($jobile_showonhome == 1)
	    echo '<div id="crumbs" class="font-14 color-fff conter-text jobile-breadcrumb"><a href="' . $jobile_homelink . '">' . $jobile_home . '</a></div>';
    } else {
	echo '<div id="crumbs" class="font-14 color-fff conter-text jobile-breadcrumb"><a href="' . $jobile_homelink . '">' . $jobile_home . '</a> ' . $jobile_delimiter . ' ';

	if (is_category()) {
	    $jobile_thisCat = get_category(get_query_var('cat'), false);
	    if ($jobile_thisCat->parent != 0)
		echo get_category_parents($jobile_thisCat->parent, TRUE, ' ' . $jobile_delimiter . ' ');
	    echo $jobile_before . __('Archive by category', 'jobile') . ' "' . single_cat_title('', false) . '"' . $jobile_after;
	} elseif (is_search()) {
	    echo $jobile_before . __('Search results for', 'jobile') . ' "' . get_search_query() . '"' . $jobile_after;
	} elseif (is_day()) {
	    echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $jobile_delimiter . ' ';
	    echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $jobile_delimiter . ' ';
	    echo $jobile_before . get_the_time('d') . $jobile_after;
	} elseif (is_month()) {
	    echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $jobile_delimiter . ' ';
	    echo $jobile_before . get_the_time('F') . $jobile_after;
	} elseif (is_year()) {
	    echo $jobile_before . get_the_time('Y') . $jobile_after;
	} elseif (is_single() && !is_attachment()) {
	    if (get_post_type() != 'post') {
		$jobile_post_type = get_post_type_object(get_post_type());
		$jobile_slug = $jobile_post_type->rewrite;
		echo '<a href="' . $jobile_homelink . '/' . $jobile_slug['slug'] . '/">' . $jobile_post_type->labels->singular_name . '</a>';
		if ($jobile_showcurrent == 1)
		    echo ' ' . $jobile_delimiter . ' ' . $jobile_before . get_the_title() . $jobile_after;
	    } else {
		$jobile_cat = get_the_category();
		$jobile_cat = $jobile_cat[0];
		$jobile_cats = get_category_parents($jobile_cat, TRUE, ' ' . $jobile_delimiter . ' ');
		if ($jobile_showcurrent == 0)
		    $jobile_cats = preg_replace("#^(.+)\s$jobile_delimiter\s$#", "$1", $jobile_cats);
		echo $jobile_cats;
		if ($jobile_showcurrent == 1)
		    echo $jobile_before . get_the_title() . $jobile_after;
	    }
	} elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
	    $jobile_post_type = get_post_type_object(get_post_type());
	    echo $jobile_before . $jobile_post_type->labels->singular_name . $jobile_after;
	} elseif (is_attachment()) {
	    $jobile_parent = get_post($post->post_parent);
	    $jobile_cat = get_the_category($jobile_parent->ID);
	    $jobile_cat = $jobile_cat[0];
	    echo get_category_parents($jobile_cat, TRUE, ' ' . $jobile_delimiter . ' ');
	    echo '<a href="' . get_permalink($jobile_parent) . '">' . $jobile_parent->post_title . '</a>';
	    if ($jobile_showcurrent == 1)
		echo ' ' . $jobile_delimiter . ' ' . $jobile_before . get_the_title() . $jobile_after;
	} elseif (is_page() && !$post->post_parent) {
	    if ($jobile_showcurrent == 1)
		echo $jobile_before . get_the_title() . $jobile_after;
	} elseif (is_page() && $post->post_parent) {
	    $jobile_parent_id = $post->post_parent;
	    $jobile_breadcrumbs = array();
	    while ($jobile_parent_id) {
		$jobile_page = get_page($jobile_parent_id);
		$jobile_breadcrumbs[] = '<a href="' . get_permalink($jobile_page->ID) . '">' . get_the_title($jobile_page->ID) . '</a>';
		$jobile_parent_id = $jobile_page->post_parent;
	    }
	    $jobile_breadcrumbs = array_reverse($jobile_breadcrumbs);
	    for ($jobile_i = 0; $jobile_i < count($jobile_breadcrumbs); $jobile_i++) {
		echo $jobile_breadcrumbs[$jobile_i];
		if ($jobile_i != count($jobile_breadcrumbs) - 1)
		    echo ' ' . $jobile_delimiter . ' ';
	    }
	    if ($jobile_showcurrent == 1)
		echo ' ' . $jobile_delimiter . ' ' . $jobile_before . get_the_title() . $jobile_after;
	} elseif (is_tag()) {
	    echo $jobile_before . __('Posts tagged', 'jobile') . ' "' . single_tag_title('', false) . '"' . $jobile_after;
	} elseif (is_author()) {
	    global $author;
	    $jobile_userdata = get_userdata($author);
	    echo $jobile_before . __('Articles posted by', 'jobile') . $jobile_userdata->display_name . $jobile_after;
	} elseif (is_404()) {
	    echo $jobile_before . __('Error 404', 'jobile') . $jobile_after;
	}

	if (get_query_var('paged')) {
	    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
		echo ' (';
	    echo __('Page', 'jobile') . ' ' . get_query_var('paged');
	    if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author())
		echo ')';
	}
	echo '</div>';
    }
} // end jobile_custom_breadcrumbs()
/*
 * thumbnail list
 */
function jobile_thumbnail_image($content) {
    if (has_post_thumbnail())
	return the_post_thumbnail('thumbnail');
}
/**
 * excerpt function
 */
function jobile_customize_excerpt_more($more) {
    return ' ';
}

add_filter('excerpt_more', 'jobile_customize_excerpt_more');
function jobile_excerpt_length($length) {
    return (is_front_page()) ? 25 : 25;
}

add_filter('excerpt_length', 'jobile_excerpt_length', 999);

if (!function_exists('is_plugin_inactive')) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}
function jobile_image_validation($jobile_imge_url) {
    $jobile_filetype = wp_check_filetype($jobile_imge_url);

    $jobile_supported_image = array('gif', 'jpg', 'jpeg', 'png', 'ico');

    if (in_array($jobile_filetype['ext'], $jobile_supported_image)) {
	return $jobile_imge_url;
    } else {
	return '';
    }
} ?>