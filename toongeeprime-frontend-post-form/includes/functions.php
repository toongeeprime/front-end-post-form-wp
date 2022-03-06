<?php defined( 'ABSPATH' ) || exit;

/**
 *	HELPER FUNCTIONS
 */

/**
 *	If post editing URL parameters are set
 */
function toongeeprime_post_edit_url_params() {

	return isset( $_GET[ 'pid' ], $_GET[ 'edit' ] );

}



/**
 *	Front-end Edit Post URL
 */
function toongeeprime_post_edit_url() {
$pid	=	get_the_ID();

	$fPageName	=	toongeePrime_formPage( 'post_name' );
	$fPageURL	=	home_url( '/' . $fPageName . '/' );

	return ( $fPageURL . '?pid=' . $pid . '&edit' );

}




/**
 *	Output Post Field
 */
function toongeeprime_post_field( $field = '', $pToEdit = null, $echo = '' ) {

	// If a post object exists to edit
	if ( is_object( $pToEdit ) ) {

		// Display field value
		if ( $echo == 'return' ) {
			return $pToEdit->$field;
		}
		else {
			echo $pToEdit->$field;
		}

	}

}




/**
 *	Path to a plugin image
 */
function toongeeprime_FEForm_image( $imgSlug ) {

	return esc_url( home_url( 'wp-content/plugins/toongeeprime-frontend-post-form/images/' . $imgSlug ) );

}

