<?php defined( 'ABSPATH' ) || exit;

/**
 *	Add form stylesheet file to the end of the queue
 */
add_action( 'wp_enqueue_scripts', 'toongeePrime_fe_form_css_enqueue' );
function toongeePrime_fe_form_css_enqueue() {

    $dir	=	plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'toongeePrime_formCSS', $dir . 'files/form-css.css' );

}


add_action( 'wp_footer', 'toongeePrime_fe_form_js' );
function toongeePrime_fe_form_js() {

    $dir	=	plugin_dir_url( __FILE__ );
    wp_enqueue_script( 'toongeePrime_formJS', $dir . 'files/form-js.js' );
    wp_enqueue_script( 'toongeePrime_mediaLib', $dir . 'files/media-library.js' );

}




/**
 *	AUTO REQUIRE includes FILES
 */

// DIR PATH
$incFolder	=	PRIME_FE_POST_FORM . 'includes/';

// Get files in the directory
$incFiles	=	scandir( $incFolder );

foreach( $incFiles as $incs ) {

	$incPath	=	$incFolder . $incs;

	// Ensure php file extension and require
	if ( pathinfo( $incPath )[ 'extension' ] == 'php' ) require_once $incPath;

}




/**
 *	AUTO REQUIRE FORM FILES
 */

// DIR PATH
$formFolder	=	PRIME_FE_POST_FORM . 'form/';

// Get files in the directory
$formFiles	=	scandir( $formFolder );

foreach( $formFiles as $form ) {

	$formPath	=	$formFolder . $form;

	// Ensure php file extension and require
	if ( pathinfo( $formPath )[ 'extension' ] == 'php' ) require_once $formPath;

}
