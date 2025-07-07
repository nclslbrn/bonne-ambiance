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

// project cover options
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
				'small'    => __('Small', 'Bonne-Ambiance'),
				'normal'   => __('Normal', 'Bonne-Ambiance'),
                'large'    => __('Large', 'Bonne-Ambiance'),
                'huge'     => __('Huge', 'Bonne-Ambiance')
			),
		));
	}
);

