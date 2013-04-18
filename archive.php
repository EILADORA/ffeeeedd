<?php
/**
 * Page d'archives
 * @author        Gaël Poupard
 * @link          www.ffoodd.fr
 *
 * En savoir plus : http://codex.wordpress.org/Template_Hierarchy
 *
 * @package       WordPress
 * @subpackage    ffeeeedd
 * @since         ffeeeedd 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

  <?php if ( is_day() ) : ?>
    <h2><?php echo __('Archive', 'ffeeeedd'); ?> : <?php echo  get_the_date( __('j F Y', 'ffeeeedd') ); ?></h2>
  <?php elseif ( is_month() ) : ?>
    <h2><?php echo __('Archive', 'ffeeeedd'); ?> : <?php echo  get_the_date( __('F Y', 'ffeeeedd') ); ?></h2>
  <?php elseif ( is_year() ) : ?>
    <h2><?php echo __('Archive', 'ffeeeedd'); ?> : <?php echo  get_the_date( __('Y', 'ffeeeedd') ); ?></h2>
  <?php else : ?>
    <h2><?php echo __('Archive', 'ffeeeedd'); ?></h2>
  <?php endif; ?>

  <ol>
    <?php while ( have_posts() ) : the_post(); ?>
    <li class="mb2">
      <article itemscope itemtype="http://schema.org/Article">
        <h3 itemprop="name"><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h3>

        <p itemprop="UserComments"><?php comments_number( '0', '1', '% ' ); ?></p>
        <a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" itemprop="image"><?php the_post_thumbnail(); ?></a>
        <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate itemprop="datePublished"><?php the_time( __('j F Y', 'ffeeeedd') ); ?></time>
        <?php $excerpt = get_the_excerpt() ?>
        <p itemprop="description"><?php echo $excerpt ?></p>

        <footer><?php ffeeeedd__meta(); ?></footer>
      </article>
    </li>
    <?php endwhile; ?>
  </ol>

  <?php theme_pagination(); ?>

  <?php else: ?>
  <h2><?php echo __('Il n\'y a aucun article à afficher', 'ffeeeedd'); ?>.</h2>
  <?php endif; ?>

<?php get_footer(); ?>
