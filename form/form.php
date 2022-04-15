<?php defined( 'ABSPATH' ) || exit;

/**
 *	THE POSTING FORM
 *
 *	In HTML for simplicity
 */

/**
 *	THE WORKING FUNCTION AND SHORTCODE
 */

add_shortcode( 'toongeeprime_posts_form', 'toongeeprime_FEPost_form_runner' );
function toongeeprime_FEPost_form_runner() {

	// Form should only work on pages
	if ( ! is_page() ) {
		return 'Sorry, this form will not work here. It must be set on a Page.';
	}


	// Authorized users only
	if ( ! current_user_can( 'edit_posts' ) ) {
		return 'Sorry, no permissions.';
	}


	// Cache Page IDs and form Page determiner
	$pID		=	get_the_ID();
	$fPageID	=	toongeePrime_formPage( 'ID', 'publish' );
	$formPage	=	( $fPageID === $pID );


	// If form Page is not set
	if ( ! $fPageID ) {
		return 'No page is set for the posts Form.';
	}


	// Form should only work on form page
	if ( $fPageID && ! $formPage ) {
		return 'You already have a page for this form. <a href="'. get_page_link( $fPageID ) .'">Please click here to go to the page</a>.';
	}



	/**
	 *	THE POSTING FORM ITSELF
	 */

	// If required URL parameters exist, get post object
	if ( toongeeprime_post_edit_url_params() ) {

		$pid		=	$_GET[ 'pid' ];
		$pToEdit	=	get_post( intval( $pid ) );


		// If post object does not exist
		if ( ! is_object( $pToEdit ) || ( $pToEdit->post_type != 'post' ) ) {
			return 'Your desired post is non-existent';
		}


		// Get post Status
		$pStatus	=	toongeeprime_post_field( 'post_status', $pToEdit, 'return' );

		// Get Tags
		$postTags	=	wp_get_post_tags( $pid, array( 'fields' => 'names' ) );

		// Get Categories
		$pCats		=	get_the_terms( $pToEdit, 'category' );
		$pCat		=	$pCats[0]->name;

	}
	else {
	// Add a new post

		$pid	=	'0';
		$pStatus = $pToEdit = $postTags	= $pCats = $pCat		=	null;

	}


	/**
	 *		The Form HTML
	 */
$form	=	'<div id="prime2g_feformWrap" class="prime2g_form prel">';
$form	.=	'<form id="prime2g_fe_post_form" class="prime2g-forms" name="prime2g_fe_post_form" method="post" action="" enctype="multipart/form-data">';

	if ( isset( $_GET[ 'pstatus' ] ) ) {
		$pStat	=	$_GET[ 'pstatus' ];

		if ( $pStat == 'published' ) {
			$form	.=	'<p id="prime2g_pstatus_notice" title="Dismiss">Your new Post has been Published</p>';
		}
		if ( $pStat == 'draft' ) {
			$form	.=	'<p id="prime2g_pstatus_notice" title="Dismiss">Your Draft has been Saved</p>';
		}
		if ( $pStat == 'updated' ) {
			$form	.=	'<p id="prime2g_pstatus_notice" title="Dismiss">Your Post has been Updated</p>';
		}

	}

	if ( $pStatus ) {
		$form	.=	'<p id="poststatus" class="prel">';
		$form	.=	'Status: <span>';
			if ( $pStatus == 'publish' ) {

				$form	.=	'Published';

			}
			if ( $pStatus == 'draft' ) {

				$form	.=	'Draft';

			}
		$form	.=	'</span>';
		$form	.=	'</p>';


		$form	.=	'<!-- Post Link -->';
		$form	.=	'<div class="fld-set post_url">';
		// $form	.=	'<!-- <a href="'. get_preview_post_link( $pid ) .'" target="_blank"><button id="previewBtn" class="btn button">Preview Changes</button></a> -->';

		if (  $pStatus == 'publish' ) {

			$form	.=	'<p style="text-align:center;"><a href="'. get_permalink( $pid ) .'" target="_blank" id="post_url" title="View this post">View Post</a></p>';

		}

		$form	.=	'<p class="p-abso" style="text-align:center;"><a href="'. get_edit_post_link( $pid ) .'" id="wp_edit_post_url" title="Edit post">Edit Post in WordPress</a></p>';
		$form	.=	'</div>';

	}


$form	.=	'<div class="akwform-sides grid">';
$form	.=	'<div class="akwform-left">';
$form	.=	'<!-- Post Name -->';
$form	.=	'<div class="fld-set title">';
$form	.=	'<label for="post_title">Post Title</label>';
$form	.=	'<input type="text" id="post_title" tabindex="1" name="post_title" class="flds" value="'. toongeeprime_post_field( 'post_title', $pToEdit, 'return' ) .'" required />';
$form	.=	'</div>';
$form	.=	'<!-- post Excerpt -->';
$form	.=	'<div class="fld-set excerpt">';
$form	.=	'<label for="post_excerpt">Excerpt / Brief</label>';
$form	.=	'<textarea id="post_excerpt" tabindex="1" name="post_excerpt" cols="50" rows="3" class="flds">'. toongeeprime_post_field( 'post_excerpt', $pToEdit, 'return' ) .'</textarea>';
$form	.=	'</div>';
$form	.=	'<!-- Post Content -->';
$form	.=	'<div class="fld-set content">';


$form	.=	'<label for="post_content">Post Content</label>';
$theContent = toongeeprime_post_field( 'post_content', $pToEdit, 'return' );

	$set_edtr	=	array(
		'tabindex'		=>	1,
		'textarea_rows'	=>	10,
		'editor_class'	=>	'flds',
		'drag_drop_upload'	=>	true,
		'quicktags'		=>	true
	);

$form	.=	toongeePrime_get_wp_editor( $theContent, 'post_content', $set_edtr );


$form	.=	'</div>';
$form	.=	'</div><!-- leftside -->';
$form	.=	'<div class="akwform-right">';
$form	.=	'<!-- Post Category -->';
$form	.=	'<div class="fld-set taxo categ">';


$form	.=	'<label for="category">Category:</label>';
	$args = array(
		'show_count'		=>	0,
		'name'				=>	'category',
		'class'				=>	'flds taxo',
		'selected'			=>	$pCat,
		'tab_index'			=>	1,
		'taxonomy'			=>	'category',
		'hide_empty'		=>	false,
		'value_field'		=>	'name',
	);
$form	.=	toongeePrime_get_categ_dropdown( $args );


$form	.=	'</div>';

	// Featured Image
	$form	.=	toongeePrime_form_ftImage( $pid );

$form	.=	'<!-- Post Tags -->';
$form	.=	'<div class="fld-set taxo tag">';
$form	.=	'<label for="post_tag">Tags:</label>';

$form	.=	'<input type="text" value="';
	if ( $postTags ) {
		foreach ( $postTags as $tag => $value ) {

			$form	.=	$value . ', ';

		}
	}

$form	.=	'" tabindex="1" name="post_tag" id="post_tag" class="flds taxo" placeholder="Separate tags with a comma" />';
$form	.=	'</div>';

$form	.=	'<!-- Publish Now? -->';
$form	.=	'<div class="fld-set select">';
$form	.=	'<label for="the_status">Action</label>';
$form	.=	'<select id="the_status" class="flds" name="the_status" tabindex="1">';
$form	.=	'<option value="draft">';

	if ( $pStatus == 'publish' ) {

		$form	.=	'Unpublish';

	}
	else {

		$form	.=	'Save Draft';

	}

$form	.=	'</option>';
$form	.=	'<option value="publish"';

	if ( $pStatus == 'publish' ) {

		$form	.=	' selected';

	}

$form	.=	'>';

	if ( $pStatus == 'publish' ) {

		$form	.=	'Save Update';

	}
	else {

		$form	.=	'Publish Now';

	}

$form	.=	'</option>';
$form	.=	'</select>';
$form	.=	'</div>';
$form	.=	'<div align="right">';
$form	.=	'<input type="submit" value="Update" tabindex="1" id="submit" name="submit" class="btn button" />';
$form	.=	'</div>';
$form	.=	'</div><!-- rightside -->';
$form	.=	'</div><!-- formsides -->';
$form	.=	'<input type="hidden" name="fe_post_id" value="'. $pid .'" >';
$form	.=	'<input type="hidden" name="action" value="prime2g_post" />';
$form	.=	wp_nonce_field( 'prime2g_nonce', '_the-nonce' );
$form	.=	'</form>';
$form	.=	'</div><!-- #prime2g_feformWrap -->';


wp_enqueue_media();

return $form;

}

