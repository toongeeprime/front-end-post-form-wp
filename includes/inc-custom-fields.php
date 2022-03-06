<?php defined( 'ABSPATH' ) || exit;

/**
 *	CUTOM FIELDS
 */

add_action( 'add_meta_boxes', 'toongeeprime_FEForm_mBox' );
add_action( 'save_post', 'toongeeprime_FEForm_save_mBox' );


/**
 * Add The Field Metaboxes
 */
function toongeeprime_FEForm_mBox() {

	add_meta_box(
		'toongeeprime_FEForm_mBox',
		__( 'Front-End Posts Form', 'twentytwentyone' ),
		'toongeeprime_FEForm_display_callback',
		'page',
		'side',
		'high'
	);

}


/**
 * Save meta box content
 */
function toongeeprime_FEForm_save_mBox( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( $parent_id = wp_is_post_revision( $post_id ) ) {
		$post_id = $parent_id;
	}
	$fields = [
		'prime_has_feForm_post_shortcode',
	];
	foreach( $fields as $field ) {
		if ( array_key_exists( $field, $_POST ) ) {
			update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
		}
	}
}



/**
 *	Custom Fields in Admin
 */
function toongeeprime_FEForm_display_callback( $post ) {
	$pid	=	get_the_ID();
	$scTrue	=	( get_post_meta( $pid, 'prime_has_feForm_post_shortcode', true ) == 'true' );

	$scTrue ? $theSC = $scTrue : $theSC = '';
?>

	<div class="akawey_box">

		<div class="primeFE_shortcode">
			<label for="primeFE_shortcode">Use This Page for Form?</label>
			<select  id="primeFE_shortcode" name="prime_has_feForm_post_shortcode">
				<option value="false">Do Not Use This Page</option>
				<option value="true" <?php if ( $scTrue ) echo 'selected'; ?>>Yes, Use This Page</option>
			</select>
		</div>

	</div>

<?php


/**
 * Hiding the select metabox
 *	** Keep this outside the content editing query
 */

add_action( 'admin_footer', function() use( &$scTrue ) {

	// Check existence of form Page
	$fPID	=	toongeePrime_formPage( 'ID', 'publish' );

	// Hide metabox with CSS
	if ( $fPID && ! $scTrue ) {
		echo '<style>#toongeeprime_FEForm_mBox{display:none!important;}</style>';
	}

} );

}






/**
 * AUTO SET SHORTCODE IN FORM PAGE
 *
 ***** WORK IN PROGRESS
add_action( 'save_post_page', 'toongeeprime_set_formPageSgortcode' );
function toongeeprime_set_formPageSgortcode() {



if(){

$content = '[akawey_user_dashboard_page]';

	$dash = array(
		'post_type'		=>	'page',
		'post_name'		=>	'me',
		'post_author'	=>	1,
		'post_status'	=>	'publish',
		'post_content'	=>	$content
	);

wp_insert_post( $dash );

}
}
*/

