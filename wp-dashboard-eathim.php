<?php
/**
 * Plugin Name:       WP Dashboard Eathim
 * Plugin URI:        https://wordpress.org/plugins/wp-dashboard-eathim/
 * Description:       Provides a excellent widgets for your WP Dashboard.
 * Tags: dashboard, widget, widgets, user notes, use list, list, notes
 * Version:           1.0.2
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Author:            Rawshan ali
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wpdeathim
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) die();

// dir path
define("WPDE_PLUGIN_DIR", plugin_dir_path(__FILE__));
define("WPDE_ASSETS_DIR", plugin_dir_url(__FILE__));



// Plugin loaded
function wpde_load_plugin_textdomain(){
    load_plugin_textdomain('wpdeathim', false,WPDE_ASSETS_DIR."/languages");
}
add_action('plugins_loaded','wpde_load_plugin_textdomain');

//Activation hooks
register_activation_hook(__FILE__,"wpde_todolists");

//Enqueue files
function wpde_admin_assets(){
    wp_enqueue_style('wpde-admin-style', WPDE_ASSETS_DIR."/assets/admin/css/admin-style.css");
}
add_action('admin_enqueue_scripts','wpde_admin_assets');

//Dashboard Pages
function wpde_dashboard_links($links){
    $newlinks = sprintf("<a href='%s'>%s</a>",admin_url().'index.php', __("Dashboard","wpdeathim"));
    $links[] = $newlinks;
    return $links;
}
add_filter('plugin_action_links_wp-dashboard-eathim/wp-dashboard-eathim.php','wpde_dashboard_links');

//Include Files
require_once (WPDE_PLUGIN_DIR .'inc/userstatus.php');
require_once (WPDE_PLUGIN_DIR .'inc/todolist.php');