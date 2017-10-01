<?php
/**
 * Sans Customizer.
 *
 * @package Sans
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sans_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'sans_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'sans_customize_partial_blogdescription',
	) );
}
add_action( 'customize_register', 'sans_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @see sans_customize_register()
 *
 * @return void
 */
function sans_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @see sans_customize_register()
 *
 * @return void
 */
function sans_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function sans_customize_preview_js() {
	wp_enqueue_script( 'sans_customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '3.0.1', true );
}
add_action( 'customize_preview_init', 'sans_customize_preview_js' );
