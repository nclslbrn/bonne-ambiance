<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bonne-Ambiance
 */

// post grid card
if (! is_single()) : ?>
	<?php $grid_size = get_post_meta(get_the_ID(), 'grid_size', true); ?>
	<?php $post_grid_class = 'grid-size-' . ( $grid_size ? $grid_size : 'normal'); ?>
	<div class="cell <?php echo esc_attr($post_grid_class); ?>">
		<article id="post-<?php the_ID(); ?>">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
			
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<div class="post-meta">
				<?php /*<div class="posted-on"> 
					<?php ba_posted_on(); ?>
				</div> */ ?>
				<div class="posted-by">
					<?php ba_posted_by(); ?>
				</div>


				<div class="posted-in">
					<?php ba_posted_in(); ?>
				</div>
			</div>
			
		
			<?php ba_the_excerpt(); ?>

		</article>
	</div>
<?php else : ?> 
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if ( 'post' === get_post_type() ) : ?>
				<div class="entry-meta">
					<?php ba_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		
			<?php
				the_content(
					sprintf(
					/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'Bonne-Ambiance' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) 
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Bonne-Ambiance' ),
						'after'  => '</div>',
					) 
				);
				?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<?php ba_entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</article><!-- #post-## -->
<?php endif; ?>