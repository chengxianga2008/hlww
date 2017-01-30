<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
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
	exit;
}

wc_print_notices();

# start: modified by Arlind Nushi
do_action('laborator_woocommerce_before_wrapper');

?>
<h1 class="myaccount-title"><?php _e('My Account', 'woocommerce'); ?></h1>

<div class="myaccount-env">

<?php
# end: modified by Arlind Nushi

	
	/**
	 * My Account navigation.
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_navigation' ); 
	?>
	
	<div class="woocommerce-MyAccount-content">
		<?php
			/**
			 * My Account content.
			 * @since 2.6.0
			 */
			do_action( 'woocommerce_account_content' );
		?>
	</div>

</div>
<?php
	
# start: modified by Arlind Nushi
do_action('laborator_woocommerce_after_wrapper');
# end: modified by Arlind Nushi