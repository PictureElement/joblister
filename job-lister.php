<?php

/**
 * Plugin name: JobLister
 * Description: Simple job listing plugin to manage job openings on your WordPress site.
 * Author: Marios Sofokleous
 * Author URI: https://www.msof.me
 */

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Include files for each functionality
require_once plugin_dir_path(__FILE__) . 'includes/dependencies.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'includes/scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/styles.php';
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-types.php';
require_once plugin_dir_path(__FILE__) . 'includes/custom-taxonomies.php';
require_once plugin_dir_path(__FILE__) . 'includes/rest-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/meta-boxes.php';
require_once plugin_dir_path(__FILE__) . 'includes/admin-columns.php';
