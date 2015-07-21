<?php
namespace ChatMe;

class mini_ShortCodes {

private $default = array(
			'jappix_url' 		        => 'https://webchat.chatme.im',
			'chat_domains' 		        => 'https://webchat.domains',
			'muc_url' 		            => 'https://conference.chatme.im',
			'conference_domain' 	    => '@conference.chatme.im',	
			'room' 					    => '<option value="piazza@conference.chatme.im">Piazza</option>
									        <option value="support@conference.chatme.im">Support</option>
									        <option value="rosolina@conference.chatme.im">Rosolina</option>
									        <option value="politica@conference.chatme.im">Politica</option>',
    		'domains_status'     	    => "http://webchat.domains/status/",
    		'status' 				    => "http://webchat.chatme.im/status/",
    		'chat_powered' 			    => '<div><small>Chat powered by <a href="http://chatme.im" target="_blank">ChatMe</a></small></div>',  
            //Default Variables
            //userStatus
        	'userStatus_user'           => 'admin@chatme.im',
        	'userStatus_hosted'    	    => false,
        	'userStatus_link'      	    => false,   
            //chatRoom    
            'chatRoom_anon' 		    => true,
            //chatRoomIframe
            'chatRoomIframe_room'       => 'piazza',
            'chatRoomIframe_width'	    => '100%',
            'chatRoomIframe_height'     => '100%',
            'chatRoomIframe_hosted' 	=> false,
            'chatRoomIframe_powered'    => true,
            
			);

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
			    'user'      => $this->default['userStatus_user'],
			    'hosted'    => $this->default['userStatus_hosted'],
			    'link'      => $this->default['userStatus_link'],
			    );
            $atts = shortcode_atts( $defaults, $atts );    
                
            $link = ((bool)$atts['link']) ? ' <a href="xmpp:'. $atts['user'] . '" title="Chatta con ' . $atts['user'] . '">' . $atts['user'] . '</a>' : '';
            
            if ((bool)$atts['hosted']) {
		        return  '<img src="' . $this->default['domains_status'] . $atts['user'] . '" alt="Status">' . $link;
            } else {
		        return '<img src="' . $this->default['status'] . $atts['user'] . '" alt="Status">' . $link;		
            }
	    }	
	
    //Chat Room [chatRoom anon="1"]	
    function chatRoom_short($atts)
	    {
		    $defaults = array(
			    'anon' => $this->default['chatRoom_anon'],
			    );
            $atts = shortcode_atts( $defaults, $atts );    
                
		    if (!(bool)$atts['anon'])  {	
                
		    return '<form method="get" action="' . $this->default['muc_url'] . '" target="_blank" class="form-horizontal">
            	    <select name="room">
					    ' . $this->default['room'] . '
				    </select>
                <button type="submit">Entra nella stanza</button>
            </form> ';
		    } else {
                
		    return '<form method="get" action="' . $this->default['jappix_url'] . '" target="_blank">
            	    <select name="r">
					    ' . $this->default['room'] . '
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
			    'room' 		=> $this->default['chatRoomIframe_room'],
			    'width' 	=> $this->default['chatRoomIframe_width'],
			    'height' 	=> $this->default['chatRoomIframe_height'],
			    'hosted' 	=> $this->default['chatRoomIframe_hosted'],
				'powered' 	=> $this->default['chatRoomIframe_powered'],
			    );
                $atts = shortcode_atts( $defaults, $atts );
                
				$chat_url = ((bool)$atts['hosted']) ? $this->default['chat_domains'] : $this->default['jappix_url'];
				$powered = ((bool)$atts['powered']) ? $this->default['chat_powered'] : '';
				
				return '<div class="cm-iframe-room"><iframe src="' . $chat_url . '/?r='. $atts['room'] . $this->default['conference_domain'] . '" width="' . $atts['width'] . '" height="' . $atts['height'] . '" border="0">Il tuo browser non supporta iframe</iframe>' . $powered . '</div>';		
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
new \ChatMe\mini_ShortCodes;			
?>