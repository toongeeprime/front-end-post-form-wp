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



// Dismiss form notification
let pr2gNotif	=	document.getElementById( 'prime2g_pstatus_notice' );

pr2gNotif.addEventListener( 'click', ()=>{
	pr2gNotif.classList.add( 'dismiss' );
} );
