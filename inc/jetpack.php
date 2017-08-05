<?php
/**
 * Jetpack Compatibility File.
 *
 * @link https://jetpack.me/
 *
 * @package Sans
 */

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.me/support/infinite-scroll/
 * See: https://jetpack.me/support/responsive-videos/
 */
function sans_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'sans_infinite_scroll_render',
		'footer'    => 'page',
		'footer_widgets' => 'sidebar-1',
	) );

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

}
add_action( 'after_setup_theme', 'sans_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function sans_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		if ( is_search() ) {
			get_template_part( 'components/post/content', 'search' );
		} else {
			get_template_part( 'components/post/content', get_post_format() );
		}
	}
}

/**
 * Custom filter to replace footer credits for Infinite Scroll.
 **/
function sans_infinite_scroll_credits() {
	return sans_footer_credits();
}
add_filter( 'infinite_scroll_credit', 'sans_infinite_scroll_credits' );
