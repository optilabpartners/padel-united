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
          $short_title = get_post_meta($post->ID, 'short_title', true);
          $extra_hall_text = get_post_meta($post->ID, 'extra_hall_text', true);
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

          $facebook = get_post_meta($post->ID, 'facebook', true);
          $instagram = get_post_meta($post->ID, 'instagram', true);
          ?>
      <div class="form-field">
        <label for="hallSida">Hall Sida?</label>
        <input type="checkbox" id="hallSida" name="hall_sida" value="1" <?= $hallSidaChecked ?>>
      </div>
      <div class="form-field">
        <label for="short_title">Kort Titel</label><br />
        <input type="text" name="short_title" id="short_title" value="<?php echo $short_title; ?>">
      </div>
      <div class="form-field">
        <label for="extra_hall_text">Om regionen har extra hallar fr??n andra bolag skriv en kort text h??r(se Stocholm eller Sk??ne f??r mer info)</label><br />
        <input type="text" name="extra_hall_text" id="extra_hall_text" value="<?php echo $extra_hall_text; ?>">
      </div>
      <div class="form-field">
        <label for="matchi_link">Matchi L??nk</label><br />
        <input type="text" name="matchi_link" id="matchi_link" value="<?php echo $matchi_link; ?>">
      </div>
      <div class="form-field">
        <label for="telefon_nummer">Telefon Nummer (+46735303030)</label><br />
        <input type="text" name="telefon_nummer" id="telefon_nummer" value="<?php echo $telefon_nummer; ?>">
      </div>
      <div class="form-field">
        <label for="maps_link">Hitta Hit L??nk</label><br />
        <input type="text" name="maps_link" id="maps_link" value="<?php echo $maps_link; ?>">
      </div>
      <div class="form-field">
        <label for="antal_banor">Antal Banor</label><br />
        <input type="text" name="antal_banor" id="antal_banor" value="<?php echo $antal_banor; ?>">
      </div>
      <div class="form-field">
        <label for="tak_hojd">Tak H??jd</label><br />
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
        <label for="oppettider">??ppettider</label><br />
        <textarea id="oppettider" name="oppettider" row="5" ><?php echo  $oppettider; ?></textarea>
      </div>
      <div class="form-field">
        <label for="google_maps_adress">Google Maps Adress</label><br />
        <input type="text" name="google_maps_adress" id="google_maps_adress" value="<?php echo $google_maps_adress; ?>">
      </div>
      <div class="form-field">
        <label for="facebook">Facebook</label><br />
        <input type="text" name="facebook" id="facebook" value="<?php echo $facebook; ?>">
      </div>
      <div class="form-field">
        <label for="instagram">Instagram</label><br />
        <input type="text" name="instagram" id="instagram" value="<?php echo $instagram; ?>">
      </div>
    <?php

    },
    $post->post_type, 'normal', 'core'
  );

  $setup->add_meta_box(
    'tranare_codebox',
    'Tr??nare',
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
    'V??rt Seriespel',
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
    'F??retag & Skola',
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

  $setup->add_meta_box(
    'pris_box_one_codebox',
    'Pris Box Ett',
    function($post) {
        wp_nonce_field( 'pris_box_one_codebox', 'padelunited_new_nonce' );
        $pris_box_one = get_post_meta($post->ID, 'pris_box_one', true);?>
        <div class="form-field">
          <?php wp_editor( $pris_box_one, 'pris_box_one', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'pris_box_two_codebox',
    'Pris Box Tv??',
    function($post) {
        wp_nonce_field( 'pris_box_two_codebox', 'padelunited_new_nonce' );
        $pris_box_two = get_post_meta($post->ID, 'pris_box_two', true);?>
        <div class="form-field">
          <?php wp_editor( $pris_box_two, 'pris_box_two', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'pris_box_three_codebox',
    'Pris Box Tre',
    function($post) {
        wp_nonce_field( 'pris_box_three_codebox', 'padelunited_new_nonce' );
        $pris_box_three = get_post_meta($post->ID, 'pris_box_three', true);?>
        <div class="form-field">
          <?php wp_editor( $pris_box_three, 'pris_box_three', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
        </div>
    <?php
    },
    $post->post_type , 'normal', 'core'
  );

  $setup->add_meta_box(
    'above_footer_codebox',
    'Ovanf??r Footer Text',
    function($post) {
        wp_nonce_field( 'above_footer_codebox', 'padelunited_new_nonce' );
        $above_footer = get_post_meta($post->ID, 'above_footer', true);?>
        <div class="form-field">
          <?php wp_editor( $above_footer, 'above_footer', array('wpautop' => false, 'textarea_rows' => 12) ); ?>
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
        update_post_meta($post_id, 'short_title', $_POST['short_title']);
        update_post_meta($post_id, 'extra_hall_text', $_POST['extra_hall_text']);
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

        update_post_meta($post_id, 'facebook', $_POST['facebook']);
        update_post_meta($post_id, 'instagram', $_POST['instagram']);

        update_post_meta($post_id, 'pris_box_one', $_POST['pris_box_one']);
        update_post_meta($post_id, 'pris_box_two', $_POST['pris_box_two']);
        update_post_meta($post_id, 'pris_box_three', $_POST['pris_box_three']);

        update_post_meta($post_id, 'above_footer', $_POST['above_footer']);
    }
}
