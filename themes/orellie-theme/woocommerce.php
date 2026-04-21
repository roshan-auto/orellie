<?php
/**
 * Orellie Theme — WooCommerce Archive (Shop Page) Wrapper
 *
 * @package Orellie
 */

get_header(); ?>

<!-- Shop hero banner -->
<section class="hero" style="padding: 7rem 0 3rem;">
  <div class="hero__blob"></div>
  <div class="container" style="text-align: center; max-width: 700px;">
    <div class="badge" style="margin: 0 auto 1.5rem; display: inline-flex;">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
      The Full Collection
    </div>
    <h1 class="animate-fadeInUp" style="font-size: clamp(2.5rem, 5vw, 4rem); margin-bottom: 1rem;">
      Wear What You <span class="accent">Feel.</span>
    </h1>
    <p class="hero__desc animate-fadeInUp animate-fadeInUp-delay-1" style="margin-bottom: 2.5rem;">
      Every Orellie piece is handcrafted by hand in Aotearoa New Zealand from premium polymer clay. Hypoallergenic. Impossibly lightweight. Built to last a lifetime.
    </p>
    <div class="trust-signals animate-fadeInUp animate-fadeInUp-delay-2">
      <span>🇳🇿 Made in New Zealand</span>
      <span>💎 Hypoallergenic fittings</span>
      <span>📦 Free NZ shipping over $80</span>
      <span>✨ Gift packaging included</span>
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
