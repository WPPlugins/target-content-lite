<?php
/*
Plugin Name: Target Content Lite
Plugin URI: http://www.simongoodchild.com
Description: Target content to users based on conditions that you can set. Like logged in or out, their name, role, referred from a URL, check URL parameters, days since registration, consecutive days, days since last visit. And show content if the condition isn't met. Totally personalise your visitor's and user's experience - it will engage them, convert them and make them feel a valued visitor or member of your site.
Version: 1.0
Author: Simon Goodchild
License: GPLv2 or later
*/

if ( !defined('TCTD') ) define('TCTD', 'target-content');
if ( !defined('TCCOOKIE') ) define('TCCOOKIE', 'tc_cookie');    
if ( !defined('TCCOOKIESESSION') ) define('TCCOOKIESESSION', 'tc_cookie_session');    
if ( !defined('TCSHOWCOOKIE') ) define('TCSHOWCOOKIE', false);
if ( !defined('LOGEVERYLOAD') ) define('LOGEVERYLOAD', false);
if ( !defined('FORCELOG') ) {
	if (isset($_GET['tc_force'])) {
		define('FORCELOG', true);
	} else {
		define('FORCELOG', false);
	}
}
if ( !defined('EXPIRY') ) define('EXPIRY', 365);
if ( !defined('MAXNUMCOOKIEDATES') ) define('MAXNUMCOOKIEDATES', 365); // max 1 year, and within cookie max length

// Delete cookie?
if (isset($_GET['tc_delete'])) {
    unset( $_COOKIE[TCCOOKIE] );
    setcookie( TCCOOKIE, '', time() - ( 15 * 60 ) );
    unset( $_COOKIE[TCCOOKIESESSION] );
    setcookie( TCCOOKIESESSION, '', time() - ( 15 * 60 ) );
    echo '<div style="margin:30px;" class="tc_notice">'.__('TC cookies deleted.', TCTD).'</div>';
} else {
    if (!is_admin()) {
        add_action('init', 'tc_register_my_session'); // register new session
        add_action( 'wp_enqueue_scripts', 'tc_adding_scripts' ); // load the JS and CSS file
    }
}

// load JS and CSS
function tc_adding_scripts() {

    wp_enqueue_script('tc-js', plugins_url('target-content.js', __FILE__), array('jquery'));    
    wp_localize_script( 'tc-js', 'tc_ajax', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'TCCOOKIE' => TCCOOKIE,
        'TCCOOKIESESSION' => TCCOOKIESESSION,
        'TCSHOWCOOKIE' => TCSHOWCOOKIE,
        'LOGEVERYLOAD' => LOGEVERYLOAD,
        'EXPIRY' => EXPIRY,
        'MAXNUMCOOKIEDATES' => MAXNUMCOOKIEDATES,
        'FORCELOG' => FORCELOG		
    ));     
    wp_enqueue_script('tc-js');
    wp_enqueue_style('tc-css', plugins_url('styles.css', __FILE__), 'css');
}


// Start a new session when first loaded
function tc_register_my_session()
{
    // Check if session has started...
    if ( TCSHOWCOOKIE ) {

        if ( tc_getcookie(TCCOOKIESESSION) ) {
                
            echo '<div style="margin:30px;" class="tc_notice">Cookie marking this session exists: '.tc_getcookie(TCCOOKIESESSION).'</div>';

        } else {

            echo '<div style="margin:30px;" class="tc_notice">No session cookie there :(</div>';

        }

    }

}


// Set the cookie and encode it
function tc_setcookie($cookie, $value, $life) {
    // ... $life is in days
    
    setcookie($cookie, $value, ($life * 24 * 60 * 60), '/');
        
}

// Get the cookie and decode it
function tc_getcookie($cookie) {
    
    if (isset($_COOKIE[$cookie])) {
        return $_COOKIE[$cookie];
    } else {
        return false;
    }
        
}

/* ************************ SHORTCODES - LITE ************************ */

// Has Role
add_shortcode('tc-has-role', 'tc_has_role');
function tc_has_role($atts, $content) {

	global $current_user;

	// Shortcode parameters
   	extract( shortcode_atts( array(
		'role' => 'subscriber',
		'else' => ''
	), $atts, 'tc_has_role' ) );

	$role = strtolower($role);
	$roles = explode(',', $role);
    $html = '';

	$show = false;
	foreach ($roles as $role) {
		if ( user_can( $current_user, $role ) || (is_user_logged_in() && $role == 'any') ) { $show = true; }
	}

	if ( $show ) {
		$html = $content;
	} else {
		if ($else) $html = $else;
	}

    if ($html) {
	   $html = do_shortcode($html);
	   return '<div class="tc tc-has-role">'.$html.'</div>';
    } else {
        return '';
    }

}

// Is Logged In
add_shortcode('tc-logged-in', 'tc_logged_in');
function tc_logged_in($atts, $content) {

	global $current_user;

	// Shortcode parameters
   	extract( shortcode_atts( array(
		'else' => ''
	), $atts, 'tc_logged_in' ) );

    $html = '';
	if ( is_user_logged_in() ) {
		$html = $content;
	} else {
		if ($else) $html = $else;
	}

    if ($html) {
        $html = do_shortcode($html);
        return '<div class="tc tc-logged-in">'.$html.'</div>';	
    } else {
        return '';
    }
}

// Is Not Logged In
add_shortcode('tc-logged-out', 'tc_logged_out');
function tc_logged_out($atts, $content) {

	global $current_user;

	// Shortcode parameters
   	extract( shortcode_atts( array(
		'else' => ''
	), $atts, 'tc_logged_out' ) );

	if ( !is_user_logged_in() ) {
		$html = $content;
	} else {
		$html = $else;
	}

    if ($html) {
        $html = do_shortcode($html);
        return '<div class="tc tc-logged-out">'.$html.'</div>';	
    } else {
        return '';
    }
    
}

// Show date and time when current session started
add_shortcode('tc-datetime', 'tc_datetime');
function tc_datetime($atts) {
        
    $html = '<span class="tc tc-datetime"></span>';
    
    return $html;

}

// Display Role(s)
add_shortcode('tc-show-role', 'tc_show_role');
function tc_show_role($atts) {
    
	// Shortcode parameters
   	extract( shortcode_atts( array(
        'else' => false,
	), $atts, 'tc_show_role' ) );     
    
    $html = '';
    
    if ( is_user_logged_in() ) {
        global $current_user;
        $user_info = get_userdata($current_user->ID);
        $html = implode(', ', $user_info->roles);
    } else {
        if ($else) {
            $html = $else;
        }        
    }
    
    if ($html) {
        $html = do_shortcode($html);
        return '<span class="tc tc-show-role">'.$html.'</span>';	
    } else {
        return '';
    }
    
}

// Display Name(s)
add_shortcode('tc-show-name', 'tc_show_name');
function tc_show_name($atts) {
    
	// Shortcode parameters
   	extract( shortcode_atts( array(
        'else' => false,
		'show' => 'display_name',
	), $atts, 'tc_show_name' ) );    
    
    $html = '';
    
    if ( is_user_logged_in() ) {
        global $current_user;
        
        $choices = explode(',', $show);
        $shown = false;
        foreach ($choices as $choice) {
            
            switch ($choice) {
                case "display_name":
                    if ($current_user->display_name) {
                        $html .= ucwords($current_user->display_name);
                        $shown = true;
                    }
                    break;
                case "first_name":
                    if ($current_user->first_name) {
                        $html .= ucwords($current_user->first_name);
                        $shown = true;
                    }
                    break;
                case "last_name":
                    if ($current_user->last_name) {
                        $html .= ucwords($current_user->last_name);
                        $shown = true;
                    }
                    break;
                default:
                    if ($current_user->user_login) {                    
                        $html .= $current_user->user_login;
                        $shown = true;
                    }
            }
            
            if ($shown) break;
            
        }
        
    } else {
        if ($else) {
            $html = $else;
        }
    }
    
    if ($html) {
        $html = do_shortcode($html);
        return '<span class="tc tc-show-name">'.$html.'</span>';	
    } else {
        return '';
    }
    
}


/* ***************************** ADMIN ***************************** */

require_once('target-content-admin.php');


add_action('wp_head', 'tc_hook_css');
add_action('admin_head', 'tc_hook_css');
function tc_hook_css() {
    ?><style>
            .tc_notice {
                background-color : #f1f1f1;
				border-left: 9px solid red;
				padding: 6px 6px 6px 12px;
            }
			.tc_pre {
				font-size: 14px;
			}
	</style><?php
}



?>