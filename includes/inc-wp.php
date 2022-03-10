<?php defined( 'ABSPATH' ) || exit;

/**
 *	PLUGGING INTO WP
 */


/**
 *	WP Admin Bar Menu
 */
add_action( 'admin_bar_menu', 'akw_admintoolbar_menu', 100 );
function akw_admintoolbar_menu( $admin_bar ) {

if ( is_admin() || ! is_singular( 'post' ) ) return;

$admin_bar->add_menu( array(
	'id'	=>	'toongeePrime_bar_menu',
	'title'	=>	'Front End',
	'href'	=>	'#',
)
);

$admin_bar->add_menu( array(
	'id'		=>	'prime2g_fe_edit_post',
	'parent'	=>	'toongeePrime_bar_menu',
	'title'		=>	'Edit Post',
	'href'		=>	toongeeprime_post_edit_url(),
	'meta'		=>	array(
		'title'	=>	__( 'Edit this post in the Front end', '' ),
		'class'	=>	'prime2g_menus'
	),
)
);

}




/**
 *	WP Admin Post State
 */
add_filter( 'display_post_states', 'toongeePrime_admin_post_state', 10, 2 );
function toongeePrime_admin_post_state( $post_states, $post ) {

	if ( $post->prime_has_feForm_post_shortcode == 'true' ) {
		$post_states[] = 'Front-end Posts Page';
	}

	return $post_states;
}




/**
 *	WP Admin Notices
 */
add_action( 'admin_notices', 'toongeePrime_admin_notices' );
function toongeePrime_admin_notices() {

if ( ! current_user_can( 'edit_others_posts' ) ) return;

$screen			=	get_current_screen();
$admin_pages	=	[ 'dashboard', 'edit-page', 'plugins', 'options-general' ]; // DO NOT include page editing screens

	if ( in_array( $screen->id, $admin_pages ) ) {

		if ( ! toongeePrime_formPage( 'ID', 'publish' ) ) {
		?>
			<div class="notice notice-info is-dismissible">
				<p>To use the Front-end Posts form, Please set this shortcode <strong>[toongeeprime_posts_form]</strong> on a Page</p>
			</div>
		<?php

		return;
		}

	}

	if ( $screen->id == 'edit-page' && toongeePrime_formPage( 'count', 'publish' ) > 1 ) {
	?>
		<div class="notice notice-warning is-dismissible">
			<p>You have more than one <strong>Front-end Posts Page</strong> with this shortcode <strong>[toongeeprime_posts_form]</strong></p>
		</div>
	<?php
	}

}

