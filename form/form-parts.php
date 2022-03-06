<?php defined( 'ABSPATH' ) || exit;

/**
 *	PARTS OF THE FORM
 */

function toongeePrime_form_ftImage( $pid = '0' ) {

if ( current_user_can( 'upload_files' ) ) {

	if ( $pid != '0' ) {
		$url = get_the_post_thumbnail_url( $pid );
	}
	else {
		$url = '';
	}

?>

	<div class="filediv">
	<div id="post_ft_image" class="fld-set prime2g_uploader">
		<div id="thumb_img_wrapper">
		<label for="post_thumbnail_id">Featured Image</label>
			<img id="fmrFTimg" src="<?php echo $url; ?>"/>
			<img id="thumb_img" />
		</div>
			<input type="hidden" id="post_thumbnail_id" name="post_thumbnail_id" value="" />
	</div>
		<input type="button" class="prime_rmv_button button" style="display:none;" value="Reset Image" />
	</div>

<?php

}

}



