<?php
/**
 * @wordpress-plugin
 * Plugin Name:       WordPress Base Plugin
 * Plugin URI:        https://github.com/dmhendricks/wordpress-base-plugin
 * Description:       A boilerplate for WordPress plugins
 * Version:           0.3.0
 * Author:            Daniel M. Hendricks
 * Author URI:        https://www.danhendricks.com
 * License:           GPL-2.0
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain: 			wordpress-base-plugin
 * Domain Path: 			languages
 * GitHub Plugin URI: dmhendricks/wordpress-base-plugin
 */

/*	Copyright 2017	  Daniel M. Hendricks (https://www.danhendricks.com/)

		This program is free software; you can redistribute it and/or
    modify it under the terms of the GNU General Public License
    as published by the Free Software Foundation; either version 2
    of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

if(!defined('ABSPATH')) die();

require( __DIR__ . '/vendor/autoload.php' );
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

// Initialize plugin - Change to use your own namespace
new \VendorName\PluginName\Plugin( array(
	'data' => get_plugin_data( __FILE__ ),
	'path' => trailingslashit( realpath( plugin_dir_path( __FILE__ ) ) ),
	'url' => plugin_dir_url( __FILE__ ),
	'plugin_file' => plugin_basename( __FILE__ )
) );
