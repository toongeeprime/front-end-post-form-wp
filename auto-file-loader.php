<?php defined( 'ABSPATH' ) || exit;

/**
 *	LOAD FILES
 */

/**
 *	Add form stylesheet file to the queue
 */
add_action( 'wp_enqueue_scripts', 'toongeePrime_fe_form_enqueues' );
function toongeePrime_fe_form_enqueues() {

	// return if Not on form Page
	if ( ! toongeeprime_is_form_page() ) return;

	$dir		=	plugin_dir_url( __FILE__ );
	$version	=	primefe_plugin_data()['Version'];

	wp_enqueue_style(
		'toongeePrime_formCSS',
		$dir . 'files/form-css.css',
		array(),
		$version,
	);

	wp_enqueue_script(
		'toongeePrime_mediaLib',
		$dir . 'files/media-library.js',
		array(),
		$version,
		true
	);
	wp_enqueue_script(
		'toongeePrime_formJS',
		$dir . 'files/form-js.js',
		array(),
		$version,
		true
	);

}


/**
 *	GET PLUGIN PHP FILES THROUGH DIRECTORIES ARRAY
 */
$directories	=	[ 'includes', 'form' ];

foreach( $directories as $dir ) {

	$folder	=	PRIME_FE_POST_FORM . $dir . '/';
	$files	=	scandir( $folder );

	foreach( $files as $file ) {
		$path	=	$folder . $file;

		if ( ! is_dir( $path ) && pathinfo( $path )[ 'extension' ] == 'php' ) require_once $path;
	}

}


