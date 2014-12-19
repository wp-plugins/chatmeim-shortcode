<?php
/*
Plugin Name: ChatMe ShortCode
Plugin URI: http://www.chatme.im/
Description: This plugin add ChatMe Shortcode to Wordpress.
Version: 3.0.1
Author: camaran
Author URI: http://www.chatme.im
*/

if(!class_exists('ChatMe_mini_ShortCodes')) {

class ChatMe_mini_ShortCodes {

private $jappix_url = 'https://webchat.chatme.im';
private $chat_domains = "http://webchat.domains";
private $muc_url = 'http://muc.chatme.im';
private $conference_domain = '@conference.chatme.im';
private $room = '<option value="piazza@conference.chatme.im">Piazza</option>
					<option value="support@conference.chatme.im">Support</option>
					<option value="rosolina@conference.chatme.im">Rosolina</option>
					<option value="politica@conference.chatme.im">Politica</option>';
private $domains_status = "http://webchat.domains/status/";
private $status = "http://webchat.chatme.im/status/";

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
			    'user'      => 'admin@chatme.im',
			    'hosted'    => false,
			    'link'      => false,
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
			    'anon' => true,
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

    //Stato utente [chatRoomIframe room="room" width="width" height="height"]
    function chatRoomIframe_short($atts)
	    {	
		    $defaults = array(
			    'room' => 'piazza',
			    'width' => '100%',
			    'height' => '100%',
			    'hosted' => false,
			    );
                $atts = shortcode_atts( $defaults, $atts );
                
				$chat_url = ((bool)$atts['hosted']) ? $this->chat_domains : $chat_url = $this->jappix_url;
				return '<div class="cm-iframe-room"><iframe src="' . $chat_url . '/?r='. $atts['room'] . $this->conference_domain . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" border="0">Il tuo browser non supporta iframe</iframe></div>';		
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