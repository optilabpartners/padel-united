<?php

namespace App\Controllers;

use Sober\Controller\Controller;

class App extends Controller
{
    public function siteName()
    {
        return get_bloginfo('name');
    }

    public static function title()
    {
        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }
            return __('Latest Posts', 'sage');
        }
        if (is_archive()) {
            return get_the_archive_title();
        }
        if (is_search()) {
            return sprintf(__('Sök resultat för "%s"', 'sage'), get_search_query());
        }
        if (is_404()) {
            return __('Sidan finns inte', 'sage');
        }
        return get_the_title();
    }

    //Get the links for the dropdown list on the first page on the button Boka Bana Nu
    public function get_matchi_links()
    {
        global $post;
        $args = array(
            'post_type' => 'omrade_hall',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => 'hall_sida',
                    'value' => 1
                )
            )
        );

        $matchi_links = new \WP_Query( $args );
        wp_reset_query();
        if ($matchi_links)
           return $matchi_links;
    }

    //Get children of this Områdes sida.
    public function get_children_pages()
    {
        global $post;
        $parent = false;
        $args = array(
            'post_type'      => 'omrade_hall',
            'posts_per_page' => -1,
            'post_parent'    => $post->ID,
            'order'          => 'ASC',
            'orderby'        => 'title'
         );
        
        
        $parent = new \WP_Query( $args );
        wp_reset_query();
        if ($parent->have_posts()) {
            return $parent;
        } else {
            return $parent;
        }
         
    }
}
