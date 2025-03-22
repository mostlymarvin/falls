<?php
/**
 * Title: Falls Logo: White
 * Slug: falls-co/falls-logo-white
 * Categories: theme, images
 * Block Types: core/image

 * @package falls-co
 * @since 1.0.0
 */

 $logo_dest = get_home_url();
 $logo_uri = FALLS_CO_URL . '/assets/images/falls_logo_white@2x.png';
?>
<!-- wp:image {"lightbox":{"enabled":false},"width":"400px","sizeSlug":"full","linkDestination":"custom","className":"falls-logo-white"} -->
<figure class="wp-block-image size-full is-resized falls-logo-white"><a href="<?php echo esc_url( $logo_dest ); ?>"><img src="<?php echo esc_url( $logo_uri ); ?>" alt="Falls &amp; Co logo, white" style="width:400px"/></a></figure>
<!-- /wp:image -->