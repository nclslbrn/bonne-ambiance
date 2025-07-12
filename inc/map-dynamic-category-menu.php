<?php
/**
 * Add a list of project dynamicly (order by descending year) in wp_nav_menu
 *
 * @package Bonne-Ambiance
 * @version 7.4.3
 */

add_filter( 'wp_nav_menu_objects', 'ba_dynamic_category', 10, 2 );

/**
 * Add custom post project list
 *
 * The nav menu has to be called with 'add_category_list' => true.
 * Example:
 * wp_nav_menu(
 *  array(
 *      'theme_location' => 'primary',
 *      'add_category_list' => true
 *  )
 * );
 *
 * @param   array  $sorted_menu_items Existing menu items.
 * @param   object $args Nav menu arguments as object.
 * 
 * @return  array
 */
function ba_dynamic_category( $sorted_menu_items, $args ) {
	if ( ! isset( $args->add_category_list ) || ! $args->add_category_list ) {
		return $sorted_menu_items;
	}

    $categories = get_terms( array(
  	  	'taxonomy'   	=> 'category',
 	   	'hide_empty' 	=> true,
		'orderby'		=> 'term_id',
		'order'			=> 'ASC'
	) );

	foreach ( $categories as $order => $cat ) {
		$menu_item                   	 = new stdClass();
		$menu_item->ID               	 = -1;
		$menu_item->attr_title			 = $cat->name;
		$menu_item->classes 				 = [
			'menu-item', 
			'menu-item-type-term', 
			'menu-item-object-category', 
			is_category($cat->term_id) ? 'current-menu-item' : ''
		];	
		$menu_item->db_id            	 = $cat->term_id;
		$menu_item->description 		 = '';
		$menu_item->menu_item_parent 	 = 0;
		$menu_item->object				 = 'category';
		$menu_item->object_id			 = $cat->term_id;
		$menu_item->post_parent			 = 0;
		$menu_item->post_title            = $cat->name;
		$menu_item->target           	 = "";
		$menu_item->title            	 = $cat->name;
		$menu_item->type 				 = 'taxonomy';
		$menu_item->type_label 			 = __('theme', 'Bonne-Ambiance');
		$menu_item->url              	 = get_site_url() . "/category/$cat->slug";
		$menu_item->guid 				 = get_site_url() . "?cat=$cat->term_id";
		$menu_item->xfn              	 = 0;
		$menu_item->current				 = is_category($cat->term_id);
	
		array_unshift($sorted_menu_items,  wp_setup_nav_menu_item( $menu_item ));
	}

	return $sorted_menu_items;
}
