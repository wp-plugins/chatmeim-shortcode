<?php
/*
Plugin Name: ChatMe ShortCode
Plugin URI: http://www.chatme.im/
Description: This plugin add ChatMe Shortcode to Wordpress.
Version: 3.0.4
Author: camaran
Author URI: http://www.chatme.im
*/

if(!class_exists('ChatMe_mini_ShortCodes')) {

class ChatMe_mini_ShortCodes {

private $jappix_url 			= 'https://webchat.chatme.im';
private $chat_domains 			= "http://webchat.domains";
private $muc_url 				= 'http://conference.webchat.chatme.im';
private $conference_domain 		= '@conference.chatme.im';
private $room 					= '<option value="piazza@conference.chatme.im">Piazza</option>
									<option value="support@conference.chatme.im">Support</option>
									<option value="rosolina@conference.chatme.im">Rosolina</option>
									<option value="politica@conference.chatme.im">Politica</option>';
private $domains_status 		= "http://webchat.domains/status/";
private $status 				= "http://webchat.chatme.im/status/";
private $chat_powered 			= '<div><small>Chat powered by <a href="http://chatme.im" target="_blank">ChatMe</a></small></div>';
//Default Variables
//userStatus
private $userStatus_user      	= 'admin@chatme.im';
private $userStatus_hosted    	= false;
private $userStatus_link      	= false;
//chatRoom	
private $chatRoom_anon 			= true;
//chatRoomIframe
private $chatRoomIframe_room	= 'piazza';
private $chatRoomIframe_width	= '100%';
private $chatRoomIframe_height	= '100%';
private $chatRoomIframe_hosted 	= false;
private $chatRoomIframe_powered = true;

	function __construct() {
		self::register_shortcodes( $this->shortcodes_core() );
	}

	private function shortcodes_core() {
		$core = array(
			'userStatus'			=>	array( 'function' => 'userStatus_short' ),
			'chatRoom'			    =>	array( 'function' => 'chatRoom_short' ),
			'chatRoomIframe'		=>	array( 'function' => 'chatRoomIframe_short' ),
			'swatchTime'			=>	array( 'function' => 'swatchTime_short' ),
			);
		return $core;
	}

    //Stato utente [userStatus user="users" link="1"]
    function userStatus_short($atts)
	    {	
		    $defaults = array(
			    'user'      => $this->userStatus_user,
			    'hosted'    => $this->userStatus_hosted,
			    'link'      => $this->userStatus_link,
			    );
            $atts = shortcode_atts( $defaults, $atts );    
                
            $link = ((bool)$atts['link']) ? ' <a href="xmpp:'. $atts['user'] . '" title="Chatta con ' . $atts['user'] . '">' . $atts['user'] . '</a>' : '';
            
            if ((bool)$atts['hosted']) {
		        return  '<img src="' . $this->domains_status . $atts['user'] . '" alt="Status">' . $link;
            } else {
		        return '<img src="' . $this->status . $atts['user'] . '" alt="Status">' . $link;		
            }
	    }	
	
    //Chat Room [chatRoom anon="1"]	
    function chatRoom_short($atts)
	    {
		    $defaults = array(
			    'anon' => $this->chatRoom_anon,
			    );
            $atts = shortcode_atts( $defaults, $atts );    
                
		    if (!(bool)$atts['anon'])  {	
                
		    return '<form method="get" action="' . $this->muc_url . '" target="_blank" class="form-horizontal">
            	    <select name="room">
					    ' . $this->room . '
				    </select>
                <button type="submit">Entra nella stanza</button>
            </form> ';
		    } else {
                
		    return '<form method="get" action="' . $this->jappix_url . '" target="_blank">
            	    <select name="r">
					    ' . $this->room . '
				    </select>
    			    <input type="text" name="n" placeholder="Nickname" autocomplete="off">
        	    <button type="submit">Entra nella stanza</button>
            </form> ';
		    }
	    }

    //Iframe Chat Room [chatRoomIframe room="room" width="width" height="height"]
    function chatRoomIframe_short($atts)
	    {	
		    $defaults = array(
			    'room' 		=> $this->chatRoomIframe_room,
			    'width' 	=> $this->chatRoomIframe_width,
			    'height' 	=> $this->chatRoomIframe_height,
			    'hosted' 	=> $this->chatRoomIframe_hosted,
				'powered' 	=> $this->chatRoomIframe_powered,
			    );
                $atts = shortcode_atts( $defaults, $atts );
                
				$chat_url = ((bool)$atts['hosted']) ? $this->chat_domains : $this->jappix_url;
				$powered = ((bool)$atts['powered']) ? $this->chat_powered : '';
				
				return '<div class="cm-iframe-room"><iframe src="' . $chat_url . '/?r='. $atts['room'] . $this->conference_domain . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" border="0">Il tuo browser non supporta iframe</iframe>' . $powered . '</div>';		
	    }

    //Internet Swatch Time [swatchTime]
    function swatchTime_short()
	    {	
		return "Internet Swatch Time <strong>@" . date('B') . "</strong>";
	    }

    //Registro tutti gli shortcode della classe
	    private function register_shortcodes( $shortcodes ) {
		    foreach ( $shortcodes as $shortcode => $data ) {
			    add_shortcode( $shortcode, array( $this, $data['function']) );
		    }
	    }

}
}
new ChatMe_mini_ShortCodes;			
?>