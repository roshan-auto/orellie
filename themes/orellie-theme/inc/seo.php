<?php
/** Search metadata for the live WordPress storefront. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function orellie_help_metadata() {
	return array(
		'contact' => array( 'Contact Orellie', 'Contact Orellie with questions about your earrings, an order or the collection.' ),
		'shipping-delivery' => array( 'Shipping and Delivery', 'Read Orellie shipping and delivery information for your jewellery order.' ),
		'returns-exchanges' => array( 'Returns and Exchanges', 'Read Orellie returns and exchanges information and find out how to contact us about an order.' ),
		'jewellery-care' => array( 'Polymer Clay Jewellery Care & Cleaning Guide NZ', 'Complete guide on how to clean, store, and care for polymer clay earrings in New Zealand. Learn water safety, makeup removal, and 316L steel post sanitizing tips.' ),
		'orders' => array( 'Order Help', 'Find help with your Orellie order and contact details for order enquiries.' ),
		'privacy-policy' => array( 'Privacy Policy', 'Read the Orellie privacy policy, including how information is handled when you use the website.' ),
		'terms-of-use' => array( 'Terms of Use', 'Read the terms of use for the Orellie website and online store.' ),
		'gift-cards' => array( 'Gift Cards', 'Explore Orellie gift cards and read how they can be used in the online store.' ),
		'hypoallergenic-earrings-guide' => array( 'Hypoallergenic Earrings Guide NZ', 'The definitive New Zealand guide to hypoallergenic earrings for sensitive ears. Learn why medical-grade 316L surgical steel and lightweight polymer clay prevent irritation.' ),
		'gift-guide-handmade-earrings' => array( 'Gift Guide: Handmade Statement Earrings NZ', 'Curated gift guide for handcrafted statement earrings in New Zealand. Discover hypoallergenic polymer clay earrings for birthdays, anniversaries, and bridal gifts.' ),
		'statement-earrings-style-guide' => array( 'Statement Earrings Style Guide NZ | Handcrafted Dangles & Studs', 'Complete guide to styling handcrafted statement earrings in New Zealand. Learn how to match polymer clay dangles to face shapes, outfits, and occasions with 316L surgical steel comfort.' ),
	);
}

/** Match only real theme routes; /contact-fake and query strings never match. */
function orellie_help_slug() {
	 = wp_parse_url( wp_unslash( ['REQUEST_URI'] ?? '/' ), PHP_URL_PATH );
	 = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
	foreach ( orellie_help_metadata() as  =>  ) {
		if ( rtrim( (string) , '/' ) ===  . '/' .  ) { return ; }
	}
	return '';
}

/** A configured SEO plugin owns its own head output. */
function orellie_has_seo_plugin() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' );
}

function orellie_seo_description() {
	 = orellie_help_slug();
	if (  ) { return orellie_help_metadata()[  ][1]; }
	if ( is_front_page() ) {
		return 'Shop handcrafted polymer clay earrings made in Aotearoa New Zealand. Explore Orellie studs, hoops and dangles for everyday wear and gifts.';
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return 'Browse Orellie handcrafted polymer clay earrings. Explore the collection of studs, hoops and dangles made in Aotearoa New Zealand.';
	}
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		 = get_queried_object();
		 = trim( wp_strip_all_tags( term_description() ) );
		if (  ) { return wp_trim_words( , 28, '...' ); }
		 =  ? ->slug : '';
		if ( 'studs' ===  ) {
			return 'Shop handcrafted polymer clay stud earrings made in New Zealand. Impossibly lightweight with hypoallergenic 316L surgical steel posts for sensitive ears.';
		} elseif ( 'dangles' ===  ) {
			return 'Discover handcrafted statement dangle earrings made in New Zealand from lightweight polymer clay (2–5g). Zero earlobe strain with medical-grade 316L surgical steel posts.';
		}
		 =  ? ->name : 'Handmade Earrings';
		return 'Shop handcrafted ' . esc_attr( strtolower(  ) ) . ' made in Aotearoa New Zealand from lightweight polymer clay. Hypoallergenic 316L surgical steel posts for sensitive ears.';
	}
	if ( is_singular() ) {
		 = get_queried_object();
		 = ->post_excerpt ?: ->post_content;
		 = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( strip_shortcodes(  ) ) ) );
		if (  ) { return wp_trim_words( , 28, '...' ); }
		return 'Read ' . get_the_title() . ' on Orellie.';
	}
	if ( is_tax() || is_category() || is_tag() ) {
		 = trim( wp_strip_all_tags( term_description() ) );
		return  ? wp_trim_words( , 28, '...' ) : 'Browse ' . single_term_title( '', false ) . ' from Orellie.';
	}
	return '';
}

function orellie_seo_title_parts(  ) {
	if ( orellie_has_seo_plugin() ) { return ; }
	 = orellie_help_slug();
	if (  ) { ['title'] = orellie_help_metadata()[  ][0]; }
	elseif ( is_front_page() ) { ['title'] = 'Handcrafted Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_shop' ) && is_shop() ) { ['title'] = 'Shop Handmade Polymer Clay Earrings NZ'; }
	elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		 = get_queried_object();
		 =  ? ->slug : '';
		if ( 'studs' ===  ) {
			['title'] = 'Handcrafted Stud Earrings NZ | Lightweight Polymer Clay';
		} elseif ( 'dangles' ===  ) {
			['title'] = 'Handmade Statement Dangles NZ | Polymer Clay Earrings';
		} else {
			['title'] = (  ? ->name : 'Earrings' ) . ' | Handcrafted Polymer Clay Jewellery NZ';
		}
	}
	else { return ; }
	['site'] = 'Orellie';
	unset( ['tagline'] );
	return ;
}
add_filter( 'document_title_parts', 'orellie_seo_title_parts' );

function orellie_seo_head() {
	if ( orellie_has_seo_plugin() || is_404() || is_search() ) { return; }
	 = orellie_seo_description();
	if ( !  ) { return; }
	 = orellie_help_slug();
	 = '';
	 = false;
	if (  ) {
		 = home_url( '/' .  . '/' );
		 = ! is_singular();
	} elseif ( is_singular() ) {
		 = wp_get_canonical_url();
	} elseif ( is_front_page() ) {
		 = home_url( '/' );
		 = true;
	} elseif ( ( function_exists( 'is_shop' ) && is_shop() ) || is_tax() || is_category() || is_tag() ) {
		// Keep pagination, but omit sorting/tracking parameters from the canonical.
		 = strtok( get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ), false ), '?' );
		 = true;
	}
	 = wp_get_document_title();
	 = get_template_directory_uri() . '/assets/images/hero-poster.jpg';
	if ( is_singular() && has_post_thumbnail() ) {  = get_the_post_thumbnail_url( null, 'large' ); }
	echo '<meta name=description content= . esc_attr( $description ) . >' . "
";
	if (  &&  ) { echo '<link rel=canonical href= . esc_url( $canonical ) . >' . "
"; }
	 = array( 'og:type' => 'website', 'og:site_name' => 'Orellie', 'og:locale' => 'en_NZ', 'og:title' => , 'og:description' => , 'og:image' =>  );
	if (  ) { ['og:url'] = ; }
	foreach (  as  =>  ) { echo '<meta property= . esc_attr( $property ) .  content= . esc_attr( $value ) . >' . "
"; }
	foreach ( array( 'twitter:card' => 'summary_large_image', 'twitter:title' => , 'twitter:description' => , 'twitter:image' =>  ) as  =>  ) {
		echo '<meta name= . esc_attr( $name ) .  content= . esc_attr( $value ) . >' . "
";
	}
	if ( is_front_page() ) {
		 = home_url( '/' );
		 = array(
			array( '@type' => 'Organization', '@id' =>  . '#organization', 'name' => 'Orellie', 'url' => , 'logo' => get_template_directory_uri() . '/assets/images/orellie-logo.png', 'sameAs' => array( 'https://www.facebook.com/orellienzart', 'https://www.instagram.com/orellienzart/', 'https://www.tiktok.com/@orellienz' ) ),
			array( '@type' => 'WebSite', '@id' =>  . '#website', 'name' => 'Orellie', 'url' => , 'inLanguage' => 'en-NZ', 'publisher' => array( '@id' =>  . '#organization' ) ),
		);
		echo '<script type=application/ld+json>' . wp_json_encode( array( '@context' => 'https://schema.org', '@graph' =>  ), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	}
	if (  ) {
		 = array(
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
					'name' => orellie_help_metadata()[  ][0],
					'item' => home_url( '/' .  . '/' ),
				),
			),
		);
		echo '<script type=application/ld+json>' . wp_json_encode( , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	} elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
		 = get_queried_object();
		 = array(
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
					'name' =>  ? ->name : 'Earrings',
					'item' => ,
				),
			),
		);
		echo '<script type=application/ld+json>' . wp_json_encode( , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT ) . '</script>' . "
";
	}
}
add_action( 'wp_head', 'orellie_seo_head', 5 );

/** Enrich WooCommerce Product JSON-LD schema with Brand, NZ Origin, Materials & Shipping/Returns. */
add_filter( 'woocommerce_structured_data_product', function ( ,  ) {
	if ( ! is_array(  ) ) { return ; }
	['brand'] = array(
		'@type' => 'Brand',
		'name'  => 'Orellie',
	);
	['countryOfOrigin'] = array(
		'@type' => 'Country',
		'name'  => 'New Zealand',
	);
	['material'] = 'Polymer Clay, 316L Surgical Steel';
	['category'] = 'Earrings > Handmade Polymer Clay Earrings';
	['audience'] = array(
		'@type' => 'PeopleAudience',
		'suggestedGender' => 'female',
		'geographicArea' => array(
			'@type' => 'Country',
			'name'  => 'New Zealand',
		),
	);
	['additionalProperty'] = array(
		array(
			'@type' => 'PropertyValue',
			'name'  => 'Weight',
			'value' => '2–5g (Featherlight)',
		),
		array(
			'@type' => 'PropertyValue',
			'name'  => 'Post Material',
			'value' => '316L Medical Grade Surgical Stainless Steel',
		),
		array(
			'@type' => 'PropertyValue',
			'name'  => 'Handcrafted Location',
			'value' => 'Aotearoa New Zealand',
		),
	);
	if ( ! empty( ['offers'] ) && is_array( ['offers'] ) ) {
		 = (int) date( 'Y' ) + 1;
		foreach ( ['offers'] as  =>  ) {
			['offers'][  ]['itemCondition'] = 'https://schema.org/NewCondition';
			['offers'][  ]['priceValidUntil'] =  . '-12-31';
			['offers'][  ]['seller'] = array(
				'@type' => 'Organization',
				'name'  => 'Orellie',
				'url'   => home_url( '/' ),
			);
			['offers'][  ]['shippingDetails'] = array(
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
			['offers'][  ]['hasMerchantReturnPolicy'] = array(
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
	return ;
}, 10, 2 );

/** Add on-page NZ trust and delivery signals on single product pages. */
function orellie_single_product_trust_signals() {
	?>
	<div class="product-trust-card" style="margin: 1.5rem 0 2rem; padding: 1.25rem 1.5rem; background: #faf9f6; border: 1px solid var(--border, #e8e2dc); border-radius: 8px;">
		<h4 style="margin: 0 0 0.75rem; font-family: var(--font-serif, serif); font-size: 1.05rem; font-weight: 500; color: var(--foreground, #1a1a1a);">
			The Orellie Craftsmanship Promise
		</h4>
		<ul style="margin: 0; padding-left: 1.2rem; font-size: 0.875rem; line-height: 1.6; color: #4a4a4a;">
			<li style="margin-bottom: 0.35rem;"><strong>Handmade in Aotearoa:</strong> Sculpted, baked, and finished by hand in small artisan batches.</li>
			<li style="margin-bottom: 0.35rem;"><strong>Sensitive Ears Safe:</strong> Medical-grade <strong>316L surgical stainless steel</strong> posts &mdash; biocompatible and tarnish-free.</li>
			<li style="margin-bottom: 0.35rem;"><strong>Featherlight Weight (2&ndash;5g):</strong> All-day statement wear without earlobe drag or pulling.</li>
			<li style="margin-bottom: 0.35rem;"><strong>Tracked NZ Shipping:</strong> Nationwide tracked delivery (.50 flat rate, free on orders over 0).</li>
			<li><strong>Gift-Ready Presentation:</strong> Delivered in our signature rigid box, perfect for birthdays and celebrations.</li>
		</ul>
	</div>
	<?php
}
add_action( 'woocommerce_single_product_summary', 'orellie_single_product_trust_signals', 35 );

/** Ensure all product and gallery images have rich semantic alt attributes for image search. */
add_filter( 'wp_get_attachment_image_attributes', function ( ,  ) {
	if ( is_admin() ) {
		return ;
	}
	 = trim( ['alt'] ?? '' );
	if ( empty(  ) || strtolower(  ) === 'image' || strtolower(  ) === 'product' ) {
		 = get_the_title();
		if (  && ( is_product() || ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_category' ) && is_product_category() ) ) ) {
			['alt'] = esc_attr(  . ' - Handcrafted Polymer Clay Earrings NZ | Orellie' );
		}
	}
	return ;
}, 10, 2 );

/** Theme-backed help pages need a provider because they may have no DB rows. */
add_action( 'wp_sitemaps_init', function () {
	 = new class extends WP_Sitemaps_Provider {
		public function __construct() { ->name = 'orelliehelp'; ->object_type = 'orelliehelp'; }
		public function get_url_list( ,  = '' ) {
			if ( (int)  !== 1 ) { return array(); }
			 = array();
			foreach ( orellie_help_metadata() as  =>  ) {
				// Core already lists published pages. Order lookup is a utility page.
				 = get_page_by_path(  );
				if (  === 'orders' || (  && ->post_status === 'publish' ) ) { continue; }
				if ( file_exists( get_template_directory() . '/page-' .  . '.php' ) ) { [] = array( 'loc' => home_url( '/' .  . '/' ) ); }
			}
			return ;
		}
		public function get_max_num_pages(  = '' ) { return ->get_url_list( 1 ) ? 1 : 0; }
	};
	wp_register_sitemap_provider( 'orelliehelp',  );
} );
