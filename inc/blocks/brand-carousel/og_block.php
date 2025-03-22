<?php
/**
 * Brand Carousel Block
 *
 * @package falls-co
 * @since 1.0.0
 * 
 * @param array $block The block settings and attributes.
 */

// ID
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = $block['anchor'];
}
$class_name = 'brand-carousel';

// Block Data and settings:
$data = $block['data'] ?? array();

$selected_brands = $data['select_brands'] ?? array();
$link_brand = $data['link_brand_to_work'] ?? false;
$show_brand_name = $data['show_brand_name'] ?? false;
$show_brand_logo = intval( $data['show_brand_logo'] ?? false );

//Position and behavior of logo (hide until hover, align top/bottom/center)
$brand_name_position = 'slick-title-' . sanitize_title( $data['brand_name_position'] ?? 'center' );
$hide_name_unless = $data['hide_name_unless'] ?? false;
$link_to = is_admin() ? 'none' : ( $data['link_brand_to'] ?? 'work' );

// Block Styles and Customization:
$block_attributes = get_block_wrapper_attributes();
$text_color = $block['textColor'] ?? ( $block['style']['color']['text'] ?? false );
$background_color = $block['backgroundColor'] ?? ( $block['style']['color']['background'] ?? false );


//Single Slide: TITLE
$title_wrap_class = 'carousel-title ' . $brand_name_position;
// Add class tto name if only visible on hover
if ( $hide_name_unless ) {
  $title_wrap_class .= ' only-hover';
}
$title_class = array();
$title_style = array();

// If showing both logo and brand, remove the slide background color so that the name shows.
// To set alternate background, wrap block into a group.
if ( $show_brand_logo && $show_brand_name ) {

  if ( ! empty( $text_color ) ) {
    $title_class[] = 'has-text-color';

    if ( ! empty( $block['textColor'] ) ) {
      $title_class[] = 'has-' . esc_attr( $block['textColor'] ) . '-color';
    } else {
      $title_style[] = 'color: ' . sanitize_hex_color( $text_color ) . ';';
    }
  }
  // Background color classes
  if ( ! empty( $background_color ) ) {
    $title_class[] = ' has-background';

    if ( ! empty( $block['backgroundColor'] ) ) {
      $title_class[] = ' has-' . esc_attr( $block['backgroundColor'] ) . '-background-color';
    } else {
      $title_style[] = ' background-color: ' . sanitize_hex_color( $background_color ) . ';';
    }
  }
  // Strip the color and style tags that we are replicating to the title element.
  $block_attributes = str_replace( $title_class, " ", $block_attributes );
  $block_attributes = str_replace( $title_style, " ", $block_attributes );
}

// Set the mode manually - for some reason this is behaving strangely.
$mode = is_admin() ? ( $block['mode'] ?? 'edit' ) : 'preview';
$is_preview = $mode === 'preview' ? true : false;

/**
 * Start assembling Output
 * 
 * @var $output
 */
$output = '';

$image_class = 'carousel-image';
$has_content = 'true';

// If in admin, and no brands selected, handle dummy output.
if ( is_admin() && empty( $selected_brands ) ) {
  $image_class .= ' admin-preview-default';
  $has_content = false;

  $args = array(
    'post_type' => 'work',
    'posts_per_page' => 8,
    'post_status' => 'publish',
    'fields' => 'ids'
  );
  $brand_query = new WP_Query( $args );
  $brands = $brand_query->posts ?? array();

  if( $brands && is_array( $brands ) ) {
    $selected_brands = $brands;
  }
  wp_reset_postdata();
}

/**
 * Begin output
 *
 * @var [type]
 */
if ( $is_preview ) { 
 
  $output .= sprintf(
    '<div id="%1$s" %2$s>',
    esc_attr( $anchor ),
    $block_attributes
  );
} 

$output .= '<div class="slick-carousel">';

// Add warning if in admin and no brands are selected.
if ( ! $has_content ) {
  $output .= '<h5 class="action-required">Please select Brands to display in this carousel.</h5>';
}

$slides = '';
foreach( $selected_brands as $brand_id ) {
  /**
   * Slide Data
   * 
   * @var $logo_id
   * @var $brand_name
   * @var $permalink
   * @var $ext_link
   * @var $alt_text
   */

    $logo_id = intval( get_post_meta( $brand_id, 'brand_logo', true ) );
    $logo = wp_get_attachment_image_url( $logo_id, 'medium');

    if ( empty( $logo_id )  ) {

      if ( is_admin() ) {
        $logo = 'https://placehold.co/500x500?text=Logo%20Placeholder';
      } else {
        $logo = 'https://placehold.co/500x500/transparent/transparent/?text=Logo%20Placeholder';
      }
    }

    $brand_name = get_the_title( $brand_id );
    $permalink = get_the_permalink( $brand_id );
    $ext_link = get_post_meta( $brand_id, 'brand_external_link', true );
    $alt_text = get_post_meta( $logo_id , '_wp_attachment_image_alt', true );

    $img_before = '';
    $img_after = '';

    switch( $link_to ) {
      case 'none':
        
        break;
      case 'ext':
        $img_before = sprintf(
          '<a class="carousel-link" target="_blank" href="%1$s">',
          $ext_link
        );
        $img_after = '</a>';      
      
        break;
      case 'work':
        default:
        $img_before = sprintf(
          '<a class="carousel-link" target="_blank" href="%1$s">',
          $permalink
        );
        $img_after = '</a>';      
        break;
    }

    $slide_title = '';
    if ( intval( $show_brand_name )  === 1 ) {

      if ( is_array( $title_class ) ) {
        $title_class = implode( ' ', $title_class );
      }
      
      if ( ! $logo_id  && $show_brand_logo ) {
        $title_class = $title_class . ' empty-logo';
      }
      $slide_title = sprintf(
        '<div class="%1$s"><span class="%2$s" style="%3$s">%4$s</span></div>',
        esc_attr( $title_wrap_class ),
        esc_attr( $title_class ),
        implode( ' ', $title_style ),
        esc_html( $brand_name )
      );
    }

    $slides .= sprintf(
      '%6$s<img alt="%1$s" src="%2$s" id="brand-%3$s" title="%4$s" class="%5$s"/> %7$s %8$s',
      esc_attr( $alt_text ),
      esc_url( $logo ),
      esc_attr( $brand_id ), 
      esc_attr( $brand_name ),
      esc_attr( $image_class ),
      $img_before,
      $slide_title,
      $img_after
    );
  }
  
$output .= $slides . '</div>';

if ( $is_preview ) { 
  $output .= '</div>';
} 

if ( ! empty( $selected_brands ) ) {
  echo $output;
}

