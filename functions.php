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
include ("inc/ajax.php");


/*
 * WooCommerce
 * */

function timber_set_product( $post ) {
	global $product;

	if ( is_woocommerce() ) {
		$product = wc_get_product( $post->ID );
	}
}

add_filter('add_to_cart_redirect', 'addToCartRedirectToCheckout');
function addToCartRedirectToCheckout() {
	global $woocommerce;
	return $woocommerce->cart->get_checkout_url();
}

add_filter( 'woocommerce_add_to_cart_validation', 'remove_cart_item_before_add_to_cart', 20, 3 );
function remove_cart_item_before_add_to_cart( $passed, $product_id, $quantity ) {
	if( ! WC()->cart->is_empty() )
		WC()->cart->empty_cart();
	return $passed;
}

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'wc_remove_options_text');
function wc_remove_options_text( $args ){
	$args['show_option_none'] = '';
	return $args;
}


function isSimpleProduct($id) {
	return wc_get_product($id)->is_type('simple');
}


add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' );
function woocommerce_custom_single_add_to_cart_text() {
	return __( 'Kup teraz', 'woocommerce' );
}


add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
function wpb_custom_billing_fields( $fields = array() ) {
	unset($fields['billing_company']);
//	unset($fields['billing_address_1']);
//	unset($fields['billing_address_2']);
//	unset($fields['billing_state']);
//	unset($fields['billing_city']);
//	unset($fields['billing_phone']);
//	unset($fields['billing_postcode']);
//	unset($fields['billing_country']);
	return $fields;
}


function getWCProducts() {
//	$products =  wc_get_products([]);
//	$posts = [];
//	foreach ($products as $product) {
//		array_push($posts, get_post($product->get_id()));
//	}
//	return $posts;
	return Timber::get_posts( [
		'post_type'      => 'product',
		'orderby' => [
			'date' => 'ASC'
		]
   ] );
}


/*
 * END WooCommerce
 * */

function deferLoad($url) {
	if ( strpos( $url, '#asyncload') === false )
		return $url;
	else if ( is_admin() )
		return str_replace( '#asyncload', '', $url );
	else
		return str_replace( "#asyncload'", '', $url )."' defer='defer";
}

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
		add_filter( 'clean_url', 'deferLoad', 11, 1 );

		/*
		 * WooCommerce
		 * */
		add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
		add_filter( 'woocommerce_is_sold_individually','__return_true', 10, 2 );
		add_filter('woocommerce_reset_variations_link', '__return_empty_string');
		add_filter( 'wc_add_to_cart_message', '__return');
		remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 21 );
		parent::__construct();
	}

	public function register_post_types() {

	}
	public function register_taxonomies() {

	}

	public function add_to_context( $context ) {
		$context['menu']  = new Timber\Menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support('html5',
			array(
//				'comment-form',
//				'comment-list',
//				'gallery',
//				'caption',
			)
		);
		add_theme_support('post-formats',
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
		add_theme_support( 'woocommerce' );

	}


	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		$twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

    function loadScripts() {
        wp_deregister_script('jquery');
        wp_deregister_script( 'wp-embed' );
        wp_register_script('jquery', includes_url('/js/jquery/jquery.min.js') . "#asyncload",false, NULL, true);
	    wp_dequeue_style( 'wc-block-style' );
//	    if(!is_checkout()) {
//	    	wp_deregister_script('woocommerce');
//		    wp_dequeue_script('wc-add-to-cart');
//		    wp_dequeue_script('jquery-blockui');
//		    wp_dequeue_script('jquery-placeholder');
//		    wp_dequeue_script('woocommerce');
//		    wp_dequeue_script('jquery-cookie');
//		    wp_dequeue_script('wc-cart-fragments');
//	    }
	    if(!is_product() && !is_checkout()) {
	    	wp_deregister_script('woocommerce');
	    	wp_deregister_script('wc-cart-fragments');
		    wp_enqueue_script('jquery');
	    } else {
	    	wp_deregister_script('jquery');
	    	wp_enqueue_script('jquery', includes_url('/js/jquery/jquery.min.js'), NULL, NULL, false);
	    }

//	    echo "<script>console.log('" .  . "')</script>";
//		wp_deregister_script('wc-single-product');
//	    if(is_product()) {
////		    wp_deregister_script( 'wc-add-to-cart-variation' );
////			wp_deregister_script('jquery-blockui');
//			wp_dequeue_script('jquery-blockui');
//	    }
        $styleVer = time();
        wp_enqueue_script( 'script-name', get_template_directory_uri() . '/static/site.min.js#asyncload', array('jquery'), null, true );
//        wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/style.min.css?' . $styleVer);
//        wp_enqueue_style('casino-style1', get_stylesheet_directory_uri() . '/static/css/siteLayout.css?' . $styleVer);
//        wp_enqueue_style('casino-style2', get_stylesheet_directory_uri() . '/static/css/normalization.css?' . $styleVer);
//        wp_enqueue_style('casino-style3', get_stylesheet_directory_uri() . '/static/css/frontPage.css?' . $styleVer);
//        wp_enqueue_style('casino-style4', get_stylesheet_directory_uri() . '/static/css/header.css?' . $styleVer);
//        wp_enqueue_style('casino-style5', get_stylesheet_directory_uri() . '/static/css/footer.css?' . $styleVer);
//        wp_enqueue_style('casino-style6', get_stylesheet_directory_uri() . '/static/css/articlePage.css?' . $styleVer);
//        wp_enqueue_style('casino-style7', get_stylesheet_directory_uri() . '/static/css/common.css?' . $styleVer);
//	    wp_enqueue_style('casino-style8', get_stylesheet_directory_uri() . '/static/css/tableOfContentsPage.css?' . $styleVer);
//	    wp_enqueue_style('casino-style9', get_stylesheet_directory_uri() . '/static/css/shop.css?' . $styleVer);
//	    wp_enqueue_style('casino-style10', get_stylesheet_directory_uri() . '/static/css/singleProduct.css?' . $styleVer);
//	    wp_enqueue_style('casino-style11', get_stylesheet_directory_uri() . '/static/css/checkout.css?' . $styleVer);
//	    wp_enqueue_style('casino-style12', get_stylesheet_directory_uri() . '/static/css/aboutMe.css?' . $styleVer);
//	    wp_enqueue_style('casino-style13', get_stylesheet_directory_uri() . '/static/css/page.css?' . $styleVer);
//	            wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/style.min.css?' . $styleVer);
//	    if(is_front_page()) {
//		    wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/static/css/productionFrontPage.min.css?', $styleVer);
//	    } else {
	    wp_enqueue_style('casino-style', get_stylesheet_directory_uri() . '/style.min.css', null, null, null,);
//	    }
	    wp_dequeue_style( 'wp-block-library' );
        wp_dequeue_style( 'wp-block-library-theme' );
    }
}

new StarterSite();
