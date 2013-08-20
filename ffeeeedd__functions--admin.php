<?php
/**
 * ffeeeedd : fonctions du thème - partie administration
 * @author      Gaël Poupard
 * @link        www.ffoodd.fr
 *
 * @package     WordPress
 * @subpackage  ffeeeedd
 * @since       ffeeeedd 1.0
 */

/* ----------------------------- */
/* Sommaire */
/* ----------------------------- */
/*
  == Référencement Social / SEO
    -- Création des blocs dans l'administration
    -- Ajout des champs utiles dans ces blocs
    -- Sauvegarder la valeur de ces champs
  == Profil utilisateur
  == Compteur de caractères sur le champ extrait dans l'administration
*/


  /* == @section Référencement Social / SEO ==================== */
  /**
   * @note : Inspiré par le thème Noviseo2012, permet d'ajouter un champ "Titre" et "Description" à la zone d'édition
   * @author : Sylvain Fouillaud
   * @see : https://twitter.com/noviseo
   * @see : http://noviseo.fr/2012/11/theme-wordpress-referencement/
   * @note : Modifications :
   * @author : Gaël Poupard
   * @see : https://twitter.com/ffoodd_fr
   * @note : Homogénéisation du code, meilleure intégration dans l'administration, ajout des métas DublinCore et réorganisation des métas par contenu.
   */

  /* @note : on teste d'abord si la fonction est surchargée ou si un plugin dédié existe : */
  if (
    ! function_exists( 'ffeeeedd__metabox' ) &&
    ! class_exists( 'WPSEO_Frontend' ) &&
    ! class_exists( 'All_in_One_SEO_Pack' )
  ) {

    /* -- @subsection Création des blocs dans l'administration -------------------- */
    function ffeeeedd__metabox() {
      add_meta_box( 'ffeeeedd__metabox__seo', __( 'SEO', 'ffeeeedd' ), 'ffeeeedd__metabox__contenu', 'post', 'side', 'high' );
      add_meta_box( 'ffeeeedd__metabox__seo', __( 'SEO', 'ffeeeedd' ), 'ffeeeedd__metabox__contenu', 'page', 'side', 'high' );
    }
    add_action( 'add_meta_boxes', 'ffeeeedd__metabox' );

    /* -- @subsection Ajout des champs utiles dans ces blocs -------------------- */
    function ffeeeedd__metabox__contenu( $post ) {
      $val_title = get_post_meta( $post->ID, '_ffeeeedd__metabox__titre', true );
      $val_canonical = get_post_meta( $post->ID, '_ffeeeedd__metabox__canonical', true );
      $val_description = get_post_meta( $post->ID, '_ffeeeedd__metabox__description', true ); ?>
      <p><?php _e( 'Those datas are used in <meta> tags for SEO and SMO.', 'ffeeeedd' ); ?>.</p>
      <p><strong><?php _e( 'Title', 'ffeeeedd' ); ?></strong></p>
      <p>
        <label class="screen-reader-text" for="ffeeeedd__metabox__titre"><?php _e( 'Title', 'ffeeeedd' ); ?></label>
        <input id="ffeeeedd__metabox__titre" name="ffeeeedd__metabox__titre" type="text" style="width:100%;" value="<?php echo $val_title; ?>" />
      </p>
      <p><strong><?php _e( 'Description', 'ffeeeedd' ); ?></strong></p>
      <p>
        <label class="screen-reader-text" for="ffeeeedd__metabox__description"><?php _e( 'Description', 'ffeeeedd' ); ?></label>
        <textarea id="ffeeeedd__metabox__description" name="ffeeeedd__metabox__description" style="width:100%; resize:vertical;"><?php echo $val_description; ?></textarea>
      </p>
      <p><strong><?php _e( 'Canonical URL', 'ffeeeedd' ); ?></strong></p>
      <p>
        <label class="screen-reader-text" for="ffeeeedd__metabox__canonical"><?php _e( 'Canonical URL', 'ffeeeedd' ); ?></label>
        <input id="ffeeeedd__metabox__canonical" name="ffeeeedd__metabox__canonical" placeholder="http://" type="url" style="width:100%;" value="<?php echo $val_canonical; ?>" />
      </p>
    <?php }

    /* -- @subsection Sauvegarder la valeur de ces champs -------------------- */
    function ffeeeedd__metabox__save( $post_ID ) {
      if( isset( $_POST['ffeeeedd__metabox__titre'] ) ) {
        update_post_meta( $post_ID, '_ffeeeedd__metabox__titre', esc_html( $_POST['ffeeeedd__metabox__titre'] ) );
      }
      if( isset( $_POST['ffeeeedd__metabox__description'] ) ) {
        update_post_meta( $post_ID, '_ffeeeedd__metabox__description', esc_html( $_POST['ffeeeedd__metabox__description'] ) );
      }
      if( isset( $_POST['ffeeeedd__metabox__canonical'] ) ) {
        update_post_meta( $post_ID, '_ffeeeedd__metabox__canonical', esc_html( $_POST['ffeeeedd__metabox__canonical'] ) );
      }
    }
    add_action( 'save_post', 'ffeeeedd__metabox__save' );
  }


  /* == @section Profil utilisateur ==================== */
  /**
   * @note : Ajoute un champ 'Twitter' dans les profils utilisateur
   * @note : Supprime les champs inutiles
   * @author : Valentin Brandt
   * @see : https://twitter.com/geekeriesfr
   * @see : http://www.geekeries.fr/snippet/gerer-champs-contact-profil-utilisateur-wordpress/
   */
  add_filter( 'user_contactmethods', 'ffeeeedd__user', 75, 1 );
  if ( ! function_exists( 'ffeeeedd__user' ) ) {
    function ffeeeedd__user() {
      /* Ajouter un champ Twitter */
      $contact['twitter'] = 'Twitter';
      $contact['google'] = 'Google+';
      return $contact;
    }
  }


  /* == @section Compteur de caractères sur le champ extrait dans l'administration ==================== */
  /**
   * @author : Elio Rivero
   * @see : https://twitter.com/eliorivero
   * @see : http://www.ilovecolors.com.ar/character-counter-excerpt-wordpress/
   */

  define( 'THEME_URI', get_template_directory_uri() );
  add_action( 'admin_enqueue_scripts', 'ffeeeedd__compteur', 10, 1 );
  function ffeeeedd__compteur( $page ) {
    if ( isset ( $_GET['post'] ) ) {
      $post = get_post( $_GET['post'] );
      $typenow = $post->post_type;
      if( $typenow != 'page' ) {
        if ( $page == 'post-new.php' || $page == 'post.php' ) {
          wp_enqueue_script( 'ffeeeedd__compteur', THEME_URI .'/js/ffeeeedd__compteur.js', array('jquery'), null, false );
        }
      }
    }
  }