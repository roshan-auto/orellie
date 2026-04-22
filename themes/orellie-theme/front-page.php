<?php
/**
 * Orellie Theme — Front Page (Homepage)
 *
 * Recreates the Next.js landing page design as a WordPress template.
 *
 * @package Orellie
 */

get_header();
?>

<!-- ═══════════════════════════════════════════════
     HERO VIDEO SECTION
     ═══════════════════════════════════════════════ -->
<section class="video-hero">
  <!-- Video Background -->
  <video 
    class="video-hero__bg" 
    autoplay 
    loop 
    muted 
    playsinline 
    poster="<?php echo esc_url( get_template_directory_uri() . '/assets/images/signature/Model_wearing_earring_202604131109.jpeg' ); ?>">
    <!-- Dynamic Cache Buster v3 applied for Hostinger Auto-Deploy -->
    <source src="<?php echo esc_url( get_template_directory_uri() . '/assets/videos/hero.mp4?v=3' ); ?>" type="video/mp4">
  </video>
  
  <!-- Overlay to ensure text readability -->
  <div class="video-hero__overlay"></div>

  <!-- Text Content on the left -->
  <div class="container video-hero__container">
    <div class="video-hero__content">
      <div class="badge video-hero__badge animate-fadeInUp">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/><path d="M5 3v4"/><path d="M19 17v4"/><path d="M3 5h4"/><path d="M17 19h4"/></svg>
        The Aura Collection
      </div>

      <!-- User requested text mapping from the screenshot -->
      <h1 class="animate-fadeInUp animate-fadeInUp-delay-1">
        Express your inner <br>
        <span class="accent">radiance.</span>
      </h1>

      <p class="video-hero__desc animate-fadeInUp animate-fadeInUp-delay-2">
        Handcrafted luxury earrings designed to turn heads without weighing you down. Experience the perfect blend of bold aesthetics and delicate craftsmanship.
      </p>

      <div class="hero__buttons animate-fadeInUp animate-fadeInUp-delay-3">
        <?php if ( class_exists( 'WooCommerce' ) ) : ?>
          <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-primary btn-lg">
            Shop the Collection
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
          </a>
        <?php endif; ?>
        <a href="#features" class="btn btn-outline btn-lg" style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.3); color: white;">Explore Styles</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     FEATURES SECTION
     ═══════════════════════════════════════════════ -->
<section class="features" id="features">
  <div class="container">
    <!-- Image -->
    <div class="features__image">
      <div class="features__image-wrap">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/signature/Woman_revealing_earring_202604131110.jpeg' ); ?>"
          alt="Model wearing delicate handmade pink earrings"
          loading="lazy"
        >
      </div>
    </div>

    <!-- Feature List -->
    <div class="features__list">
      <div class="feature-item">
        <div class="feature-number">01</div>
        <div>
          <h3>Handmade purely from affection.</h3>
          <p>Every piece is thoughtfully designed and created by hand in our studio. We believe in the slow craft of making things that last.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">02</div>
        <div>
          <h3>Incredibly lightweight.</h3>
          <p>We use premium polymer clay designed to be so light, you'll forget you're wearing them. Statement earrings that don't weigh you down.</p>
        </div>
      </div>

      <div class="feature-item">
        <div class="feature-number">03</div>
        <div>
          <h3>Hypoallergenic fittings.</h3>
          <p>Your comfort is our priority. We exclusively use surgical steel and titanium posts, safe for even the most sensitive ears.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     SIGNATURE PRODUCT GRID
     ═══════════════════════════════════════════════ -->
<section class="signature-grid">
  <div class="container">
    <div class="signature-grid__header">
      <div>
        <h2>Curated Signatures</h2>
        <p>Explore our most beloved handcrafted designs, shaped by intuition and defined by elegance.</p>
      </div>
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="view-all-desktop">
          View full collection
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
      <?php endif; ?>
    </div>

    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
      <?php
      // 9 Model Images to use in the grid
      $grid_images = [
        'signature/Earrings_with_matching_202604131110.jpeg',
        'signature/Earrings_with_matching_202604131110 (1).jpeg',
        'signature/Place_earring_onto_202604131109.jpeg',
        'signature/Earring_height_40mm_202604131110.jpeg',
        'signature/Earring_height_31_202604131110.jpeg',
        'signature/Stud_earring_diameter_202604131110.jpeg',
        'signature/Stud_earrings_14mm_202604131110.jpeg',
        'signature/Model_wearing_earring_202604131109.jpeg',
        'signature/Woman_revealing_earring_202604131110.jpeg'
      ];

      // Pull latest products
      $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 9,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
      );
      $products_query = new WP_Query( $args );
      
      // 1. First Pass: Map products WITH manual slots
      $manual_products = [];
      $auto_products = [];
      if ( $products_query->have_posts() ) {
          while ( $products_query->have_posts() ) {
              $products_query->the_post();
              $slot_val = get_post_meta(get_the_ID(), '_orellie_signature_image', true);
              if (!empty($slot_val)) {
                  $manual_products[(int)$slot_val] = get_post();
              } else {
                  $auto_products[] = get_post();
              }
          }
          wp_reset_postdata();
      }

      // 2. Second Pass: Assemble final grid (1-9)
      $grid_slots = array_fill(1, 9, null);
      // Place manuals first
      foreach ($manual_products as $m_slot => $m_post) {
          if ($m_slot >= 1 && $m_slot <= 9) {
              $grid_slots[$m_slot] = $m_post;
          }
      }
      // Fill remaining with auto products
      foreach ($auto_products as $a_post) {
          for ($i = 1; $i <= 9; $i++) {
              if (empty($grid_slots[$i])) {
                  $grid_slots[$i] = $a_post;
                  break;
              }
          }
      }

      // Define static placeholders for empty slots
      $placeholders = array(
        array( 'name' => 'Rose Petal Studs',      'price' => '$55.00' ),
        array( 'name' => 'Gilded Blossom Set',    'price' => '$85.00' ),
        array( 'name' => 'Signature Pearline',    'price' => '$75.00' ),
        array( 'name' => 'Artisan Curve',         'price' => '$95.00' ),
        array( 'name' => 'Ethereal Dangles',      'price' => '$80.00' ),
        array( 'name' => 'Minimal 31mm Studs',    'price' => '$45.00' ),
        array( 'name' => 'Classic 14mm Studs',    'price' => '$40.00' ),
        array( 'name' => 'Geometric Precision',   'price' => '$110.00' ),
        array( 'name' => 'Celestial Aura Drops',  'price' => '$65.00' ),
      );
      $placeholder_iter = 0;
      ?>
      
      <div class="product-grid">
        <?php
        for ($slot = 1; $slot <= 9; $slot++) :
          $product_obj = $grid_slots[$slot];
          $model_img = $grid_images[$slot - 1];
          
          if ($product_obj) :
            $post = $product_obj;
            setup_postdata($post);
            global $product;
            $product = wc_get_product($post->ID);
            ?>
            <a href="<?php the_permalink($post->ID); ?>" class="product-card">
              <div class="product-card__image">
                <img
                  src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $model_img ); ?>"
                  alt="<?php echo esc_attr($post->post_title); ?>"
                  loading="lazy"
                >
                <?php if ( $product->is_on_sale() ) : ?>
                  <div class="product-card__badges">
                    <span class="product-badge product-badge--sale">Sale</span>
                  </div>
                <?php endif; ?>
                <div class="product-card__quickview">
                  <span>View Details →</span>
                </div>
              </div>

              <div class="product-card__info">
                <div>
                  <div class="product-card__name"><?php echo esc_html($post->post_title); ?></div>
                  <div class="product-card__category">
                    <?php
                    $cats = wp_get_post_terms( $post->ID, 'product_cat' );
                    echo ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'Handcrafted';
                    ?>
                  </div>
                </div>
                <div>
                  <div class="product-card__price"><?php echo $product->get_price_html(); ?></div>
                </div>
              </div>
            </a>
            <?php
            wp_reset_postdata();
          else :
            // No product in this slot, use placeholder copy
            $item = $placeholders[$placeholder_iter % count($placeholders)];
            $placeholder_iter++;
            ?>
            <div class="product-card">
              <div class="product-card__image">
                <img
                  src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/' . $model_img ); ?>"
                  alt="<?php echo esc_attr( $item['name'] ); ?>"
                  loading="lazy"
                >
                <div class="product-card__quickview">
                  <span>Available Soon</span>
                </div>
              </div>
              <div class="product-card__info">
                <div>
                  <div class="product-card__name"><?php echo esc_html( $item['name'] ); ?></div>
                  <div class="product-card__category">Coming Soon</div>
                </div>
                <div class="product-card__price"><?php echo esc_html( $item['price'] ); ?></div>
              </div>
            </div>
          <?php
          endif;
        endfor;
        ?>
      </div>
    <?php endif; ?>

    <div class="signature-grid__mobile-cta">
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn btn-outline">
          View full collection
        </a>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════
     TRUST SIGNALS
     ═══════════════════════════════════════════════ -->
<section class="cta-banner">
  <div class="container">
    <div class="trust-signals" style="margin-bottom: 3rem;">
      <span>🇳🇿 Made in New Zealand</span>
      <span>💎 Hypoallergenic fittings</span>
      <span>📦 Free NZ shipping over $80</span>
      <span>✨ Gift packaging included</span>
    </div>

    <h2>Not sure where to start?</h2>
    <p>Take our style quiz and we'll recommend the perfect Orellie piece for you.</p>
    <a href="#" class="btn btn-outline btn-lg">
      Take the Style Quiz
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
    </a>
  </div>
</section>

<?php get_footer(); ?>
