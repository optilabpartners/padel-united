<?php
namespace App\MetaBoxes;

use Optilab\WPMetaBoxBuilder;

/**
* Implement CodeBox class for the post/page that uses front-page.php template file.
*/
class ArticleMetaBoxBootstrap extends WPMetaBoxBuilder\Bootstrap
{

  public function __construct()
  {
    add_action( 'add_meta_boxes_post',  array( $this, 'register' ) );
    add_action( 'save_post',  array( $this, 'save' ) );
  }

  /**
   * Inintite MetaBox class and setup the metaboxes to be shown in the admin page
   **/
  public function register($post)
  {
    $setup = new WPMetaBoxBuilder\MetaBox($post);

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
    }

}
