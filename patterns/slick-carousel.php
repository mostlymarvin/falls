<?php
/**
 * Title: Slick Carousel
 * Slug: falls-co/slick-carousel
 * Categories: featured
 * 
 * @package falls-co
 * @since 1.0.0
 */

$logo_dest = get_home_url();
$logo_uri = FALLS_CO_URL . '/assets/images/placeholder-square.jpeg';

?>
<!-- wp:group {"lock":{"move":false,"remove":false},"metadata":{"name":"Slides"},"className":"slick-carousel","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"default"}} -->
<div class="wp-block-group slick-carousel" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:cover {"url":"<?php echo esc_url($logo_uri ); ?>","dimRatio":50,"customOverlayColor":"#5e5e5e","isUserOverlayColor":false,"minHeight":250,"contentPosition":"bottom left","metadata":{"name":"Slide"},"className":"slick-slide","layout":{"type":"default"}} -->
<div class="wp-block-cover has-custom-content-position is-position-bottom-left slick-slide" style="min-height:250px"><span aria-hidden="true" class="wp-block-cover__background has-background-dim" style="background-color:#5e5e5e"></span><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url($logo_uri ); ?>" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":3,"metadata":{"name":"Slide Title Link"}} -->
<h3 class="wp-block-heading has-text-align-center"><a href="<?php echo esc_url( $logo_dest ); ?>">Cover Text</a></h3>
<!-- /wp:heading --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:group -->