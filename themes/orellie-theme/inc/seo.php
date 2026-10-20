<?php
/** Search metadata for the live WordPress storefront. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function orellie_help_metadata() {
	return array(
		'contact' => array( 'Contact Orellie', 'Contact Orellie with questions about your earrings, an order or the collection.' ),
		'shipping-delivery' => array( 'Shipping and Delivery', 'Read Orellie shipping and delivery information for your jewellery order.' ),
		'returns-exchanges' => array( 'Returns and Exchanges', 'Read Orellie returns and exchanges information and find out how to contact us about an order.' ),
		'jewellery-care' => array( 'Earring Care & Cleaning Guide NZ', 'How to clean, store and care for resin and polymer clay earrings in New Zealand: water, makeup removal and cleaning 316L steel posts.' ),
		'orders' => array( 'Order Help', 'Find help with your Orellie order and contact details for order enquiries.' ),
		'privacy-policy' => array( 'Privacy Policy', 'Read the Orellie privacy policy, including how information is handled when you use the website.' ),
		'terms-of-use' => array( 'Terms of Use', 'Read the terms of use for the Orellie website and online store.' ),
		'gift-cards' => array( 'Gift Cards', 'Explore Orellie gift cards and read how they can be used in the online store.' ),
		'hypoallergenic-earrings-guide' => array( 'Hypoallergenic Earrings Guide NZ', 'A New Zealand guide to hypoallergenic earrings for sensitive ears. Learn why the post metal and the weight of an earring both matter.' ),
		'gift-guide-handmade-earrings' => array( 'Gift Guide: Handmade Statement Earrings NZ', 'Curated gift guide for handcrafted statement earrings in New Zealand. Discover resin and polymer clay earrings with 316L surgical steel posts for birthdays, anniversaries, and bridal gifts.' ),
		'statement-earrings-style-guide' => array( 'Statement Earrings Style Guide NZ | Handcrafted Dangles & Studs', 'Complete guide to styling handcrafted statement earrings in New Zealand. Learn how to match handmade dangles to face shapes, outfits, and occasions, all on 316L surgical steel posts.' ),
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
		return 'Shop handcrafted resin and polymer clay earrings made in Aotearoa New Zealand. Explore Orellie studs, hoops and dangles for everyday wear and gifts.';
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return 'Browse Orellie handcrafted resin and polymer clay earrings. Explore the collection of studs, hoops and dangles made in Aotearoa New Zealand.';
	}
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$term = get_queried_object();
		$term_desc = trim( wp_strip_all_tags( term_description() ) );
		if ( $term_desc ) { return wp_trim_words( $term_desc, 28, '...' ); }
		$cat_slug = $term ? $term->slug : '';
		if ( 'studs' === $cat_slug ) {
			return 'Shop handcrafted stud earrings made in New Zealand, in resin and polymer clay, with 316L surgical steel posts chosen for sensitive ears.';
		} elseif ( 'dangles' === $cat_slug ) {
			return 'Discover handcrafted statement dangle earrings made in New Zealand, in resin and polymer clay, with 316L surgical steel posts chosen for sensitive ears.';
		}
		$cat_title = $term ? $term->name : 'Handmade Earrings';
		return 'Shop handcrafted ' . esc_attr( strtolower( $cat_title ) ) . ' made in Aotearoa New Zealand, with 316L surgical steel posts chosen for sensitive ears.';
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
	elseif ( is_front_page() ) { $parts['title'] = 'Handcrafted Resin & Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_shop' ) && is_shop() ) { $parts['title'] = 'Shop Handmade Resin & Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$cat = get_queried_object();
		$cat_slug = $cat ? $cat->slug : '';
		if ( 'studs' === $cat_slug ) {
			$parts['title'] = 'Handcrafted Stud Earrings NZ | Resin & Polymer Clay';
		} elseif ( 'dangles' === $cat_slug ) {
			$parts['title'] = 'Handmade Statement Dangles NZ | Resin & Polymer Clay';
		} else {
			$parts['title'] = ( $cat ? $cat->name : 'Earrings' ) . ' | Handcrafted Earrings NZ';
		}
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
	echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "
";
	if ( $needs_canonical && $canonical ) { echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "
"; }
	$tags = array( 'og:type' => 'website', 'og:site_name' => 'Orellie', 'og:locale' => 'en_NZ', 'og:title' => $title, 'og:description' => $description, 'og:image' => $image );
	if ( $canonical ) { $tags['og:url'] = $canonical; }
	foreach ( $tags as $property => $value ) { echo '<meta property="' . esc_attr( $property ) . '" content="' . esc_attr( $value ) . '">' . "
"; }
	foreach ( array( 'twitter:card' => 'summary_large_image', 'twitter:title' => $title, 'twitter:description' => $description, 'twitter:image' => $image ) as $name => $value ) {
		echo '<meta name="' . esc_attr( $name ) . '" content="' . esc_attr( $value ) . '">' . "
";
	}
	if ( is_front_page() ) {
		$origin = home_url( '/' );
		$graph = array(
			array( '@type' => 'Organization', '@id' => $origin . '#organization', 'name' => 'Orellie', 'url' => $origin, 'logo' => get_template_directory_uri() . '/assets/images/orellie-logo.png', 'sameAs' => array( 'https://www.facebook.com/orellienzart', 'https://www.instagram.com/orellienzart/', 'https://www.tiktok.com/@orellienz' ) ),
			array( '@type' => 'WebSite', '@id' => $origin . '#website', 'name' => 'Orellie', 'url' => $origin, 'inLanguage' => 'en-NZ', 'publisher' => array( '@id' => $origin . '#organization' ) ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	}
	if ( $help ) {
		$breadcrumb_graph = array(
			'@context' => 'https://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type' => 'ListItem',
					'position' => 1,
					'name' => 'Home',
					'item' => home_url( '/' ),
				),
				array(
					'@type' => 'ListItem',
					'position' => 2,
					'name' => orellie_help_metadata()[ $help ][0],
					'item' => home_url( '/' . $help . '/' ),
				),
			),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb_graph, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	} elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		$term = get_queried_object();
		$breadcrumb_graph = array(
			'@context' => 'https://schema.org',
			'@type' => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type' => 'ListItem',
					'position' => 1,
					'name' => 'Home',
					'item' => home_url( '/' ),
				),
				array(
					'@type' => 'ListItem',
					'position' => 2,
					'name' => 'Shop',
					'item' => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ),
				),
				array(
					'@type' => 'ListItem',
					'position' => 3,
					'name' => $term ? $term->name : 'Earrings',
					'item' => $canonical,
				),
			),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $breadcrumb_graph, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	}
}
add_action( 'wp_head', 'orellie_seo_head', 5 );

/**
 * The earring's body material as orellie.com states it: 'Resin', 'Polymer clay' or ''.
 * Set per product by scripts/orellie-import/sync-materials.py. Empty means .com says
 * nothing, so the site says nothing: resin and clay pieces differ in weight and feel.
 */
function orellie_product_material( $product ) {
	if ( ! $product instanceof WC_Product ) { return ''; }
	$labels = array( 'resin' => 'Resin', 'polymer-clay' => 'Polymer clay' );
	$key = (string) $product->get_meta( '_orellie_material' );
	return $labels[ $key ] ?? '';
}

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
	$material = orellie_product_material( $product );
	$markup['material'] = $material ? $material . ', 316L Surgical Steel' : '316L Surgical Steel';
	$markup['category'] = 'Earrings';
	$markup['audience'] = array(
		'@type' => 'PeopleAudience',
		'suggestedGender' => 'female',
		'geographicArea' => array(
			'@type' => 'Country',
			'name'  => 'New Zealand',
		),
	);
	$markup['additionalProperty'] = array(
		array(
			'@type' => 'PropertyValue',
			'name'  => 'Post Material',
			'value' => '316L Surgical Steel',
		),
		array(
			'@type' => 'PropertyValue',
			'name'  => 'Handcrafted Location',
			'value' => 'Aotearoa New Zealand',
		),
	);
	if ( ! empty( $markup['offers'] ) && is_array( $markup['offers'] ) ) {
		$next_year = (int) date( 'Y' ) + 1;
		foreach ( $markup['offers'] as $key => $offer ) {
			$markup['offers'][ $key ]['itemCondition'] = 'https://schema.org/NewCondition';
			$markup['offers'][ $key ]['priceValidUntil'] = $next_year . '-12-31';
			$markup['offers'][ $key ]['seller'] = array(
				'@type' => 'Organization',
				'name'  => 'Orellie',
				'url'   => home_url( '/' ),
			);
			$markup['offers'][ $key ]['shippingDetails'] = array(
				'@type' => 'OfferShippingDetails',
				'shippingRate' => array(
					'@type' => 'MonetaryAmount',
					'value' => '6.00',
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
				'merchantReturnDays' => 7,
				'returnMethod' => 'https://schema.org/ReturnByMail',
				'returnFees' => 'https://schema.org/CustomerRemorseReturnFees',
				'url' => home_url( '/returns-exchanges/' ),
			);
		}
	}
	return $markup;
}, 10, 2 );

/** Add on-page NZ trust and delivery signals on single product pages. Every line must hold for this product. */
function orellie_single_product_trust_signals() {
	global $product;
	if ( ! $product instanceof WC_Product || $product->is_virtual() || $product->is_type( 'pw-gift-card' ) ) { return; }
	$material = orellie_product_material( $product );
	?>
	<div class="product-trust-card" style="margin: 1.5rem 0 2rem; padding: 1.25rem 1.5rem; background: #faf9f6; border: 1px solid var(--border, #e8e2dc); border-radius: 8px;">
		<h4 style="margin: 0 0 0.75rem; font-family: var(--font-serif, serif); font-size: 1.05rem; font-weight: 500; color: var(--foreground, #1a1a1a);">
			The Orellie Craftsmanship Promise
		</h4>
		<ul style="margin: 0; padding-left: 1.2rem; font-size: 0.875rem; line-height: 1.6; color: #4a4a4a;">
			<li style="margin-bottom: 0.35rem;"><strong>Handmade in Aotearoa:</strong> Made and finished by hand in small artisan batches.</li>
			<?php if ( $material ) : ?>
			<li style="margin-bottom: 0.35rem;"><strong>Material:</strong> <?php echo esc_html( $material ); ?>.</li>
			<?php endif; ?>
			<li style="margin-bottom: 0.35rem;"><strong>For Sensitive Ears:</strong> <strong>316L surgical steel</strong> posts, chosen for sensitive ears.</li>
			<li style="margin-bottom: 0.35rem;"><strong>Tracked NZ Shipping:</strong> Nationwide delivery from $6, free on orders over $80.</li>
			<li><strong>Gift-Ready Presentation:</strong> Every order comes gift-packaged, perfect for birthdays and celebrations.</li>
		</ul>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'orellie_single_product_trust_signals', 35 );
/** Ensure all product and gallery images have rich semantic alt attributes for image search. */
add_filter( 'wp_get_attachment_image_attributes', function ( $attr, $attachment ) {
	if ( is_admin() ) {
		return $attr;
	}
	$alt = trim( $attr['alt'] ?? '' );
	if ( empty( $alt ) || strtolower( $alt ) === 'image' || strtolower( $alt ) === 'product' ) {
		$title = get_the_title();
		if ( $title && ( ( function_exists( 'is_product' ) && is_product() ) || ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) ) ) {
			$attr['alt'] = esc_attr( $title . ' - Handmade Earrings NZ | Orellie' );
		}
	}
	return $attr;
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
