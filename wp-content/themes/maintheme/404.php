<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<section id="error" class="container">
        <h1>404, Page not found</h1>
        <p>The Page you are looking for doesn't exist or an other error occurred.</p>
        <a class="btn btn-success" href="index.html">GO BACK TO THE HOMEPAGE</a>
        <p></p>
		<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentyfifteen' ); ?></p>
		<div class="col-md-4 col-md-offset-4">
			<?php get_search_form(); ?>
		</div>
    </section><!--/#error-->
				
<?php get_footer(); ?>
