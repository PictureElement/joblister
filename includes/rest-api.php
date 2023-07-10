<?php

// If this file is access directly, abort!
defined('ABSPATH') or die('Unauthorized Access');

// Utility function that process the taxonomy term for the REST API response
function jl_process_taxonomy_term($term_id) {
  $result = new stdClass();
  // Use slug as id
  $result->id = get_term($term_id)->slug;
  // Use html_entity_decode() to avoid html entities like &amp;
  $result->name = html_entity_decode(get_term($term_id)->name);
  return $result;
}

// Filter the "jl_job" post data for the REST API response
function jl_filter_rest_jl_job($response) {

  $location = '';
  if (isset($response->data['jl-locations'][0])) {
    $location = jl_process_taxonomy_term($response->data['jl-locations'][0]);
  }

  $category = '';
  if (isset($response->data['jl-categories'][0])) {
    $category = jl_process_taxonomy_term($response->data['jl-categories'][0]);
  }
  
  $type = '';
  if (isset($response->data['jl-types'][0])) {
    $type = jl_process_taxonomy_term($response->data['jl-types'][0]);
  }

  $experience_level = '';
  if (isset($response->data['jl-experience-levels'][0])) {
    $experience_level = jl_process_taxonomy_term($response->data['jl-experience-levels'][0]);
  }

  return [
    'id' => $response->data['id'],
    'modified' => $response->data['modified'],
    'modified_gmt' => $response->data['modified_gmt'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'title' => html_entity_decode($response->data['title']['rendered']),
    'content' => html_entity_decode($response->data['content']['rendered']),
    'location' => $location,
    'category' => $category,
    'type' => $type,
    'experience_level' => $experience_level,
  ];
}
add_filter('rest_prepare_jl_job', 'jl_filter_rest_jl_job');

// Filter the "jl_location" taxonomy data for the REST API response
function jl_filter_rest_jl_location($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_location', 'jl_filter_rest_jl_location');

// Filter the "jl_category" taxonomy data for the REST API response
function jl_filter_rest_jl_category($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_category', 'jl_filter_rest_jl_category');

// Filter the "jl_type" taxonomy data for the REST API response
function jl_filter_rest_jl_type($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_type', 'jl_filter_rest_jl_type');

// Filter the "jl_experience_level" taxonomy data for the REST API response
function jl_filter_rest_jl_experience_level($response) {
  return [
    // Use slug as id
    'id' => $response->data['slug'],
    'count' => $response->data['count'],
    // Use html_entity_decode() to avoid html entities like &amp;
    'name' => html_entity_decode($response->data['name']),
  ];
}
add_filter('rest_prepare_jl_experience_level', 'jl_filter_rest_jl_experience_level');

// Add a custom POST endpoint for the "jl_application" post type 
function jl_modify_jl_application_post_endpoint( $endpoints ) {
  $endpoints['/wp/v2/jl-applications'] = array(
      'methods'  => 'POST',
      'callback' => 'jl_application_post_callback',
  );

  return $endpoints;
}
add_filter( 'rest_endpoints', 'jl_modify_jl_application_post_endpoint' );

function jl_application_post_callback( $request ) {
  // Create a new application
  $name = sanitize_text_field( $request['name'] );
  $email = sanitize_email( $request['email'] );
  $job_id = sanitize_text_field( $request['job_id'] );
  
  $new_jl_application_id = wp_insert_post(array (
    'post_type' => 'jl_application',
    'name' => $name,
    'email' => $email,
    'job_id' => $job_id,
    'post_status' => 'publish',
  ));

  if ( $new_jl_application_id ) {
    update_post_meta( $new_jl_application_id, 'name', $name );
    update_post_meta( $new_jl_application_id, 'email', $email );
    update_post_meta( $new_jl_application_id, 'job_id', $job_id );
    return new WP_REST_Response( 'Application created successfully.', 201 );
  } else {
    return new WP_REST_Response( 'Failed to create application.', 500 );
  }
}
