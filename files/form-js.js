/**
 *	FORM SCRIPTS
 */

function akw_pubBtnTxt() {

let akselbx	=	document.getElementById( "the_status" ),
	aksbmt	=	document.getElementById( "submit" );

	akselbx.setAttribute( 'onchange', 'akw_pubBtnTxt();' );

	if ( akselbx.value == 'publish' ) {
		aksbmt.value = "Update";
	}
	else {
		aksbmt.value = "Save Draft";
	}

}
akw_pubBtnTxt();
