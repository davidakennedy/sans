<?php
/**
 * The markup for the top menu.
 *
 * @package Sans
 */

if ( has_nav_menu( 'menu-1' ) ) { ?>
	<h2 class="screen-reader-text">Top navigation</h2>
	<nav id="site-navigation" class="main-navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'top-menu', 'depth' => 1, 'fallback_cb' => false ) ); ?>
	</nav>
<?php }
