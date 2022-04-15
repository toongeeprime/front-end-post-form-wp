<?php defined( 'ABSPATH' ) || exit;

/**
 * Creates a front-end form for adding and editing Posts using a shortcode.
 *
 * @package		toongeeprime-frontend-post-form
 * @link		https://github.com/toongeeprime/toongeeprime-frontend-post-form
 * @author		ToongeePrime <toongeeprime@gmail.com>
 * @copyright		2022
 * @license		GPL v2 or later
 *
 * Plugin Name:		ToongeePrime Frontend Post Form
 * Description:		Creates a front-end form for adding and editing Posts using a shortcode.
 * Version:		1.2
 * Plugin URI:		https://github.com/toongeeprime/toongeeprime-frontend-post-form
 * Author:		ToongeePrime
 * Author URI:		https://github.com/toongeeprime/
 * Text Domain:		toongeeprime-frontend-post-form
 * Domain Path:		/languages/
 * Requires PHP:	7.0
 * Requires at least:	5.5
 * Tested up to:	5.9
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */


/**
 *		DEFINE PLUGIN ROOT DIR CONSTANT
 */
define( 'PRIME_FE_POST_FORM', WP_PLUGIN_DIR . '/toongeeprime-frontend-post-form/' );



/**
 *		PLUGIN DATA
 */
function primefe_plugin_data() {
	return get_plugin_data( __FILE__ );
}


/**
 *	REQUIRE FILES
 *	Contains enqueues and links all plugin files 
 */
require_once PRIME_FE_POST_FORM . 'auto-file-loader.php';

