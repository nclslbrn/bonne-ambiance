<?php 
/**
 * Functions to get and save custom metadata
 * Post has a postmeta to change the size of the post in the homepage post grid
 *
 * @package Bonne-Ambiance.
 * @version 1.0.0.
 */

/**
 * Add every metabox to project post
 */

// post cover options
add_action(
	'cmb2_admin_init',
	function () {
		$cmb = new_cmb2_box(array(
			'id'            => 'post_grid_size_metabox',
			'title'         => __('Post grid size', 'Bonne-Ambiance'),
			'object_types'  => array('post'),
			'context'       => 'normal',
			'priority'      => 'high',
		));

		$cmb->add_field(array(
			'name'       => __(
				'How large is this post in the homepage/archive grid ?',
				'Bonne-Ambiance'
			),
			'id'               => 'grid_size',
			'type'             => 'radio',
			'show_option_none' => false,
			'options'          => array(
				'normal'   => __('Normal', 'Bonne-Ambiance'),
                'large'    => __('Large', 'Bonne-Ambiance'),
			),
		));
	}
);

if (!function_exists('ba_get_authors_ID_name_list')) {
	function ba_get_authors_ID_name_list() {
		$authors = get_users(array('fields' => array('ID', 'display_name')));
		$curr_user = wp_get_current_user();
		$options = [];
		foreach ($authors as $opt) {
			if (intval($curr_user->ID) !== intval($opt->ID)) {
				$options[$opt->ID] = $opt->display_name;
			}
		}
		return $options;
	}
}

// multi author options
add_action(
	'cmb2_admin_init',
	function () {
			$cmb = new_cmb2_box(array(
			'id'            => 'coauthor_metabox',
			'title'         => __('Multi author', 'Bonne-Ambiance'),
			'object_types'  => array('post'),
			'context'       => 'normal',
			'priority'      => 'high',
		));

		$cmb->add_field(array(
			'name'       => __(
				'Is it a multi-author post?',
				'Bonne-Ambiance'
			),
			'description'	    => __('If so check the right co-author below', 'Bonne-Ambiance'),
			'id'                => 'co_author',
			'type'              => 'multicheck',
			'show_option_none'  => false,
			'select_all_button' => false,
			'options_cb'	    => 'ba_get_authors_ID_name_list'
		));
	}
);

