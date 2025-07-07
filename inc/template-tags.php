<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bonne-Ambiance
 */

if ( ! function_exists( 'ba_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function ba_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'Bonne-Ambiance' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'ba_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function ba_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'Bonne-Ambiance' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'ba_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ba_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', '_s' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', '_s' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', '_s' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', '_s' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', '_s' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', '_s' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Flush out the transients used in mapcategorized_blog.
 */
function ba_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'mapcategories' );
}
add_action( 'edit_category', 'ba_category_transient_flusher' );
add_action( 'save_post', 'ba_category_transient_flusher' );
/**
 * Add share butttons
 *
 * @param string $title the post title to share.
 * @param string $url the post permalink.
 * @param string $class optional module classname.
 */
function ba_social_module( $title, $url, $class = '' ) {
	?>
	<div class="social-sharing-module <?php echo esc_attr( $class ); ?>">	
		<p class="list-title"><?php echo esc_html( __( 'Share', 'Bonne-Ambiance' ) ); ?></p>
		<ul>
			<li>
				<a href="https://www.facebook.com/sharer.php?u=<?php echo esc_url( $url ); ?>" target="_blank">
					<svg class="icon icon-facebook">
						<use xlink:href="#icon-facebook"></use>
					</svg>
					<span class="screen-reader-text">
						<?php echo esc_html( __( 'Share on Facebook', 'Bonne-Ambiance' ) ); ?>
					</span>
				</a>
			</li>
			<li>
				<a href="https://twitter.com/intent/tweet?text=<?php echo esc_url( $url ); ?> via @Nicolas_Lebrun_" target="_blank">
					<svg class="icon icon-twitter">
						<use xlink:href="#icon-twitter"></use>
					</svg>
					<span class="screen-reader-text">
						<?php echo esc_html( __( 'Share on Twitter', 'Bonne-Ambiance' ) ); ?>
					</span>
				</a>
			</li>
			<li>
				<a href="mailto:?&body=<?php echo esc_url( $url ); ?>" target="_blank">
					<svg class="icon icon-mail">
						<use xlink:href="#icon-mail"></use>
					</svg>
					<span class="screen-reader-text">
						<?php echo esc_html( __( 'Send Email', 'Bonne-Ambiance' ) ); ?>
					</span>
				</a>
			</li>
		</ul>
	</div>
	<?php
}
/**
 * Replace Search text
 *
 * @return string $form The search form HTML output.
 */
function ba_search_form_text() {

	$form = '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" class="search-form">
								<input type="search" 
											 name="s" 
											 id="s" 
											 class="search-field" 
											 placeholder="' . esc_attr_x( 'Search', 'submit button', 'Bonne-Ambiance' ) . '..." 
											 value="' . esc_attr( get_search_query() ) . '" 
								required>
								<button type="submit" class="search-submit">
									<svg class="icon icon-search">
										<use xlink:href="#icon-search"></use>
									</svg>
									<span class="screen-reader-text">' . esc_attr_x( 'Search', 'submit button', 'Bonne-Ambiance' ) . '</span>
								</button>
						</form>';

	return $form;
}
add_filter( 'get_search_form', 'ba_search_form_text' );
