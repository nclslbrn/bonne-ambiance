<?php

/**
 * Bonne-Ambiance functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bonne-Ambiance
 */

if (! function_exists('ba_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ba_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Bonne-Ambiance, use a find and replace
		 * to change 'Bonne-Ambiance' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('Bonne-Ambiance', get_template_directory() . '/languages');
		$local      = get_locale();
		$local_file = get_template_directory() . "/languages/$local";

		if (is_readable($local_file)) {
			require_once $local_file;
		}

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary'     => esc_html__('Primary', 'Bonne-Ambiance'),
				'footer-menu' => esc_html__('Footer Menu', 'Bonne-Ambiance'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ba_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add front style to Gutenberg editor block
		add_theme_support('editor-styles');
		add_editor_style( 'editor.css' );
	}
endif;
add_action('after_setup_theme', 'ba_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ba_content_width()
{
	$GLOBALS['content_width'] = apply_filters('ba_content_width', 1400);
}
add_action('after_setup_theme', 'ba_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ba_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Header', 'Bonne-Ambiance'),
			'id'            => 'sidebar-header',
			'description'   => esc_html__('Add widgets here.', 'Bonne-Ambiance'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__('Footer', 'Bonne-Ambiance'),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__('Add widgets here.', 'Bonne-Ambiance'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

}
add_action('widgets_init', 'ba_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function ba_scripts()
{
	wp_enqueue_style('Bonne-Ambiance-style', get_template_directory_uri() . '/style.css', '', '2.0.2', 'all');
	wp_enqueue_script('jquery');
	wp_enqueue_script('Masonry', '//cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js', array(), '4.2.2', true);
	wp_enqueue_script('ImageLoaded', '//unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js', array(), '5', true);

	wp_enqueue_script(
		'Bonne-Ambiance-script', get_template_directory_uri() . '/build/js/front.js',
		array('jquery', 'Masonry', 'ImageLoaded'), 
		'2.0.2', 
		true
	);
	wp_enqueue_style('vidstack-theme', 'https://cdn.vidstack.io/player/theme.css', '', '', 'all');
	wp_enqueue_style('vidstack-video', 'https://cdn.vidstack.io/player/video.css', '', '', 'all');
	wp_enqueue_script_module('vidstack-script', 'https://cdn.vidstack.io/player@1.11.21', array(), '1.11.21', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'ba_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load a dynamic project menu (comment to disable it)
 */
require get_template_directory() . '/inc/map-dynamic-category-menu.php';

/**
 * Clean archive page title
 */
require get_template_directory() . '/inc/clean-archive-page-title.php';

/**
 * Modify author archive page query to include co-created post 
 */
require get_template_directory() . '/inc/alter-author-archive-page-query.php';

/**
 * Contact form functions 
 */
require get_template_directory() . '/inc/contact-form.php';

/**
 * Load meta box features.
 */
require get_template_directory() . '/lib/index.php';
require get_template_directory() . '/inc/post-metabox.php';
require get_template_directory() . '/inc/category-metabox.php';
require get_template_directory() . '/inc/user-metabox.php';
/**
 * Load night mode widget
 */
require get_template_directory() . '/inc/class-map-night-mode-widget.php';

/**
 * Load custom gutenberg block
 */
require get_template_directory() . '/inc/gutenberg-block.php';
