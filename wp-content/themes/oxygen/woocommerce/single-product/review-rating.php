<?php
/**
 * The template to display the reviewers star rating in reviews
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $comment;
$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

if ( $rating && get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) { ?>
	
	<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
	
		<div class="rating filled-<?php echo absint($rating); ?>">
			<span class="glyphicon glyphicon-star star-1"></span>
			<span class="glyphicon glyphicon-star star-2"></span>
			<span class="glyphicon glyphicon-star star-3"></span>
			<span class="glyphicon glyphicon-star star-4"></span>
			<span class="glyphicon glyphicon-star star-5"></span>
		</div>
		
	</div>

<?php }
