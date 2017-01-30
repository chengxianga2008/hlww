<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

# start: modified by Arlind Nushi
$category_columns = apply_filters( 'oxygen_shop_category_columns', 4 );
$category_class = 'product-category product lab_wpb_banner_2 wpb_content_element banner-type-2';

switch ( $category_columns ) {
	case 2:
		$category_columns = 'col-sm-6 col-xs-6';
		break;
	
	case 3:
		$category_columns = 'col-sm-4 col-xs-6';
		break;
	
	case 4:
	default: 
		$category_columns = 'col-sm-3 col-xs-6';
}
# end: modified by Arlind Nushi
?>
<div class="<?php echo "products-category-entry {$category_columns}"; ?>">
	<div <?php wc_product_cat_class( $category_class, $category ); // Modified by Arlind Nushi ?>>
		<?php
		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		do_action( 'woocommerce_before_subcategory', $category );
	
		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action( 'woocommerce_before_subcategory_title', $category );
	
		/**
		 * woocommerce_shop_loop_subcategory_title hook.
		 *
		 * @hooked woocommerce_template_loop_category_title - 10
		 */
		do_action( 'woocommerce_shop_loop_subcategory_title', $category );
	
		/**
		 * woocommerce_after_subcategory_title hook.
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );
	
		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</div>