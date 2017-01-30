<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $shown_id;

# start: modified by Arlind Nushi
wp_enqueue_script(array('nivo-lightbox'));
wp_enqueue_style(array('nivo-lightbox', 'nivo-lightbox-default'));

$attachment_ids = $product->get_gallery_attachment_ids();
$zoom = get_data('shop_single_fullscreen') ? '<span class="zoom-image"><i class="glyphicon glyphicon-fullscreen"></i></span>' : '';
# end: modified by Arlind Nushi
?>
<div class="images hidden">
	<div class="thumbnails"></div>
</div>

<div class="main-images product-images<?php echo count( $attachment_ids ) == 0 ? ' images' : ''; // Modified by Arlind Nushi ?>">
	<?php
	if(is_wishlist_supported()):

		if($product->is_type('external') == false && $product->is_in_stock()):

			global $add_to_wishlist_args;

			$lists = WC_Wishlists_User::get_wishlists();
			$wishlisted = woocommerce_wishlists_get_wishlists_for_product($product->id);
			?>
			<div class="wish-list<?php echo $wishlisted ? ' wishlisted' : ''; ?>">

				<a href="#" class="glyphicon glyphicon-heart wl-add-to<?php echo ! $lists ? ' wl-add-to-single' : ''; ?>" data-listid="" data-toggle="tooltip" data-placement="left" title="<?php echo esc_attr(apply_filters('woocommerce_wishlist_add_to_wishlist_text', WC_Wishlists_Settings::get_setting('wc_wishlist_button_text', 'Add to wishlist'), $product->product_type)); ?>"></a>

			</div>
			<?php

		endif;


	elseif(is_yith_wishlist_supported()):

		oxygen_yith_wcwl_add_to_wishlist();

	endif;
	?>
	
	<div id="main-image-slider">
	<?php
		if ( has_post_thumbnail() || count($attachment_ids) ) {

			# start: modified by Arlind Nushi
			if(has_post_thumbnail())
				$shown_id = get_post_thumbnail_id();
			# end: modified by Arlind Nushi
			
			$attachment_count = count( $attachment_ids );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'oxygen_shop_single_thumb', 'shop-thumb-4' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			echo apply_filters(
				'woocommerce_single_product_image_html',
				sprintf(
					'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-lightbox-gallery="main-images">%s %s</a>',
					esc_url( $props['url'] ),
					esc_attr( $props['caption'] ),
					$image,
					$zoom
				),
				$post->ID
			);
		}
		
		if ( $attachment_ids ) {
			
			if( ! has_post_thumbnail())
				array_shift($attachment_ids);
			
			$attachment_ids = array_diff($attachment_ids, array(get_post_thumbnail_id()));
			
			foreach ( $attachment_ids as $attachment_id ) {
				
				$props = wc_get_product_attachment_props( $attachment_id, $post );
				
				echo apply_filters(
					'woocommerce_single_product_image_html',
					sprintf(
						'<a href="%s" itemprop="image" class="woocommerce-main-image zoom hidden" title="%s" data-lightbox-gallery="main-images">%s %s</a>',
						esc_url( $props['url'] ),
						esc_attr( $props['caption'] ),
						wp_get_attachment_image( $attachment_id, apply_filters( 'oxygen_shop_single_thumb', 'shop-thumb-4' ), 0, $props ),
						$zoom
					),
					$post->ID
				);
			}
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}
	?>
	</div>
	
	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
</div>
