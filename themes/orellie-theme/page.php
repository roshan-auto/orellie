<?php
/**
 * Orellie Theme — Page template
 *
 * @package Orellie
 */

get_header(); ?>

<main class="site-main">
  <?php while ( have_posts() ) : the_post(); ?>
    <header class="page-header">
      <div class="container">
        <div class="page-header__content">
          <h1 class="page-title animate-fadeInUp">
            <?php the_title(); ?>
          </h1>
          <div class="page-header__line animate-fadeInUp-delay-1"></div>
        </div>
      </div>
    </header>

    <div class="container">
      <article id="page-<?php the_ID(); ?>" <?php post_class('page-content animate-fadeInUp-delay-2'); ?>>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
    </div>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
