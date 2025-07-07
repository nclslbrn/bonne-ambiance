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
			<header class="entry-header">
				<h1 class="entry-title"><?php echo esc_html( $post->post_title ); ?></h1>
			</header>

			<div id="post-grid" class="entry-content">
				<?php $post_query_args = array(
					'post_type'      => 'post',
					'post_status'    => 'publish',
				);
				$paged              = 1;

				if (-1 !== $posts_per_page) {
					if (get_query_var('paged')) {
						$paged = get_query_var('paged');
					} elseif (get_query_var('page')) {
						$paged = get_query_var('page');
					}
					$post_query_args['paged']          = $paged;
					$post_query_args['posts_per_page'] = $posts_per_page;
				}
				$post_query = new WP_Query($post_query_args);

				if ($post_query->have_posts()) {
					while ($post_query->have_posts()) {
						global $post;
						$post_query->the_post();

						get_template_part('template-parts/content',  get_post_format() );
					}
					if ($post_query->max_num_pages > 1 && -1 !== $posts_per_page) {
						$current_page = max(1, get_query_var('page'));
						echo '<nav class=\'page-nav\'>';
						echo wp_kses_post(
							paginate_links(
								array(
									'prev_next' => false,
									'current'   => $paged,
									'total'     => $post_query->max_num_pages,
								)
							)
						);
						echo '</nav><!-- .page-nav -->';
					}
				} ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>
