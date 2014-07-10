<?php
/*
Plugin Name: Shaashadda Admin Dashboard
Plugin URI: http://aqoonkaal.com/
Description: Maaraynta shaashadda Dhashboard ee laga hago WordPress
Version: 1.3
Author: Aqoonkaal
Author URI: http://aqoonkaal.com/afeef/
Contributors: aqoonkaal
License: GPLv2 or later
*/

/*  Copyright 2014  Shaashadda Admin Dashboard  (@aqoonkaal)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) die( "Can not load this file directly" );

/*******************************************
* global variables
*******************************************/
/*
* plugin_dir_path( __FILE__ ) returns the servers filesystem directory path
* pointing to the current file and is used for loading php files, eg:
* include( SHAD_PLUGIN_DIR . 'includes/scripts.php' );
*/
if ( !defined( 'SHAD_PLUGIN_DIR' ) ) {
	define( 'SHAD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/*
* plugin_dir_url( __FILE__ ) returns web URL with a trailing slash
* and is used for loading assets like images, CSS, and JS files,eg:
* wp_enqueue_style( 'plugin-styles', SHAD_PLUGIN_URL . 'css/plugin-styles.css' );
* wp_enqueue_script( 'unique-js', SHAD_PLUGIN_URL . 'js/jquery.name.js' );
* wp_register_script( 'jsname', SHAD_PLUGIN_URL . 'js/jquery.uname.js', array('jquery') );
* <img src="<?php echo SHAD_PLUGIN_URL; ?>/images/imagename.png"/>
*/
if ( !defined( 'SHAD_PLUGIN_URL' ) ) {
	define( 'SHAD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/*
* __FILE__ The full path and filename of the file
* Gets the path to a plugin file or directory, relative to the plugins directory,
* without the leading and trailing slashes.
* eg: register_activation_hook( SHAD_PLUGIN_FILE, 'shad_rewrite_flush' );
*/
if ( !defined( 'SHAD_PLUGIN_FILE' ) ) {
    define( 'SHAD_PLUGIN_FILE', __FILE__ );
}

/*
* plugin version
* wp_register_style('style-name',  SHAD_PLUGIN_URL . 'css/file-name.css', SHAD_PLUGIN_VERSION );
*/
if ( !defined( 'SHAD_PLUGIN_VERSION' ) ) {
    define( 'SHAD_PLUGIN_VERSION', '1.3' );
}

/*******************************************
* file includes
*******************************************/

include( SHAD_PLUGIN_DIR . 'includes/admin-dashboard-fuctions.php' );

require_once( 'BFIGitHubPluginUploader.php' );
if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'aqoonkaal', "shaashadda-admin-dashboard" );
}