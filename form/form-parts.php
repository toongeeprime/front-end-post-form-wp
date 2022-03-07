<?php defined( 'ABSPATH' ) || exit;

/**
 *	PARTS OF THE FORM
 */

/**
 *	Return WP Editor
 */

function toongeePrime_get_wp_editor( $content, $editor_id, $options ) {
	ob_start();

	wp_editor( $content, $editor_id, $options );

$editr = ob_get_clean();

return $editr;

}



/**
 *	Return WP Post Category Dropdown
 */

function toongeePrime_get_categ_dropdown( $args ) {
	ob_start();

	wp_dropdown_categories( $args );

$categs = ob_get_clean();

return $categs;

}




/**
 *	FEATURED IMAGE BOX
 */

function toongeePrime_form_ftImage( $pid = '0' ) {

if ( ! current_user_can( 'upload_files' ) ) return;

	if ( $pid != '0' ) {
		$url = get_the_post_thumbnail_url( $pid );
	}
	else {
		$url = '';
	}


$ftImg	=	'<div class="filediv">';
$ftImg	.=	'<div id="post_ft_image" class="fld-set prime2g_uploader">';
$ftImg	.=	'<div id="thumb_img_wrapper">';
$ftImg	.=	'<label for="post_thumbnail_id">Featured Image</label>';
$ftImg	.=	'<img id="fmrFTimg" src="'. $url .'"/>';
$ftImg	.=	'<img id="thumb_img" />';
$ftImg	.=	'</div>';
$ftImg	.=	'<input type="hidden" id="post_thumbnail_id" name="post_thumbnail_id" value="" />';
$ftImg	.=	'</div>';
$ftImg	.=	'<input type="button" class="prime_rmv_button button" style="display:none;" value="Reset Image" />';
$ftImg	.=	'</div>';

return $ftImg;

}


