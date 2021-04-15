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
      'General Hall Information',
      function($post) {
          wp_nonce_field( 'omrade_hall_item_general_information_codebox', 'padelunited_new_nonce' );

          $matchi_link = get_post_meta($post->ID, 'matchi_link', true);
          $telefon_nummer = get_post_meta($post->ID, 'telefon_nummer', true);
          $maps_link = get_post_meta($post->ID, 'maps_link', true);
          $antal_banor = get_post_meta($post->ID, 'antal_banor', true);
          $tak_hojd = get_post_meta($post->ID, 'tak_hojd', true);
          $epost = get_post_meta($post->ID, 'epost', true);
          $friParkering = (bool) get_post_meta($post->ID, 'fri_parkering', true);
          $friParkeringChecked = '';
            
          if ($friParkeringChecked) {
            $friParkeringChecked = "checked";
          }
          
          $adress = get_post_meta($post->ID, 'adress', true);
          $hitta_hit = get_post_meta($post->ID, 'hitta_hit', true);
          $oppettider = get_post_meta($post->ID, 'oppettider', true);
          ?>
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
    <?php

    },
    $post->post_type, 'normal', 'core'
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
    }

}
