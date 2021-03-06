<?php
/**
 *	Oxygen WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */


# WooCommerce Styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );


# Page Title optimized for better seo
add_filter('wp_title', 'filter_wp_title');

function filter_wp_title( $title )
{
	global $page, $paged;

	$separator = '-';

	if ( is_feed() )
		return $title;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' '.$separator.' ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' '.$separator.' ' . sprintf( __( 'Page %s', 'oxygen'), max( $paged, $page ) ) : '';

	return $filtered_title;
}


# Laborator Theme Options Translate
add_filter('admin_menu', 'laborator_add_menu_classes', 100);

function laborator_add_menu_classes($items)
{
	global $submenu;

	foreach($submenu as $menu_id => $sub)
	{
		if($menu_id == 'laborator_options')
		{
			$submenu[$menu_id][0][0] = __('Theme Options', 'oxygen');
		}
	}

	return $submenu;
}


# Excerpt Length & More
add_filter('excerpt_length', create_function('', 'return '.(get_data('blog_sidebar_position') == 'Hide' ? 80 : 38).';'));
add_filter('excerpt_more', create_function('', 'return "&hellip;";'));



# Render Comment Fields
function laborator_comment_fields($fields)
{
	foreach($fields as $field_type => $field_html)
	{
		preg_match("/<label(.*?)>(.*?)\<\/label>/", $field_html, $html_label);
		preg_match("/<input(.*?)\/>/", $field_html, $html_input);

		$html_label = strip_tags($html_label[2]);
		$html_input = $html_input[0];

		$html_input = str_replace("<input", '<input class="form-control" placeholder="'.esc_attr($html_label).'" ', $html_input);
		$html_label = str_replace('*', '<span class="red">*</span>', $html_label);

		$fields[$field_type] = "
		<div class=\"col-lg-4 mobile-padding\">
			<label>" . $html_label . "</label>
			{$html_input}
		</div>";
	}


	return $fields;
}



# Body Class
add_filter('body_class', 'laborator_body_class');

function laborator_body_class($classes)
{
	if(get_data('sidebar_menu_position') === "0")
		$classes[] = 'right-sidebar';

	if(in_array(HEADER_TYPE, array(2,3,4)))
	{
		$classes[] = 'oxygen-top-menu';

		if(HEADER_TYPE == 3)
			$classes[] = 'top-header-flat';

		if(HEADER_TYPE == 4)
			$classes[] = 'top-header-center';

		$classes[] = 'ht-' . HEADER_TYPE;

		if(get_data('cart_ribbon_position'))
		{
			$classes[] = 'ribbon-left';
		}
	}
	else
	if(HEADER_TYPE == 1)
	{
		$classes[] = 'oxygen-sidebar-menu ht-1';
	}

	if(get_data('header_sticky_menu'))
	{
		$classes[] = 'sticky-menu';
	}

	if( ! get_data('cart_ribbon_show'))
	{
		$classes[] = 'cart-ribbon-hidden';
	}

	if(is_catalog_mode())
	{
		$classes[] = 'catalog-mode-only';

		if(catalog_mode_hide_prices())
		{
			$classes[] = 'catalog-mode-hide-prices';
		}
	}

	return $classes;
}


# Add Do-shortcode for text widgets
add_filter('widget_text', 'widget_text_do_shortcodes');

function widget_text_do_shortcodes($text)
{
	return do_shortcode($text);
}



# Shortcode for Social Networks [lab_social_networks]
add_shortcode('lab_social_networks', 'shortcode_lab_social_networks');

function shortcode_lab_social_networks($atts = array(), $content = '')
{
	$social_order = get_data('social_order');

	$social_order_list = array(
		"fb"  => array("title" => "Facebook", 	"icon" => "fa-facebook"),
		"tw"  => array("title" => "Twitter", 	"icon" => "fa-twitter"),
		"lin" => array("title" => "LinkedIn", 	"icon" => "fa-linkedin"),
		"yt"  => array("title" => "YouTube", 	"icon" => "fa-youtube"),
		"vm"  => array("title" => "Vimeo", 		"icon" => "fa-vimeo"),
		"drb" => array("title" => "Dribbble", 	"icon" => "fa-dribbble"),
		"ig"  => array("title" => "Instagram", 	"icon" => "fa-instagram"),
		"pi"  => array("title" => "Pinterest", 	"icon" => "fa-pinterest"),
		"gp"  => array("title" => "Google+", 	"icon" => "fa-google-plus"),
		"vk"  => array("title" => "VKontakte", 	"icon" => "fa-vk"),
		"tu"  => array("title" => "Tumblr", 	"icon" => "fa-tumblr"),
	);


	$html = '<ul class="social-networks">';

	foreach($social_order['visible'] as $key => $title)
	{
		if($key == 'placebo')
			continue;

		$sn = $social_order_list[$key];

		$html .= '<li>';
			$html .= '<a href="'.get_data("social_network_link_{$key}").'" target="_blank" class="icon-'.(str_replace('fa-', 'social-', $sn['icon'])).'">';
				$html .= '<i class="fa '.$sn['icon'].'"></i>';
			$html .= '</a>';
		$html .= '</li>';
	}

	$html .= '</ul>';


	return $html;

}



# Skin Compiler
add_filter('of_options_before_save', 'lab_custom_skin_compiler');

function lab_custom_skin_compiler($data)
{
	if(isset($data['use_custom_skin']) && $data['use_custom_skin'])
	{
		try
		{
			custom_skin_compile(array(
				'link-color'		=> $data['custom_skin_main_color'],
				'menu-link'		 => $data['custom_skin_menu_link_color'],
				'background-color'  => $data['custom_skin_background_color'],
			));
		}
		catch(Exception $e){}
	}

	return $data;
}


# Catalog Mode
if(is_catalog_mode())
{
	add_filter('get_data_cart_ribbon_show', create_function('', 'return false;'));
}



# Testimonial Thumbnail
if(function_exists('add_theme_support'))
{
	add_filter('manage_posts_columns', 'laborator_testimonial_featured_image_column', 5);
	add_filter('manage_pages_columns', 'laborator_testimonial_featured_image_column', 5);

	add_action('manage_posts_custom_column', 'laborator_testimonial_featured_image_column_content', 5, 2);
	add_action('manage_pages_custom_column', 'laborator_testimonial_featured_image_column_content', 5, 2);
}
function laborator_testimonial_featured_image_column($columns)
{
	if(lab_get('post_type') == 'testimonial')
	{
		$columns_new = array(
			'cb' => $columns['cb'],
			'testimonial_featured_image' =>  __('Image', TD)
		);

		$columns = array_merge($columns_new, $columns);
	}

	return ($columns);
}

function laborator_testimonial_featured_image_column_content($column_name, $id)
{
	if($column_name === 'testimonial_featured_image')
	{
		echo '<center>';

		if(has_post_thumbnail())
		{
			echo laborator_show_img(get_the_id(), 48, 48, 1);
		}
		else
		{
			echo "<small>No Image</small>";
		}

		echo '</center>';
	}
}


// Post Thumbnail Remove height and width
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3);

function remove_thumbnail_dimensions($html, $post_id, $post_image_id)
{
	return remove_wh($html);
}




// Remove temporary title bug in WooCommerce
remove_filter('the_title', 'wc_page_endpoint_title');



// Visual Composer Update
add_action( 'init', 'vc_tgm_update_active' );

function vc_tgm_update_active() {
	
	global $wp_filter;
	
	$tags = array(
		'upgrader_pre_download',
		'upgrader_process_complete',
		'pre_set_site_transient_update_plugins'
	);
	
	$methods = array(
		'upgradeFilterFromEnvato',
		'preUpgradeFilter',
		'removeTemporaryDir',
		'check_update'
	);
	
	foreach ( $tags as $tag ) {
		if ( ! empty( $wp_filter[ $tag ] ) ) {
			foreach ( $wp_filter[ $tag ] as $priority => $priority_filters ) {
				foreach ( $priority_filters as $filter_hashname => $fn ) {
					foreach ( $methods as $method ) {						
						if ( strpos( $filter_hashname, $method ) ) {
							unset( $wp_filter[ $tag ][$priority][$filter_hashname] );
						}
					}
				}
			}
		}
	}
}