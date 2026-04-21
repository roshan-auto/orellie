<?php
/**
 * Orellie Theme — Page template
 *
 * @package Orellie
 */

get_header(); ?>

<div class="container" style="padding-top: 6rem; padding-bottom: 4rem;">
  <?php while ( have_posts() ) : the_post(); ?>
    <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 2rem;">
        <?php the_title(); ?>
      </h1>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; ?>
</div>

<?php get_footer(); ?>
