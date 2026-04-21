<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php bloginfo( 'description' ); ?>">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ── Sticky Navbar ── -->
<header class="site-header">
  <div class="container">
    <!-- Logo -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
      orellie
    </a>

    <!-- Desktop Navigation -->
    <nav class="nav-desktop">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop</a>
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="nav-cta">Shop Now</a>
        <!-- Cart icon -->
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon" aria-label="View cart">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
          </svg>
          <?php
          $cart_count = orellie_cart_count();
          if ( $cart_count > 0 ) :
          ?>
            <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
          <?php endif; ?>
        </a>
      <?php endif; ?>
    </nav>

    <!-- Mobile Controls -->
    <div class="mobile-controls">
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon" aria-label="View cart">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/>
            <path d="M16 10a4 4 0 0 1-8 0"/>
          </svg>
          <?php if ( $cart_count > 0 ) : ?>
            <span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
          <?php endif; ?>
        </a>
      <?php endif; ?>
      <button class="hamburger" id="mobile-menu-toggle" aria-label="Toggle menu">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="4" y1="6" x2="20" y2="6"/>
          <line x1="4" y1="12" x2="20" y2="12"/>
          <line x1="4" y1="18" x2="20" y2="18"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu -->
  <nav class="mobile-menu" id="mobile-menu">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
    <?php if ( class_exists( 'WooCommerce' ) ) : ?>
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">Shop</a>
      <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="nav-cta-mobile">Shop Now</a>
    <?php endif; ?>
  </nav>
</header>

<main id="main-content" class="site-main">
