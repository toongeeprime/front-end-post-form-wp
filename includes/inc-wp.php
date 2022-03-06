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

