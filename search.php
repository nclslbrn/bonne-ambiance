<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Bonne-Ambiance
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : 
			?>

			<header class="entry-header">
				<h1 class="entry-title">
					<?php 
					echo sprintf( 
						/* translators: %s: user input search term */
						esc_html__( 'Search Results for: %s', 'Bonne-Ambiance' ), 
						'<span>' . get_search_query() . '</span>'
					); 
					?>
				</h1>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', 'search' );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; 
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
et_sidebar();
get_footer();
