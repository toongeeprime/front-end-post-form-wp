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
 *	Determine if current page is form Page
 */
function toongeeprime_is_form_page() {

	// Return if any of these
	if ( is_admin() || ! is_page() ) return;

	return	( toongeePrime_formPage( 'ID', 'publish' ) === get_the_ID() );

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
function toongeeprime_post_field( $field = '', $pToEdit = null, $return = '' ) {

	// If a post object exists to edit
	if ( is_object( $pToEdit ) ) {

		// Display field value
		if ( $return == 'return' ) {
			return htmlspecialchars( $pToEdit->$field );
		}
		else {
			echo htmlspecialchars( $pToEdit->$field );
		}

	}

}




/**
 *	Path to a plugin image
 */
function toongeeprime_FEForm_image( $imgSlug ) {

	return esc_url( home_url( 'wp-content/plugins/toongeeprime-frontend-post-form/images/' . $imgSlug ) );

}

