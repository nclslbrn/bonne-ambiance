<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bonne-Ambiance
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) : 
			?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
					
			?>
			</header><!-- .page-header -->
			<?php if ( is_category() || is_author() ) :
				$category = get_queried_object();
				$ba_html_cat_description = get_term_meta($category->term_id, 'cat_description', true);
				?>
				<div class="category-description">
					<?php echo wp_kses_post(wpautop($ba_html_cat_description)); ?>
				</div>

				<div id="grid" class="entry-content">
					<div class="grid-sizer"></div>
			<?php endif;
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;
			
			if (is_category()) : ?>
				</div>
			<?php endif; 
			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; 
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
