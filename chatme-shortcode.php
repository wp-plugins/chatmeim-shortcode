<?php
/*
Plugin Name: Chatme.im ShortCode
Plugin URI: http://www.chatme.im/
Description: This plugin add ChatMe Shortcode to Wordpress.
Version: 1.0.1
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
//Stato utente [userStatus user="users" helga="1" link="1"]
function userStatus_short($atts)
	{	
		extract(shortcode_atts(array(
			'user' => '',
			'helga' => '0',
			'link' => '',
			), $atts));
		if ($link == "1") 
			$link = ' <a href="xmpp:'. $user .'@chatme.im" title="Chatta con ' . $user . '@chatme.im">' . $user . '@chatme.im</a>';
		if ($helga == "1") {
			return  '<img src="http://chatme.im/plugins/helga/user?jid=' . $user . '@chatme.im" border="0" alt="Status">' . $link;
		} else {
			return '<img src="http://chatme.im/plugins/presence/status?jid=' . $user . '@chatme.im" border="0" alt="Status">' . $link;		
		}
	}		
//Chat Room [chatRoom anon="1"]	
function chatRoom_short($atts)
	{
		extract(shortcode_atts(array(
			'anon' => '1',
			), $atts));
		if ($anon == "1")  {	
		return '<form method="get" action="https://muc.chatme.im" target="_blank" class="form-horizontal">
            	<select name="room">
					<option value="piazza@conference.chatme.im">Piazza</option>
					<option value="support@conference.chatme.im">Support</option>
					<option value="rosolina@conference.chatme.im">Rosolina</option>
					<option value="diceluidicelei@conference.chatme.im">Dice Lui Dice Lei</option>
                    <option value="scuola@conference.chatme.im">Basket</option>
				</select>
            <button type="submit">Entra nella stanza</button>
        </form> ';
		} else {
		return '<form method="get" action="https://webchat.chatme.im" target="_blank">
            	<select name="r">
					<option value="piazza@conference.chatme.im">Piazza</option>
					<option value="support@conference.chatme.im">Support</option>
					<option value="rosolina@conference.chatme.im">Rosolina</option>
					<option value="sesso@conference.chatme.im">Sesso (Richiede Password)</option>
					<option value="diceluidicelei@conference.chatme.im">Dice Lui Dice Lei</option>
                    <option value="scuola@conference.chatme.im">Basket</option>
				</select>
    			<input type="text" name="n" placeholder="Nickname" autocomplete="off">
        	<button type="submit">Entra nella stanza</button>
        </form> ';
		}
	}	
add_shortcode( 'userStatus', 'userStatus_short' );	
add_shortcode( 'chatRoom', 'chatRoom_short' );
?>