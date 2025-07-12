<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bonne-Ambiance
 */

?>

<header class="entry-header">
	<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'Bonne-Ambiance' ); ?></h1>
</header><!-- .page-header -->

<div class="entry-content">
	<?php
	if ( is_home() && current_user_can( 'publish_posts' ) ) : 
		?>

		<p>
		<?php 
		printf( 
			wp_kses( 
				/* translators: 1: first post edit link  */
				__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'Bonne-Ambiance' ), 
				array( 
					'a' => array( 'href' => array() ),
				) 
			), 
			esc_url( admin_url( 'post-new.php' ) ) 
		); 
		?>
			</p>

	<?php elseif ( is_search() ) : ?>

		<p><?php echo esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'Bonne-Ambiance' ); ?></p>
		<br>
		<?php
			get_search_form();

	else : 
		?>

		<p><?php esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'Bonne-Ambiance' ); ?></p>
		<?php
			get_search_form();

	endif; 
	?>
</div><!-- .entry-content -->
