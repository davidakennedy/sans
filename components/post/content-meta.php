<?php
/**
 * The markup for the entry meta.
 *
 * @package Sans
 */

?>
<div class="entry-meta">
	<?php if ( is_single() || is_search() ) {
		sans_posted_on();
	} else {
		sans_entry_date();
	} ?>
</div><!-- .entry-meta -->
