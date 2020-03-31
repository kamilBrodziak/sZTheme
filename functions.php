<?php
/**
 * Szczesliwy Zwiazek Theme
 *
 * @package  WordPress
 */

/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/static/no-timber.html';
		}
	);
	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
include ("inc/functions-admin.php");
include ("inc/functions-adminSettings.php");
include ("inc/functions-adminNewsletter.php");
include ("inc/functions-adminCustomCss.php");
include ("inc/functions-adminEnqueue.php");

class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'loadScripts' ) );
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action ('wp_head', 'rsd_link');
//        add_filter('the_generator', 'crunchify_remove_version');
        remove_action( 'wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'rest_output_link_wp_head', 10);
        remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        remove_action('template_redirect', 'rest_output_link_header', 11, 0);
        parent::__construct();
	}

	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
//				'comment-form',
//				'comment-list',
//				'gallery',
//				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

    function loadScripts() {
        wp_deregister_script('jquery');
        wp_deregister_script( 'wp-embed' );
        wp_enqueue_script('jquery', '/wp-includes/js/jquery/jquery.min.js');
        $styleVer = time();
        wp_enqueue_script( 'script-name', get_template_directory_uri() . '/static/site.min.js?' . $styleVer, array('jquery'), null, true );
//        wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/style.min.css?' . $styleVer);
        wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/static/css/site.css?' . $styleVer);
        wp_enqueue_style('casino-style6', get_stylesheet_directory_uri() . '/static/css/siteLayout.css?' . $styleVer);
        wp_enqueue_style('casino-style1', get_stylesheet_directory_uri() . '/static/css/normalization.css?' . $styleVer);
        wp_enqueue_style('casino-style2', get_stylesheet_directory_uri() . '/static/css/frontPage.css?' . $styleVer);
        wp_enqueue_style('casino-style3', get_stylesheet_directory_uri() . '/static/css/header.css?' . $styleVer);
        wp_enqueue_style('casino-style4', get_stylesheet_directory_uri() . '/static/css/footer.css?' . $styleVer);
        wp_enqueue_style('casino-style5', get_stylesheet_directory_uri() . '/static/css/articlePage.css?' . $styleVer);
        wp_enqueue_style('casino-style7', get_stylesheet_directory_uri() . '/static/css/common.css?' . $styleVer);

        wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}

new StarterSite();
