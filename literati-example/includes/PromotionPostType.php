<?php
if (!defined('ABSPATH')) {
  exit;
}

function literati_add_promotion_meta_boxes()
{
  add_meta_box(
    'promotion_details',
    'Promotion Details',
    'literati_promotion_meta_box_html',
    'promotion'
  );
}
add_action('add_meta_boxes', 'literati_add_promotion_meta_boxes');


function literati_promotion_meta_box_html($post)
{
  $header = get_post_meta($post->ID, '_literati_promotion_header', true);
  $text = get_post_meta($post->ID, '_literati_promotion_text', true);
  $button_text = get_post_meta($post->ID, '_literati_promotion_button_text', true);
  $button_url = get_post_meta($post->ID, '_literati_promotion_image', true);

  wp_nonce_field(plugin_basename(__FILE__), 'promotion_details_nonce');

  echo '<label for="promotion_header">Header</label>' .
    '<input type="text" id="promotion_header" name="promotion_header" value="' . esc_attr($header) . '" class="widefat">' .
    '<label for="promotion_text">Text</label>' .
    '<textarea id="promotion_text" name="promotion_text" class="widefat" rows="4">' . esc_textarea($text) . '</textarea>' .
    '<label for="promotion_button_text">Button Text</label>' .
    '<input type="text" id="promotion_button_text" name="promotion_button_text" value="' . esc_attr($button_text) . '" class="widefat">' .
    '<label for="promotion_image">Image</label>' .
    '<input type="file" id="promotion_image" name="promotion_image" value="' . esc_url($button_url) . '" class="widefat">';
}

function literati_save_promotion_meta_box_data($post_id)
{
  if (!isset($_POST['promotion_details_nonce']) || !wp_verify_nonce($_POST['promotion_details_nonce'], plugin_basename(__FILE__))) {
    return;
  }

  if ('promotion' != $_POST['post_type']) {
    return;
  }

  if (!current_user_can('edit_post', $post_id)) {
    return;
  }

  update_post_meta($post_id, '_literati_promotion_header', sanitize_text_field($_POST['promotion_header']));
  update_post_meta($post_id, '_literati_promotion_text', sanitize_textarea_field($_POST['promotion_text']));
  update_post_meta($post_id, '_literati_promotion_button_text', sanitize_text_field($_POST['promotion_button_text']));
 
  if (!empty($_FILES['promotion_image']['name'])) {
    $file = $_FILES['promotion_image'];
    $supported_types = array('image/jpeg', 'image/png', 'image/gif');
    
    if (in_array($file['type'], $supported_types)) {
        $upload = wp_upload_bits($file['name'], null, file_get_contents($file['tmp_name']));

        if (isset($upload['error']) && $upload['error'] != 0) {
            wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
        } else {
            $attachment = array(
                'post_mime_type' => $file['type'],
                'post_title' => sanitize_file_name(str_replace(" ","-",$file["name"])),
                'post_content' => '',
                'post_status' => 'inherit'
            );

            $attach_id = wp_insert_attachment($attachment, $upload['file'], $post_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $upload['file']);
            wp_update_attachment_metadata($attach_id, $attach_data);
            update_post_meta($post_id, '_literati_promotion_image',sanitize_file_name(str_replace(" ","-",$file['name'])));
        }
    } else {
        wp_die('The file type that you have uploaded is not a JPEG, PNG, or GIF.');
    }
  }
}
add_action('save_post', 'literati_save_promotion_meta_box_data');


function literati_add_post_enctype() {
  echo ' enctype="multipart/form-data"';
}
add_action('post_edit_form_tag', 'literati_add_post_enctype');



function register_promotion_post_type()
{
  $args = array(
    'labels' => array(
      'name' => 'Promotions',
      'singular_name' => 'Promotion',
    ),
    'public' => true,
    'has_archive' => true,
    'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
    'menu_icon' => 'dashicons-megaphone',
  );
  register_post_type('promotion', $args);
}
add_action('init', 'register_promotion_post_type');
