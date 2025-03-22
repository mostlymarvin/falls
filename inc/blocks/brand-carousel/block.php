<?php
/**
 * Brand Carousel Block
 *
 * @package falls-co
 * @since 1.0.0
 * 
 * @param array $block The block settings and attributes.
 */

/**
 * Dependencies
 *
 * - Helper functions for this Block.
 */
require_once FALLS_CO_PATH . '/inc/blocks/helper-functions.php';

/**
 * Attributes
 * 
 * @var string   $anchor                 block anchor.
 * @var array    $data            block attributes
 *
 * @var string   $background_color
 * @var string   $brand_name_position
 * @var string   $hide_name_unless
 * @var boolean  $hide_name_unless
 * @var array    $selected_brands
 * @var boolean  $show_brand_logo
 * @var boolean  $show_brand_name
 * @var string   $text_color
 * 
 */
$anchor              = $block['anchor'] ?? false;
$data                = $block['data'] ?? array();

$background_color    = $block['backgroundColor'] ?? ( $block['style']['color']['background'] ?? false );
$brand_name_position = 'slick-title-' . sanitize_title( $data['brand_name_position'] ?? 'center' );
$hide_name_unless    = $data['hide_name_unless'] ?? false;
$link_to             = $data['link_brand_to'] ?? 'work';
$selected_brands     = $data['select_brands'] ?? array();
$show_brand_logo     = intval( $data['show_brand_logo'] ?? false );
$show_brand_name     = $data['show_brand_name'] ?? false;
$text_color          = $block['textColor'] ?? ( $block['style']['color']['text'] ?? false );

/**
 * Mode
 *
 * @var string  $mode          choice of: preview/edit/auto
 * @var bool    $is_preview    whether or not we are rendering the block preview.
 */
$mode       = is_admin() ? ( $block['mode'] ?? 'edit' ) : 'preview';
$is_preview = $mode === 'preview' ? true : false;

/**
 * Assemble output classes and modify block wrapper attributes.
 * 
 * @var string $block_attributes
 */


$block_class = 'slick-carousel';
$block_attributes = get_block_wrapper_attributes( array( 'class' => $block_class ) );
$image_class      = 'carousel-image';
$title_class      = array();
$title_style      = array();
$title_wrap_class = 'carousel-title ' . $brand_name_position;

// Title class
if ( $show_brand_logo && $show_brand_name ) {

  // Title wrap class.
  if ( $hide_name_unless ) {
    $title_wrap_class .= ' only-hover';
  }

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

// if the title class is an array, flatten it.
if ( is_array( $title_class ) && ! empty( $title_class ) ) {
  $title_class = implode( ' ', $title_class );
}

$block_data = '';
if ( is_array( $selected_brands ) && ! empty( $selected_brands ) ) {
  $show_slides         = 8;
  // Make sure we have at least 8 slides. Add class if fewer.
  $slide_count = count( $selected_brands );
  // How many slides to shpw?
  if ( $slide_count < 8 ) { 
    $block_data = $slide_count;
  }
}

/**
 * Get Dummy Data, if we are in the admin and there are no brands selected.
 *
 * @var mixed bool/array $items - individual page navigation items
 */
if ( is_admin() && empty( $selected_brands ) ) {

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
 * Get data needed for selected brands and format the output.
 * 
 * @var string $slides
 * @var array  $brand_data
 */
$slides = '';
$brand_data = falls_get_carousel_data( $selected_brands );

if ( ! empty( $brand_data ) && is_array( $brand_data ) ) {

  foreach( $brand_data as $brand ) {
    
    $alt_text     = $brand['alt_text'] ?? '';
    $brand_id     = $brand['brand_id'] ?? '';
    $brand_name   = $brand['brand_name'] ?? '';
    $ext_url      = $brand['ext_url'] ?? '';
    $img_after    = '';
    $img_before   = '';
    $logo_url     = $brand['logo_url'] ?? '';
    $permalink    = $brand['permalink'] ?? '';

    /**
     * Add link to approrpirate URL, based on link type:
     * If in the admin, link to nothing.
     *
     * @var string $link_to
     */
    switch( $link_to ) {
      case 'none':
        break;
      case 'ext':
        //if ( ! empty( $ext_url ) ) {
          $img_before = sprintf(
            '<a class="carousel-link" target="_blank" href="%1$s">',
            esc_url( $ext_url )
          );
          $img_after = '</a>';   
        //}   
      
        break;
      case 'work':
        default:
       // if ( ! empty( $permalink ) ) {
          $img_before = sprintf(
            '<a class="carousel-link" target="_blank" href="%1$s">',
            esc_url( $permalink )
          );
          $img_after = '</a>';      
       // }
        break;
    }

    /**
     * Slide title
     *
     * @var string $slide_title
     */
    $slide_title = '';
    // If we are showing the brand name:
    if ( ! empty( $show_brand_name )) {

      // If there is no logo ID and we are supposed to show a logo, add a class.
      if ( empty( $logo_id ) && $show_brand_logo ) {
        //$add_class = ' empty-logo';
      }
      // Assemble the title
      $slide_title = sprintf(
        '<div class="%1$s"><span class="%2$s %3$s" style="%4$s">%5$s</span></div>',
        esc_attr( $title_wrap_class ),
        esc_attr( $title_class ),
        esc_attr( $add_class ),
        implode( ' ', $title_style ),
        esc_html( $brand_name )
      );
    }

    //Put it all together.
    $slides .= sprintf(
      '%6$s<img alt="%1$s" src="%2$s" id="brand-%3$s" title="%4$s" class="%5$s"/> %7$s %8$s',
      esc_attr( $alt_text ),
      esc_url( $logo_url ),
      esc_attr( $brand_id ), 
      esc_attr( $brand_name ),
      esc_attr( $image_class ),
      $img_before,
      $slide_title,
      $img_after
    );
  }
} else {
  if ( is_admin() ) {
  $slides = '<h5 class="action-required">Please select Brands to display in this carousel.</h5>';
  } else {
  $slides = false;
  }
}

/**
 * Begin output
 *
 * @var string $output
 */
$output = '';

if ( $is_preview ) { 
 
  $output .= sprintf(
    '<div id="%1$s" %2$s data-brands="%3$s">',
    esc_attr( $anchor ),
    $block_attributes,
    $block_data
  );
} 

$output .= $slides;

if ( $is_preview ) { 
  $output .= '</div>';
} 

// Do not output empty slider on front end.
if ( ! empty( $slides ) ) {
  echo $output;
}


