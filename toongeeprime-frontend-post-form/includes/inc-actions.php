<?php defined( 'ABSPATH' ) || exit;

/**
 *		IMPORTANT ACTIONS
 */

/**
 *	Restrict media library access to only users' own media
 */
add_action( 'pre_get_posts', 'toongeePrime_restrict_media_library' );

function toongeePrime_restrict_media_library( $wp_query_obj ) {

global $current_user, $pagenow;

	if ( ! is_a( $current_user, 'WP_User' ) ) return;

	if ( 'admin-ajax.php' != $pagenow || $_REQUEST[ 'action' ] != 'query-attachments' ) return;

	if ( ! current_user_can( 'delete_others_posts' ) ) {

		$wp_query_obj->set( 'author', $current_user->ID );

	}

return;
}




add_action( 'admin_footer', 'toongeeprime_FEForm_hideWPEditor' );
add_action( 'wp_head', 'akawey_createDOMs_js' );
add_action( 'admin_head', 'akawey_createDOMs_js' );


/**
 *	CREATE & POPULATE DOM ELEMENTS
 */
if ( ! function_exists( 'akawey_createDOMs_js' ) ) {

function akawey_createDOMs_js() { ?>
<script id="akw-site-element-creator">

// Create New DOM Element
function akw_createNewItem( elType, newID, newClass, parentEl, putBeforeEl ) {
	let newEl		=	document.createElement( elType ),
		parentElmt	=	document.querySelector( parentEl ),
		iBefore		=	document.querySelector( putBeforeEl );
		newEl.id	=	newID,
		newEl.className	=	newClass,
		parentElmt.insertBefore( newEl, iBefore );
}

// Add content to Elements
function akw_addContentToEl( theEl, theTxt, theHtml, ifNoText = 'Empty!' ) {
let theElmt	=	document.querySelector( theEl );

if ( theElmt !== null ) {
let txtContent	=	document.createTextNode( theTxt ),
	noTxt		=	document.createTextNode( ifNoText );

		if ( theTxt ) {
			theElmt.appendChild( txtContent );
		}
		else if ( theHtml ) {
			theElmt.innerHTML = theHtml;
		}
		else {
			// theElmt.appendChild(noTxt); // plain text or
			theElmt.innerHTML = ifNoText; // html
		}
	}
	else {
		notifBox.innerHTML = "Your Requested Element, "+theEl+", Doesn't Exist.<br>No contents can be inserted therefore. <em>Sorry!</em>";
		notifBox.style.display = 'block';
	}
}
</script>
<?php
}

}


function toongeeprime_FEForm_hideWPEditor() {

if( is_admin() && isset( $_GET[ 'post' ] ) ) {

global $pagenow;

	// Get the ID of form Page:
	$pid	=	toongeePrime_formPage( 'ID', 'publish' );

	/**
	 *	Disable WP Editor on form Page
	 */
	if ( $pagenow == 'post.php' && $_GET[ 'action' ] == 'edit' ) {

	if ( $pid == $_GET[ 'post' ] ) {
	remove_post_type_support( 'page', 'editor' );

	?>
	<style id="akw-notif-css">
		#postdivrich,#elementor-switch-mode,#edit-slug-box,.block-editor-writing-flow,.edit-post-header-toolbar{display:none;}
		#akw-donot{margin:40px auto 0;}
		#akw-donot .postbox{padding:10px 20px 20px;}
	</style>

	<script id="akw-notif-js">
		akw_createNewItem( 'div', 'akw-donot', 'postbox-container', '#post-body-content', '#postdivrich' );
		akw_addContentToEl( '#akw-donot', '', '<div class="postbox"><h1>THIS IS YOUR POSTS FORM PAGE!</h1></div>', 'No Notice!' );
	</script>
	<?php
	}
}

}

}

