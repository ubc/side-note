<?php
/**
 * The WordPress Plugin Boilerplate.
 *
 * A foundation off of which to build well-documented WordPress plugins that
 * also follow WordPress Coding Standards and PHP best practices.
 *
 * @package   Side_Note
 * @license   GPL-2.0+
 * @link      http://github.com/ubc/side-note
 * @copyright 2014 CTLT UBC
 *
 * @wordpress-plugin
 * Plugin Name:       Side Note
 * Plugin URI:        github.com/ubc/side-note
 * Description:       Add
 * Version:           0.5
 * Text Domain:       side-notes-locale
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/ubc/side-note
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*----------------------------------------------------------------------------*
 * Public-Facing Functionality
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/class-side-notes.php' );

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 *
 */
register_activation_hook( __FILE__, array( 'Side_Note', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Side_Note', 'deactivate' ) );

/*

 */
add_action( 'plugins_loaded', array( 'Side_Note', 'get_instance' ) );
