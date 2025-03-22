<?php
/**
 * Title: Slick Slider
 * Slug: falls-co/slick-slider
 * Categories: featured
 * 
 * @package falls-co
 * @since 1.0.0
 */

  $img_uri = FALLS_CO_URL . '/assets/images/placeholder.jpeg';

?>
<!-- wp:media-text {"align":"full","mediaPosition":"right","mediaId":4800,"mediaLink":"<?php echo esc_url($img_uri);?>","mediaType":"image","imageFill":true,"lock":{"move":true,"remove":false},"metadata":{"categories":["theme","posts","media","featured","text"],"patternName":"falls-co/slick-slider","name":"Media Text - Slider"},"className":"has-base-background-color","style":{"spacing":{"margin":{"top":"0px"}}},"backgroundColor":"white"} -->
<div class="wp-block-media-text alignfull has-media-on-the-right is-stacked-on-mobile is-image-fill-element has-base-background-color has-white-background-color has-background" style="margin-top:0px"><div class="wp-block-media-text__content"><!-- wp:group {"lock":{"move":true,"remove":true},"metadata":{"name":"Slides"},"className":"slick-slides","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|70","left":"0","right":"0"},"margin":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained","contentSize":"540px","wideSize":"700px"}} -->
<div class="wp-block-group slick-slides" style="margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--30);padding-top:var(--wp--preset--spacing--60);padding-right:0;padding-bottom:var(--wp--preset--spacing--70);padding-left:0"><!-- wp:group {"lock":{"move":true,"remove":true},"metadata":{"name":"Slide"},"className":"slick-slide","layout":{"type":"default"}} -->
<div class="wp-block-group slick-slide"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Slide Title</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"Content…"} -->
<p>For each slide in this slideshow, create a slick-slide block within this container, or duplicate this slide. The footer links will automatically be generated based on the titles of each slide.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"placeholder":"Content…"} -->
<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Nullam quis risus eget urna mollis ornare vel eu leo. Curabitur blandit tempus porttitor. Nullam quis risus eget urna mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div><figure class="wp-block-media-text__media"><img src="<?php echo esc_url($img_uri);?>" alt="" class="wp-image-4800 size-full" style="object-position:50% 50%"/></figure></div>
<!-- /wp:media-text -->