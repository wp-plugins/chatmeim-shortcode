<?php
/*
Plugin Name: ChatMe ShortCode
Plugin URI: http://www.chatme.im/
Description: This plugin add ChatMe Shortcode to Wordpress.
Version: 3.1.1
Author: camaran
Author URI: http://www.chatme.im
*/

add_action('admin_menu', 'chatme_shortcode_menu' );
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_messenger_links' );

	function add_action_messenger_links ( $links ) {
      	$mylinks = array( '<a href="' . admin_url( 'options-general.php?page=chatme-shortcode' ) . '">Help Page</a>', );
      	return array_merge( $links, $mylinks );
    }

	function chatme_shortcode_menu() {
  		$my_admin_page = add_options_page('ChatMe Shortocode Help', 'ChatMe Shortcode Help', 'manage_options', 'chatme-shortcode', 'mini_shortcode_help' );
	}

function mini_shortcode_help() {
  		if (!current_user_can('manage_options'))  {
    	wp_die( __('You do not have sufficient permissions to access this page.', 'chatmeim-mini-messenger') );
  		} 
	?>
 	<div class="wrap">
	<h2>ChatMe Shortocode Help</h2>
	<p><b>[userStatus user="users" link=1 hosted=0]</b><br/>This code show user status (online/offline/etc):<ul><li><b>user</b>: insert the user with the domain (example: user@chatme.im)</li><li><b>link</b> (boolean): can be 0 (default) for not link and 1 for link to the user</li><li><b>hosted</b> (boolean): can be 0 (default) for not hosted domain and 1 if you have a custom domain hosted in ChatMe XMPP server</li></ul></p> 
	<p><b>[chatRoom anon=1]</b><br/>This code show a list of default chat room.<ul><li><b>anon</b> (boolean): can be 0 for not anonymous login (require username and password) or 1 (default) for chat only with nickname.</li></ul></p> 
	<p><b>[chatRoomIframe room="room" width="width" height="height" hosted=0]</b><br/>This shortcode show a chat room in your wordpress page:<ul><li><b>room</b>: the name of the chat room (default: piazza@conference.chatme.im)</li><li><b>width</b>: the frame width (default: 100%)</li><li><b>height</b>: the height of frame (default: 100%)</li><li><b>hosted</b> (boolean): can be 0 (default) for not hosted domain and 1 if you have a custom domain hosted in ChatMe XMPP server</li></ul></p> 
	<p><b>[swatchTime]</b><br/>This shortcode show Internet Swatch Time.</p> 
	<p>For more information visit our <a href="http://chatme.im/forums" target="_blank">forum</a></p> 

	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="8CTUY8YDK5SEL">
		<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
		<img alt="" border="0" src="https://www.paypalobjects.com/it_IT/i/scr/pixel.gif" width="1" height="1">
	</form>

	<a href="https://twitter.com/share" class="twitter-share-button" data-url="http://chatme.im" data-text="Visita chatme.im" data-via="chatmeim" data-lang="it">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

	</div>
<?php 
	}

require_once( 'class.shortcode.php' );
?>