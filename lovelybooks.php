<?php
/*
Plugin Name: LovelyBooks Sidebar Widget
Version: 0.2
Description: Adds Widget for LovelyBooks. Please enter your User ID and preferred color settings in the <a href="options-general.php?page=lovelybooks">settings page</a>. Then drag the LovelyBooks-Widget in the desired widget area.
Author: Bego Mario Garde
Author URI: https://pixolin.de
License: GPLv2
Domain Path:  /languages
Text Domain: lovelybooks

COPYRIGHT (c) 2016 Bego Mario Garde <pixolin@pixolin.de>

GNU GENERAL PUBLIC LICENSE
   Version 2, June 1991

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Initialize the plugin
 */
if ( ! function_exists( 'lb_init' ) ) {
	function lb_init() {
		require_once( dirname( __FILE__ ) . '/inc/widget-class.php' );
		$lovely = new LBWidget();

		require_once( dirname( __FILE__ ) . '/admin/settings.php' );
		$lovely_settings = new LBsettings();

		load_plugin_textdomain( 'lovelybooks', false, plugin_basename( dirname( __FILE__ ) ).'/languages' );

	}
}
add_action( 'plugins_loaded', 'lb_init' );

if ( ! function_exists( 'lb_scripts' ) ) {
	function lb_scripts() {
		wp_register_script( 'lovelybooks', plugins_url( '/js/lovelybooks.js', __FILE__ ), array( 'jquery' ), 1.0, true );

		$lb_settings = get_option( 'lbsettings' );

		$userid  = $lb_settings['userid']  ? $lb_settings['userid']  : '18438024';
		$variant = $lb_settings['variant'] ? $lb_settings['variant'] : '1';
		$bgcolor = $lb_settings['bgcolor'] ? $lb_settings['bgcolor'] : '#ffffff';
		$acolor  = $lb_settings['acolor']  ? $lb_settings['acolor']  : '#e6a117';
		$pcolor  = $lb_settings['pcolor']  ? $lb_settings['pcolor']  : '#7c7d7f';

		$l10n = array(
			'userID' => $userid,
			'variant' => $variant,
			'bgColor' => $bgcolor,
			'accentColor' => $acolor,
			'primaryTxtColor' => $pcolor,
		);
		wp_localize_script( 'lovelybooks', 'lbuserdata', $l10n );

		wp_enqueue_script( 'lovelybooks' );
	}
}
add_action( 'wp_enqueue_scripts', 'lb_scripts' );

if ( ! function_exists( 'lb_add_color_picker' ) ) {
	function lb_add_color_picker() {

		if ( is_admin() ) {
			wp_enqueue_style( 'wp-color-picker' );

			// Include our custom jQuery file with WordPress Color Picker dependency
			wp_enqueue_script( 'lb_colorpicker', plugins_url( '/js/lb-colorpicker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		}
	}
}
add_action( 'admin_enqueue_scripts', 'lb_add_color_picker' );

if ( ! function_exists( 'bl_plugin_action_links' ) ) {
	function lb_plugin_action_links( $links ) {
		$mylinks = array(
			'<a href="options-general.php?page=lovelybooks">'. __( 'settings page', 'lovelybooks' ) . '</a>',
		);
		return array_merge( $links, $mylinks );
	}
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ) , 'lb_plugin_action_links' );
