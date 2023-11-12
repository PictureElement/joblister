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
      'jl_settings',
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
        // Generates the necessary hidden input fields (nonce field, action field, and option_page field)
        settings_fields('jl_option_group');
        // Renders the sections on the settings page:
        do_settings_sections('jl_settings_page');
        // Generate the submit button
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  public function register_settings() {
    register_setting('jl_option_group', 'jl_options', array($this, 'options_validate'));

    add_settings_section(
      'jl_primary',
      'Primary Settings',
      array($this, 'primary_callback'),
      'jl_settings_page'
    );

    add_settings_field(
      'jl_per_page',
      'Items Per Page',
      array($this, 'per_page_callback'),
      'jl_settings_page',
      'jl_primary'
    );

    add_settings_field(
      'jl_wordpress_username',
      'WordPress Username',
      array($this, 'wordpress_username_callback'),
      'jl_settings_page',
      'jl_primary'
    );

    add_settings_field(
      'jl_application_password',
      'Application Password',
      array($this, 'application_password_callback'),
      'jl_settings_page',
      'jl_primary'
    );
    
    add_settings_field(
      'jl_captcha_site_key',
      'Invisible reCAPTCHA v2 Site Key',
      array($this, 'captcha_site_key_callback'),
      'jl_settings_page',
      'jl_primary'
    );

    add_settings_field(
      'jl_privacy_link',
      'Privacy Policy Link',
      array($this, 'privacy_link_callback'),
      'jl_settings_page',
      'jl_primary'
    );

    add_settings_section(
      'jl_style',
      'Style Settings',
      array($this, 'style_callback'),
      'jl_settings_page'
    );

    add_settings_field(
      'jl_google_font_link',
      'Google Font Link',
      array($this, 'google_font_import_callback'),
      'jl_settings_page',
      'jl_style'
    );

    add_settings_field(
      'jl_google_font_family',
      'Google Font Family',
      array($this, 'google_font_family_callback'),
      'jl_settings_page',
      'jl_style'
    );

    $color_settings = [
      'jl_accent' => [
        'title' => 'Accent',
        'description' => 'Enter the "accent" color in hex format. Defaults to #1a73e8.'
      ],
      'jl_on_accent' => [
        'title' => 'On Accent',
        'description' => 'Enter the "on accent" color in hex format. Defaults to #ffffff.'
      ],
      'jl_background' => [
        'title' => 'Background',
        'description' => 'Enter the "background" color in hex format. Defaults to #f8f9fa.'
      ],
      'jl_on_background_primary' => [
        'title' => 'On Background Primary',
        'description' => 'Enter the "on background primary" color in hex format. Defaults to #202124.'
      ],
      'jl_on_background_secondary' => [
        'title' => 'On Background Secondary',
        'description' => 'Enter the "on background secondary" color in hex format. Defaults to #5f6368.'
      ],
      'jl_on_background_border' => [
        'title' => 'On Background Border',
        'description' => 'Enter the "on background border" color in hex format. Defaults to #dadce0.'
      ],
      'jl_surface' => [
        'title' => 'Surface',
        'description' => 'Enter the "surface" color in hex format. Defaults to #ffffff.'
      ],
      'jl_on_surface_primary' => [
        'title' => 'On Surface Primary',
        'description' => 'Enter the "on surface primary" color in hex format. Defaults to #202124.'
      ],
      'jl_on_surface_secondary' => [
        'title' => 'On Surface Secondary',
        'description' => 'Enter the "on surface secondary" color in hex format. Defaults to #5f6368.'
      ],
      'jl_on_surface_border' => [
        'title' => 'On Surface Border',
        'description' => 'Enter the "on surface border" color in hex format. Defaults to #dadce0.'
      ],
      'jl_error' => [
        'title' => 'Error',
        'description' => 'Enter the "error" color in hex format. Defaults to #dc3545.'
      ],
      'jl_success' => [
        'title' => 'Success',
        'description' => 'Enter the "success" color in hex format. Defaults to #198754.'
      ]
    ];

    foreach ($color_settings as $key => $value) {
      add_settings_field(
        $key,
        $value['title'],
        array($this, 'color_callback'),
        'jl_settings_page',
        'jl_style',
        // Extra arguments that get passed to the callback function
        array(
          'id' => $key,
          'description' => $value['description']
        )
      );
    }
  }

  public function primary_callback() {
    echo 'Set up core aspects of JobLister for optimal integration with your site.';
  }

  public function per_page_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="jl_per_page" name="jl_options[jl_per_page]" value="<?php echo isset($options['jl_per_page']) ? esc_attr($options['jl_per_page']) : '10'; ?>">
    <?php
  }

  public function wordpress_username_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="jl_wordpress_username" name="jl_options[jl_wordpress_username]" value="<?php echo isset($options['jl_wordpress_username']) ? esc_attr($options['jl_wordpress_username']) : ''; ?>">
    <?php
  }

  public function application_password_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="jl_application_password" name="jl_options[jl_application_password]" value="<?php echo isset($options['jl_application_password']) ? esc_attr($options['jl_application_password']) : ''; ?>">
    <?php
  }

  public function captcha_site_key_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="jl_captcha_site_key" name="jl_options[jl_captcha_site_key]" value="<?php echo isset($options['jl_captcha_site_key']) ? esc_attr($options['jl_captcha_site_key']) : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'; ?>">
    <?php
  }

  public function privacy_link_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="url" id="jl_privacy_link" name="jl_options[jl_privacy_link]" value="<?php echo isset($options['jl_privacy_link']) ? esc_attr($options['jl_privacy_link']) : ''; ?>">
    <?php
  }

  public function style_callback() {
    echo 'Adjust the visual style of your job listings. Tailor colors, fonts, and more to ensure the JobLister plugin complements your site\'s theme.';
  }

  public function google_font_import_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="url" id="jl_google_font_link" name="jl_options[jl_google_font_link]" value="<?php echo isset($options['jl_google_font_link']) ? esc_attr($options['jl_google_font_link']) : ''; ?>">
    <p class="description">Enter the CSS @import link for your chosen Google Font, including the weights: 300, 400, and 700. Example: <strong>https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap</strong></p>
    <?php
  }

  public function google_font_family_callback() {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="jl_google_font_family" name="jl_options[jl_google_font_family]" value="<?php echo isset($options['jl_google_font_family']) ? esc_attr($options['jl_google_font_family']) : ''; ?>">
    <p class="description">Enter just the font family portion for your chosen Google Font, as you would use in a CSS 'font-family' property. Do not include 'font-family:' itself. Example: <strong>'Poppins', sans-serif</strong></p>
    <?php
  }

  public function color_callback($args) {
    $options = get_option('jl_options');
    ?>
    <input style="width: 100%;" type="text" id="<?php echo esc_attr($args['id']); ?>" name="jl_options[<?php echo esc_attr($args['id']); ?>]" value="<?php echo isset($options[$args['id']]) ? esc_attr($options[$args['id']]) : '' ?>">
    <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php
  }

  // Trim and sanitize color input. If it's not set or is an invalid color, use the default color.
  public function sanitize_color_option($color, $default) {
    $trimmed_and_sanitized_color = isset($color) ? sanitize_hex_color(trim($color)) : '';
    return $trimmed_and_sanitized_color ? $trimmed_and_sanitized_color : $default;
  }

  public function options_validate($input) {
    // Set 'jl_per_page' input to an integer greater than 0. If it's not set, not numeric, or less than 1, default to 10.
    $input['jl_per_page'] = (isset($input['jl_per_page']) && is_numeric($input['jl_per_page']) && intval($input['jl_per_page']) > 0) ? intval($input['jl_per_page']) : 10;

    // Sanitize and save the 'jl_wordpress_username' input. If it's not set, default to an empty string.
    $input['jl_wordpress_username'] = isset($input['jl_wordpress_username']) ? sanitize_text_field(trim($input['jl_wordpress_username'])) : '';

    // Sanitize and save the 'jl_application_password' input. If it's not set, default to an empty string.
    $input['jl_application_password'] = isset($input['jl_application_password']) ? sanitize_text_field(trim($input['jl_application_password'])) : '';
    
    // Trim and sanitize 'jl_captcha_site_key'. If it's not set or after sanitization and trimming it's an empty string, use the default key.
    $trimmed_and_sanitized_captcha_site_key = isset($input['jl_captcha_site_key']) ? sanitize_text_field(trim($input['jl_captcha_site_key'])) : '';
    $input['jl_captcha_site_key'] = $trimmed_and_sanitized_captcha_site_key !== '' ? $trimmed_and_sanitized_captcha_site_key : '6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI';

    // Sanitize and save the 'jl_privacy_link' input. If it's not set, default to an empty string.
    $input['jl_privacy_link'] = isset($input['jl_privacy_link']) ? sanitize_url(trim($input['jl_privacy_link'])) : '';

    $input['jl_accent'] = $this->sanitize_color_option($input['jl_accent'], '#1a73e8');
    $input['jl_on_accent'] = $this->sanitize_color_option($input['jl_on_accent'], '#ffffff');
    $input['jl_background'] = $this->sanitize_color_option($input['jl_background'], '#f8f9fa');
    $input['jl_on_background_primary'] = $this->sanitize_color_option($input['jl_on_background_primary'], '#202124');
    $input['jl_on_background_secondary'] = $this->sanitize_color_option($input['jl_on_background_secondary'], '#5f6368');
    $input['jl_on_background_border'] = $this->sanitize_color_option($input['jl_on_background_border'], '#dadce0');
    $input['jl_surface'] = $this->sanitize_color_option($input['jl_surface'], '#ffffff');
    $input['jl_on_surface_primary'] = $this->sanitize_color_option($input['jl_on_surface_primary'], '#202124');
    $input['jl_on_surface_secondary'] = $this->sanitize_color_option($input['jl_on_surface_secondary'], '#5f6368');
    $input['jl_on_surface_border'] = $this->sanitize_color_option($input['jl_on_surface_border'], '#dadce0');
    $input['jl_error'] = $this->sanitize_color_option($input['jl_error'], '#dc3545');
    $input['jl_success'] = $this->sanitize_color_option($input['jl_success'], '#198754');

    // Sanitize and save the 'jl_google_font_link' input. If it's not set, default to an empty string.
    $input['jl_google_font_link'] = isset($input['jl_google_font_link']) ? sanitize_url(trim($input['jl_google_font_link'])) : '';

    // Sanitize and save the 'jl_google_font_family' input. If it's not set, default to an empty string.
    $input['jl_google_font_family'] = isset($input['jl_google_font_family']) ? sanitize_text_field(trim($input['jl_google_font_family'])) : '';

    // Return the array to ensure the settings are saved.
    return $input;
  }
}
