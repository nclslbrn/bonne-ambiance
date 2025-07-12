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
			'id'                => 'category_description_metabox',
			'title'             => __('Category description', 'Bonne-Ambiance'),
			'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		    'taxonomies'       => array( 'category', 'post_tag' ), 
			'context'           => 'normal',
            'new_term_section'  => false
		));
  
        $cmb->add_field( array(
		    'name' => esc_html__( 'Term Image', 'Bonne-Ambiance' ),
		    'id'   => 'ba_image_cover',
		    'type' => 'file',
	    ) );
		
        $cmb->add_field(array(
			'name'       => __(
				'Category introduction text',
				'Bonne-Ambiance'
			),
			'id'               => 'cat_description',
			'type'             => 'wysiwyg',
            //'taxonomies'       => array('category')
		));
	}
);

// hide the default textarea
function ba_hide_cat_descr() { ?>

    <style type="text/css">
       .term-description-wrap {
           display: none;
       }
    </style>

<?php } 
add_action( 'admin_head-term.php', 'ba_hide_cat_descr' );
add_action( 'admin_head-edit-tags.php', 'ba_hide_cat_descr' );

