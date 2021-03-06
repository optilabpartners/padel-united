<?php

// Register Custom Post Type
function omrade_hall() {

    $labels = array(
        'name'                  => _x( 'Region & Hall', 'Post Type General Name', 'sage' ),
        'singular_name'         => _x( 'Region & Hall', 'Post Type Singular Name', 'sage' ),
        'menu_name'             => __( 'Region & Hall', 'sage' ),
        'name_admin_bar'        => __( 'Region & Hall', 'sage' ),
        'archives'              => __( 'Region & Hall Archives', 'sage' ),
        'parent_item_colon'     => __( 'Parent Region & Hall Article:', 'sage' ),
        'all_items'             => __( 'All Region & Hall Articles', 'sage' ),
        'add_new_item'          => __( 'Add New Region & Hall Article', 'sage' ),
        'add_new'               => __( 'Add New', 'sage' ),
        'new_item'              => __( 'New Region & Hall', 'sage' ),
        'edit_item'             => __( 'Edit Region & Hall', 'sage' ),
        'update_item'           => __( 'Update Region & Hall', 'sage' ),
        'view_item'             => __( 'View Region & Hall', 'sage' ),
        'search_items'          => __( 'Search Region & Hall', 'sage' ),
        'not_found'             => __( 'Not found', 'sage' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
        'featured_image'        => __( 'Featured Image', 'sage' ),
        'set_featured_image'    => __( 'Set featured image', 'sage' ),
        'remove_featured_image' => __( 'Remove featured image', 'sage' ),
        'use_featured_image'    => __( 'Use as featured image', 'sage' ),
        'insert_into_item'      => __( 'Insert into article', 'sage' ),
        'uploaded_to_this_item' => __( 'Uploaded to this article', 'sage' ),
        'items_list'            => __( 'Region & Hall list', 'sage' ),
        'items_list_navigation' => __( 'Region & Hall list navigation', 'sage' ),
        'filter_items_list'     => __( 'Filter articles list', 'sage' ),
    );
    $args = array(
        'label'                 => __( 'Region & Hall', 'sage' ),
        'description'           => __( 'Region & Hall', 'sage' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail','page-attributes', 'comments' ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-format-aside',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => '', 'with_front' => false),
        'capability_type'       => 'post',
    );
    register_post_type( 'omrade_hall', $args );

}

if (function_exists('add_action')) {
    add_action( 'init', 'omrade_hall', 0 );
}