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
        'title'          => 'Generala Inställningar',
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

    $wp_customize->add_setting( 'antal_hallar', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'antal_hallar', array(
        'label' => __( 'Antal Hallar'),
        'section' => 'general_settings',
        'settings' => 'antal_hallar',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'antal_banor', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'antal_banor', array(
        'label' => __( 'Antal Banor'),
        'section' => 'general_settings',
        'settings' => 'antal_banor',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'antal_turneringar', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'antal_turneringar', array(
        'label' => __( 'Antal Turneringar'),
        'section' => 'general_settings',
        'settings' => 'antal_turneringar',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'antal_medlemmar', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'antal_medlemmar', array(
        'label' => __( 'Antal Medlemmar'),
        'section' => 'general_settings',
        'settings' => 'antal_medlemmar',
        'type'  => 'text'
    )));
    
});
    
/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
