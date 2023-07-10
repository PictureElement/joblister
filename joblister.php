<?php

/**
 * Plugin name: JobLister
 * Description: Simple job listing plugin to manage job openings on your WordPress site.
 * Author: Marios Sofokleous
 * Author URI: https://www.msof.me
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// The core plugin class
require_once plugin_dir_path(__FILE__) . 'includes/class-joblister.php';

// Initialize the JobLister plugin
new JobLister();
