<?php
/**
 * Orellie Theme - WooCommerce Archive (Shop & Category Pages) Wrapper
 *
 * @package Orellie
 */

get_header(); 

// Dynamic hero copy based on archive context
$badge_text = 'The Full Collection';
$hero_title = 'Wear What You <span class="accent">Feel.</span>';
$hero_desc  = 'Every Orellie piece is handcrafted in Aotearoa New Zealand from premium polymer clay. 316L surgical steel posts for sensitive ears. Impossibly lightweight. Built to last a lifetime.';

if ( function_exists( 'is_product_category' ) && is_product_category() ) {
	$term = get_queried_object();
	$slug = $term ? $term->slug : '';
	if ( 'studs' === $slug ) {
		$badge_text = 'Everyday Artisan Elegance';
		$hero_title = 'Handcrafted <span class="accent">Stud Earrings</span>';
		$hero_desc  = 'Delicate, featherlight polymer clay stud earrings handcrafted in New Zealand. Biocompatible 316L surgical steel posts for sensitive ears. Perfect for effortless daily wear, office styling, and thoughtful gifting.';
	} elseif ( 'dangles' === $slug ) {
		$badge_text = 'Sculptural Statement Pieces';
		$hero_title = 'Handmade <span class="accent">Statement Dangles</span>';
		$hero_desc  = 'Expressive architectural and botanical dangle earrings handcrafted in New Zealand. Impossibly featherlight (2–5 grams) with zero earlobe drag. Designed with 316L surgical steel posts to turn heads in complete comfort.';
	} else {
		$badge_text = 'Handcrafted NZ Jewellery';
		$hero_title = single_term_title( '', false );
		$term_desc  = trim( wp_strip_all_tags( term_description() ) );
		if ( $term_desc ) {
			$hero_desc = $term_desc;
		}
	}
}
?>

<!-- Shop hero banner -->
<section class="hero" style="padding: 7rem 0 3rem;">
  <div class="hero__blob"></div>
  <div class="container" style="text-align: center; max-width: 700px;">
    <div class="badge" style="margin: 0 auto 1.5rem; display: inline-flex;">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
      <?php echo esc_html( $badge_text ); ?>
    </div>
    <h1 class="animate-fadeInUp" style="font-family: var(--font-serif); font-weight: 400; letter-spacing: -0.02em; line-height: 1.1; color: var(--foreground); font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 1rem;">
      <?php echo wp_kses_post( $hero_title ); ?>
    </h1>
    <p class="hero__desc animate-fadeInUp animate-fadeInUp-delay-1" style="margin-bottom: 2.5rem;">
      <?php echo esc_html( $hero_desc ); ?>
    </p>
    <div class="trust-signals animate-fadeInUp animate-fadeInUp-delay-2">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        Handcrafted in New Zealand
      </span>
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        316L Surgical Steel (Sensitive Ears Safe)
      </span>
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        Tracked NZ Delivery (Free over $80)
      </span>
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:-2px; margin-right:4px;"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/></svg>
        Gift Presentation Box Included
      </span>
    </div>
  </div>
</section>

<!-- WooCommerce shop content -->
<section style="padding-bottom: 6rem;">
  <div class="container">
    <?php woocommerce_content(); ?>
  </div>
</section>

<?php get_footer(); ?>
