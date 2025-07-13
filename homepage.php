<?php
/**
 * Template Name: Homepage
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @package Bonne-Ambiance
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<div id="grid" class="entry-content"> 

				<?php $post_query_args = array( 'post_type' => 'post', 'post_status' => 'publish'); ?>
				<?php $paged = 1; ?>

				<?php if (-1 !== $posts_per_page) :
					if (get_query_var('paged')) :
						$paged = get_query_var('paged');
					elseif (get_query_var('page')) :
						$paged = get_query_var('page');
					endif;

					$post_query_args['paged']          = $paged;
					$post_query_args['posts_per_page'] = $posts_per_page;
				endif;
				$post_query = new WP_Query($post_query_args); ?>

				<?php if ($post_query->have_posts()) : ?>
				
					<div class="grid-sizer"></div>

					<?php while ($post_query->have_posts()) : ?>
						<?php global $post; ?>
						<?php $post_query->the_post(); ?>
						<?php get_template_part('template-parts/content',  get_post_format() ); ?>
					<?php endwhile; ?>

					<?php if ($post_query->max_num_pages > 1 && -1 !== $posts_per_page) : ?>
						<?php $current_page = max(1, get_query_var('page')); ?>
						<nav class="page-nav">
						
						<?php echo wp_kses_post(
							paginate_links(
								array(
									'prev_next' => false,
									'current'   => $paged,
									'total'     => $post_query->max_num_pages,
								)
							)
						); ?>
						</nav><!-- .page-nav -->
					<?php endif; ?>
				<?php endif; ?>
				<!-- item sizer -->
				<div class="post-card grid-size-normal"></div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>
