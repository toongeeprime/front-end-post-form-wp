<?php defined( 'ABSPATH' ) || exit;

/**
 *	THE POSTING FORM
 *
 *	Done in HTML for simplicity
 */

/**
 *	THE WORKING FUNCTION AND SHORTCODE
 */

add_shortcode( 'toongeeprime_posts_form', 'toongeeprime_FEPost_form_runner' );
function toongeeprime_FEPost_form_runner() {

	// Form should only work on pages
	if ( ! is_page() ) {
		echo 'Sorry, this form will not work here. It must be set on a page.';
		return;
	}


	// Authorized users only
	if ( ! current_user_can( 'edit_posts' ) ) {
		echo 'Sorry, no permissions.';
		return;
	}


	// Cache Page IDs and form Page determiner
	$pID		=	get_the_ID();
	$fPageID	=	toongeePrime_formPage( 'ID', 'publish' );
	$formPage	=	( $fPageID === $pID );


	// If form Page is not set
	if ( ! $fPageID ) {
		echo 'No page is set for the posts Form.';
		return;
	}


	// Form should only work on form page
	if ( $fPageID && ! $formPage ) {
		echo 'You already have a page for this form. <a href="'. get_page_link( $fPageID ) .'">Please click here to go to the page</a>.';
		return;
	}



	/**
	 *	THE POSTING FORM ITSELF
	 */

	// If required URL parameters exist, get post object
	if ( toongeeprime_post_edit_url_params() ) {

		$pid		=	$_GET[ 'pid' ];
		$pToEdit	=	get_post( intval( $pid ) );


		// If post object does not exist
		if ( ! is_object( $pToEdit ) || ( get_post_type( $pToEdit ) != 'post' ) ) {
			echo 'Your desired post is non-existent';
			return;
		}


		// Get post Status
		// $pStatus	=	get_post_status( $pid );
		$pStatus	=	toongeeprime_post_field( 'post_status', $pToEdit, 'return' ); // since post object is already available

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
?>
<div id="prime2g_feformWrap" class="prime2g_form prel">

	<form id="prime2g_fe_post_form" class="prime2g-forms" name="prime2g_fe_post_form" method="post" action="" enctype="multipart/form-data">

	<?php
		if ( $pStatus ) {
		echo '<p id="poststatus" class="prel">';
		echo 'Status: <span>';
			if ( $pStatus == 'publish' ) {
				echo 'Published';
			}
			if ( $pStatus == 'draft' ) {
				echo 'Draft';
			}
		echo '</span>';
		echo '</p>';
		}
	?>

	<?php if ( $pStatus ) { ?>

		<!-- Post Link -->
		<div class="fld-set post_url">
			<!-- <a href="<?php // echo get_preview_post_link( $pid ); ?>" target="_blank"><button id="previewBtn" class="btn button">Preview Changes</button></a> -->

		<?php if (  $pStatus == 'publish' ) { ?>
			<p style="text-align:center;"><a href="<?php echo get_permalink( $pid ); ?>" target="_blank" id="post_url" title="View this post">View Post</a></p>
		<?php } ?>

			<p class="p-abso" style="text-align:center;"><a href="<?php echo get_edit_post_link( $pid ); ?>" id="wp_edit_post_url" title="Edit post">Edit Post in WordPress</a></p>
		</div>

	<?php } ?>


	<div class="akwform-sides grid">
	<div class="akwform-left">
		<!-- Post Name -->
		<div class="fld-set title">
			<label for="post_title">Post Title</label>
			<input type="text" id="post_title" tabindex="1" name="post_title" class="flds" value="<?php toongeeprime_post_field( 'post_title', $pToEdit ); ?>" required />
		</div>

		<!-- post Excerpt -->
		<div class="fld-set excerpt">
			<label for="post_excerpt">Excerpt / Brief</label>
			<textarea id="post_excerpt" tabindex="1" name="post_excerpt" cols="50" rows="3" class="flds"><?php toongeeprime_post_field( 'post_excerpt', $pToEdit ); ?></textarea>
		</div>

		<!-- Post Content -->
		<div class="fld-set content">
			<label for="post_content">Post Content</label>
			<?php
			$theContent = toongeeprime_post_field( 'post_content', $pToEdit, 'return' );
				$set_edtr	=	array(
					'tabindex'		=>	1,
					'textarea_rows'	=>	10,
					'editor_class'	=>	'flds',
					'drag_drop_upload'	=>	true,
					'quicktags'		=>	true
				);
			wp_editor( $theContent, 'post_content', $set_edtr );
			?>
		</div>
	</div><!-- leftside -->

	<div class="akwform-right">
		<!-- Post Category -->
		<div class="fld-set taxo categ">
			<label for="category">Category:</label>
			<?php
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
			wp_dropdown_categories( $args );
			?>
		</div>

	<?php
		// Featured Image
		toongeePrime_form_ftImage( $pid );
	?>

		<!-- Post Tags -->
		<div class="fld-set taxo tag">
			<label for="post_tag">Tags:</label>
			<input type="text" value="<?php
			if ( $postTags ) {
				foreach ( $postTags as $tag => $value ) { echo $value . ', '; }
			}
			?>" tabindex="1" name="post_tag" id="post_tag" class="flds taxo" placeholder="Separate tags with a comma" />
		</div>

		<!-- Publish Now? -->
		<div class="fld-set select">
			<label for="the_status">Action</label>
			<select id="the_status" class="flds" name="the_status" tabindex="1">
				<option value="draft">
				<?php
					if ( $pStatus == 'publish' ) {
						echo 'Unpublish';
					}
					else {
						echo 'Save Draft';
					}
				?>
				</option>
				<option value="publish" <?php if ( $pStatus == 'publish' ) echo 'selected'; ?>>
				<?php
					if ( $pStatus == 'publish' ) {
						echo 'Save Update';
					}
					else {
						echo 'Publish Now';
					}
				?>
				</option>
			</select>
		</div>

		<div align="right">
			<input type="submit" value="Update" tabindex="1" id="submit" name="submit" class="btn button" />
		</div>

	</div><!-- rightside -->
	</div><!-- formsides -->

	<input type="hidden" name="fe_post_id" value="<?php echo $pid; ?>" >
	<input type="hidden" name="action" value="prime2g_post" />
	<?php wp_nonce_field( 'prime2g_nonce', '_the-nonce' ); ?>
	</form>

</div><!-- #prime2g_feformWrap -->

<?php

wp_enqueue_media();

}


