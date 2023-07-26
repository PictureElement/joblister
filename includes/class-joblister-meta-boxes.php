<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

/*
 * When we're working on a WordPress admin screen, these files are included by WordPress automatically. 
 * But when we're making a request from a separate React app, these files aren't automatically included 
 * because we're not on an admin screen.
 * 
 * To summarize, these lines of code are necessary because they make the media_handle_upload() function 
 * and other related functions/classes available to our code when it's not running in the usual 
 * WordPress context (such as when it's running as part of a REST API endpoint or in response 
 * to a request from a separate React app).
 */
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

class JL_Meta_Boxes
{
  public function __construct()
  {
    add_action('post_edit_form_tag', array($this, 'post_edit_form_tag'));
    add_action('add_meta_boxes_jl_application', array($this, 'add_jl_application_fields'));
    add_action('save_post', array($this, 'save_jl_application_fields'));
  }

  public function post_edit_form_tag()
  {
    echo ' enctype="multipart/form-data"';
  }

  // Add a meta box to the "jl_application" post type screen
  public function add_jl_application_fields()
  {
    add_meta_box(
      'jl-application-fields',
      'Application Details',
      array($this, 'render_jl_application_fields'),
      'jl_application',
      'normal',
      'high'
    );
  }

  // Fill the meta box with the desired content
  public function render_jl_application_fields($post)
  {
    $job_id = get_post_meta($post->ID, 'job_id', true);
    $name = get_post_meta($post->ID, 'name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $resume = get_post_meta($post->ID, 'resume', true);
?>
    <div style="margin-bottom:1em;">
      <label style="display:block;margin-bottom:4px;" for="job_id">Job ID</label>
      <input style="width:100%;" type="text" id="job_id" name="job_id" autocomplete="off" value="<?php echo esc_attr($job_id); ?>">
    </div>
    <div style="margin-bottom:1em;">
      <label style="display:block;margin-bottom:4px;" for="name">Name</label>
      <input style="width:100%;" type="text" id="name" name="name" autocomplete="off" value="<?php echo esc_attr($name); ?>">
    </div>
    <div style="margin-bottom:1em;">
      <label style="display:block;margin-bottom:4px;" for="email">Email</label>
      <input style="width:100%;" type="email" id="email" name="email" value="<?php echo esc_attr($email); ?>">
    </div>
    <div style="margin-bottom:1em;">
      <label style="display:block;margin-bottom:4px;" for="resume">Resume</label>
      <input style="padding:0;" type="file" id="resume" name="resume" accept=".pdf,.doc,.docx">
    </div>
    <?php if ($resume) : ?>
      <div style="display:flex;align-items:center;">
        <label style="margin-inline-end:4px;cursor:default;" for="uploaded_file">Uploaded File:</label>
        <output id="uploaded_resume" name="uploaded_file">
          <a href="<?php echo esc_url(wp_get_attachment_url($resume)); ?>" target="_blank"><?php echo esc_html(basename(get_attached_file($resume))); ?></a>
        </output>
      </div>
    <?php endif; ?>
<?php
  }

  // Update "jl_application" meta fields once a post has been saved
  public function save_jl_application_fields($post_id)
  {
    // Capability check
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }

    // Skip saving if it's an autosave operation
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return;
    }

    // Setup the array of supported file types
    $supported_types = array(
      'application/pdf', // PDF
      'application/msword', // DOC
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document' // DOCX
    );

    // File upload
    if (isset($_FILES['resume']) && $_FILES['resume']['size'] > 0) {
      // Sanitize the file name
      $filename = sanitize_file_name($_FILES['resume']['name']);

      // Check the file type
      $validate = wp_check_filetype_and_ext($_FILES['resume']['name'], $filename);
      $file_type = $validate['type'];

      if (!in_array($file_type, $supported_types)) {
        wp_die("The file type that you've uploaded is not a PDF/DOC/DOCX.");
      }

      // Save the file submitted from the POST request and create an attachment post for it.
      $attachment_id = media_handle_upload('resume', $post_id);

      // Check for upload errors
      if (is_wp_error($attachment_id)) {
        wp_die($attachment_id->get_error_message());
      }

      update_post_meta($post_id, 'resume', $attachment_id);
    }

    if (isset($_POST['job_id'])) {
      update_post_meta($post_id, 'job_id', sanitize_text_field($_POST['job_id']));
    }

    if (isset($_POST['name'])) {
      update_post_meta($post_id, 'name', sanitize_text_field($_POST['name']));
    }

    if (isset($_POST['email'])) {
      update_post_meta($post_id, 'email', sanitize_email($_POST['email']));
    }
  }
}

// Initialize the JL_Meta_Boxes
new JL_Meta_Boxes();
