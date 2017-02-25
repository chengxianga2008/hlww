<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Shipping_Australia_Post class deprecatedd.
 *
 * This class serves only WC < 2.6 and will be removed by WC 2.8
 * @extends WC_Shipping_Method
 */
class WC_Shipping_Australia_Post extends WC_Shipping_Method {

	private $default_api_key = 'smUZLviAk6JIkIHvL0xgzP1yToSu7iQJ';
	private $max_weight;
	private $services;
	private $extra_cover;
	private $delivery_confirmation;

	private $endpoints = array(
		'calculation' => 'https://digitalapi.auspost.com.au/api/postage/{type}/{doi}/calculate.json',
		'services'    => 'https://digitalapi.auspost.com.au/api/postage/{type}/{doi}/service.json',
	);

	private $sod_cost = 2.95;
	private $int_sod_cost = 4.99;
	private $found_rates;
	private $rate_cache;
	private $is_international = false;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->id                 = 'australia_post';
		$this->method_title       = __( 'Australia Post', 'woocommerce-shipping-australia-post' );
		$this->method_description = __( 'The <strong>Australia Post</strong> extension obtains rates dynamically from the Australia Post API during cart/checkout.', 'woocommerce-shipping-australia-post' );
		$this->init();
	}

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	private function init() {
		// Load the settings.
		$this->init_settings();
		$this->init_form_fields();

		// Define user set variables
		$this->title            = isset( $this->settings['title'] ) ? $this->settings['title'] : $this->method_title;
		$this->availability     = isset( $this->settings['availability'] ) ? $this->settings['availability'] : 'all';
		$this->enabled          = $this->get_option( 'enabled', $this->enabled );
		$this->countries        = isset( $this->settings['countries'] ) ? $this->settings['countries'] : array();
		$this->excluding_tax    = isset( $this->settings['excluding_tax'] ) ? $this->settings['excluding_tax'] : 'no';
		$this->origin           = isset( $this->settings['origin'] ) ? $this->settings['origin'] : '';
		$this->api_key          = ! empty( $this->settings['api_key'] ) ? $this->settings['api_key'] : $this->default_api_key;
		$this->packing_method   = isset( $this->settings['packing_method'] ) ? $this->settings['packing_method'] : 'per_item';
		$this->boxes            = ! empty( $this->settings['boxes'] ) ? $this->settings['boxes'] : array();
		$this->custom_services  = isset( $this->settings['services'] ) ? $this->settings['services'] : array();
		$this->offer_rates      = isset( $this->settings['offer_rates'] ) ? $this->settings['offer_rates'] : 'all';
		$this->debug            = isset( $this->settings['debug_mode'] ) ? $this->settings['debug_mode'] : 'no';
		$this->satchel_priority = isset( $this->settings['satchel_priority'] ) ? $this->settings['satchel_priority'] : 'no';

		// on, off, priority
		if ( isset( $this->settings['satchel_rates'] ) ) {
			$this->satchel_rates = $this->settings['satchel_rates'];
		} else {
			if ( 'yes' === $this->satchel_priority ) {
				$this->satchel_rates = 'priority';
			} else {
				$this->satchel_rates = 'on';
			}
		}

		$this->debug                 = $this->debug == 'yes' ? true : false;
		$this->satchel_priority      = $this->satchel_priority == 'yes' ? true : false;
		$this->services              = include( 'data/data-services.php' );
		$this->extra_cover           = include( 'data/data-extra-cover.php' );
		$this->delivery_confirmation = include( 'data/data-sod.php' );

		// Used for weight based packing only
		$this->max_weight = isset( $this->settings['max_weight'] ) ? $this->settings['max_weight'] : '20';

		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'test_api_key' ), -10 );
		add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'clear_transients' ) );
	}

	/**
	 * For letter boxes convert the metrics to match it as users have set on on the product.
	 *
	 * Example:
	 * the letter height is entered as `mm` but the product value is entered in `cm`.
	 *
	 * @since 1.9.0
	 * @param array $boxes saved settings.
	 * @return array $boxes
	 */
	public function convert_letter_boxes_to_match_product_metrics( $boxes ) {
		foreach ( $boxes as $index => $box ) {
			if ( $box['is_letter'] ) {

				$updated_box = array();

				$updated_box['is_letter']    = $box['is_letter'];
				$updated_box['outer_length'] = wc_get_dimension( $box['outer_length'], 'cm', 'mm' );
				$updated_box['outer_width']  = wc_get_dimension( $box['outer_width'],  'cm', 'mm' );
				$updated_box['outer_height'] = wc_get_dimension( $box['outer_height'], 'cm', 'mm' );
				$updated_box['inner_length'] = wc_get_dimension( $box['inner_length'], 'cm', 'mm' );
				$updated_box['inner_width']  = wc_get_dimension( $box['inner_width'],  'cm', 'mm' );
				$updated_box['inner_height'] = wc_get_dimension( $box['inner_height'], 'cm', 'mm' );
				$updated_box['box_weight']   = wc_get_weight( $box['box_weight'], 'kg', 'g' );
				$updated_box['max_weight']   = wc_get_weight( $box['max_weight'], 'kg', 'g' );

				$boxes[ $index ] = $updated_box;

			}
		}
		return $boxes;
	}

	/**
	 * Output a message
	 */
	public function debug( $message, $type = 'notice' ) {
		if ( $this->debug ) {
			wc_add_notice( $message, $type );
		}
	}

	/**
	 * environment_check function.
	 *
	 * @access public
	 * @return void
	 */
	private function environment_check() {
		
		$general_tab_link = admin_url( add_query_arg( array(
			'page'    => 'wc-settings',
			'tab'     => 'general',
		), 'admin.php' ) );
		
		if ( 'AU' !== WC()->countries->get_base_country() ) {
			echo '<div class="error">
				<p>' . wp_kses( sprintf( __( 'Australia Post requires that the <a href="%s">base country/region</a> is set to Australia.', 'woocommerce-shipping-australia-post' ), esc_url( $general_tab_link ) ), array( 'a' => array( 'href' => array() ) ) ) . '</p>
			</div>';
		} elseif ( ! $this->origin && 'yes' === $this->enabled ) {
			echo '<div class="error">
				<p>' . esc_html__( 'Australia Post is enabled, but the origin postcode has not been set.', 'woocommerce-shipping-australia-post' ) . '</p>
			</div>';
		}
	}

	/**
	 * admin_options function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_options() {
		// Check users environment supports this method
		$this->environment_check();

		// Show settings
		parent::admin_options();
	}

	/**
	 * generate_services_html function.
	 *
	 * @access public
	 * @return void
	 */
	public function generate_services_html() {
		ob_start();
		include( 'views/html-services.php' );
		return ob_get_clean();
	}

	/**
	 * generate_box_packing_html function.
	 *
	 * @access public
	 * @return void
	 */
	public function generate_box_packing_html() {
		ob_start();
		include( 'views/html-box-packing.php' );
		return ob_get_clean();
	}

	/**
	 * validate_box_packing_field function.
	 *
	 * @access public
	 *
	 * @param mixed $key
	 *
	 * @return void
	 */
	public function validate_box_packing_field( $key ) {
		$boxes = array();

		if ( isset( $_POST['boxes_outer_length'] ) ) {
			$boxes_outer_length = $_POST['boxes_outer_length'];
			$boxes_outer_width  = $_POST['boxes_outer_width'];
			$boxes_outer_height = $_POST['boxes_outer_height'];
			$boxes_inner_length = $_POST['boxes_inner_length'];
			$boxes_inner_width  = $_POST['boxes_inner_width'];
			$boxes_inner_height = $_POST['boxes_inner_height'];
			$boxes_box_weight   = $_POST['boxes_box_weight'];
			$boxes_max_weight   = $_POST['boxes_max_weight'];
			$boxes_is_letter    = isset( $_POST['boxes_is_letter'] ) ? $_POST['boxes_is_letter'] : array();

			for ( $i = 0; $i < sizeof( $boxes_outer_length ); $i++ ) {

				if ( $boxes_outer_length[ $i ] && $boxes_outer_width[ $i ] && $boxes_outer_height[ $i ] && $boxes_inner_length[ $i ] && $boxes_inner_width[ $i ] && $boxes_inner_height[ $i ] ) {

					$boxes[] = array(
						'outer_length' => floatval( $boxes_outer_length[ $i ] ),
						'outer_width'  => floatval( $boxes_outer_width[ $i ] ),
						'outer_height' => floatval( $boxes_outer_height[ $i ] ),
						'inner_length' => floatval( $boxes_inner_length[ $i ] ),
						'inner_width'  => floatval( $boxes_inner_width[ $i ] ),
						'inner_height' => floatval( $boxes_inner_height[ $i ] ),
						'box_weight'   => floatval( $boxes_box_weight[ $i ] ),
						'max_weight'   => floatval( $boxes_max_weight[ $i ] ),
						'is_letter'    => isset( $boxes_is_letter[ $i ] ) ? true : false
					);

				}

			}
		}

		return $boxes;
	}

	/**
	 * validate_services_field function.
	 *
	 * @access public
	 *
	 * @param mixed $key
	 *
	 * @return void
	 */
	public function validate_services_field( $key ) {
		$services        = array();
		$posted_services = $_POST['australia_post_service'];

		foreach ( $posted_services as $code => $settings ) {

			$services[ $code ] = array(
				'name'                  => woocommerce_clean( $settings['name'] ),
				'order'                 => woocommerce_clean( $settings['order'] ),
				'enabled'               => isset( $settings['enabled'] ) ? true : false,
				'adjustment'            => woocommerce_clean( $settings['adjustment'] ),
				'adjustment_percent'    => str_replace( '%', '', woocommerce_clean( $settings['adjustment_percent'] ) ),
				'extra_cover'           => isset( $settings['extra_cover'] ) ? true : false,
				'delivery_confirmation' => isset( $settings['delivery_confirmation'] ) ? true : false,
			);

		}

		return $services;
	}

	/**
	 * clear_transients function.
	 *
	 * @access public
	 * @return void
	 */
	public function clear_transients() {
		delete_transient( 'wc_australia_post_quotes' );
	}

	/**
	 * init_form_fields function.
	 *
	 * @access public
	 * @return void
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled'        => array(
				'title'   => __( 'Enable/Disable', 'woocommerce-shipping-australia-post' ),
				'type'    => 'checkbox',
				'label'   => __( 'Enable this shipping method', 'woocommerce-shipping-australia-post' ),
				'default' => 'no',
			),
			'title'          => array(
				'title'       => __( 'Method Title', 'woocommerce-shipping-australia-post' ),
				'type'        => 'text',
				'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce-shipping-australia-post' ),
				'default'     => __( 'Australia Post', 'woocommerce-shipping-australia-post' ),
			),
			'origin'         => array(
				'title'       => __( 'Origin Postcode', 'woocommerce-shipping-australia-post' ),
				'type'        => 'text',
				'description' => __( 'Enter the postcode for the <strong>sender</strong>.', 'woocommerce-shipping-australia-post' ),
				'default'     => '',
			),
			'availability'   => array(
				'title'   => __( 'Method Availability', 'woocommerce-shipping-australia-post' ),
				'type'    => 'select',
				'default' => 'all',
				'class'   => 'availability',
				'options' => array(
					'all'      => __( 'All Countries', 'woocommerce-shipping-australia-post' ),
					'specific' => __( 'Specific Countries', 'woocommerce-shipping-australia-post' ),
				),
			),
			'countries'      => array(
				'title'   => __( 'Specific Countries', 'woocommerce-shipping-australia-post' ),
				'type'    => 'multiselect',
				'class'   => 'chosen_select',
				'css'     => 'width: 450px;',
				'default' => '',
				'options' => WC()->countries->get_allowed_countries(),
			),
			'excluding_tax'  => array(
				'title'       => __( 'Tax', 'woocommerce-shipping-australia-post' ),
				'label'       => __( 'Calculate Rates Excluding Tax', 'woocommerce-shipping-australia-post' ),
				'type'        => 'checkbox',
				'description' => __( "Calculate shipping rates excluding tax (if you plan to add tax via WooCommerce's tax system). By default rates returned by the Australia Post API include tax.", 'woocommerce-shipping-australia-post' ),
				'default'     => 'no',
			),
			'api'            => array(
				'title'       => __( 'API Settings', 'woocommerce-shipping-australia-post' ),
				'type'        => 'title',
				'description' => __( 'Your API access details are obtained from the Australia Post website. You can obtain your <a href="https://auspost.com.au/devcentre/pacpcs-registration.asp">own key here</a>, or just use ours.', 'woocommerce-shipping-australia-post' ),
			),
			'api_key'        => array(
				'title'       => __( 'API Key', 'woocommerce-shipping-australia-post' ),
				'type'        => 'text',
				'description' => __( 'Leave blank to use our API Key.', 'woocommerce-shipping-australia-post' ),
				'default'     => '',
				'placeholder' => $this->default_api_key,
			),
			'debug_mode'     => array(
				'title'       => __( 'Debug Mode', 'woocommerce-shipping-australia-post' ),
				'label'       => __( 'Enable debug mode', 'woocommerce-shipping-australia-post' ),
				'type'        => 'checkbox',
				'default'     => 'no',
				'description' => __( 'Enable debug mode to show debugging information on your cart/checkout.', 'woocommerce-shipping-australia-post' ),
			),
			'rates'          => array(
				'title'       => __( 'Rates and Services', 'woocommerce-shipping-australia-post' ),
				'type'        => 'title',
				'description' => __( 'The following settings determine the rates you offer your customers.', 'woocommerce-shipping-australia-post' ),
			),
			'packing_method' => array(
				'title'   => __( 'Parcel Packing Method', 'woocommerce-shipping-australia-post' ),
				'type'    => 'select',
				'default' => '',
				'class'   => 'packing_method',
				'options' => array(
					'per_item'    => __( 'Default: Pack items individually', 'woocommerce-shipping-australia-post' ),
					'weight'      => __( 'Weight of all items', 'woocommerce-shipping-australia-post' ),
					'box_packing' => __( 'Recommended: Pack into boxes with weights and dimensions', 'woocommerce-shipping-australia-post' ),
				),
			),
			'max_weight'     => array(
				'title'       => __( 'Maximum weight (kg)', 'woocommerce-shipping-australia-post' ),
				'type'        => 'text',
				'default'     => '20',
				'description' => __( 'Maximum weight per package in kg.', 'woocommerce-shipping-australia-post' ),
			),
			'boxes'          => array(
				'type' => 'box_packing',
			),
			'satchel_rates'  => array(
				'title'   => __( 'Satchel Rates', 'woocommerce-shipping-australia-post' ),
				'type'    => 'select',
				'options' => array(
					'on'       => __( 'Enable Satchel Rates', 'woocommerce-shipping-australia-post' ),
					'priority' => __( 'Prioritze Satchel Rates', 'woocommerce-shipping-australia-post' ),
					'off'      => __( 'Disable Satchel Rates', 'woocommerce-shipping-australia-post' ),
				),
				'default' => ( isset( $this->settings['satchel_priority'] ) && 'yes' === $this->settings['satchel_priority'] ) ? 'priority' : 'on',
			),
			'offer_rates'    => array(
				'title'       => __( 'Offer Rates', 'woocommerce-shipping-australia-post' ),
				'type'        => 'select',
				'description' => '',
				'default'     => 'all',
				'options'     => array(
					'all'      => __( 'Offer the customer all returned rates', 'woocommerce-shipping-australia-post' ),
					'cheapest' => __( 'Offer the customer the cheapest rate only, anonymously', 'woocommerce-shipping-australia-post' ),
				),
			),
			'services'       => array(
				'type' => 'services',
			),
		);
	}

	/**
	 * Tests the entered API key against the service to see if a forbidden error is returned.
	 * If it is, the key is rejected and an error message is displayed.
	 */
	function test_api_key() {
		if ( empty ( $_POST['woocommerce_australia_post_api_key'] ) ) {
			return;
		}

		$test_endpoint = str_replace( array( '{type}', '{doi}' ), array(
			'parcel',
			'domestic',
		), $this->endpoints['calculation'] );
		$test_request  = "weight=5&height=5&width=5&length=5&from_postcode=3149&to_postcode=3149&service_code=AUS_PARCEL_REGULAR";
		$test_headers  = array( 'AUTH-KEY' => $_POST['woocommerce_australia_post_api_key'] );

		// We don't want to use $this->get_response here because we don't want the result cached,
		// we want to avoid the front end debug notices, and we want to get back the actual status code
		$response      = wp_remote_get( $test_endpoint . '?' . $test_request, array(
			'headers' => $test_headers,
		) );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 403 !== $response_code ) {
			return;
		}

		echo '<div class="error">
			<p>' . esc_html__( 'The Australia Post API key you entered is invalid. Please make sure you entered a valid key (<a href="https://auspost.com.au/devcentre/pacpcs-registration.asp">which can be obtained here</a>) and not your WooCommerce license key. Our API key will be used instead.', 'woocommerce-shipping-australia-post' ) . '</p>
		</div>';

		$_POST['woocommerce_australia_post_api_key'] = '';
	}

	/**
	 * Calculates the extra cover cost
	 * For International its $9.60 for first $100, $2.50 for each additional $100
	 * For domestic its $1.50 per $100
	 * We are assuming max cover for each items
	 *
	 * @since 2.3.12
	 * @version 2.3.12
	 * @access public
	 * @param float $item_value
	 * @param int $max_extra_cover the maximum allowed value to cover
	 * @return float $cover_cost
	 */
	public function calculate_extra_cover_cost( $item_value, $max_extra_cover ) {
		$extra_cover_cost = 1.50;
		$int_extra_cover = 2.50;
		$int_extra_cover_base_cost = 9.60;

		if ( empty( $item_value ) ) {
			return 0;
		}

		// make sure item value is no more than max cover value
		if ( $item_value > $max_extra_cover ) {
			$item_value = $max_extra_cover;
		}

		if ( $this->is_international ) {
			if ( $item_value < 100 ) {
				return $int_extra_cover_base_cost;
			}

			return $int_extra_cover_base_cost + ( ceil( ( $item_value - 100 ) / 100 ) * $int_extra_cover );
		}

		return $extra_cover_cost * ( ceil( $item_value / 100 ) );
	}

	/**
	 * Will girth fit
	 *
	 * @param  [type] $item_w
	 * @param  [type] $item_h
	 * @param  [type] $package_w
	 * @param  [type] $package_h
	 *
	 * @return bool
	 */
	public function girth_fits_in_satchel( $item_l, $item_w, $item_h, $package_l, $package_w ) {
		// Check max height
		if ( $item_h > ( $package_w / 2 ) ) {
			return false;
		}

		// Girth = around the item
		$item_girth = $item_w + $item_h;

		if ( $item_girth > $package_w ) {
			return false;
		}

		// Girth 2 = around the item
		$item_girth = $item_l + $item_h;

		if ( $item_girth > $package_l ) {
			return false;
		}

		return true;
	}

	/**
	 * See if rate is satchel
	 *
	 * @return boolean
	 */
	public function is_satchel( $code ) {
		return strpos( $code, '_SATCHEL_' ) !== false;
	}

	/**
	 * calculate_shipping function.
	 *
	 * @access public
	 *
	 * @param array $package
	 *
	 * @return void
	 */
	public function calculate_shipping( $package = array() ) {
		$this->found_rates      = array();
		$this->rate_cache       = get_transient( 'wc_australia_post_quotes' );
		$this->is_international = $this->is_international( $package );
		$headers                = $this->get_request_header();
		$package_requests       = $this->get_package_requests( $package );

		$this->debug( __( 'Australia Post debug mode is on - to hide these messages, turn debug mode off in the settings.', 'woocommerce-shipping-australia-post' ) );

		// Prepare endpoints
		$letter_services_endpoint    = str_replace( array( '{type}', '{doi}' ), array(
			'letter',
			( $this->is_international ? 'international' : 'domestic' ),
		), $this->endpoints['services'] );

		$letter_calculation_endpoint = str_replace( array( '{type}', '{doi}' ), array(
			'letter',
			( $this->is_international ? 'international' : 'domestic' ),
		), $this->endpoints['calculation'] );

		$services_endpoint           = str_replace( array( '{type}', '{doi}' ), array(
			'parcel',
			( $this->is_international ? 'international' : 'domestic' ),
		), $this->endpoints['services'] );

		$calculation_endpoint        = str_replace( array( '{type}', '{doi}' ), array(
			'parcel',
			( $this->is_international ? 'international' : 'domestic' ),
		), $this->endpoints['calculation'] );

		if ( $package_requests ) {

			foreach ( $package_requests as $key => $package_request ) {

				$request = http_build_query( array_merge( $package_request, $this->get_request( $package ) ), '', '&' );

				if ( isset( $package_request['thickness'] ) ) {
					$response = $this->get_response( $letter_services_endpoint, $request, $headers );
				} else {
					$response = $this->get_response( $services_endpoint, $request, $headers );
				}

				if ( isset( $response->services->service ) && is_array( $response->services->service ) ) {

					// Loop our known services
					foreach ( $this->services as $service => $values ) {

						$rate_code = (string) $service;
						$rate_id   = $this->id . ':' . $rate_code;
						$rate_name = (string) $values['name'];
						$rate_cost = null;

						// Main service code
						foreach ( $response->services->service as $quote ) {
							if ( ( isset( $values['alternate_services'] ) && in_array( $quote->code, $values['alternate_services'] ) ) || $service == $quote->code ) {

								$delivery_confirmation = false;
								$rate_set              = false;

								if ( $this->is_satchel( $quote->code ) && 'off' === $this->satchel_rates ) {
									continue;
								}

								if ( $this->is_satchel( $quote->code ) ) {
									switch ( $quote->code ) {
										case 'AUS_PARCEL_REGULAR_SATCHEL_500G' :
										case 'AUS_PARCEL_EXPRESS_SATCHEL_500G' :
											if ( $package_request['length'] > 35 || $package_request['width'] > 22 || ! $this->girth_fits_in_satchel( $package_request['length'], $package_request['width'], $package_request['height'], 35, 22 ) ) {
												continue;
											}
											break;
										case 'AUS_PARCEL_REGULAR_SATCHEL_3KG' :
										case 'AUS_PARCEL_EXPRESS_SATCHEL_3KG' :
											if ( $package_request['length'] > 40 || $package_request['width'] > 31 || ! $this->girth_fits_in_satchel( $package_request['length'], $package_request['width'], $package_request['height'], 40, 31 ) ) {
												continue;
											}
											break;
										case 'AUS_PARCEL_REGULAR_SATCHEL_5KG' :
										case 'AUS_PARCEL_EXPRESS_SATCHEL_5KG' :
											if ( $package_request['length'] > 51 || $package_request['width'] > 43 || ! $this->girth_fits_in_satchel( $package_request['length'], $package_request['width'], $package_request['height'], 51, 43 ) ) {
												continue;
											}
											break;
									}
									if ( 'priority' === $this->satchel_rates ) {
										$rate_cost = $quote->price;
										$rate_set  = true;
									}
									if ( ! empty( $this->custom_services[ $rate_code ]['delivery_confirmation'] ) ) {
										$delivery_confirmation = true;
									}
								} elseif ( ! empty( $this->custom_services[ $rate_code ]['delivery_confirmation'] ) ) {
									$delivery_confirmation = true;
								}

								if ( is_null( $rate_cost ) ) {
									$rate_cost = $quote->price;
									$rate_set  = true;
								} elseif ( $quote->price < $rate_cost ) {
									$rate_cost = $quote->price;
									$rate_set  = true;
								}

								if ( $rate_set ) {
									// User wants extra cover
									if ( ! empty( $this->custom_services[ $rate_code ]['extra_cover'] ) && isset( $package_request['extra_cover'] ) ) {
										$rate_cost += $this->calculate_extra_cover_cost( $package_request['extra_cover'], $quote->max_extra_cover );
									}

									// User wants SOD
									if ( $delivery_confirmation ) {
										if ( $this->is_international ) {
											$rate_cost += $this->int_sod_cost;
										} else {
											$rate_cost += $this->sod_cost;
										}
									}
								}
							}
						}

						if ( $rate_cost ) {
							$this->prepare_rate( $rate_code, $rate_id, $rate_name, $rate_cost, $package_request, $package );
						}
					}
				}
			}
		}

		// Set transient
		set_transient( 'wc_australia_post_quotes', $this->rate_cache, YEAR_IN_SECONDS );

		// Ensure rates were found for all packages
		if ( $this->found_rates ) {
			foreach ( $this->found_rates as $key => $value ) {
				if ( $value['packages'] < sizeof( $package_requests ) ) {
					unset( $this->found_rates[ $key ] );
				}
			}
		}

		// Add rates
		if ( $this->found_rates ) {
			if ( 'all' === $this->offer_rates ) {

				uasort( $this->found_rates, array( $this, 'sort_rates' ) );

				foreach ( $this->found_rates as $key => $rate ) {
					$this->add_rate( $rate );
				}

			} else {

				$cheapest_rate = '';

				foreach ( $this->found_rates as $key => $rate ) {
					if ( ! $cheapest_rate || $cheapest_rate['cost'] > $rate['cost'] ) {
						$cheapest_rate = $rate;
					}
				}

				$cheapest_rate['label'] = $this->title; // will use generic rate label defined by user
				$this->add_rate( $cheapest_rate );

			}
		}
	}

	/**
	 * Checks if destination is international
	 *
	 * @since 2.3.12
	 * @version 2.3.12
	 * @param array $package
	 * @return bool
	 */
	public function is_international( $package ) {
		if ( 'AU' !== $package['destination']['country'] ) {
			return true;
		}

		return false;
	}

	/**
	 * prepare_rate function.
	 *
	 * @access private
	 *
	 * @param mixed $rate_code
	 * @param mixed $rate_id
	 * @param mixed $rate_name
	 * @param mixed $rate_cost
	 */
	private function prepare_rate( $rate_code, $rate_id, $rate_name, $rate_cost, $package_request = '', $package = array() ) {
		// Name adjustment
		if ( ! empty( $this->custom_services[ $rate_code ]['name'] ) ) {
			$rate_name = $this->custom_services[ $rate_code ]['name'];
		}

		// Cost adjustment %
		if ( ! empty( $this->custom_services[ $rate_code ]['adjustment_percent'] ) ) {
			$rate_cost = $rate_cost + ( $rate_cost * ( floatval( $this->custom_services[ $rate_code ]['adjustment_percent'] ) / 100 ) );
		}

		// Cost adjustment
		if ( ! empty( $this->custom_services[ $rate_code ]['adjustment'] ) ) {
			$rate_cost = $rate_cost + floatval( $this->custom_services[ $rate_code ]['adjustment'] );
		}

		// Exclude Tax?
		if ( 'yes' === $this->excluding_tax && ! $this->is_international ) {
			$tax_rate  = apply_filters( 'woocommerce_shipping_australia_post_tax_rate', 0.10 );
			$rate_cost = $rate_cost / ( $tax_rate + 1 );
		}

		// Enabled check
		if ( isset( $this->custom_services[ $rate_code ] ) && empty( $this->custom_services[ $rate_code ]['enabled'] ) ) {
			return;
		}

		// Merging
		if ( isset( $this->found_rates[ $rate_id ] ) ) {
			$rate_cost = $rate_cost + $this->found_rates[ $rate_id ]['cost'];
			$packages  = 1 + $this->found_rates[ $rate_id ]['packages'];
		} else {
			$packages = 1;
		}

		// Sort
		if ( isset( $this->custom_services[ $rate_code ]['order'] ) ) {
			$sort = $this->custom_services[ $rate_code ]['order'];
		} else {
			$sort = 999;
		}

		$this->found_rates[ $rate_id ] = array(
			'id'       => $rate_id,
			'label'    => $rate_name,
			'cost'     => $rate_cost,
			'sort'     => $sort,
			'packages' => $packages,
		);
	}

	/**
	 * get_response function.
	 *
	 * @access private
	 *
	 * @param mixed $endpoint
	 * @param mixed $request
	 *
	 * @return void
	 */
	private function get_response( $endpoint, $request, $headers ) {
		if ( isset( $this->rate_cache[ md5( $request ) ] ) ) {

			$response = $this->rate_cache[ md5( $request ) ];

		} else {

			$response = wp_remote_get( $endpoint . '?' . $request,
				array(
					'timeout' => 70,
					'headers' => $headers,
				)
			);

			$response = json_decode( $response['body'] );

			// Store result in case the request is made again
			$this->rate_cache[ md5( $request ) ] = $response;
		}

		$this->debug( 'Australia Post REQUEST: <pre>' . print_r( htmlspecialchars( $request ), true ) . '</pre>' );
		$this->debug( 'Australia Post RESPONSE: <pre>' . print_r( $response, true ) . '</pre>' );

		return $response;
	}

	/**
	 * sort_rates function.
	 *
	 * @access public
	 *
	 * @param mixed $a
	 * @param mixed $b
	 *
	 * @return void
	 */
	public function sort_rates( $a, $b ) {
		if ( $a['sort'] == $b['sort'] ) {
			return 0;
		}

		return ( $a['sort'] < $b['sort'] ) ? -1 : 1;
	}

	/**
	 * get_request_header function.
	 *
	 * @access private
	 * @return array
	 */
	private function get_request_header() {
		return array(
			'AUTH-KEY' => $this->api_key,
		);
	}

	/**
	 * get_request function.
	 *
	 * @access private
	 *
	 * @param mixed $package
	 *
	 * @return void
	 */
	private function get_request( $package ) {
		$request = array();

		$request['from_postcode'] = str_replace( ' ', '', strtoupper( $this->origin ) );

		switch ( $package['destination']['country'] ) {
			case "AU" :
				$request['to_postcode'] = str_replace( ' ', '', strtoupper( $package['destination']['postcode'] ) );
				break;
			default :
				$request['country_code'] = $package['destination']['country'];
				break;
		}

		return $request;
	}

	/**
	 * get_request function.
	 *
	 * @access private
	 * @return void
	 */
	private function get_package_requests( $package ) {
		$requests = array();

		// Choose selected packing
		switch ( $this->packing_method ) {
			case 'weight' :
				$requests = $this->weight_only_shipping( $package );
				break;
			case 'box_packing' :
				$requests = $this->box_shipping( $package );
				break;
			case 'per_item' :
			default :
				$requests = $this->per_item_shipping( $package );
				break;
		}

		return $requests;
	}

	/**
	 * weight_only_shipping function.
	 *
	 * @access private
	 *
	 * @param mixed $package
	 *
	 * @return array
	 */
	private function weight_only_shipping( $package ) {
		if ( ! class_exists( 'WC_Boxpack' ) ) {
			include_once 'box-packer/class-wc-boxpack.php';
		}

		$packer = new WC_Boxpack();

		// Get weight of order
		foreach ( $package['contents'] as $item_id => $values ) {

			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product #%d is missing virtual. Aborting.', 'woocommerce-shipping-australia-post' ), $item_id ), 'error' );
				continue;
			}

			if ( ! $values['data']->get_weight() ) {
				$this->debug( sprintf( __( 'Product #%d is missing weight. Aborting.', 'woocommerce-shipping-australia-post' ), $item_id ), 'error' );

				return null;
			}

			$weight = wc_get_weight( $values['data']->get_weight(), 'kg' );
			$price  = $values['data']->get_price();
			for ( $i = 0; $i < $values['quantity']; $i++ ) {
				$packer->add_item( 0, 0, 0, $weight, $price );
			}
		}

		$box = $packer->add_box( 1, 1, 1, 0 );
		$box->set_max_weight( $this->max_weight );
		$packer->pack();
		$packages = $packer->get_packages();

		if ( sizeof( $packages ) > 1 ) {
			$this->debug( __( 'Package is too heavy. Splitting.', 'woocommerce-shipping-australia-post' ), 'error' );
			$this->debug( "Splitting into " . sizeof( $packages ) . ' packages.' );
		}

		$requests = array();
		foreach ( $packages as $p ) {
			$parcel                = array();
			$parcel['weight']      = str_replace( ',', '.', round( $p->weight, 2 ) );
			$parcel['extra_cover'] = ceil( $p->value );

			// Domestic parcels require dimensions
			if ( ! $this->is_international ) {
				$dimension        = 1;
				$parcel['height'] = $dimension;
				$parcel['width']  = $dimension;
				$parcel['length'] = $dimension;
			}

			$requests[] = $parcel;
		}

		return $requests;
	}

	/**
	 * per_item_shipping function.
	 *
	 * @access private
	 *
	 * @param mixed $package
	 *
	 * @return void
	 */
	private function per_item_shipping( $package ) {
		$requests = array();

		// Get weight of order
		foreach ( $package['contents'] as $item_id => $values ) {

			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product #%d is virtual. Skipping.', 'woocommerce-shipping-australia-post' ), $item_id ) );
				continue;
			}

			if ( ! $values['data']->get_weight() || ! $values['data']->length || ! $values['data']->height || ! $values['data']->width ) {
				$this->debug( sprintf( __( 'Product #%d is missing weight/dimensions. Aborting.', 'woocommerce-shipping-australia-post' ), $item_id ) );

				return;
			}

			$parcel = array();

			$parcel['weight'] = wc_get_weight( $values['data']->get_weight(), 'kg' );

			$dimensions = array(
				wc_get_dimension( $values['data']->length, 'cm' ),
				wc_get_dimension( $values['data']->height, 'cm' ),
				wc_get_dimension( $values['data']->width, 'cm' ),
			);

			sort( $dimensions );

			// Min sizes - girth minimum is 16
			$girth = $dimensions[0] + $dimensions[0] + $dimensions[1] + $dimensions[1];

			if ( $girth < 16 ) {
				if ( $dimensions[0] < 4 ) {
					$dimensions[0] = 4;
				}
				if ( $dimensions[1] < 5 ) {
					$dimensions[1] = 5;
				}

				$girth = $dimensions[0] + $dimensions[0] + $dimensions[1] + $dimensions[1];
			}

			if ( $parcel['weight'] > 22 || $dimensions[2] > 105 ) {
				$this->debug( sprintf( __( 'Product %d has invalid weight/dimensions. Aborting. See <a href="http://auspost.com.au/personal/parcel-dimensions.html">http://auspost.com.au/personal/parcel-dimensions.html</a>', 'woocommerce-shipping-australia-post' ), $item_id ), 'error' );

				return;
			}

			$parcel['height'] = $dimensions[0];
			$parcel['width']  = $dimensions[1];
			$parcel['length'] = $dimensions[2];

			$parcel['extra_cover'] = ceil( $values['data']->get_price() );

			for ( $i = 0; $i < $values['quantity']; $i++ ) {
				$requests[] = $parcel;
			}
		}

		return $requests;
	}

	/**
	 * box_shipping function.
	 *
	 * @access private
	 *
	 * @param mixed $package
	 *
	 * @return void
	 */
	private function box_shipping( $package ) {
		$requests = array();

		if ( ! class_exists( 'WC_Boxpack' ) ) {
			include_once 'box-packer/class-wc-boxpack.php';
		}

		$boxpack = new WC_Boxpack();

		// Needed to ensure box packer works correctly.
		$boxes = $this->convert_letter_boxes_to_match_product_metrics( $this->boxes );
		// Define boxes
		if ( $boxes ) {
			foreach ( $boxes as $key => $box ) {

				$newbox = $boxpack->add_box( $box['outer_length'], $box['outer_width'], $box['outer_height'], $box['box_weight'] );

				$newbox->set_id( $key );
				$newbox->set_inner_dimensions( $box['inner_length'], $box['inner_width'], $box['inner_height'] );

				if ( $box['max_weight'] ) {
					$newbox->set_max_weight( $box['max_weight'] );
				}
			}
		}

		// Add items
		foreach ( $package['contents'] as $item_id => $values ) {

			if ( ! $values['data']->needs_shipping() ) {
				$this->debug( sprintf( __( 'Product #%d is virtual. Skipping.', 'woocommerce-shipping-australia-post' ), $item_id ) );
				continue;
			}

			if ( $values['data']->length && $values['data']->height && $values['data']->width && $values['data']->weight ) {

				$dimensions = array( $values['data']->length, $values['data']->height, $values['data']->width );

				for ( $i = 0; $i < $values['quantity']; $i++ ) {

					$boxpack->add_item(
						wc_get_dimension( $dimensions[2], 'cm' ),
						wc_get_dimension( $dimensions[1], 'cm' ),
						wc_get_dimension( $dimensions[0], 'cm' ),
						wc_get_weight( $values['data']->get_weight(), 'kg' ),
						$values['data']->get_price()
					);
				}

			} else {
				$this->debug( sprintf( __( 'Product #%d is missing dimensions. Aborting.', 'woocommerce-shipping-australia-post' ), $item_id ), 'error' );

				return;
			}
		}

		// Pack it
		$boxpack->pack();

		// Get packages
		$packages = $boxpack->get_packages();

		foreach ( $packages as $package ) {

			$dimensions = array( $package->length, $package->width, $package->height );

			sort( $dimensions );

			if ( empty( $this->boxes[ $package->id ]['is_letter'] ) ) {
				$request['height'] = $dimensions[0];
				$request['weight'] = $package->weight;
				$request['width']  = $dimensions[1];
				$request['length'] = $dimensions[2];
			} else {
				// convert values back to what the API expects
				// Changed in $this->convert_letter_boxes_to_match_product_metrics()
				$request['thickness'] = wc_get_dimension( $dimensions[0], 'mm', 'cm' );
				$request['width']     = wc_get_dimension( $dimensions[1], 'mm', 'cm' );
				$request['length']    = wc_get_dimension( $dimensions[2], 'mm', 'cm' );
				$request['weight']    = wc_get_weight( $package->weight, 'g', 'kg' );
			}

			$request['extra_cover'] = ceil( $package->value );

			$requests[] = $request;
		}

		return $requests;
	}
}
