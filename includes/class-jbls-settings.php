<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_Settings {

  private $color_settings = [
    'jbls_accent' => [
      'title' => 'Accent',
      'description' => 'Enter the "accent" color in hex format. Defaults to #1a73e8.'
    ],
    'jbls_on_accent' => [
      'title' => 'On Accent',
      'description' => 'Enter the "on accent" color in hex format. Defaults to #ffffff.'
    ],
    'jbls_background' => [
      'title' => 'Background',
      'description' => 'Enter the "background" color in hex format. Defaults to #f8f9fa.'
    ],
    'jbls_on_background_primary' => [
      'title' => 'On Background Primary',
      'description' => 'Enter the "on background primary" color in hex format. Defaults to #202124.'
    ],
    'jbls_on_background_secondary' => [
      'title' => 'On Background Secondary',
      'description' => 'Enter the "on background secondary" color in hex format. Defaults to #5f6368.'
    ],
    'jbls_on_background_border' => [
      'title' => 'On Background Border',
      'description' => 'Enter the "on background border" color in hex format. Defaults to #dadce0.'
    ],
    'jbls_surface' => [
      'title' => 'Surface',
      'description' => 'Enter the "surface" color in hex format. Defaults to #ffffff.'
    ],
    'jbls_on_surface_primary' => [
      'title' => 'On Surface Primary',
      'description' => 'Enter the "on surface primary" color in hex format. Defaults to #202124.'
    ],
    'jbls_on_surface_secondary' => [
      'title' => 'On Surface Secondary',
      'description' => 'Enter the "on surface secondary" color in hex format. Defaults to #5f6368.'
    ],
    'jbls_on_surface_border' => [
      'title' => 'On Surface Border',
      'description' => 'Enter the "on surface border" color in hex format. Defaults to #dadce0.'
    ],
    'jbls_error' => [
      'title' => 'Error',
      'description' => 'Enter the "error" color in hex format. Defaults to #dc3545.'
    ],
    'jbls_success' => [
      'title' => 'Success',
      'description' => 'Enter the "success" color in hex format. Defaults to #198754.'
    ]
  ];

  public function __construct() {
    add_action('admin_menu', array($this, 'jbls_add_settings_page'));
    add_action('admin_init', array($this, 'jbls_register_settings'));
  }

  public function jbls_add_settings_page() {
    add_submenu_page(
      'edit.php?post_type=jbls_job',
      'Settings',
      'Settings',
      'manage_options',
      'jbls_settings',
      array($this, 'jbls_settings_page'),
      7
    );
  }

  public function jbls_settings_page() {
    ?>
    <div class="wrap">
      <h1>Settings</h1>
      <form method="post" action="options.php">
        <?php
        // Generates the necessary hidden input fields (nonce field, action field, and option_page field)
        settings_fields('jbls_option_group');
        // Renders the sections on the settings page:
        do_settings_sections('jbls_settings_page');
        // Generate the submit button
        submit_button();
        ?>
      </form>
    </div>
    <?php
  }

  public function jbls_register_settings() {
    register_setting('jbls_option_group', 'jbls_options', array($this, 'jbls_options_validate'));

    add_settings_section(
      'jbls_general',
      'General Settings',
      array($this, 'jbls_general_callback'),
      'jbls_settings_page'
    );

    add_settings_field(
      'jbls_per_page',
      'Items Per Page',
      array($this, 'jbls_per_page_callback'),
      'jbls_settings_page',
      'jbls_general'
    );

    add_settings_field(
      'jbls_captcha_site_key',
      'Invisible reCAPTCHA v2 Site Key',
      array($this, 'jbls_captcha_site_key_callback'),
      'jbls_settings_page',
      'jbls_general'
    );

    add_settings_field(
      'jbls_captcha_secret_key',
      'Invisible reCAPTCHA v2 Secret Key',
      array($this, 'jbls_captcha_secret_key_callback'),
      'jbls_settings_page',
      'jbls_general'
    );

    add_settings_field(
      'jbls_privacy_url',
      'Privacy Policy URL',
      array($this, 'jbls_privacy_url_callback'),
      'jbls_settings_page',
      'jbls_general'
    );

    add_settings_section(
      'jbls_style',
      'Style Settings',
      array($this, 'jbls_style_callback'),
      'jbls_settings_page'
    );

    add_settings_field(
      'jbls_google_font_url',
      'Google Font URL',
      array($this, 'jbls_google_font_import_callback'),
      'jbls_settings_page',
      'jbls_style'
    );

    add_settings_field(
      'jbls_google_font_family',
      'Google Font Family',
      array($this, 'jbls_google_font_family_callback'),
      'jbls_settings_page',
      'jbls_style'
    );

    foreach ($this->color_settings as $key => $value) {
      add_settings_field(
        $key,
        $value['title'],
        array($this, 'jbls_color_callback'),
        'jbls_settings_page',
        'jbls_style',
        // Extra arguments that get passed to the callback function
        array(
          'id' => $key,
          'description' => $value['description']
        )
      );
    }
  }

  public function jbls_general_callback() {
    echo 'Set up core aspects for optimal integration with your site.';
  }

  public function jbls_per_page_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="text" id="jbls_per_page" name="jbls_options[jbls_per_page]" value="<?php echo isset($options['jbls_per_page']) ? esc_attr($options['jbls_per_page']) : ''; ?>">
    <p class="description">Defaults to 10.</p>
    <?php
  }

  public function jbls_captcha_site_key_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="text" id="jbls_captcha_site_key" name="jbls_options[jbls_captcha_site_key]" value="<?php echo isset($options['jbls_captcha_site_key']) ? esc_attr($options['jbls_captcha_site_key']) : ''; ?>">
    <p class="description">Defaults to the reCAPTCHA v2 site test key 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI.</p>
    <?php
  }

  public function jbls_captcha_secret_key_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="text" id="jbls_captcha_secret_key" name="jbls_options[jbls_captcha_secret_key]" value="<?php echo isset($options['jbls_captcha_secret_key']) ? esc_attr($options['jbls_captcha_secret_key']) : ''; ?>">
    <p class="description">Defaults to the reCAPTCHA v2 secret test key 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe.</p>
    <?php
  }

  public function jbls_privacy_url_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="url" id="jbls_privacy_url" name="jbls_options[jbls_privacy_url]" value="<?php echo isset($options['jbls_privacy_url']) ? esc_attr($options['jbls_privacy_url']) : ''; ?>">
    <p class="description">Enter the absolute URL, including the protocol (http:// or https://). Defaults to relative URL /privacy-policy/.</p>
    <?php
  }

  public function jbls_style_callback() {
    echo 'Adjust the visual style of your job listings. Tailor colors, fonts, and more to ensure the JobLister plugin complements your site\'s theme.';
  }

  public function jbls_google_font_import_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="url" id="jbls_google_font_url" name="jbls_options[jbls_google_font_url]" value="<?php echo isset($options['jbls_google_font_url']) ? esc_attr($options['jbls_google_font_url']) : ''; ?>">
    <p class="description">Enter the CSS @import URL for your chosen Google Font, including the weights: 300, 400, and 700. Example: https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap</p>
    <?php
  }

  public function jbls_google_font_family_callback() {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="text" id="jbls_google_font_family" name="jbls_options[jbls_google_font_family]" value="<?php echo isset($options['jbls_google_font_family']) ? esc_attr($options['jbls_google_font_family']) : ''; ?>">
    <p class="description">Enter just the font family portion for your chosen Google Font, as you would use in a CSS 'font-family' property. Do not include 'font-family:' itself. Example: 'Poppins', sans-serif. Defaults to inherit.</p>
    <?php
  }

  public function jbls_color_callback($args) {
    $options = get_option('jbls_options');
    ?>
    <input style="width: 100%;" type="text" id="<?php echo esc_attr($args['id']); ?>" name="jbls_options[<?php echo esc_attr($args['id']); ?>]" value="<?php echo isset($options[$args['id']]) ? esc_attr($options[$args['id']]) : '' ?>">
    <p class="description"><?php echo esc_html($args['description']); ?></p>
    <?php
  }

  public function jbls_options_validate($input) {
    // Validate and set 'jbls_per_page'. Ensure it's a positive number, otherwise set to null.
    $input['jbls_per_page'] = (isset($input['jbls_per_page']) && is_numeric($input['jbls_per_page']) && intval($input['jbls_per_page']) > 0) ? intval($input['jbls_per_page']) : null;
        
    // Sanitize 'jbls_captcha_site_key'. Set to null if not provided.
    $input['jbls_captcha_site_key'] = isset($input['jbls_captcha_site_key']) ? sanitize_text_field(trim($input['jbls_captcha_site_key'])) : null;

    // Sanitize 'jbls_captcha_secret_key'. Set to null if not provided.
    $input['jbls_captcha_secret_key'] = isset($input['jbls_captcha_secret_key']) ? sanitize_text_field(trim($input['jbls_captcha_secret_key'])) : null;

    // Sanitize the 'jbls_privacy_url' field. Set to null if not provided.
    $input['jbls_privacy_url'] = isset($input['jbls_privacy_url']) ? sanitize_url(trim($input['jbls_privacy_url'])) : null;

    // Sanitize the 'jbls_google_font_url' field. Set to null if not provided.
    $input['jbls_google_font_url'] = isset($input['jbls_google_font_url']) ? sanitize_url(trim($input['jbls_google_font_url'])) : null;

    // Sanitize the 'jbls_google_font_family' field. Set to null if not provided.
    $input['jbls_google_font_family'] = isset($input['jbls_google_font_family']) ? sanitize_text_field(trim($input['jbls_google_font_family'])) : null;

    // Sanitize color input fields, set to null if not provided.
    $input['jbls_accent'] = isset($input['jbls_accent']) ? sanitize_hex_color(trim($input['jbls_accent'])) : null;
    $input['jbls_on_accent'] = isset($input['jbls_on_accent']) ? sanitize_hex_color(trim($input['jbls_on_accent'])) : null;
    $input['jbls_background'] = isset($input['jbls_background']) ? sanitize_hex_color(trim($input['jbls_background'])) : null;
    $input['jbls_on_background_primary'] = isset($input['jbls_on_background_primary']) ? sanitize_hex_color(trim($input['jbls_on_background_primary'])) : null;
    $input['jbls_on_background_secondary'] = isset($input['jbls_on_background_secondary']) ? sanitize_hex_color(trim($input['jbls_on_background_secondary'])) : null;
    $input['jbls_on_background_border'] = isset($input['jbls_on_background_border']) ? sanitize_hex_color(trim($input['jbls_on_background_border'])) : null;
    $input['jbls_surface'] = isset($input['jbls_surface']) ? sanitize_hex_color(trim($input['jbls_surface'])) : null;
    $input['jbls_on_surface_primary'] = isset($input['jbls_on_surface_primary']) ? sanitize_hex_color(trim($input['jbls_on_surface_primary'])) : null;
    $input['jbls_on_surface_secondary'] = isset($input['jbls_on_surface_secondary']) ? sanitize_hex_color(trim($input['jbls_on_surface_secondary'])) : null;
    $input['jbls_on_surface_border'] = isset($input['jbls_on_surface_border']) ? sanitize_hex_color(trim($input['jbls_on_surface_border'])) : null;
    $input['jbls_error'] = isset($input['jbls_error']) ? sanitize_hex_color(trim($input['jbls_error'])) : null;
    $input['jbls_success'] = isset($input['jbls_success']) ? sanitize_hex_color(trim($input['jbls_success'])) : null;

    // Return the sanitized and validated input array.
    return $input;
  }
}
