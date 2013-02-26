<?php
/**
 * Page d'archives
 * @author Gaël Poupard
 * @link www.ffoodd.fr
 *
 * En savoir plus : http://codex.wordpress.org/Template_Hierarchy
 *
 * @package 	WordPress
 * @subpackage 	ffeeeedd
 * @since 		ffeeeedd 1.0
 */
get_header(); ?>

<?php if ( have_posts() ): ?>

    <?php if ( is_day() ) : ?>
        <h2>Archive : <?php echo  get_the_date( 'j F Y' ); ?></h2>							
    <?php elseif ( is_month() ) : ?>
        <h2>Archive : <?php echo  get_the_date( 'F Y' ); ?></h2>	
    <?php elseif ( is_year() ) : ?>
        <h2>Archive : <?php echo  get_the_date( 'Y' ); ?></h2>								
    <?php else : ?>
        <h2>Archive</h2>	
    <?php endif; ?>
    
    <ol>
        <?php while ( have_posts() ) : the_post(); ?>
            <li class="mb2">
                <article itemscope itemtype="http://schema.org/Article">
                    <h3 itemprop="name"><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h3>
                    <time datetime="<?php the_time( 'j-F-Y' ); ?>" pubdate itemprop="datePublished"><?php the_date(); ?></time>
                    <?php $excerpt = get_the_excerpt() ?>
                    <p itemprop="description"><?php echo $excerpt ?></p>
                </article>
            </li>
        <?php endwhile; ?>
    </ol>

    <?php
        global $wp_query;        
        $big = 999999999;        
        echo paginate_links( array(
            'base'         => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
            'format'       => '?paged=%#%',
            'current'      => max( 1, get_query_var('paged') ),
            'total'        => $wp_query->max_num_pages,
            'prev_text'    => __('&larr; Précédent'),
            'next_text'    => __('Suivant &rarr;'),
            'type'         => 'list'
        ) );
    ?>

<?php else: ?>
    <h2>Il n'y a aucun article à afficher.</h2>	
<?php endif; ?>

<?php get_footer(); ?>