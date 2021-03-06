<?php
/**
* Plugin Name: Fast Video and Image Display
* Plugin URI: https://wordpress.org/plugins/fast-video-and-image-display/
* Description: Cut seconds off your load time by deferring the loading of YouTube videos and images, which scale automatically for mobile devices.
* Version: 2.5.1
* Author: Sam Perrow
* Author URI: https://www.linkedin.com/in/sam-perrow
* License: GPL2
* last edited April 7, 2018
*
* Copyright 2018  Sam Perrow  (email : sam.perrow399@gmail.com)
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*    GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// prevent direct file access
if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

define( 'GKTVI_PLUGIN', __FILE__ );
define( 'GKTVI_PLUGIN_DIR', untrailingslashit( dirname( GKTVI_PLUGIN ) ) );

require_once is_admin() ? GKTVI_PLUGIN_DIR . '/class-gktvi-media-buttons.php' : GKTVI_PLUGIN_DIR . '/class-gktvi-create-shortcodes.php';


add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'gktvi_set_admin_links' );
function gktvi_set_admin_links( $links ) {
	$gktvi_links = array(
		'<a href="https://github.com/samperrow/fast-video-and-image-display">View on GitHub</a>',
		'<a href="https://www.paypal.me/samperrow">Donate</a>' );
	return array_merge( $links, $gktvi_links );
}


// load modal CSS and admin js
add_action('wp_enqueue_media', 'gkt_load_admin_stuff');
function gkt_load_admin_stuff() {
	wp_register_style( 'gkt_formTable_stylesheet', plugin_dir_url(__FILE__) . 'css/admin.css', null, '2.5.1' );
	wp_register_script( 'gkt_media_button', plugin_dir_url(__FILE__) . 'js/media-button.js', array('jquery'), '2.5.1', true);

	wp_enqueue_style( 'gkt_formTable_stylesheet');
	wp_enqueue_script('gkt_media_button');
}


// the two functions below can be switched on or off depending on user preferences. gktvi_load_cssJS_requests() loads the css/js as requests, gktvi_load_cssJS_inline() loads them minified inline.
// add_action('wp_enqueue_scripts', 'gktvi_load_cssJS_requests');
function gktvi_load_cssJS_requests() {
	wp_register_style( 'gktvi_styles', plugin_dir_url(__FILE__) . 'css/styles.css', null, '2.5.1' );
	wp_register_script( 'gktvi_js', plugin_dir_url(__FILE__) . 'js/execute-shortcodes.js', null, '2.5.1', false);

	wp_enqueue_style( 'gktvi_styles');
	wp_enqueue_script( 'gktvi_js' );
}	


add_action('wp_head', 'gktvi_load_cssJS_inline', 10, 0);
function gktvi_load_cssJS_inline() { ?>
	<style type='text/css'>div.gktviDiv{position:relative}div.gktviDiv img{width:100%;height:100%;max-height:100%;margin:0}iframe.gktviIframe{width:100%;height:100%;margin:0 auto}div.gktviDiv>img:hover,svg.yt-svg:hover{cursor:pointer}path.outer-button{fill:#1f1f1e;fill-opacity:.81}path.outer-button:hover{cursor:pointer;fill:red;fill-opacity:1}svg.yt-svg{position:absolute;display:block;font:13.33px Arial;z-index:1000;background-color:inherit;border:0;width:15%;height:15%;left:42.5%;right:42.5%;top:42.5%;bottom:42.5%}@media only screen and (max-width:1180px){div.gktviDiv.mobile{width:inherit;max-width:80%!important;height:auto!important;max-height:inherit;margin:0 auto}div.gktviDiv.mobile>img{width:100%;height:auto!important;display:block;margin:0 auto}div.gktviDiv.mobile>iframe{display:block;height:inherit}img.gktviImage.mobile{width:80%!important;height:auto!important;display:block;margin:0 auto}}</style>
	<script type='text/javascript'>function gktviCreateElement(e,t,i,n,d,l,r,a){var o=document.createElement(e);return o.id=e+"_"+t,o.src=i,o.className=n,o.style.width=d+"px",o.style.height=l+"px",r&&(o.alt=r),a&&(o.title=a),o}function gktviChangeSVG(e,t,i){e.style.fill=t,e.style.fillOpacity=i}function gktviTriggerEvent(e,t,i,n){window.addEventListener?e.addEventListener(t,n):e.attachEvent(i,n)}function gktviTriggerVideos(e,t,i,n,d,l){gktviTriggerEvent(document,"DOMContentLoaded","onreadystatechange",gktviLoadVideo(e,t,i,n,d,l))}function gktviLoadVideo(e,t,i,n,d,l){var r=document.getElementById("div_"+e),a=document.getElementById("svg_"+e),o=gktviCreateElement("img",e,t,i,d,l),g=[a,o];r.appendChild(o);var c=gktviCreateElement("iframe",e,n,i,d,l);c.setAttribute("allowfullscreen",!0);for(var v=0;v<g.length;v++)gktviTriggerEvent(g[v],"click","onclick",replaceThumbWithVideo(c,o,a))}function replaceThumbWithVideo(e,t,i){return function(){e.style.width=t.offsetWidth+"px",e.style.height=t.offsetHeight+"px",t.parentNode.replaceChild(e,t),i.style.display="none"}}function loadDeferredImage(e,t,i,n,d,l,r){var a=document.getElementById("div_"+e),o=gktviCreateElement("img",e,t,i,l,r,n,d);a.parentNode.replaceChild(o,a)}</script>
	<?php
}
?>