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

    $wp_customize->add_setting( 'above_footer_title', array(
        'default'        => '',
    ) );
    
    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'above_footer_title', array(
        'label' => __('Ovanför Footer Title(Syns på startsidan)'),
        'section' => 'general_settings',
        'settings' => 'above_footer_title',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'above_footer_text', array(
        'default'        => '',
    ) );
    
    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'above_footer_text', array(
        'label' => __('Ovanför Footer Text(Syns på startsidan)'),
        'section' => 'general_settings',
        'settings' => 'above_footer_text',
        'type'  => 'textarea'
    )));

    $wp_customize->add_section( 'hall_settings', array(
        'title'          => 'Hall Inställningar',
        'priority'       => 500,
    ) );

    $wp_customize->add_setting( 'above_hall_footer_title', array(
        'default'        => '',
    ) );
    
    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'above_hall_footer_title', array(
        'label' => __('Ovanför Footer Title(Syns på hall sidor)'),
        'section' => 'hall_settings',
        'settings' => 'above_hall_footer_title',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'above_hall_footer_text', array(
        'default'        => '',
    ) );
    
    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'above_hall_footer_text', array(
        'label' => __('Ovanför Footer Text(Syns på hall sidor)'),
        'section' => 'hall_settings',
        'settings' => 'above_hall_footer_text',
        'type'  => 'textarea'
    )));

    $wp_customize->add_section( 'medlemskap_settings', array(
        'title'          => 'Medlemskaps Inställningar',
        'priority'       => 600,
    ) );
    
    $wp_customize->add_setting( 'ingar_medlemskapet', array(
        'default' => 'Skriv vad som ingår i medlemskapet. En sak per rad.',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'ingar_medlemskapet', array(
        'label' => __('Ingår i Medlemskapet'),
        'section' => 'medlemskap_settings',
        'settings' => 'ingar_medlemskapet',
        'type'  => 'textarea'
    )));

    $wp_customize->add_setting( 'medlemskaps_pris', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'medlemskaps_pris', array(
        'label' => __( 'Pris'),
        'section' => 'medlemskap_settings',
        'settings' => 'medlemskaps_pris',
        'type'  => 'text'
    )));

    $wp_customize->add_setting( 'medlemskaps_link', array(
        'default'        => '',
    ) );

    $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'medlemskaps_link', array(
        'label' => __( 'Länk'),
        'section' => 'medlemskap_settings',
        'settings' => 'medlemskaps_link',
        'type'  => 'text'
    )));

});
    
/**
 * Customizer JS
 */
add_action('customize_preview_init', function () {
    wp_enqueue_script('sage/customizer.js', asset_path('scripts/customizer.js'), ['customize-preview'], null, true);
});
