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
      'joblister_primary',
      'Primary Settings',
      array($this, 'primary_callback'),
      'joblister'
    );
    add_settings_field(
      'joblister_per_page',
      'Items Per Page',
      array($this, 'per_page_callback'),
      'joblister',
      'joblister_primary'
    );
    add_settings_field(
      'joblister_wordpress_username',
      'WordPress Username',
      array($this, 'wordpress_username_callback'),
      'joblister',
      'joblister_primary'
    );
    add_settings_field(
      'joblister_application_password',
      'Application Password',
      array($this, 'application_password_callback'),
      'joblister',
      'joblister_primary'
    );
    add_settings_field(
      'joblister_captcha_site_key',
      'Invisible reCAPTCHA v2 Site Key',
      array($this, 'captcha_site_key_callback'),
      'joblister',
      'joblister_primary'
    );
    add_settings_section(
      'joblister_style',
      'Style Settings',
      array($this, 'style_callback'),
      'joblister'
    );
    add_settings_field(
      'joblister_accent',
      'Accent Color',
      array($this, 'accent_callback'),
      'joblister',
      'joblister_style'
    );
    add_settings_field(
      'joblister_on_accent',
      'On Accent Color',
      array($this, 'on_accent_callback'),
      'joblister',
      'joblister_style'
    );
  }

  public function primary_callback() {
    echo 'Set up core aspects of JobLister for optimal integration with your site.';
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
    <input type="text" id="joblister_captcha_site_key" name="joblister_options[captcha_site_key]" value="<?php echo isset($options['captcha_site_key']) ? esc_attr($options['captcha_site_key']) : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; ?>">
    <?php
  }

  public function style_callback() {
    echo 'Adjust the visual style of your job listings. Tailor colors, fonts, and more to ensure the JobLister plugin complements your site\'s theme.';
  }

  public function accent_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_accent" name="joblister_options[accent]" value="<?php echo isset($options['accent']) ? esc_attr($options['accent']) : ''; ?>">
    <p class="description">Enter the accent color in hex format. E.g., #ff4500</p>
    <?php
  }

  public function on_accent_callback() {
    $options = get_option('joblister_options');
    ?>
    <input type="text" id="joblister_on_accent" name="joblister_options[on_accent]" value="<?php echo isset($options['on_accent']) ? esc_attr($options['on_accent']) : ''; ?>">
    <p class="description">Enter the <strong>on accent</strong> color in hex format. E.g., #ff4500</p>
    <?php
  }

  public function options_validate($input) {
    // Set 'per_page' input to an integer greater than 0. If it's not set, not numeric, or less than 1, default to 10.
    $input['per_page'] = (isset($input['per_page']) && is_numeric($input['per_page']) && intval($input['per_page']) > 0) ? intval($input['per_page']) : 10;

    // Sanitize and save the 'wordpress_username' input. If it's not set, default to an empty string.
    $input['wordpress_username'] = isset($input['wordpress_username']) ? sanitize_text_field(trim($input['wordpress_username'])) : '';

    // Sanitize and save the 'application_password' input. If it's not set, default to an empty string.
    $input['application_password'] = isset($input['application_password']) ? sanitize_text_field(trim($input['application_password'])) : '';
    
    // Trim and sanitize 'captcha_site_key'. If it's not set or after sanitization and trimming it's an empty string, use the default key.
    $trimmed_and_sanitized_captcha_site_key = isset($input['captcha_site_key']) ? sanitize_text_field(trim($input['captcha_site_key'])) : '';
    $input['captcha_site_key'] = $trimmed_and_sanitized_captcha_site_key !== '' ? $trimmed_and_sanitized_captcha_site_key : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';

    // Trim and sanitize 'accent' color input. If it's not set or is an invalid color, use the default color.
    $trimmed_and_sanitized_accent = isset($input['accent']) ? sanitize_hex_color(trim($input['accent'])) : '';
    $input['accent'] = $trimmed_and_sanitized_accent !== '' ? $trimmed_and_sanitized_accent : '#1a73e8';

    // Trim and sanitize 'on_accent' color input. If it's not set or is an invalid color, use the default color.
    $trimmed_and_sanitized_on_accent = isset($input['on_accent']) ? sanitize_hex_color(trim($input['on_accent'])) : '';
    $input['on_accent'] = $trimmed_and_sanitized_on_accent !== '' ? $trimmed_and_sanitized_on_accent : '#ffffff';

    // Return the array to ensure the settings are saved.
    return $input;
  }
}
