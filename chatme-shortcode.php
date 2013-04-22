<?php
/*
Plugin Name: Chatme.im ShortCode
Plugin URI: http://www.chatme.im/
Description: This plugin add ChatMe Shortcode to Wordpress.
Version: 1.0.6
Author: camaran
Author URI: http://www.chatme.im
*/

/*  Copyright 2013  Thomas Camaran  (email : camaran@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$GLOBALS['jappix_url'] = 'https://webchat.chatme.im';
$GLOBALS['muc_url'] = 'https://muc.chatme.im';
$GLOBALS['domain'] = '@chatme.im';
$GLOBALS['conference_domain'] = '@conference.chatme.im';
$GLOBALS['room'] = '<option value="piazza' . $GLOBALS['conference_domain'] . '">Piazza</option>
					<option value="support' . $GLOBALS['conference_domain'] . '">Support</option>
					<option value="rosolina' . $GLOBALS['conference_domain'] . '">Rosolina</option>
					<option value="diceluidicelei' . $GLOBALS['conference_domain'] . '">Dice Lui Dice Lei</option>
                    <option value="scuola' . $GLOBALS['conference_domain'] . '">Basket</option>
					<option value="politica' . $GLOBALS['conference_domain'] . '">Politica</option>';
//Stato utente [userStatus user="users" helga="1" link="1"]
function userStatus_short($atts)
	{	
		extract(shortcode_atts(array(
			'user' => '',
			'helga' => '0',
			'link' => '',
			), $atts));
		if ($link == "1") 
			$link = ' <a href="xmpp:'. $user . $GLOBALS['domain'] . '" title="Chatta con ' . $user . $GLOBALS['domain'] . '">' . $user . $GLOBALS['domain'] . '</a>';
		if ($helga == "1") {
			return  '<img src="http://chatme.im/plugins/helga/user?jid=' . $user . $GLOBALS['domain'] . '" border="0" alt="Status">' . $link;
		} else {
			return '<img src="http://chatme.im/plugins/presence/status?jid=' . $user . $GLOBALS['domain'] . '" border="0" alt="Status">' . $link;		
		}
	}		
//Chat Room [chatRoom anon="1"]	
function chatRoom_short($atts)
	{
		extract(shortcode_atts(array(
			'anon' => '1',
			), $atts));
		if ($anon == "0")  {	
		return '<form method="get" action="' . $GLOBALS['muc_url'] . '" target="_blank" class="form-horizontal">
            	<select name="room">
					' . $GLOBALS['room'] . '
				</select>
            <button type="submit">Entra nella stanza</button>
        </form> ';
		} else {
		return '<form method="get" action="' . $GLOBALS['jappix_url'] . '" target="_blank">
            	<select name="r">
					' . $GLOBALS['room'] . '
				</select>
    			<input type="text" name="n" placeholder="Nickname" autocomplete="off">
        	<button type="submit">Entra nella stanza</button>
        </form> ';
		}
	}
//Stato utente [chatRoomIframe room="room" width="width" height="height"]
function chatRoomIframe_short()
	{	
		extract(shortcode_atts(array(
			'room' => 'piazza',
			'width' => '100%',
			'height' => '100%',
			), $atts));
				return '<div class="cm-iframe-room"><iframe src="' . $GLOBALS['jappix_url'] . '/?r='. $room . $GLOBALS['conference_domain'] . '" width="' . $width . '" height="' . $height . '" border="0">Il tuo browser non supporta iframe</iframe></div>';		
	}		
add_shortcode( 'userStatus', 'userStatus_short' );	
add_shortcode( 'chatRoom', 'chatRoom_short' );
add_shortcode( 'chatRoomIframe', 'chatRoomIframe_short' );
?>