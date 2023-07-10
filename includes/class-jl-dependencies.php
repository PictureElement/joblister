<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Dependencies
{

  // Constructor
  public function __construct()
  {
    add_action('admin_init', array($this, 'handle_plugin_dependencies'));
  }

  // Handle plugin dependencies
  public function handle_plugin_dependencies()
  {
    if (is_admin() && current_user_can('activate_plugins') &&  !is_plugin_active('radio-buttons-for-taxonomies/radio-buttons-for-taxonomies.php')) {
      add_action('admin_notices', array($this, 'plugin_notice'));

      deactivate_plugins(plugin_basename(__FILE__));

      if (isset($_GET['activate'])) {
        unset($_GET['activate']);
      }
    }
  }

  public static function plugin_notice()
  {
    echo '<div class="error"><p>Sorry, but <strong>JobLister</strong> plugin requires the <strong>Radio Buttons for Taxonomies</strong> plugin to be installed and active.</p></div>';
  }
}

// Initialize the JL_Dependencies
new JL_Dependencies();
