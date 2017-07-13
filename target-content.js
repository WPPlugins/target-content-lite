jQuery(document).ready(function() {
	
    var value = parseInt( (new Date).getTime()  / 1000 );
    var CURRENTSESSION = readCookie(tc_ajax.TCCOOKIESESSION);

    // Check if session has started...
    if ( !CURRENTSESSION || tc_ajax.FORCELOG || tc_ajax.LOGEVERYLOAD ) {

        // ... if not mark it as started
        createCookie(tc_ajax.TCCOOKIESESSION, value.toString(), 0);

        var cookie = readCookie(tc_ajax.TCCOOKIE);
        if (!cookie) {

            // Cookie doesn't exist, so create it
            createCookie(tc_ajax.TCCOOKIE, value, tc_ajax.EXPIRY * 86400);

        } else {

            // Cookie is there, add new session timestamp to the start of the list
            var old_cookie = readCookie(tc_ajax.TCCOOKIE);
            old_cookie = old_cookie.replace('%2C', ',');
			var cookies = new Array();
			cookies = old_cookie.toString().split(",");
            var cookie_length = cookies.length;
            if (cookie_length >= tc_ajax.MAXNUMCOOKIEDATES) {
                // need to drop oldest as hit limit
                removed = cookies.splice(cookie_length-1,1);
            }
            // now add new session to the start
            cookies.unshift(value.toString());
            // and convert to string, and replace cookie
            var new_cookie = cookies.join();
            createCookie(tc_ajax.TCCOOKIE, new_cookie, tc_ajax.EXPIRY * 86400);

        }

    }   

    // now loop through all shortcodes and show values (after above has updated cookies)

    /* [tc-datetime] */
	jQuery('.tc-datetime').each(function(i, obj) {
		var current = readCookie(tc_ajax.TCCOOKIESESSION);
	    var t = jQuery(this);
		if (current) {
	        jQuery(t).html(tc_formattedTime(current));
	    } else {
	    	jQuery(t).html('No session start :(');
	    }
	});    

});


// Cookies
function createCookie(name, value, days) {
    if (days) {
	    var date = new Date();
	    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
	    var expires = "; expires=" + date.toGMTString();
    }
    else var expires = "";               

document.cookie = name + "=" + value + expires + "; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
	    var c = ca[i];
	    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
	    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
	createCookie(name, "", -1);
}

// Date & Time functions

function tc_dayValue(current) {
    var date = new Date(current * 1000);
	var year = date.getYear();
	var month = date.getMonth();
	var day = date.getDate();		    
	return parseInt( year.toString() + month.toString() + day.toString() );
}

function tc_formattedTime(current) {
    var date = new Date(current * 1000);
	var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
	var year = date.getFullYear();
	var month = months[date.getMonth()];
	var day = date.getDate();		    
	var hours = date.getHours();
	var minutes = "00" + date.getMinutes().toString();
	var seconds = "00" + date.getSeconds().toString();
	var formattedTime = day + ' ' + month + ' ' + year + ' ' + hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
	return formattedTime;	
}

