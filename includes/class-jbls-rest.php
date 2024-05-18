<?php

// Exit if accessed directly.
defined('ABSPATH') || exit;

class JBLS_REST
{
  public function __construct()
  {
    add_filter('rest_prepare_jbls_location', array($this, 'jbls_filter_rest_jbls_location'));
    add_filter('rest_prepare_jbls_category', array($this, 'jbls_filter_rest_jbls_category'));
    add_filter('rest_prepare_jbls_type', array($this, 'jbls_filter_rest_jbls_type'));
    add_filter('rest_prepare_jbls_experience_level', array($this, 'jbls_filter_rest_jbls_experience_level'));
  
    add_action('rest_api_init', array($this, 'jbls_register_custom_rest_routes'));
  }

  public function jbls_register_custom_rest_routes() {
    register_rest_route('jbls/v1', '/jbls-jobs', [
      'methods' => 'GET',
      'callback' => array($this, 'jbls_get_jobs'),
      'permission_callback' => '__return_true',
    ]);
    register_rest_route('jbls/v1', '/jbls-locations', [
      'methods' => 'GET',
      'callback' => array($this, 'jbls_get_locations'),
      'permission_callback' => '__return_true',
    ]);
    register_rest_route('jbls/v1', '/jbls-categories', [
      'methods' => 'GET',
      'callback' => array($this, 'jbls_get_categories'),
      'permission_callback' => '__return_true',
    ]);
    register_rest_route('jbls/v1', '/jbls-types', [
      'methods' => 'GET',
      'callback' => array($this, 'jbls_get_types'),
      'permission_callback' => '__return_true',
    ]);
    register_rest_route('jbls/v1', '/jbls-experience-levels', [
      'methods' => 'GET',
      'callback' => array($this, 'jbls_get_experience_levels'),
      'permission_callback' => '__return_true',
    ]);
  }

  // Callback function for custom REST route
  public function jbls_get_jobs($request) {
    $args = [
      'post_type' => 'jbls_job',
      'posts_per_page' => -1,
    ];

    $jobs = get_posts($args);
    $data = [];

    foreach ($jobs as $job) {
      // Get the location terms for each job
      $locations = wp_get_post_terms($job->ID, 'jbls_location');

      // Prepare location data
      $location_data = null;
      if (!is_wp_error($locations) && !empty($locations)) {
        // Get the first term
        $first_location = $locations[0];
        $location_data = [
          'id' => $first_location->slug,
          'name' => $first_location->name,
        ];
      }

      // Get the experience level terms for each job
      $experience_levels = wp_get_post_terms($job->ID, 'jbls_experience_level');

      // Prepare experience level data
      $experience_level_data = null;
      if (!is_wp_error($experience_levels) && !empty($experience_levels)) {
        // Get the first term
        $first_experience_level = $experience_levels[0];
        $experience_level_data = [
          'id' => $first_experience_level->slug,
          'name' => $first_experience_level->name,
        ];
      }

      // Get the category terms for each job
      $categories = wp_get_post_terms($job->ID, 'jbls_category');

      // Prepare category data
      $category_data = null;
      if (!is_wp_error($categories) && !empty($categories)) {
        // Get the first term
        $first_category = $categories[0];
        $category_data = [
          'id' => $first_category->slug,
          'name' => $first_category->name,
        ];
      }

      // Get the type terms for each job
      $types = wp_get_post_terms($job->ID, 'jbls_type');

      // Prepare type data
      $type_data = null;
      if (!is_wp_error($types) && !empty($types)) {
        // Get the first term
        $first_type = $types[0];
        $type_data = [
          'id' => $first_type->slug,
          'name' => $first_type->name,
        ];
      }

      $data[] = [
        'id' => $job->ID,
        'modified_gmt' => $job->post_modified_gmt,
        'title' => $job->post_title,
        'content' => apply_filters('the_content', $job->post_content),
        'location' => $location_data,
        'category' => $category_data,
        'type' => $type_data,
        'experience_level' => $experience_level_data,
      ];
    }

    return new WP_REST_Response($data, 200);
  }

  // Callback function for custom REST route
  public function jbls_get_locations($request) {
    $args = [
      'taxonomy' => 'jbls_location',
      'hide_empty' => false,
    ];

    $terms = get_terms($args);
    $data = [];

    foreach ($terms as $term) {
      $data[] = [
        // Use slug as id
        'id' => $term->slug,
        'count' => $term->count,
        // Use html_entity_decode() to avoid html entities like &amp;
        'name' => html_entity_decode($term->name),
      ];
    }

    return new WP_REST_Response($data, 200);
  }

  // Callback function for custom REST route
  public function jbls_get_categories($request) {
    $args = [
      'taxonomy' => 'jbls_category',
      'hide_empty' => false,
    ];

    $terms = get_terms($args);
    $data = [];

    foreach ($terms as $term) {
      $data[] = [
        // Use slug as id
        'id' => $term->slug,
        'count' => $term->count,
        // Use html_entity_decode() to avoid html entities like &amp;
        'name' => html_entity_decode($term->name),
      ];
    }

    return new WP_REST_Response($data, 200);
  }

  // Callback function for custom REST route
  public function jbls_get_types($request) {
    $args = [
      'taxonomy' => 'jbls_type',
      'hide_empty' => false,
    ];

    $terms = get_terms($args);
    $data = [];

    foreach ($terms as $term) {
      $data[] = [
        // Use slug as id
        'id' => $term->slug,
        'count' => $term->count,
        // Use html_entity_decode() to avoid html entities like &amp;
        'name' => html_entity_decode($term->name),
      ];
    }

    return new WP_REST_Response($data, 200);
  }

  // Callback function for custom REST route
  public function jbls_get_experience_levels($request) {
    $args = [
      'taxonomy' => 'jbls_experience_level',
      'hide_empty' => false,
    ];

    $terms = get_terms($args);
    $data = [];

    foreach ($terms as $term) {
      $data[] = [
        // Use slug as id
        'id' => $term->slug,
        'count' => $term->count,
        // Use html_entity_decode() to avoid html entities like &amp;
        'name' => html_entity_decode($term->name),
      ];
    }

    return new WP_REST_Response($data, 200);
  }


  // Utility function that process the taxonomy term for the REST API response
  private function jbls_process_taxonomy_term($term_id)
  {
    $result = new stdClass();
    // Use slug as id
    $result->id = get_term($term_id)->slug;
    // Use html_entity_decode() to avoid html entities like &amp;
    $result->name = html_entity_decode(get_term($term_id)->name);
    return $result;
  }

  // Add a custom POST endpoint for the "jbls_application" post type
  public function jbls_modify_jbls_application_post_endpoint($endpoints)
  {
    $endpoints['/wp/v2/jbls-applications'] = array(
      'methods'  => 'POST',
      'callback' => array($this, 'jbls_application_post_callback'),
      'permission_callback' => '__return_true',
    );

    return $endpoints;
  }

  private function jbls_job_exists($job_id) {
    $args = array(
        'post_type' => 'jbls_job',
        'p' => $job_id,
    );
    $job_posts = get_posts($args);

    // If there is at least one post returned, it means the job post with the given ID exists
    return count($job_posts) > 0;
  }

  public function jbls_application_post_callback($request)
  {
    // Retrieve the nonce from the request headers
    $nonce = sanitize_text_field($request->get_header('X-WP-Nonce'));

    // Verify the nonce
    if (!wp_verify_nonce($nonce, 'wp_rest')) {
      return new WP_Error('nonce_verification_failed', 'Nonce verification failed', array('status' => 401));
    }

    // Sanitize & validate job_id
    $job_id = intval(sanitize_text_field($request['job_id']));
    if (empty($job_id) || !$this->jbls_job_exists($job_id)) {
      return new WP_Error('invalid_job_id', 'Invalid job ID.', array('status' => 400));
    }
    
    // Sanitize & validate name
    $name = sanitize_text_field($request['name']);
    if (empty($name)) {
      return new WP_Error('empty_name', 'Enter your name.', array('status' => 400));
    } elseif (strlen($name) < 2) {
      return new WP_Error('short_name', 'Use 2 characters or more for your name.', array('status' => 400));
    } elseif (strlen($name) > 70) {
      return new WP_Error('long_name', 'Use 70 characters or less for your name.', array('status' => 400));
    }

    // Sanitize & validate email
    $email = sanitize_email($request['email']);
    if (empty($email)) {
      return new WP_Error('empty_email', 'Enter your email.', array('status' => 400));
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return new WP_Error('invalid_email', 'Enter a valid email address.', array('status' => 400));
    }

    // Sanitize & validate cover
    $cover = sanitize_textarea_field($request['cover']);
    $max_length = 4000;
    if (empty($cover)) {
      return new WP_Error('empty_cover', 'Provide a cover letter.', array('status' => 400));
    } elseif (strlen($cover) > $max_length) {
      return new WP_Error('long_cover', "Cover letter should be no more than {$max_length} characters.", array('status' => 400));
    }

    // Sanitize & validate resume
    $files = $request->get_file_params();
    if (isset($files['resume']) && !empty($files['resume']['tmp_name'])) {
      $file = $files['resume'];

      // Validate file extension
      $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
      $allowed_extensions = ['pdf'];
      if (!in_array($file_extension, $allowed_extensions)) {
        return new WP_Error('invalid_file_extension', 'Invalid file extension. Please upload a .pdf file.', array('status' => 400));
      }

      // Validate MIME type
      $allowed_mime_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
      if (!in_array($file['type'], $allowed_mime_types)) {
        return new WP_Error('invalid_file_type', 'Invalid file type. Please upload a .pdf file.', array('status' => 400));
      }

      // Validate file size
      $max_file_size = 5000000; // 5MB
      if ($file['size'] > $max_file_size) {
        return new WP_Error('file_size_exceeded', 'File size is too large. Please upload a file that is 5MB or less.', array('status' => 400));
      }
    
      // The wp_handle_upload function takes the upload file array as an argument and returns an array with file information.
      $overrides = ['test_form' => false];  // This bypasses the normal form checks - as this isn't coming from a form
      $file = wp_handle_upload($files['resume'], $overrides);

      if (isset($file['error'])) {
        error_log('Error 1');
        return new WP_Error('upload_error', $file['error'], array('status' => 500));
      }

      // Use wp_insert_attachment to move the file to the uploads directory and add the appropriate database entries
      $attachment = array(
        'guid' => $file['url'],
        'post_mime_type' => $file['type'],
        'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['file'])),
        'post_content' => '',
        'post_status' => 'inherit'
      );

      $attachment_id = wp_insert_attachment($attachment, $file['file']);
      if (is_wp_error($attachment_id)) {
        error_log('Error 2');
        return new WP_Error('attachment_creation_failed', $attachment_id->get_error_message(), array('status' => 500));
      }

      require_once(ABSPATH . 'wp-admin/includes/image.php');

      $attachment_data = wp_generate_attachment_metadata($attachment_id, $file['file']);
      wp_update_attachment_metadata($attachment_id, $attachment_data);
    }

    // Sanitize and validate consent
    $consent = isset($request['consent']) && ($request['consent'] === true || $request['consent'] === 'true') ? true : false;
    if (!$consent) {
      return new WP_Error('invalid_consent', 'Consent must be provided.', array('status' => 400));
    }

    $new_jbls_application_id = wp_insert_post(array(
      'post_type' => 'jbls_application',
      'post_status' => 'publish',
    ));

    if ($new_jbls_application_id) {
      update_post_meta($new_jbls_application_id, 'job_id', $job_id);
      update_post_meta($new_jbls_application_id, 'name', $name);
      update_post_meta($new_jbls_application_id, 'email', $email);
      update_post_meta($new_jbls_application_id, 'cover', $cover);
      update_post_meta($new_jbls_application_id, 'consent', $consent);
      if (isset($attachment_id)) {
        update_post_meta($new_jbls_application_id, 'resume', $attachment_id);
      }
      return new WP_REST_Response('Application created successfully.', 201);
    } else {
      error_log('Error 3');
      return new WP_Error('application_creation_failed', 'Failed to create application.', array('status' => 500));
    }
  }
}
