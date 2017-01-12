<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sans
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sans_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'sans_body_classes' );

if ( ! function_exists( 'sans_continue_reading_link' ) ) :
	/**
	 * Returns an ellipsis and "Continue reading" plus off-screen title link for excerpts
	 */
	function sans_continue_reading_link() {
		return '&hellip; <a class="more-link" href="' . esc_url( get_permalink() ) . '">' . sprintf( wp_kses_post( __( 'Continue reading <span class="screen-reader-text">%1$s</span>', 'sans' ) ), esc_attr( strip_tags( get_the_title() ) ) ) . '</a>';
	}
endif; // End sans_continue_reading_link.

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with sans_continue_reading_link().
 *
 * @param string $more continue reading link.
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function sans_auto_excerpt_more( $more ) {
	return sans_continue_reading_link();
}
add_filter( 'excerpt_more', 'sans_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * @param string $output continue reading link.
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function sans_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= sans_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'sans_custom_excerpt_more' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function sans_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', bloginfo( 'pingback_url' ), '">';
	}
}
add_action( 'wp_head', 'sans_pingback_header' );

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls          URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function sans_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'sans-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'sans_resource_hints', 10, 2 );
