<?php
/**
 * Orellie Theme — Generic index fallback
 *
 * @package Orellie
 */

get_header(); ?>

<div class="container" style="padding-top: 6rem; padding-bottom: 4rem;">
  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1><?php the_title(); ?></h1>
        <div class="entry-content">
          <?php the_content(); ?>
        </div>
      </article>
    <?php endwhile; ?>
  <?php else : ?>
    <p>No content found.</p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
