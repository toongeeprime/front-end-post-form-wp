<?php defined( 'ABSPATH' ) || exit;

/**
 *	RUN THE FORM HEADER
 */

add_action( 'template_redirect', 'toongeeprime_FEForm_headers' );
function toongeeprime_FEForm_headers() {

	// Return if any of these
	if ( is_admin() || ! is_page() ) return;


	// Cache Page IDs and form Page determiner
	$pID		=	get_the_ID();
	$fPageID	=	toongeePrime_formPage( 'ID', 'publish' );
	$formPage	=	( $fPageID === $pID );


	// Return if not on form Page or if no page set
	if ( ( $fPageID && ! $formPage ) || ( ! $fPageID ) ) return;


	// Redirect to error URL parameter if user has no privilege
	// DO NOT return to form Page
	if ( $formPage && ! current_user_can( 'edit_posts' ) ) {

		wp_safe_redirect( home_url( '?fe_error' ) );

	}



	/**
	 *	Now, RUN POSTING HEADER:
	 *
	 *	@ https://developer.wordpress.org/reference/functions/wp_insert_post/
	 */

	if ( ! ( 'POST' == $_SERVER[ 'REQUEST_METHOD' ] &&
		! empty( $_POST[ 'action' ] ) &&  $_POST[ 'action' ] == "prime2g_post" ) )
		{
			return;
		}

	if ( ! isset( $_REQUEST[ '_the-nonce' ] ) || ! wp_verify_nonce( $_POST[ '_the-nonce' ], 'prime2g_nonce' ) )
		{
			return;
		}


	// Validations
	if ( ! isset( $_REQUEST[ 'post_content' ] ) ) { echo '<p>No content. Please provide content</p>'; }


	// First, get the post ID
	$postID		=	$_POST[ 'fe_post_id' ];
	$thepID		=	intval( $postID );


	// Add the content of the form to $thepost
	$thepost	=	array(
		'ID'			=>	$thepID,
		'post_title'	=>	sanitize_text_field( $_POST[ 'post_title' ] ),
		'post_content'	=>	wp_kses_post( $_POST[ 'post_content' ] ),
		'post_excerpt'	=>	sanitize_text_field( $_POST[ 'post_excerpt' ] ),
		'post_status'	=>	sanitize_text_field( $_POST[ 'the_status' ] ),
		'_thumbnail_id'	=>	sanitize_text_field( $_POST[ 'post_thumbnail_id' ] ),
		// 'post_category'	=>	array(  ), // (int[]) Array of category IDs. Defaults to value of the 'default_category' option.
		// 'tags_input'	=>	array(  ), // (array) Array of tag names, slugs, or IDs. Default empty.
	);


	/**
	 *	CREATE OR SAVE THE POST
	 */

		if ( $thepID == 0 ) {

			$pid	=	wp_insert_post( $thepost );

		}
		else {

			$pid	=	wp_update_post( $thepost );

		}

	wp_set_object_terms( $pid, $_POST[ 'category' ], 'category' );
	wp_set_post_tags( $pid, $_POST[ 'post_tag' ] );


	if ( ! is_wp_error( $pid ) ) {

		// Redirect to form Page editing the current post
		$fPageName	=	toongeePrime_formPage( 'post_name' );
		$fPageURL	=	home_url( '/' . $fPageName . '/' );

		wp_safe_redirect( $fPageURL . '?pid=' . $pid . '&edit' );
		exit;

	}
	else {

		// there was an error in the post insertion, 
		echo $pid->get_error_message();

	}

}

