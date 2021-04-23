<?php
namespace App\MetaBoxes;

use Optilab\WPMetaBoxBuilder;

/**
* Implement CodeBox class for the post/page that uses front-page.php template file.
*/
class OmradeHallMetaBoxBootstrap extends WPMetaBoxBuilder\Bootstrap
{

  public function __construct()
  {
    add_action( 'add_meta_boxes_omrade_hall',  array( $this, 'register' ) );
    add_action( 'save_post',  array( $this, 'save' ) );
  }

  /**
   * Inintite MetaBox class and setup the metaboxes to be shown in the admin page
   **/
  public function register($post)
  {
    $setup = new WPMetaBoxBuilder\MetaBox($post);

    $setup->init(function() { return true; });

    $setup->add_meta_box(
      'omrade_hall_item_general_information_codebox',
      'Generell Hall Information',
      function($post) {
          wp_nonce_field( 'omrade_hall_item_general_information_codebox', 'padelunited_new_nonce' );

          $hall_sida = (bool) get_post_meta($post->ID, 'hall_sida', true);
          $hallSidaChecked = null;
          if ($hall_sida) {
            $hallSidaChecked = "checked";
          }
          $matchi_link = get_post_meta($post->ID, 'matchi_link', true);
          $telefon_nummer = get_post_meta($post->ID, 'telefon_nummer', true);
          $maps_link = get_post_meta($post->ID, 'maps_link', true);
          $antal_banor = get_post_meta($post->ID, 'antal_banor', true);
          $tak_hojd = get_post_meta($post->ID, 'tak_hojd', true);
          $epost = get_post_meta($post->ID, 'epost', true);
          $fri_parkering = (bool) get_post_meta($post->ID, 'fri_parkering', true);
          $friParkeringChecked = null;
            
          if ($fri_parkering) {
            $friParkeringChecked = "checked";
          }

          $adress = get_post_meta($post->ID, 'adress', true);
          $hitta_hit = get_post_meta($post->ID, 'hitta_hit', true);
          $oppettider = get_post_meta($post->ID, 'oppettider', true);
          $google_maps_adress = get_post_meta($post->ID, 'google_maps_adress', true);
          ?>
      <div class="form-field">
        <label for="hallSida">Hall Sida?</label>
        <input type="checkbox" id="hallSida" name="hall_sida" value="1" <?= $hallSidaChecked ?>>
      </div>
      <div class="form-field">
        <label for="matchi_link">Matchi Länk</label><br />
        <input type="text" name="matchi_link" id="matchi_link" value="<?php echo $matchi_link; ?>">
      </div>
      <div class="form-field">
        <label for="telefon_nummer">Telefon Nummer (+46735303030)</label><br />
        <input type="text" name="telefon_nummer" id="telefon_nummer" value="<?php echo $telefon_nummer; ?>">
      </div>
      <div class="form-field">
        <label for="maps_link">Hitta Hit Länk</label><br />
        <input type="text" name="maps_link" id="maps_link" value="<?php echo $maps_link; ?>">
      </div>
      <div class="form-field">
        <label for="antal_banor">Antal Banor</label><br />
        <input type="text" name="antal_banor" id="antal_banor" value="<?php echo $antal_banor; ?>">
      </div>
      <div class="form-field">
        <label for="tak_hojd">Tak Höjd</label><br />
        <input type="text" name="tak_hojd" id="tak_hojd" value="<?php echo $tak_hojd; ?>">
      </div>
      <div class="form-field">
        <label for="epost">E-post</label><br />
        <input type="text" name="epost" id="epost" value="<?php echo $epost; ?>">
      </div>
      <div class="form-field">
        <label for="friParkering">Fri Parkering?</label>
        <input type="checkbox" id="friParkering" name="fri_parkering" value="1" <?= $friParkeringChecked ?>>
      </div>
      <div class="form-field">
        <label for="adress">Adress</label><br />
        <textarea id="adress" name="adress" row="5" ><?php echo  $adress; ?></textarea>
      </div>
      <div class="form-field">
        <label for="hitta_hit">Hitta Hit</label><br />
        <textarea id="hitta_hit" name="hitta_hit" row="5" ><?php echo  $hitta_hit; ?></textarea>
      </div>
      <div class="form-field">
        <label for="oppettider">Öppettider</label><br />
        <textarea id="oppettider" name="oppettider" row="5" ><?php echo  $oppettider; ?></textarea>
      </div>
      <div class="form-field">
        <label for="google_maps_adress">Google Maps Adress</label><br />
        <input type="text" name="google_maps_adress" id="google_maps_adress" value="<?php echo $google_maps_adress; ?>">
      </div>
    <?php

    },
    $post->post_type, 'normal', 'core'
  );

  $setup->add_meta_box(
    'tranare_codebox',
    'Tränare',
    function($post) {
        wp_nonce_field( 'tranare_codebox', 'padelunited_new_nonce' );
        $tranare = get_post_meta($post->ID, 'tranare', true);?>
        <div class="form-field">
          <?php wp_editor( $tranare, 'tranare', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'vart_seriespel_codebox',
    'Vårt Seriespel',
    function($post) {
        wp_nonce_field( 'vart_seriespel_codebox', 'padelunited_new_nonce' );
        $vart_seriespel = get_post_meta($post->ID, 'vart_seriespel', true);?>
        <div class="form-field">
          <?php wp_editor( $vart_seriespel, 'vart_seriespel', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'ungdomsverksamhet_codebox',
    'Ungdomsverksamhet',
    function($post) {
        wp_nonce_field( 'ungdomsverksamhet_codebox', 'padelunited_new_nonce' );
        $ungdomsverksamhet = get_post_meta($post->ID, 'ungdomsverksamhet', true);?>
        <div class="form-field">
          <?php wp_editor( $ungdomsverksamhet, 'ungdomsverksamhet', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'foretag_codebox',
    'Företag & Skola',
    function($post) {
        wp_nonce_field( 'foretag_codebox', 'padelunited_new_nonce' );
        $foretag = get_post_meta($post->ID, 'foretag', true);?>
        <div class="form-field">
          <?php wp_editor( $foretag, 'foretag', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'abonnemang_codebox',
    'Abonnemang',
    function($post) {
        wp_nonce_field( 'abonnemang_codebox', 'padelunited_new_nonce' );
        $abonnemang = get_post_meta($post->ID, 'abonnemang', true);?>
        <div class="form-field">
          <?php wp_editor( $abonnemang, 'abonnemang', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->init(function() { return true; });
  }

  /**
   * Save post handler
   */
    function save($post_id) {

        parent::save($post_id);

        if(empty($_POST)) {
            return;
        }

        if ( defined( 'DOING_CRON' ) && DOING_CRON ) {
            return;
        }

        if (  !isset( $_POST['hall_sida'] ) ) {
          delete_post_meta($post_id, 'hall_sida');
        }

        if (  !isset( $_POST['fri_parkering'] ) ) {
          delete_post_meta($post_id, 'fri_parkering');
        }

        update_post_meta($post_id, 'hall_sida', $_POST['hall_sida']);
        update_post_meta($post_id, 'matchi_link', $_POST['matchi_link']);
        update_post_meta($post_id, 'telefon_nummer', $_POST['telefon_nummer']);
        update_post_meta($post_id, 'maps_link', $_POST['maps_link']);
        update_post_meta($post_id, 'antal_banor', $_POST['antal_banor']);
        update_post_meta($post_id, 'tak_hojd', $_POST['tak_hojd']);
        update_post_meta($post_id, 'epost', $_POST['epost']);
        update_post_meta($post_id, 'fri_parkering', $_POST['fri_parkering']);
        update_post_meta($post_id, 'adress', $_POST['adress']);
        update_post_meta($post_id, 'hitta_hit', $_POST['hitta_hit']);
        update_post_meta($post_id, 'oppettider', $_POST['oppettider']);
        update_post_meta($post_id, 'google_maps_adress', $_POST['google_maps_adress']);

        update_post_meta($post_id, 'tranare', $_POST['tranare']);
        update_post_meta($post_id, 'vart_seriespel', $_POST['vart_seriespel']);
        update_post_meta($post_id, 'ungdomsverksamhet', $_POST['ungdomsverksamhet']);
        update_post_meta($post_id, 'foretag', $_POST['foretag']);
        update_post_meta($post_id, 'abonnemang', $_POST['abonnemang']);
    }
}
