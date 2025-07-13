<?php
/**
 * Template Name: Authors 
 * The template for displaying all authors of the site.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Bonne-Ambiance
 * @var Post $post the global WordPress post object
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->
                    
					<div class="entry-content">
                        <?php the_content(); ?> 
                            
                        <?php $authors = get_users([
                                'fields'  => ['ID', 'display_name'],
                                'orderby' => 'display_name',
                        ]); ?>
                        
                        <div id="grid">
                            <div class="grid-sizer"></div>

                            <?php foreach ($authors as $user) :

                                $user_description = get_user_meta($user->ID, 'description', true);
                                $user_avatar = get_user_meta($user->ID, 'avatar', true);
                                $user_link = get_user_meta($user->ID, 'link', true);
                                $user_url = parse_url($user_link);
                                
                                ?>
                                <div class="cell">
                                    <h5>
                                        <a href="<?php echo esc_url( get_author_posts_url( $user->ID ) ); ?>">
                                            <?php echo esc_textarea($user->display_name); ?>
                                        </a>
                                    </h5>
                                    
                                    <?php if ($user_avatar) : ?>
                                        <img alt="<?php 
                                            echo __('Avatar', 'Bonne-ambiance') . ' ' .
                                            $user->display_name; ?>" 
                                            src="<?php echo esc_url($user_avatar); ?>" 
                                        />
                                    <?php endif; ?>
                                    
                                    <?php if ($user_description) : ?>
                                        <p><?php echo wp_kses_post($user_description); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($user_link && $user_url) : ?>
                                        <a href="<?php esc_url($user_link); ?>">
                                            <?php echo esc_html($user_url['host']); ?>
                                        </a>
                                    <?php endif; ?>
                                </div><!-- .cell -->
                            <?php endforeach; ?>
                        </div><!-- #grid -->
					</div>
				</article>
			<?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
get_sidebar();
get_footer();