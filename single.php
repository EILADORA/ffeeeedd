<?php
/**
 * Article
 * @author        Gaël Poupard
 * @link          www.ffoodd.fr
 *
 * En savoir plus : http://codex.wordpress.org/Template_Hierarchy
 *
 * @package       WordPress
 * @subpackage    ffeeeedd
 * @since         ffeeeedd 1.0
 * @see           http://www.crea-fr.com/blog/15-liens-de-partage-pour-les-reseaux-sociaux/
 * @note          Pour permettre le partage sur d'autres réseaux
 * @see           http://schema.org/Article
 * @see           http://php.net/manual/fr/function.date.php
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <article itemscope itemtype="http://schema.org/Article" role="article">
    <h2 itemprop="name"><?php the_title(); ?></h2>

    <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate itemprop="datePublished"><?php the_time( 'j F Y' ); ?></time>
    <div itemprop="articleBody"><?php the_content(); ?></div>

    <footer>
      <?php // Liste des catégories & tags avec un séparateur.
      $categories_list = get_the_category_list( __( ', ' ) );
      $tag_list = get_the_tag_list( '', __( ', ' ) );
      if ( '' != $tag_list ) {
        echo '<p>Article rédigé par <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="author">'. get_the_author() . '</a> et publié dans <span itemprop="keywords">' . $categories_list . '.</span><br />Mots-clés : <span itemprop="keywords">' . $tag_list . '.</span></p>';
      } elseif ( '' != $categories_list ) {
        echo '<p>Article rédigé par <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="author">'. get_the_author() . '</a> et publié dans <span itemprop="keywords">' . $categories_list . '.</span></p>';
      } else {
        echo '<p>Article rédigé par <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="author">'. get_the_author() . '</a>.</p>';
      } ?>
      <p class="print-hidden">Édité le <time class="updated" datetime="<?php the_modified_date( 'Y-m-d'); ?>" itemprop="dateModified"><?php the_modified_date( 'j F Y' ); ?></time>.</p>
      <p class="print-hidden">
        <a href="http://twitter.com/home?status=<?php the_permalink() ?>" target="_blank" rel="nofollow" title="Partagez cet article sur Twitter">Partager sur Twitter</a>
        <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink() ?>&t=<?php the_title_attribute() ?>" target="_blank" rel="nofollow" title="Partagez cet article sur Facebook">Partager sur facebook</a>
        <a href="https://plus.google.com/share?url=<?php the_permalink() ?>" target="_blank" rel="nofollow" title="Partagez cet article sur Google+">Partager sur Google +</a>
        <a href="mailto:?subject=<?php the_title_attribute() ?>?body=<?php the_permalink() ?>" target="_blank" rel="nofollow" title="Envoyez cet article par Email">Envoyer par email</a>
        <!-- Mise en place d'une mécanique simple pour l'impression, en fonction de l'activation du js -->
        <a href="javascript:window.print()" target="_blank" rel="nofollow" title="Imprimez cet article" class="js-visible">Imprimer</a>
        <strong class="js-hidden">Pour imprimer cette page, utilisez le raccourci <kbd>Ctrl + P</kbd></strong>
      </p>
    </footer>
  </article>

  <?php comments_template( '', true ); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
