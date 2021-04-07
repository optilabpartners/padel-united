<?php

namespace App;

/**
 * Theme customizer
 */
add_action('customize_register', function (\WP_Customize_Manager $wp_customize) {
    // Add postMessage support
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->selective_refresh->add_partial('blogname', [
        'selector' => '.brand',
        'render_callback' => function () {
        bloginfo('name');
        }
        ]);
    
    $wp_customize->add_section( 'general_settings', array(
        'title'          => 'General Settings',
        'priority'       => 400,
    ) );
    
    
    $wp_customize->add_setting( 'google_analytics', array(
        'default'        => '',
    ) );
    
    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'google_analytics', array(
        'label' => __('Google Analytics'),
        'section' => 'general_settings',
        'settings' => 'google_analytics',
        'type'  => 'textarea'
    )));
    
});
    
/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
