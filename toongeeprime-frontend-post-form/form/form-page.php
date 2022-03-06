<?php defined( 'ABSPATH' ) || exit;

/**
 *	OF THE FORM PAGE
 */

function toongeePrime_formPage( $getdata = 'ID', $statuses = array( 'publish', 'draft', 'pending' ) ) {


		/**
		 *	Get the form Page Object
		 */
		$args = array(
			'post_type'		=>	'page',
			'post_status'	=>	$statuses,
			'meta_key'		=>	'prime_has_feForm_post_shortcode',
			'meta_value'	=>	'true'
		);
		$pages	=	new WP_Query( $args );


		/**
		 *	Get number of pages
		 */
		if ( $getdata == 'count' ) {

			return $pages->found_posts;

		}


		/**
		 *	Get Page Data
		 */
		if ( $pages->have_posts() ) {

			$page	=	$pages->the_post();

			$data	=	get_post( $page, 'ARRAY_A' )[ $getdata ];

			wp_reset_postdata();

			return $data;

		}
		else {
			return false;
		}

}

