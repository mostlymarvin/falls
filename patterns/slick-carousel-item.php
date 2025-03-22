<?php
/**
 * Title: Slick Carousel Item
 * Slug: falls-co/slick-carousel-item
 * Categories: featured
 * 
 * @package falls-co
 * @since 1.0.0
 */

 $logo_dest = get_home_url();
 $logo_uri = FALLS_CO_URL . '/assets/images/placeholder-square.jpeg';
?>
<!-- wp:cover {"url":"<?php echo esc_url($logo_uri ); ?>","dimRatio":50,"customOverlayColor":"#5e5e5e","isUserOverlayColor":false,"minHeight":250,"contentPosition":"bottom left","metadata":{"name":"Slide"},"className":"slick-slide","layout":{"type":"default"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left slick-slide" style="min-height:250px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="background-color:#5e5e5e"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url($logo_uri ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"metadata":{"name":"Slide Title Link"}} -->
<h3 class="wp-block-heading has-text-align-center"><a href="<?php echo esc_url( $logo_dest ); ?>">Cover Text</a></h3>
<!-- /wp:heading --></div></div>
<!-- /wp:cover -->