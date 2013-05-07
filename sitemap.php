<?php
/**
 * Template Name: Plan du site
 * @author        Gaël Poupard
 * @link          www.ffoodd.fr
 *
 * @note Inspiré d'un tutoriel :
 * @author Rémi Corson
 * @see http://www.remicorson.com/create-a-simple-wordpress-sitemap/
 *
 * @package       WordPress
 * @subpackage    ffeeeedd
 * @since         ffeeeedd 1.0
 */
get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
  <article itemscope itemtype="http://schema.org/Article" role="article" class="col">
    <h2 itemprop="name"><?php the_title(); ?></h2>
    <div itemprop="articleBody">

      <h3><?php echo __( 'Pages', 'ffeeeedd' ); ?></h3>
      <ul><?php wp_list_pages( 'title_li=' ); ?></ul>

      <h3><?php echo __( 'Flux', 'ffeeeedd' ); ?></h3>
      <ul>
        <li><a href="<?php bloginfo( 'rss2_url' ); ?>" target="_blank"><?php echo __( 'Flux RSS des articles', 'ffeeeedd' ); ?></a></li>
        <li><a href="<?php bloginfo( 'comments_rss2_url' ); ?>" target="_blank"><?php echo __( 'Flux RSS des commentaires', 'ffeeeedd' ); ?></a></li>
      </ul>

      <h3><?php echo __( 'Catégories', 'ffeeeedd' ); ?></h3>
      <ul><?php wp_list_categories( 'show_count=1' ); ?></ul>

      <h3><?php echo __( 'Tous les articles', 'ffeeeedd' ); ?></h3>
      <?php $ffeeeedd__article = new WP_Query( array( 'post_type' => 'post', 'nopaging' => 'true', 'orderby' => 'date' ) );
      <?php if ( $ffeeeedd__article->have_posts() ) : ?>
      <ul>
        <?php while ( $ffeeeedd__article->have_posts() ) : $ffeeeedd__article->the_post(); ?>
          <li>
            <a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
            <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate itemprop="datePublished"><?php the_time( __( 'j F Y', 'ffeeeedd' ) ); ?></time>
          </li>
        <?php endwhile; ?>
      </ul>
      <?php endif; ?>

    </div>
  </article>
<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>