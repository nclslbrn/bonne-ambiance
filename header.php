<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Bonne-Ambiance
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	
	<?php get_template_part('template-parts/svg', 'defs'); ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'Bonne-Ambiance' ); ?></a>

		<header id="masthead" class="site-header" role="banner">
			<div class="wrapper">
				<div class="site-branding">
					<h1 class="site-title">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
							<?php echo esc_textarea( get_bloginfo( 'name' ) ); ?>
						</a>
					</h1>
				</div><!-- .site-branding -->
				<nav id="site-navigation" class="main-navigation" role="navigation">
					<?php 
					
					wp_nav_menu(
						array(
							'theme_location'   => 'primary',
							'menu_id'          => 'primary-menu',
							'container'        => '',
							'add_category_list' => true,
							'depth'            => 3,
						)
					);
					?>
				</nav><!-- #site-navigation -->

				<button 
					class="menu-toggle" 
					aria-controls="primary-menu" 
					aria-labelledby="primary-menu"
					aria-label="open-menu"
					name="menu-button" 
					aria-expanded="false">
					<span class="menu-icon"></span>
				</button>


			</div><!-- .wrapper -->
		</header><!-- #masthead -->

		<div id="content" class="site-content">
			<div class="wrapper">
