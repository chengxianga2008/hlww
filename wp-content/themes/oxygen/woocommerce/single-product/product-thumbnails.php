<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
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


global $post, $product, $woocommerce, $shown_id;

$attachment_ids = $product->get_gallery_attachment_ids();

# start: modified by Arlind Nushi
$auto_play = absint(get_data('shop_single_auto_rotate_image')) * 1000;
# end: modified by Arlind Nushi

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

	wp_enqueue_script('owl-carousel');
	wp_enqueue_style('owl-carousel-theme');

	if($shown_id)
	{
		$first_attachment_link = wp_get_attachment_url( reset($attachment_ids) );
		$thumbnail_attachment_link = wp_get_attachment_url($shown_id);

		if($first_attachment_link != $thumbnail_attachment_link)
			$attachment_ids = array_merge(array($shown_id), $attachment_ids);
	}
	?>
	<div class="thumbnails" id="image-thumbnails-carousel" data-autoplay="<?php echo $auto_play; ?>">
		<div class="row">
		<?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop === 0 || $loop % $columns === 0 ) {
				$classes[] = 'first';
			}

			if ( ( $loop + 1 ) % $columns === 0 ) {
				$classes[] = 'last';
			}
			
			# start: modified by Arlind Nushi
			$classes[] = 'product-thumb col-md-3 zoom';
			# end: modified by Arlind Nushi

			$image_class = implode( ' ', $classes );
			$props       = wc_get_product_attachment_props( $attachment_id, $post );
			
			# start: modified by Arlind Nushi
			if ( ! isset( $props['class'] ) ) {
				$props['class'] = '';
			}
			
			$props['class'] .= ' lazyOwl';
			# end: modified by Arlind Nushi

			if ( ! $props['url'] ) {
				continue;
			}

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a href="%s" class="%s" title="%s">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $image_class ),
					esc_attr( $props['caption'] ),
					str_replace( ' src=', ' data-src=', wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props ) )
				),
				$attachment_id,
				$post->ID,
				esc_attr( $image_class )
			);

			$loop++;
		}
		
		?>
		</div>
	</div>
	<?php
}
