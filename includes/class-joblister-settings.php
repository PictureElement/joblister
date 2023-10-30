<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JL_Settings {

  public function __construct() {
    add_action('admin_menu', array($this, 'add_settings_page'));
    add_action('admin_init', array($this, 'register_settings'));
  }

  public function add_settings_page() {
    add_submenu_page(
      'edit.php?post_type=jl_job',
      'Settings',
      'Settings',
      'manage_options',
      'settings',
      array($this, 'settings_page'),
      7
    );
  }

  public function settings_page() {
    ?>
    <div class="wrap">
      <h1>Settings</h1>
      <form method="post" action="options.php">
        <?php
        settings_fields('joblister_options');
        do_settings_sections('joblister');
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  public function register_settings() {
    register_setting('joblister_options', 'joblister_options', array($this, 'options_validate'));
    add_settings_section(
      'joblister_main',
      'Main Settings',
      array($this, 'main_callback'),
      'joblister'
    );
    add_settings_field(
      'joblister_base_url',
      'Base URL',
      array($this, 'base_url_callback'),
      'joblister',
      'joblister_main'
    );
    add_settings_field(
      'joblister_per_page',
      'Items Per Page',
      array($this, 'per_page_callback'),
      'joblister',
      'joblister_main'
    );
    add_settings_field(
      'joblister_wordpress_username',
      'WordPress Username',
      array($this, 'wordpress_username_callback'),
      'joblister',
      'joblister_main'
    );
    add_settings_field(
      'joblister_application_password',
      'Application Password',
      array($this, 'application_password_callback'),
      'joblister',
      'joblister_main'
    );
    add_settings_field(
      'joblister_captcha_site_key',
      'Captcha Site Key',
      array($this, 'captcha_site_key_callback'),
      'joblister',
      'joblister_main'
    );
  }

  public function main_callback() {
    echo 'Configure the main settings for the JobLister plugin. These settings will affect how the plugin interacts with your WordPress site and how the job listings are displayed.';
  }

  public function base_url_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_base_url" name="joblister_options[base_url]" value="<?php echo isset($options['base_url']) ? esc_attr($options['base_url']) : '/'; ?>">
    <?php
  }

  public function per_page_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_per_page" name="joblister_options[per_page]" value="<?php echo isset($options['per_page']) ? esc_attr($options['per_page']) : '10'; ?>">
    <?php
  }

  public function wordpress_username_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_wordpress_username" name="joblister_options[wordpress_username]" value="<?php echo isset($options['wordpress_username']) ? esc_attr($options['wordpress_username']) : ''; ?>">
    <?php
  }

  public function application_password_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_application_password" name="joblister_options[application_password]" value="<?php echo isset($options['application_password']) ? esc_attr($options['application_password']) : ''; ?>">
    <?php
  }

  public function captcha_site_key_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_captcha_site_key" name="joblister_options[captcha_site_key]" value="<?php echo isset($options['captcha_site_key']) ? esc_attr($options['captcha_site_key']) : ''; ?>">
    <?php
  }

  public function options_validate($input) {
    // Validate the input data
    $input['base_url'] = sanitize_text_field($input['base_url']);
    $input['per_page'] = sanitize_text_field($input['per_page']);
    $input['wordpress_username'] = sanitize_text_field($input['wordpress_username']);
    $input['application_password'] = sanitize_text_field($input['application_password']);
    $input['captcha_site_key'] = sanitize_text_field($input['captcha_site_key']);
    return $input;
  }
}
