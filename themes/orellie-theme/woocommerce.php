<?php

/**

 * Orellie Theme - WooCommerce Archive (Shop & Category Pages) Wrapper

 *

 * @package Orellie

 */



get_header(); 



if ( ! is_product() ) :



// Short hero copy based on archive context: one line, the grid does the selling.
$hero_title = 'Wear What You <span class="accent">Feel.</span>';
$hero_desc  = 'Handcrafted in New Zealand. Featherlight to wear, on 316L surgical steel for sensitive ears.';
$current    = '';

if ( function_exists( 'is_product_category' ) && is_product_category() ) {
	$term    = get_queried_object();
	$current = $term ? $term->slug : '';
	if ( 'studs' === $current ) {
		$hero_title = 'Stud <span class="accent">Earrings</span>';
		$hero_desc  = 'Featherlight everyday studs on 316L surgical steel posts.';
	} elseif ( 'dangles' === $current ) {
		$hero_title = 'Statement <span class="accent">Dangles</span>';
		$hero_desc  = 'Bold shapes that stay featherlight, on 316L surgical steel.';
	} else {
		$hero_title = esc_html( single_term_title( '', false ) );
		$term_desc  = trim( wp_strip_all_tags( term_description() ) );
		if ( $term_desc ) {
			// First sentence only, so the hero stays one line.
			$parts     = preg_split( '/(?<=[.!?])\s+/', $term_desc, 2 );
			$hero_desc = $parts[0];
		}
	}
}

// Category chips: quick ways into the range, empty ones skipped.
$chip_slugs = array( 'studs', 'dangles', 'hoops', 'halloween', 'collections' );
$chips      = array();
foreach ( $chip_slugs as $chip_slug ) {
	$chip_term = get_term_by( 'slug', $chip_slug, 'product_cat' );
	if ( $chip_term && ! is_wp_error( $chip_term ) && $chip_term->count > 0 ) {
		$chips[] = $chip_term;
	}
}
?>

<!-- Shop hero banner -->
<section class="hero shop-hero">
  <div class="hero__blob"></div>
  <div class="container shop-hero__inner">
    <h1 class="shop-hero__title animate-fadeInUp"><?php echo wp_kses_post( $hero_title ); ?></h1>
    <p class="shop-hero__desc animate-fadeInUp animate-fadeInUp-delay-1"><?php echo esc_html( $hero_desc ); ?></p>
    <?php if ( $chips ) : ?>
    <nav class="shop-chips animate-fadeInUp animate-fadeInUp-delay-2" aria-label="Shop by category">
      <a class="shop-chip<?php echo '' === $current ? ' is-active' : ''; ?>" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">All</a>
      <?php foreach ( $chips as $chip ) : ?>
      <a class="shop-chip<?php echo $chip->slug === $current ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $chip ) ); ?>"><?php echo esc_html( $chip->name ); ?></a>
      <?php endforeach; ?>
    </nav>
    <?php endif; ?>
  </div>
</section>

<?php endif; ?>



<!-- WooCommerce shop content -->

<section style="padding-bottom: 6rem;">

  <div class="container">

    <?php woocommerce_content(); ?>

  </div>

</section>



<?php get_footer(); ?>

