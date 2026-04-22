<?php
/**
 * Orellie Theme Functions
 *
 * @package Orellie
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ────────────────────────────────────────────────
   1. Theme Setup
   ──────────────────────────────────────────────── */

function orellie_setup() {
	// Let WP manage the document <title>
	add_theme_support( 'title-tag' );

	// Post thumbnails (used by WooCommerce for product images)
	add_theme_support( 'post-thumbnails' );

	// HTML5 support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 60,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// WooCommerce support
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	// Navigation menus
	register_nav_menus( array(
		'primary'   => __( 'Primary Navigation', 'orellie' ),
		'footer'    => __( 'Footer Navigation', 'orellie' ),
	) );
}
add_action( 'after_setup_theme', 'orellie_setup' );

/* ────────────────────────────────────────────────
   2. Enqueue Styles & Scripts
   ──────────────────────────────────────────────── */

function orellie_enqueue_assets() {
	// Google Fonts — Playfair Display + Inter
	wp_enqueue_style(
		'orellie-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,300;1,400&display=swap',
		array(),
		null
	);

	// Main theme stylesheet
	wp_enqueue_style(
		'orellie-style',
		get_stylesheet_uri(),
		array( 'orellie-google-fonts' ),
		filemtime( get_stylesheet_directory() . '/style.css' ) // Dynamic cache buster based on exact file save time
	);

	// Theme JS
	wp_enqueue_script(
		'orellie-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		filemtime( get_template_directory() . '/assets/js/main.js' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'orellie_enqueue_assets' );

/* ────────────────────────────────────────────────
   3. WooCommerce Tweaks
   ──────────────────────────────────────────────── */

// Change number of products per row to 3
add_filter( 'loop_shop_columns', function () {
	return 3;
} );

// Products per page
add_filter( 'loop_shop_per_page', function () {
	return 12;
} );

// Remove default WooCommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Cart fragment for AJAX cart count
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$count = WC()->cart->get_cart_contents_count();
	$fragments['.cart-count'] = $count > 0
		? '<span class="cart-count">' . esc_html( $count ) . '</span>'
		: '';
	return $fragments;
} );

// Wrap product images in a container for styling
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', function () {
	echo '<div class="product-card__image">';
	woocommerce_template_loop_product_thumbnail();
	echo '<div class="product-card__quickview"><span>View Details →</span></div>';
	echo '</div>';
}, 10 );

/* ────────────────────────────────────────────────
   4. Theme Widgets
   ──────────────────────────────────────────────── */

function orellie_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Footer Column 1', 'orellie' ),
		'id'            => 'footer-1',
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'orellie_widgets_init' );

/* ────────────────────────────────────────────────
   5. Helper Functions
   ──────────────────────────────────────────────── */

/**
 * Get the current WooCommerce cart count (0 if WC is not active).
 */
function orellie_cart_count() {
	if ( class_exists( 'WooCommerce' ) && WC()->cart ) {
		return WC()->cart->get_cart_contents_count();
	}
	return 0;
}

/**
 * Safe get_template_part wrapper that falls back gracefully.
 */
function orellie_get_part( $slug, $name = null ) {
	get_template_part( 'template-parts/' . $slug, $name );
}

/* ────────────────────────────────────────────────
   6. Development Interceptor (Local Visibility)
   ──────────────────────────────────────────────── */

/**
 * Intercept help page requests to show templates even if pages aren't in the DB.
 * This is for local development visibility.
 */
function orellie_intercept_help_pages() {
	if ( is_admin() ) return;

	$request_uri = $_SERVER['REQUEST_URI'];
	$slugs = array(
		'shipping-delivery',
		'returns-exchanges',
		'jewellery-care',
		'orders',
		'privacy-policy',
		'terms-of-use'
	);

	foreach ( $slugs as $slug ) {
		if ( strpos( $request_uri, '/' . $slug ) !== false ) {
			$template = get_template_directory() . '/page-' . $slug . '.php';
			if ( file_exists( $template ) ) {
				include $template;
				exit;
			}
		}
	}
}
add_action( 'template_redirect', 'orellie_intercept_help_pages', 5 );

/* ────────────────────────────────────────────────
   7. Custom Includes
   ──────────────────────────────────────────────── */
require get_template_directory() . '/inc/custom-meta.php';
