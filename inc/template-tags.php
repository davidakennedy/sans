<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Sans
 */

if ( ! function_exists( 'sans_entry_date' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function sans_entry_date() {
		$sticky = sprintf(
			esc_html__( '%s Featured', 'sans' ),
			'<span class="sticky-star">&#9733;</span>'
		);

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		if ( is_sticky() && is_home() ) {
			echo '<span class="featured">' . $sticky . '</span>'; // WPCS: XSS OK.
		}

		printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
			esc_html_x( 'Posted on', 'Used before publish date.', 'sans' ),
			esc_url( get_permalink() ),
			$time_string
		);

	}
endif;

if ( ! function_exists( 'sans_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function sans_posted_on() {
		$sticky = sprintf(
			esc_html__( '%s Featured', 'sans' ),
			'<span class="sticky-star">&#9733;</span>'
		);

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			esc_html_x( 'Posted on %s', 'post date', 'sans' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'sans' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

		if ( is_sticky() && is_home() ) {
			echo '<span class="featured">' . $sticky . '</span>'; // WPCS: XSS OK.
		}

	}
	endif;

if ( ! function_exists( 'sans_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function sans_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'sans' ) );
			if ( $categories_list && sans_categorized_blog() ) {
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'sans' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( ', ', 'sans' ) );
			if ( $tags_list ) {
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'sans' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'sans' ), esc_html__( '1 Comment', 'sans' ), esc_html__( '% Comments', 'sans' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'sans' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function sans_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'sans_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'sans_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so sans_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so sans_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in sans_categorized_blog.
 */
function sans_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'sans_categories' );
}
add_action( 'edit_category', 'sans_category_transient_flusher' );
add_action( 'save_post',     'sans_category_transient_flusher' );

if ( ! function_exists( 'sans_footer_credits' ) ) :
	/**
	 * Adds footer credits, including credits, copyright and quotes.
	 */
	function sans_footer_credits() {
		$copyright = esc_html( '&copy; 2009 - ' . date( 'Y ' ) . __( 'David A. Kennedy.', 'sans' ) );
		$credits = sprintf(
			esc_html__( 'View %1$s', 'sans' ),
			'<a href="' . esc_url( 'https://github.com/davidakennedy/sans' ) . '">' . 'source' . '</a>.'
		);
		$quotes = array(
			esc_html__( 'Go Gators!', 'sans' ),
			esc_html__( 'Let&lsquo;s go Magic!', 'sans' ),
			esc_html__( 'Probably eating a pb&amp;j.', 'sans' ),
			esc_html__( 'Looking for tacos.', 'sans' ),
			esc_html__( 'Drinking a good ale.', 'sans' ),
			esc_html__( 'Doing some burpees.', 'sans' ),
			esc_html__( 'Need moar video games.', 'sans' ),
			esc_html__( 'Penning a first draft.', 'sans' ),
		);
		$content = '<small><span class="stuff-and-things">' . $copyright . ' ' . $credits . ' ' . '<span class="quotes">' . $quotes[ rand( 0, count( $quotes ) - 1 ) ] . '</span></span></small>';
		echo $content; /* WPCS: xss ok. */
		return $content;
	}
endif;
