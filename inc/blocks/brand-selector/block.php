<?php
/**
 * Brand Carousel Block
 *
 * @package falls-co
 * @since 1.0.0
 * 
 * @param array $block The block settings and attributes.
 */

// Block Data and settings:
$data = $block['data'] ?? array();
$select_brands = $data['select_brands'] ?? array();
$link_brand_to = is_admin() ? 'none' : ( $data['link_brand_to'] ?? 'work' );
$read_more_text = $data['read_more_text'] ?? 'Visit Story';
$align_text = $block['alignText'] ?? '';
// ID and class
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = $block['anchor'];
}
$class_name = 'brand-carousel';

// Block Styles and Customization:
$block_attributes = get_block_wrapper_attributes();

$text_color = $block['textColor'] ?? ( $block['style']['color']['text'] ?? false );
$background_color = $block['backgroundColor'] ?? ( $block['style']['color']['background'] ?? false );


// Set the mode manually - for some reason this is behaving strangely.
$mode = is_admin() ? ( $block['mode'] ?? 'edit' ) : 'preview';
$is_preview = $mode === 'preview' ? true : false;

/**
 * Start assembling Output
 * 
 * @var $output
 */
$output = '';
$has_content = true;

if ( $is_preview ) { 
 
  $output .= sprintf(
    '<div id="%1$s" %2$s>',
    esc_attr( $anchor ),
    $block_attributes
  );

  if ( is_admin() && empty( $select_brands ) ) {
    $image_class .= ' admin-preview-default';
    $has_content = false;

    $args = array(
      'post_type' => 'work',
      'posts_per_page' => 3,
      'post_status' => 'publish',
      'fields' => 'ids'
    );
    $brand_query = new WP_Query( $args );
    $brands = $brand_query->posts ?? array();

    if( $brands && is_array( $brands ) ) {
      $select_brands = $brands;
    }
  }
} 

// Add warning if in admin and no brands are selected.
if ( ! $has_content ) {
  $output .= '<h3 class="action-required">Please select Brands to display in this section.</h3>';
}

$slides = '';
if ( $select_brands && is_array( $select_brands ) ) {
foreach( $select_brands as $brand_id ) {
  /**
   * @var $logo_id
   * @var $brand_name
   * @var $permalink
   * @var $ext_link
   * @var $alt_text
   */

    $brand_id = intval( $brand_id );
    $logo_id = intval( get_post_meta( $brand_id, 'brand_logo', true ) );
    $logo = wp_get_attachment_image_url( $logo_id, 'medium');

    if ( empty( $logo ) ) {
      $logo = FALLS_CO_URL . '/assets/images/brand-no-logo.png';
    }

    $brand_name = get_the_title( $brand_id );
    $permalink = get_the_permalink( $brand_id );
    $ext_link = get_post_meta( $brand_id, 'brand_external_link', true );
    $alt_text = get_post_meta( $logo_id , '_wp_attachment_image_alt', true );


    $link = '';
    switch( $link_to ) {
      case 'none':
        $link = '';
        break;
      case 'ext':
        $link = $ext_link;
        break;
      case 'work':
        default:
        $link = $permalink; 
        break;
    }


    $img_before = '';
    $img_after = '';
    if ( ! empty( $link ) ) {
      $img_before = sprintf(
        '<a href="%1$s" target="_blank">',
        esc_url( $link )
      );

      $img_after = '</a>';
    }

    $slides .= sprintf(
      '<div class="brand-image has-text-align-%1$s">%2$s<img alt="%3$s" src="%4$s" title="%5$s" class="%6$s"/><div class="brand-link">%7$s</div> %8$s</div>',
      esc_attr( $align_text ),
      $img_before,
      esc_attr( $alt_text ),
      esc_url( $logo ),
      esc_attr( $brand_name ),
      esc_attr( $image_class ),
      $read_more_text,
      $img_after
    );
  }
}
  
$output .= $slides;

if ( $is_preview ) { 
  $output .= '</div>';
} 

if ( ! empty( $select_brands ) ) {
  echo $output;
}

