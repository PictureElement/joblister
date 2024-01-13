<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Dependencies
{

  // Constructor
  public function __construct()
  {
    add_action('admin_init', array($this, 'jbls_handle_plugin_dependencies'));
  }

  // Handle plugin dependencies
  public function jbls_handle_plugin_dependencies()
  {
    if (is_admin() && current_user_can('activate_plugins') &&  !is_plugin_active('radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php')) {
      add_action('admin_notices', array($this, 'jbls_plugin_notice'));

      deactivate_plugins(plugin_basename(JBLS_PLUGIN_FILE));

      if (isset($_GET['activate'])) {
        unset($_GET['activate']);
      }
    }
  }

  public static function jbls_plugin_notice()
  {
    echo '<div class="error"><p>Sorry, but the JobLister plugin requires the <a target="_blank" href="https://wordpress.org/plugins/radio-buttons-for-taxonomies/"><strong>Radio Buttons for Taxonomies</strong></a> plugin to be installed and active.</p></div>';
  }
}
