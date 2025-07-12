<?php 
/**
 * Functions to get and save user relative custom metadata
 *
 * @package Bonne-Ambiance.
 * @version 1.0.0.
 */

add_action( 'cmb2_admin_init', function() {
    $cmb_user = new_cmb2_box( array(
		'id'               => 'user_edit',
		'title'            => esc_html__( 'User Profile Metabox', 'Bonne-Ambiance' ),
		'object_types'     => array( 'user' ), 
		'show_names'       => true,
		'new_user_section' => 'add-new-user' 
	) );
    $cmb_user->add_field( array(
		'name'    => esc_html__( 'Avatar', 'Bonne-ambiance' ),
		'desc'    => esc_html__( '400 x 400px', 'Bonne-Ambiance' ),
		'id'      => 'avatar',
		'type'    => 'file',
	) );

	$cmb_user->add_field( array(
		'name' => esc_html__( 'Link',  'Bonne-Ambiance' ),
		'id'   => 'link',
		'type' => 'text_url',
	) );
});