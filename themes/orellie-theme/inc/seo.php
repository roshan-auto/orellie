<?php
/** Search metadata for the live WordPress storefront. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function orellie_help_metadata() {
	return array(
		'contact' => array( 'Contact Orellie', 'Contact Orellie with questions about your earrings, an order or the collection.' ),
		'shipping-delivery' => array( 'Shipping and Delivery', 'Read Orellie shipping and delivery information for your jewellery order.' ),
		'returns-exchanges' => array( 'Returns and Exchanges', 'Read Orellie returns and exchanges information and find out how to contact us about an order.' ),
		'jewellery-care' => array( 'Jewellery Care', 'Learn how to store, clean and care for your Orellie polymer clay earrings.' ),
		'orders' => array( 'Order Help', 'Find help with your Orellie order and contact details for order enquiries.' ),
		'privacy-policy' => array( 'Privacy Policy', 'Read the Orellie privacy policy, including how information is handled when you use the website.' ),
		'terms-of-use' => array( 'Terms of Use', 'Read the terms of use for the Orellie website and online store.' ),
		'gift-cards' => array( 'Gift Cards', 'Explore Orellie gift cards and read how they can be used in the online store.' ),
		'hypoallergenic-earrings-guide' => array( 'Hypoallergenic Earrings Guide NZ', 'Complete guide to hypoallergenic earrings for sensitive ears in New Zealand. Learn why 316L surgical steel and lightweight polymer clay prevent irritation.' ),
		'gift-guide-handmade-earrings' => array( 'Gift Guide: Handmade Statement Earrings NZ', 'Explore handcrafted statement earrings and boutique jewellery gifts in New Zealand. Curated gift guide for birthdays, anniversaries, and bridal parties.' ),
	);
}

/** Match only real theme routes; /contact-fake and query strings never match. */
function orellie_help_slug() {
	$path = wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ), PHP_URL_PATH );
	$base = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	foreach ( orellie_help_metadata() as $slug => $metadata ) {
		if ( rtrim( (string) $path, '/' ) === $base . '/' . $slug ) { return $slug; }
	}
	return '';
}

/** A configured SEO plugin owns its own head output. */
function orellie_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function orellie_seo_description() {
	$help = orellie_help_slug();
	if ( $help ) { return orellie_help_metadata()[ $help ][1]; }
	if ( is_front_page() ) {
		return 'Shop handcrafted polymer clay earrings made in Aotearoa New Zealand. Explore Orellie studs, hoops and dangles for everyday wear and gifts.';
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return 'Browse Orellie handcrafted polymer clay earrings. Explore the collection of studs, hoops and dangles made in Aotearoa New Zealand.';
	}
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$term = get_queried_object();
		$term_desc = trim( wp_strip_all_tags( term_description() ) );
		if ( $term_desc ) { return wp_trim_words( $term_desc, 28, '...' ); }
		$cat_title = $term ? $term->name : 'Handmade Earrings';
		return 'Shop handcrafted ' . esc_attr( strtolower( $cat_title ) ) . ' made in Aotearoa New Zealand from lightweight polymer clay. Hypoallergenic 316L surgical steel posts for sensitive ears.';
	}
	if ( is_singular() ) {
		$post = get_queried_object();
		$text = $post->post_excerpt ?: $post->post_content;
		$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( strip_shortcodes( $text ) ) ) );
		if ( $text ) { return wp_trim_words( $text, 28, '...' ); }
		return 'Read ' . get_the_title() . ' on Orellie.';
	}
	if ( is_tax() || is_category() || is_tag() ) {
		$text = trim( wp_strip_all_tags( term_description() ) );
		return $text ? wp_trim_words( $text, 28, '...' ) : 'Browse ' . single_term_title( '', false ) . ' from Orellie.';
	}
	return '';
}

function orellie_seo_title_parts( $parts ) {
	if ( orellie_has_seo_plugin() ) { return $parts; }
	$help = orellie_help_slug();
	if ( $help ) { $parts['title'] = orellie_help_metadata()[ $help ][0]; }
	elseif ( is_front_page() ) { $parts['title'] = 'Handcrafted Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_shop' ) && is_shop() ) { $parts['title'] = 'Shop Handmade Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$cat = get_queried_object();
		$parts['title'] = ( $cat ? $cat->name : 'Earrings' ) . ' | Handcrafted Polymer Clay Jewellery NZ';
	}
	else { return $parts; }
	$parts['site'] = 'Orellie';
	unset( $parts['tagline'] );
	return $parts;
}
add_filter( 'document_title_parts', 'orellie_seo_title_parts' );

function orellie_seo_head() {
	if ( orellie_has_seo_plugin() || is_404() || is_search() ) { return; }
	$description = orellie_seo_description();
	if ( ! $description ) { return; }
	$help = orellie_help_slug();
	$canonical = '';
	$needs_canonical = false;
	if ( $help ) {
		$canonical = home_url( '/' . $help . '/' );
		$needs_canonical = ! is_singular();
	} elseif ( is_singular() ) {
		$canonical = wp_get_canonical_url();
	} elseif ( is_front_page() ) {
		$canonical = home_url( '/' );
		$needs_canonical = true;
	} elseif ( ( function_exists( 'is_shop' ) && is_shop() ) || is_tax() || is_category() || is_tag() ) {
		// Keep pagination, but omit sorting/tracking parameters from the canonical.
		$canonical = strtok( get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ), false ), '?' );
		$needs_canonical = true;
	}
	$title = wp_get_document_title();
	$image = get_template_directory_uri() . '/assets/images/hero-poster.jpg';
	if ( is_singular() && has_post_thumbnail() ) { $image = get_the_post_thumbnail_url( null, 'large' ); }
	echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	if ( $needs_canonical && $canonical ) { echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n"; }
	$tags = array( 'og:type' => 'website', 'og:site_name' => 'Orellie', 'og:locale' => 'en_NZ', 'og:title' => $title, 'og:description' => $description, 'og:image' => $image );
	if ( $canonical ) { $tags['og:url'] = $canonical; }
	foreach ( $tags as $property => $value ) { echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $value ) . '">' . "\n"; }
	foreach ( array( 'twitter:card' => 'summary_large_image', 'twitter:title' => $title, 'twitter:description' => $description, 'twitter:image' => $image ) as $name => $value ) {
		echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $value ) . '">' . "\n";
	}
	if ( is_front_page() ) {
		$origin = home_url( '/' );
		$graph = array(
			array( '@type' => 'Organization', '@id' => $origin . '#organization', 'name' => 'Orellie', 'url' => $origin, 'logo' => get_template_directory_uri() . '/assets/images/orellie-logo.png' ),
			array( '@type' => 'WebSite', '@id' => $origin . '#website', 'name' => 'Orellie', 'url' => $origin, 'inLanguage' => 'en-NZ', 'publisher' => array( '@id' => $origin . '#organization' ) ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "\n";
	}
}
add_action( 'wp_head', 'orellie_seo_head', 5 );

/** Enrich WooCommerce Product JSON-LD schema with Brand, NZ Origin, Materials & Shipping/Returns. */
add_filter( 'woocommerce_structured_data_product', function ( $markup, $product ) {
	if ( ! is_array( $markup ) ) { return $markup; }
	$markup['brand'] = array(
		'@type' => 'Brand',
		'name'  => 'Orellie',
	);
	$markup['countryOfOrigin'] = array(
		'@type' => 'Country',
		'name'  => 'New Zealand',
	);
	$markup['material'] = 'Polymer Clay, 316L Surgical Steel';
	if ( ! empty( $markup['offers'] ) && is_array( $markup['offers'] ) ) {
		foreach ( $markup['offers'] as $key => $offer ) {
			$markup['offers'][ $key ]['itemCondition'] = 'https://schema.org/NewCondition';
			$markup['offers'][ $key ]['shippingDetails'] = array(
				'@type' => 'OfferShippingDetails',
				'shippingRate' => array(
					'@type' => 'MonetaryAmount',
					'value' => '6.50',
					'currency' => 'NZD',
				),
				'shippingDestination' => array(
					'@type' => 'DefinedRegion',
					'addressCountry' => 'NZ',
				),
				'deliveryTime' => array(
					'@type' => 'ShippingDeliveryTime',
					'handlingTime' => array(
						'@type' => 'QuantitativeValue',
						'minValue' => 1,
						'maxValue' => 2,
						'unitCode' => 'd',
					),
					'transitTime' => array(
						'@type' => 'QuantitativeValue',
						'minValue' => 1,
						'maxValue' => 3,
						'unitCode' => 'd',
					),
				),
			);
			$markup['offers'][ $key ]['hasMerchantReturnPolicy'] = array(
				'@type' => 'MerchantReturnPolicy',
				'applicableCountry' => 'NZ',
				'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
				'merchantReturnDays' => 14,
				'returnMethod' => 'https://schema.org/ReturnByMail',
				'returnFees' => 'https://schema.org/CustomerRemorseReturnFees',
				'url' => home_url( '/returns-exchanges/' ),
			);
		}
	}
	return $markup;
}, 10, 2 );

/** Theme-backed help pages need a provider because they may have no DB rows. */
add_action( 'wp_sitemaps_init', function () {
	$provider = new class extends WP_Sitemaps_Provider {
		public function __construct() { $this->name = 'orelliehelp'; $this->object_type = 'orelliehelp'; }
		public function get_url_list( $page_num, $object_subtype = '' ) {
			if ( (int) $page_num !== 1 ) { return array(); }
			$urls = array();
			foreach ( orellie_help_metadata() as $slug => $metadata ) {
				// Core already lists published pages. Order lookup is a utility page.
				$page = get_page_by_path( $slug );
				if ( $slug === 'orders' || ( $page && $page->post_status === 'publish' ) ) { continue; }
				if ( file_exists( get_template_directory() . '/page-' . $slug . '.php' ) ) { $urls[] = array( 'loc' => home_url( '/' . $slug . '/' ) ); }
			}
			return $urls;
		}
		public function get_max_num_pages( $object_subtype = '' ) { return $this->get_url_list( 1 ) ? 1 : 0; }
	};
	wp_register_sitemap_provider( 'orelliehelp', $provider );
} );
