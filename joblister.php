<?php
/*
 * Plugin Name:       JobLister
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       React-powered job listing made simple for WordPress.
 * Version:           1.0.0
 * Author:            Marios Sofokleous
 * Author URI:        https://www.msof.me/
 * License:           GNU General Public License v3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// The core plugin class
require_once plugin_dir_path(__FILE__) . 'includes/class-joblister.php';

// Initialize the JobLister plugin
new JobLister();
