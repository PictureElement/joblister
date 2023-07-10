<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Handle plugin dependencies
function jl_handle_plugin_dependencies() {
  if (is_admin() && current_user_can('activate_plugins') &&  !is_plugin_active('radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php')) {
    add_action('admin_notices', 'jl_plugin_notice');

    deactivate_plugins(plugin_basename(__FILE__));

    if (isset($_GET['activate'])) {
      unset($_GET['activate']);
    }
  }
}

function jl_plugin_notice() {
  echo '<div class="error"><p>Sorry, but <strong>JobLister</strong> plugin requires the <strong>Radio Buttons for Taxonomies</strong> plugin to be installed and active.</p></div>';
}

add_action('admin_init', 'jl_handle_plugin_dependencies');
