<?php
// Add to Menu
add_action('admin_menu', 'tc_menu', 9); // Located in wps_admin.php
function tc_menu() {
	$menu_label = 'Target Content';
	add_menu_page($menu_label, $menu_label, 'manage_options', 'tc_setup', 'tc_setup', 'dashicons-feedback'); 
}

function tc_setup() {

  	echo '<style>.wrap { margin-top: 20px !important; margin-left: 10px !important; }</style>';
  	echo '<div class="wrap">';
	
		echo '<h1>'.__('Target Content', TCTD).'</h1>';

		echo '<h2>'.__('Logged In Or Not', TCTD).'</h2>';

		echo '<p><strong>'.__('Logged Out (Not Logged In)', TCTD).'</strong></p>';
		echo '<pre class="tc_pre">[tc-logged-out]'.__('THIS IS ONLY SHOWN TO VISITORS (NOT LOGGED IN)', TCTD).'[/tc-logged-out]</pre>';
		echo '<pre class="tc_pre">[tc-logged-out else="OTHERWISE SHOW THIS"]'.__('THIS IS ONLY SHOWN TO VISITORS (NOT LOGGED IN)', TCTD).'[/tc-logged-out]</pre>';

		echo '<p><strong>'.__('Logged In', TCTD).'</strong></p>';
		echo '<pre class="tc_pre">[tc-logged-in else="OTHERWISE SHOW THIS"]'.__('THIS IS ONLY SHOWN TO USERS (LOGGED IN)', TCTD).'[/tc-logged-in]</pre>';

		echo '<h2>'.__('Role Based', TCTD).'</h2>';

		echo '<p>'.__('If in a role (can be used with membership plugins, like s2members or WooCommerce)', TCTD).'</p>';
		echo '<pre class="tc_pre">[tc-has-role roles="subscriber,editor" else="OTHERWISE SHOW THIS"]'.__('ONLY FOR THESE ROLES', TCTD).'[/tc-has-role]</pre>';
		echo '<em>'.__('You can do for any WordPress role too.', TCTD).'</em><pre class="tc_pre">[tc-has-role roles="any" else="OTHERWISE SHOW THIS"]'.__('SHOW FOR ANY WORDPRESS ROLES', TCTD).'[/tc-has-role]</pre>';

		echo '<h2>'.__('Membership', TCTD).'</h2>';

		echo '<p>'.__('Used for membership details.', TCTD).'</p>';
		echo '<em>'.__('Display content if been a member of the website for a period of time, defaults to up to 2 days (between="0,2").', TCTD).'</em><pre class="tc_pre">[tc-member between="0,15" else="Thanks for joining recently!"]'.__('You\'ve been a member for a while, awesome!', TCTD).'[/tc-member]</pre>';
        echo '<em>'.__('Just show the number of days they\'ve been a member for (note how the shortcode ends).', TCTD).'</em><pre class="tc_pre">[tc-member show="count" /]</pre>';

        echo '<h2>'.__('Personalise For Member', TCTD).'</h2>';
        echo '<p>'.__('These will not display anything if the user is not logged - unless you include the "else" option.', TCTD).'</p>';
		
		echo '<p><strong>'.__('Display Their Name', TCTD).'</strong></p>';
		echo '<em>'.__('Shows WordPress first name, display name or user login - whichever exists first', TCTD).'</em><pre class="tc_pre">[tc-show-name show="first_name,display_name,user_login"]</pre>';
		echo '<em>'.__('Shows WordPress display name (default)', TCTD).'</em><pre class="tc_pre">[tc-show-name]</pre>';
		echo '<em>'.__('Shows WordPress username (login)', TCTD).'</em><pre class="tc_pre">[tc-show-name show="user_login"]</pre>';
		echo '<em>'.__('Shows WordPress first name', TCTD).'</em><pre class="tc_pre">[tc-show-name show="first_name"]</pre>';
		echo '<em>'.__('Shows WordPress last name', TCTD).'</em><pre class="tc_pre">[tc-show-name show="last_name"]</pre>';
		echo '<em>'.__('Shows WordPress display name or something else if not logged in', TCTD).'</em><pre class="tc_pre">[tc-show-name show="first_name" else="Sir/Madam"]</pre>';
        
		echo '<p><strong>'.__('Display Their Role(s)', TCTD).'</strong></p>';
        echo '<p>'.__('These will not display anything if the user is not logged - unless you include the "else" option.', TCTD).'</p>';
		echo '<em>'.__('Shows the WordPress role(s) the member belongs to.', TCTD).'</em><pre class="tc_pre">[tc-show-role]</pre>';
		echo '<em>'.__('Shows the WordPress role(s) the member belongs to, or somethig else if not logged in.', TCTD).'</em><pre class="tc_pre">[tc-show-role else="Visitor"]</pre>';

		echo '<p><strong>'.__('Display Their Visit Information', TCTD).'</strong></p>';
		echo '<em>'.__('When the current visit started.', TCTD).'</em><pre class="tc_pre">[tc-datetime]</pre>';
	
		echo '<h1>'.__('The following are available with <a href="http://www.wptargetcontent.com">WP Target Content</a>', TCTD).'</h1>';
		echo '<p><span style="padding:6px;background-color:yellow">'.__('To say thank you for trying this plugin, get an immediate discount of 10%, use coupon code ', TCTD).'<span style="font-weight:bold;font-family:courier;">10percent</span></span></p>';
	
        echo '<h2>'.__('Based On Visits To Your Website Whether Logged In Or Just Visiting', TCTD).'</h2>';

        echo '<p><strong>'.__('Display List Of Visits To Your Website', TCTD).'</strong></p>';
        echo '<em>'.__('Show last 5 visits date and time (defaults to 10), excluding summer time variations', TCTD).'</em><pre class="tc_pre">[tc-visits count="5"]</pre>';
        echo '<em>'.__('Show how many visits have been logged', TCTD).'</em><pre class="tc_pre">[tc-visits show="count"]</pre>';

        echo '<p><strong>'.__('On First Visit To Website', TCTD).'</strong></p>';
        echo '<p>'.__('Content only shown first time on your site, just their first ever visit (in the last year).', TCTD).'</p>';
        echo '<pre class="tc_pre">[tc-first-visit]'.__('WELCOME TO THIS SITE', TCTD).'[/tc-first-visit]</pre>';
        echo '<pre class="tc_pre">[tc-first-visit else="NICE TO SEE YOU AGAIN!"]'.__('WELCOME TO THIS SITE', TCTD).'[/tc-first-visit]</pre>';

        echo '<p><strong>'.__('If Visited A Number Of Times', TCTD).'</strong></p>';
        echo '<p>'.__('Content only shown if they have visited between x and y times.', TCTD).'</p>';
		echo '<pre class="tc_pre">[tc-history between="1,5"]'.__('YOU ARE NEW HERE', TCTD).'[/tc-history]</pre>';
		echo '<pre class="tc_pre">[tc-history between=",3" else="BEEN HERE BEFORE AT LEAST 4 TIMES"]'.__('YOU ARE NEW HERE', TCTD).'[/tc-history] <em>'.__('Missing the first value is same as 0', TCTD).'</em></pre>';
		echo '<pre class="tc_pre">[tc-history between="100,"]'.__('LOYAL VISITOR', TCTD).'[/tc-history] <em>'.__('Missing the second value is same as infinite', TCTD).'</em></pre>';
    
        echo '<p><strong>'.__('Number Of Consecutive Days', TCTD).'</strong></p>';
        echo '<p>'.__('Content only shown if they have visited every day, for x (or more) days. Defaults to 2 consecutive days. By default, "else" will not show if first visit (see below).', TCTD).'</p>';
		echo '<pre class="tc_pre">[tc-consecutive else="Sorry to miss you yesterday."]'.__('Two days in a row - woot!', TCTD).'[/tc-consecutive]</pre>';
		echo '<pre class="tc_pre">[tc-consecutive count="5"]'.__('Five days in a row? Have this &lt;a href="to-wherever"&gt;free download&lt;/a&gt; on us! Something else if you do Ten!', TCTD).'[/tc-consecutive]</pre>';
		echo '<pre class="tc_pre">[tc-consecutive count="10"]'.__('Ten days in a row! Wow! Have &lt;a href="to-wherever"&gt;this free download&lt;/a&gt;!', TCTD).'[/tc-consecutive]</pre>';
		echo '<em>'.__('Display the number of consecutive days (note how to close the shortcode!', TCTD).'</em><pre class="tc_pre">[tc-consecutive show="count" /]</pre>';

        echo '<h2>'.__('WooCommerce purchases', TCTD).'</h2>';
		
		echo '<p>'.__('If visitor has purchased (or not) one or more WooCommerce products.', TCTD).'</p>';
		echo '<em>'.__('Show content if one or more products have been purchased.', TCTD).'</em><pre class="tc_pre">[tc-has-bought products="123,456" else="You should be this!"]'.__('You bought this - you would love this too!', TCTD).'[/tc-has-bought]</pre>';

        echo '<h2>'.__('Referrer', TCTD).'</h2>';
		
		echo '<p><strong>'.__('From a website', TCTD).'</strong></p>';
		echo '<p>'.__('If visitor has come from a website of a certain domain(s)', TCTD).'</p>';
		echo '<pre class="tc_pre">[tc-referrer-domain domain="www.example.com,www.simongoodchild.com"]'.__('WELCOME FROM THERE', TCTD).'[/tc-referrer-domain]</pre>';
		echo '<pre class="tc_pre">[tc-referrer-domain domain="www.example.com" else="NOT FROM THERE"]'.__('WELCOME FROM THERE', TCTD).'[/tc-referrer-domain]</pre>';
		
		echo '<p><strong>'.__('Referred with URL parameters', TCTD).'</strong></p>';
		echo '<p>'.__('If visitor has come from a website with a parameter(s) in the URL', TCTD).'</p>';
		echo '<pre class="tc_pre">[tc-referrer-parameter parameter="test1" parameter_value="1" else="OR SHOW THIS"]'.__('SHOW BECAUSE HAS PARAMETER test1=1', TCTD).'[/tc-referrer-parameter]</pre>';
		echo '<pre class="tc_pre">[tc-referrer-parameter parameter="test1,test2" parameter_value="1,2"]'.__('SHOW BECAUSE HAS PARAMETER test1=1 OR test2=2', TCTD).'[/tc-referrer-parameter]</pre>';
		
    
	echo '</div>';

}

?>