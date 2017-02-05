<?php
/**
 *	Oxygen WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

# Constants
define('THEMEDIR', 		get_template_directory() . '/');
define('THEMEURL', 		get_template_directory_uri() . '/');
define('THEMEASSETS',	THEMEURL . 'assets/');
define('TD', 			'oxygen');
define('STIME',			microtime(true));


# Theme Content Width
$content_width = ! isset($content_width) ? 1170 : $content_width;


# Initial Actions
add_action('after_setup_theme', 	'laborator_after_setup_theme', 100);
add_action('init', 					'laborator_init');
add_action('init', 					'laborator_testimonials_postype');
add_action('widgets_init', 			'laborator_widgets_init');

add_action('wp_enqueue_scripts', 	'laborator_wp_head');
add_action('wp_enqueue_scripts', 	'laborator_wp_enqueue_scripts');
add_action('wp_print_scripts', 		'laborator_wp_print_scripts');
add_action('wp_head', 				'laborator_favicon');
add_action('wp_footer', 			'laborator_wp_footer');

add_action('admin_menu', 			'laborator_menu_page');
add_action('admin_menu', 			'laborator_menu_documentation', 100);
add_action('admin_print_styles', 	'laborator_admin_print_styles');
add_action('admin_enqueue_scripts', 'laborator_admin_enqueue_scripts');

add_action('tgmpa_register', 		'oxygen_register_required_plugins');

if(file_exists(dirname(__FILE__) . "/theme-demo/theme-demo.php"))
{
	require "theme-demo/theme-demo.php";
}


# Core Files
require 'inc/lib/smof/smof.php';
require 'inc/laborator_functions.php';
require 'inc/laborator_actions.php';
require 'inc/laborator_filters.php';

if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins'))) || class_exists( 'WooCommerce' ))
	require locate_template( 'inc/laborator_woocommerce.php' );


# Library Files
require 'inc/lib/zebra.php';
require 'inc/lib/phpthumb/ThumbLib.inc.php';
require 'inc/lib/class-tgm-plugin-activation.php';
require 'inc/lib/laborator/laborator_image_resizer.php';
require 'inc/lib/laborator/laborator_dataopt.php';
require 'inc/lib/laborator/laborator_tgs.php';
require 'inc/lib/laborator/laborator_gallerybox.php';
require 'inc/lib/laborator/laborator_custom_css.php'; # New in v2.6
require 'inc/lib/laborator/laborator-demo-content-importer/laborator_demo_content_importer.php'; # New in v2.6

if(in_array('js_composer/js_composer.php', apply_filters('active_plugins', get_option('active_plugins'))) && function_exists('vc_add_params'))
{
	require 'inc/lib/visual-composer/config.php';
	#require 'inc/lib/visual-composer/vc-modify.php';
}

require 'inc/lib/widgets/laborator_subscribe.php';


# Advanced Custom Fields
if(function_exists("register_field_group"))
{
	if(in_array('revslider/revslider.php', apply_filters('active_plugins', get_option( 'active_plugins'))))
		require 'inc/lib/acf-revslider/acf-revslider.php';

	require 'inc/acf-fields.php';
}

require 'inc/laborator_data_blocks.php';

# Laborator SEO
if( ! defined("WPSEO_PATH"))
	require 'inc/lib/laborator/laborator_seo.php';


# Thumbnail Sizes
$blog_thumb_height = get_data('blog_thumbnail_height');

laborator_img_add_size('blog-thumb-1', 410, 410, 1);
laborator_img_add_size('blog-thumb-3', 450, 300, 1);
laborator_img_add_size('shop-thumb-1', 325, 390, 4);
laborator_img_add_size('shop-thumb-1-large', 500, 596, 4);
laborator_img_add_size('shop-thumb-2', 180, 220, 4);
laborator_img_add_size('shop-thumb-3', 105, 135, 4);
laborator_img_add_size('shop-thumb-4', 580, 0, 0);
laborator_img_add_size('shop-thumb-5', 135, 160, 4);
laborator_img_add_size('shop-thumb-6', 500, 500, 3);

add_image_size('blog-thumb-1', 410, 410, true);
add_image_size('blog-thumb-3', 540, 360, true);

add_image_size('shop-thumb-1', 520, 625, true);
add_image_size('shop-thumb-1-large', 500, 596, true);
add_image_size('shop-thumb-2', 180, 220, true);
add_image_size('shop-thumb-3', 105, 135, true);
add_image_size('shop-thumb-4', 580, 0);
add_image_size('shop-thumb-5', 135, 160, true);
add_image_size('shop-thumb-6', 500, 500, true);


if($blog_thumb_height)
	laborator_img_add_size('blog-thumb-2', 870, $blog_thumb_height, 1);
else
	laborator_img_add_size('blog-thumb-2', 870, 0, 0);


// Setup Menu Locations Notification
$nav_menu_locations = get_theme_mod('nav_menu_locations');

if( ! isset($nav_menu_locations['main-menu']) || $nav_menu_locations['main-menu'] == 0)
	add_action('admin_notices', 'laborator_setup_menus_notice');


// changed by Jack, Add product color image size
	add_image_size( 'variation_table_color', 20, 20, false);
	
	
	
	/**
	 * Add new register fields for WooCommerce registration.
	 *
	 * @return string Register fields HTML.
	 */
	function wooc_extra_register_fields() {
		?>
	
		<p class="form-row form-row-wide woocommerce-FormRow woocommerce-FormRow--wide">		
			<label for="reg_billing_first_name">
				First Name
				<span class="required">*</span>
			</label>
			<input type="text" class="input-text form-control" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
		</p>
	
		<p class="form-row form-row-wide woocommerce-FormRow woocommerce-FormRow--wide">
			<label for="reg_billing_last_name">
				Last Name
				<span class="required">*</span>
			</label>
			<input type="text" class="input-text form-control" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
		</p>
	
		<p class="form-row form-row-wide woocommerce-FormRow woocommerce-FormRow--wide">
			<label for="reg_billing_phone">
				Phone
				<span class="required">*</span>
			</label>	
			<input type="tel" class="input-text form-control" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />
		</p>
	
		<?php
	}
	
	add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
	
	function login_function_fix($user_login, $user) {
	    $user_id = $user->ID;
	    delete_user_meta( $user_id, "_woocommerce_persistent_cart");
	    
	}
	add_action('wp_login', 'login_function_fix', 10, 2);
	

	/**
	 * Validate the extra register fields.
	 *
	 * @param  string $username          Current username.
	 * @param  string $email             Current email.
	 * @param  object $validation_errors WP_Error object.
	 *
	 * @return void
	 */
	function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
		if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
			$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
		}
	
		if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
			$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
		}
	
	
		if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
			$validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Phone is required!.', 'woocommerce' ) );
		}
	}
	
	add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
	
	
	
	/**
	 * Save the extra register fields.
	 *
	 * @param  int  $customer_id Current customer ID.
	 *
	 * @return void
	 */
	function wooc_save_extra_register_fields( $customer_id ) {
		if ( isset( $_POST['billing_first_name'] ) ) {
			// WordPress default first name field.
			update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
	
			// WooCommerce billing first name.
			update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		}
	
		if ( isset( $_POST['billing_last_name'] ) ) {
			// WordPress default last name field.
			update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
	
			// WooCommerce billing last name.
			update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		}
	
		if ( isset( $_POST['billing_phone'] ) ) {
			// WooCommerce billing phone
			update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
		}
	}
	
	add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
	
	
	