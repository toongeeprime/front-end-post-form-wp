/**
 *	MEDIA LIBRARY JS
 */

( function($) {

// SET COVER PHOTO
$(document).ready( function() {

	let file_frame;
	$( '.prime2g_uploader' ).on( 'click', function( event ) {
		event.preventDefault();

		// if the file_frame has already been created, use it
		if ( file_frame ) {
			file_frame.open();
			return;
		}

		file_frame = wp.media.frames.file_frame = wp.media({
			title: 'Select an Image', // $( this ).data( 'uploader_title' ),
			library :{
			// uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
			type : 'image'
			},
			button: {
				text: 'Set Image' // $( this ).data( 'uploader_button_text' ),
			},
			multiple: 0
		});

		file_frame.on( 'select', function() {
			attachment = file_frame.state().get('selection').first().toJSON();
				$( '#fmrFTimg' ).hide();
				$( '.prime_rmv_button' ).show();
				$( '#thumb_img' ).attr( 'src', attachment.url );
				$( '#post_thumbnail_id' ).attr( 'value', attachment.id );
		});

		file_frame.open();

	});

	$( '.prime_rmv_button' ).on( 'click', function( event ) {
		event.preventDefault();
			$( '.prime_rmv_button' ).hide();
			$( '#fmrFTimg' ).show();
			$( '#thumb_img' ).removeAttr('src');
			$( '#post_thumbnail_id' ).removeAttr('value');
	});

});

} )(jQuery);

