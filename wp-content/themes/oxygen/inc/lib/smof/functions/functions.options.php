<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();

### OXYGEN ###
$of_options[] = array( 	"name" 		=> "Header",
						"type" 		=> "heading"
				);

$of_options[] = array(  "name"   	=> "Site Brand",
						"desc"   	=> "Enter the text that will appear as logo.",
						"id"   		=> "logo_text",
						"std"   	=> get_bloginfo('title'),
						"type"   	=> "text"
					);

$of_options[] = array(
						"desc"   	=> "Upload Custom Logo",
						"id"   		=> "use_uploaded_logo",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch"
					);

$of_options[] = array(	"name" 		=> "Custom Logo",
						"desc" 		=> "Upload/Choose your custom logo image from gallery if you want to use it instead of the default site title text.",
						"id" 		=> "custom_logo_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "use_uploaded_logo"
					);

$of_options[] = array(
						"desc" 		=> "Responsive Logo Image, generally used for Retina Displays to show smoother pixels. Retina logo should be the double width/height of normal logo.",
						"id" 		=> "custom_logo_image_responsive",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min",
						"fold" 		=> "use_uploaded_logo"
					);

$of_options[] = array( 	"desc" 		=> "You can set maximum width for the uploaded logo, mostly used when you use upload retina (@2x) logo. Pixels unit.",
						"id" 		=> "custom_logo_max_width",
						"std" 		=> "",
						"plc"		=> "Maximum Logo Width",
						"type" 		=> "text",
						"fold" 		=> "use_uploaded_logo"
				);

$of_options[] = array( 	"name" 		=> "Header Type",
						"desc" 		=> "",
						"id" 		=> "header_type",
						"std" 		=> "2",
						"type" 		=> "images",
						"options" 	=> array(
							'1'      => THEMEASSETS . 'images/header-type-1.png',
							'2'      => THEMEASSETS . 'images/header-type-2.png',
							'2-gray' => THEMEASSETS . 'images/header-type-2-gray.png',
							'3'      => THEMEASSETS . 'images/header-type-3.png',
							'4'      => THEMEASSETS . 'images/header-type-4.png',
						)
				);

$of_options[] = array( 	"name" 		=> "Left Sidebar Options",
						"desc" 		=> "<strong>Main Sidebar Position</strong> - Select where sidebar menu is placed in the container.",
						"id" 		=> "sidebar_menu_position",
						"std" 		=> 1,
						"on" 		=> "Left",
						"off" 		=> "Right",
						"type" 		=> "switch"
				);


$of_options[] = array( 	"desc" 		=> "<strong>Sidebar Menu Links</strong> - Choose the display type of sidebar links in the menu. <br /><br />These settings are applied only if <em>Header Type</em> is set to <strong>Left Sidebar</strong>.",
						"id" 		=> "sidebar_menu_links_display",
						"std" 		=> "Collapsed",
						"type" 		=> "select",
						"options" 	=> array("Collapsed", "Expanded")
				);

$of_options[] = array( 	"name" 		=> "Sticky Menu",
						"desc" 		=> "Enable or disable sticky menu (if supported by header type).",
						"id" 		=> "header_sticky_menu",
						"std" 		=> 1,
						"on" 		=> "Enable",
						"off" 		=> "Disable",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Search Form in Header",
						"desc" 		=> "Enable or disable search form in the main menu.",
						"id" 		=> "header_menu_search",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" 		=> "Cart Ribbon",
						"desc" 		=> "Show cart ribbon in the page header (right side).",
						"id" 		=> "cart_ribbon_show",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$of_options[] = array( 	#"name" 		=> "Cart Ribbon Image",
						"desc" 		=> "Select a cart ribbon image.",
						"id" 		=> "cart_ribbon_image",
						"std" 		=> THEMEASSETS . 'images/cart-icon-1-black.png',
						"type" 		=> "tiles",
						"options"	=> array(
							THEMEASSETS . 'images/cart-icon-1-black.png',
							THEMEASSETS . 'images/cart-icon-3-black.png',
							THEMEASSETS . 'images/cart-icon-2-black.png',
							THEMEASSETS . 'images/cart-icon-4-black.png',
						),
						"fold"		=> "cart_ribbon_show"
				);

$of_options[] = array(  "desc" 		=> "Cart ribbon position. Only applied for <strong>top menu</strong> header type.",
						"id" 		=> "cart_ribbon_position",
						"std" 		=> 0,
						"on" 		=> "Left",
						"off" 		=> "Right",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" 		=> "Header Social Networks",
						"desc" 		=> "Show social networks on top menu container.",
						"id" 		=> "top_menu_social",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);

$of_options[] = array(	"desc" 		=> "Show social networks on mobile menu container.",
						"id" 		=> "social_mobile_menu",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);

$of_options[] = array( "name" 		=> "Top Menu in Mobile",
						"desc" 		=> "Show top menu on mobile screens.",
						"id" 		=> "top_menu_mobile",
						"std" 		=> 0,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch"
				);


$of_options[] = array( 	"name" 		=> "Footer",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Footer Widgets",
						"desc" 		=> "Show or hide footer widgets.",
						"id" 		=> "footer_widgets",
						"std" 		=> 1,
						"on" 		=> "Show",
						"off" 		=> "Hide",
						"type" 		=> "switch",
						"folds"		=> 1
				);


$of_options[] = array( 	"name" 		=> "Columns Count",
					 	"desc" 		=> "Select the type of footer widgets column to show.",
						"id" 		=> "footer_widgets_columns",
						"std" 		=> "[1/3] Three Columns",
						"type" 		=> "select",
						"options" 	=> array("[1/2] Two Columns", "[1/3] Three Columns", "[1/4] Four Columns", "[1/6] Six Columns"),
						"fold"		=> "footer_widgets"
				);

$of_options[] = array( 	"name" 		=> "Footer Text",
						"desc" 		=> "Copyrights text in the footer.",
						"id" 		=> "footer_text",
						"std" 		=> "&copy; Oxygen WordPress Theme.",
						"type" 		=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template.",
						"id" 		=> "google_analytics",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"name" 		=> "Shop Settings",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "General Shop Settings",
						"desc" 		=> "Shop head title (listing page).",
						"id" 		=> "shop_title_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Quick View product (listing page).",
						"id" 		=> "shop_quickview",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product sorting and results count.",
						"id" 		=> "shop_sorting_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product rating (listing page).",
						"id" 		=> "shop_rating_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Sale or out-of-stock ribbon (listing page).",
						"id" 		=> "shop_sale_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>Featured Product</strong> badge (ribbon).",
						"id" 		=> "shop_featured_product_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Item category (listing page).",
						"id" 		=> "shop_product_category_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Item price (listing page).",
						"id" 		=> "shop_product_price_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Add to cart product (listing page).",
						"id" 		=> "shop_add_to_cart_listing",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show cart items count with AJAX.",
						"id" 		=> "shop_cart_counter_ajax",
						"std" 		=> 0,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Enable <font color='#dd1f26'><strong>catalog</strong></font> mode only.",
						"id" 		=> "shop_catalog_mode",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> true
				);

$of_options[] = array( 	"desc" 		=> "<strong>Catalog mode</strong> &ndash; hide prices.",
						"id" 		=> "shop_catalog_mode_hide_prices",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"fold"		=> "shop_catalog_mode"
				);

$of_options[] = array( 	"desc" 		=> "Item thumbnail preview type.",
						"id" 		=> "shop_item_preview_type",
						"std" 		=> "Product Gallery Slider",
						"type" 		=> "select",
						"options" 	=> array("Product Gallery Slider", "Second Image on Hover", "None")
				);
				

$of_options[] = array( 	"desc" 		=> "Catalog thumbnail size.",
						"id" 		=> "shop_catalog_thumbnail_size",
						"std" 		=> "default",
						"type" 		=> "select",
						"options" 	=> array(
							"default" => "Default size (325x390)",
							"proportional-m" => "Original size – Medium",
							"proportional-l" => "Original size – Large",
						)
				);

$of_options[] = array( 	"desc" 		=> "Set how many products to show in mobile devices.",
						"id" 		=> "shop_products_mobile_two_per_row",
						"std" 		=> "decide",
						"type" 		=> "select",
						"options" 	=> array(
							"one" => "One product per row",
							"two" => "Two products per row",
						)
				);

$of_options[] = array( 	"desc" 		=> "Categories per row.",
						"id" 		=> "shop_categories_per_row",
						"std" 		=> "four",
						"type" 		=> "select",
						"options" 	=> array(
							"2"    => "2 categories per row",
							"3"  => "3 categories per row",
							"4"   => "4 categories per row",
						)
				);

$of_options[] = array( 	"name" 		=> "Shop Sidebar",
						"desc" 		=> "Main sidebar visibility.",
						"id" 		=> "shop_sidebar",
						"std" 		=> "Hide Sidebar",
						"type" 		=> "select",
						"options" 	=> array("Show Sidebar on Left", "Show Sidebar on Right", "Hide Sidebar")
				);

$of_options[] = array( 	"desc" 		=> "Show <strong>footer</strong> sidebar.",
						"id" 		=> "shop_sidebar_footer",
						"std" 		=> 0,
						"type" 		=> "checkbox",
						"folds"		=> 1
				);

$of_options[] = array( 	"name" 		=> "Footer Sidebar Columns",
					 	"desc" 		=> "Set the number of columns to show in <strong>footer</strong> sidebar.",
						"id" 		=> "shop_sidebar_footer_columns",
						"std" 		=> "4",
						"type" 		=> "select",
						"options" 	=> array("2", "3", "4",),
						"fold"		=> "shop_sidebar_footer"
				);

$of_options[] = array( 	"name" 		=> "Single Item Settings",
						"desc" 		=> "Enable full screen for gallery images.",
						"id" 		=> "shop_single_fullscreen",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Sale or out-of-stock ribbon.",
						"id" 		=> "shop_single_sale_ribbon_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product <strong>Next-Prev</strong> navigation.",
						"id" 		=> "shop_single_next_prev",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Show item category (below title).",
						"id" 		=> "shop_single_product_category",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Product meta (id, category and tags).",
						"id" 		=> "shop_single_meta_show",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Single item sidebar visibility.",
						"id" 		=> "shop_single_sidebar",
						"std" 		=> "Hide Sidebar",
						"type" 		=> "select",
						"options" 	=> array("Show Sidebar on Left", "Show Sidebar on Right", "Hide Sidebar")
				);

$of_options[] = array( 	"desc" 		=> "Auto rotate product images.",
						"id" 		=> "shop_single_auto_rotate_image",
						"std" 		=> "",
						"plc"		=> "Default: 5 (seconds) - 0 to disable",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Pagination",
					 	"desc" 		=> "Products to show per one page.",
						"id" 		=> "shop_products_per_page",
						"std" 		=> "4 rows",
						"type" 		=> "select",
						"options" 	=> array("9 rows", "8 rows", "7 rows", "6 rows", "5 rows", "4 rows", "3 rows", "2 rows", "1 row")
				);

$of_options[] = array( 	"desc" 		=> "Products per row.",
						"id" 		=> "shop_products_per_column",
						"std" 		=> "four",
						"type" 		=> "select",
						"options" 	=> array(
							"three"  => "3 products per row",
							"four"   => "4 products per row",
							"five"   => "5 products per row",
							"decide" => "Decide when sidebar is present",
						)
				);

$of_options[] = array( 	"desc" 		=> "Related products count (shown on single product page).",
						"id" 		=> "shop_related_products_per_page",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> range(12, 1)
				);

$of_options[] = array( 	"name" 		=> "Product Sharing",
						"desc" 		=> "Enable or disable sharing the product in popular Social Networks.",
						"id" 		=> "shop_share_product",
						"std" 		=> 0,
						"on" 		=> "Allow Share",
						"off" 		=> "No",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$share_product_networks = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"gp"       	=> "Google Plus",
				"pi"        => "Pinterest",
				"em"       	=> "Email",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"lin"       => "LinkedIn",
				"tlr"       => "Tumblr",
				"vk"       	=> "VKontakte",
			),
);

$of_options[] = array( 	"name" 		=> "Share Product Networks",
						"desc" 		=> "Select social networks that you allow users to share the products of your shop.",
						"id" 		=> "shop_share_product_networks",
						"std" 		=> $share_product_networks,
						"type" 		=> "sorter",
						"fold"		=> "shop_share_product"
				);




$of_options[] = array( 	"name" 		=> "Blog Settings",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Toggle Blog Functionality",
						"desc" 		=> "Thumbnails (post featured image)",
						"id" 		=> "blog_thumbnails",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Single post thumbnail (featured image)",
						"id" 		=> "blog_single_thumbnails",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Thumbnail hover effect",
						"id" 		=> "blog_thumbnail_hover_effect",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Author name (shown on posts list)",
						"id" 		=> "blog_author_name",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Author info (shown on single post)",
						"id" 		=> "blog_author_info",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Category (shown everywhere)",
						"id" 		=> "blog_category",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Post date (shown everywhere)",
						"id" 		=> "blog_post_date",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Tags (shown on single post)",
						"id" 		=> "blog_tags",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"desc" 		=> "Comments number",
						"id" 		=> "blog_comments_count",
						"std" 		=> 1,
						"type" 		=> "checkbox"
				);

$of_options[] = array( 	"name" 		=> "Blog Sidebar",
					 	"desc" 		=> "Set blog sidebar position, you can even hide it.",
						"id" 		=> "blog_sidebar_position",
						"std" 		=> "Right",
						"type" 		=> "select",
						"options" 	=> array("Right", "Left", "Hide")
				);

$of_options[] = array( 	"name" 		=> "Pagination Position",
						"desc" 		=> "Set blog pagination position.",
						"id" 		=> "blog_pagination_position",
						"std" 		=> "Center",
						"type" 		=> "select",
						"options" 	=> array("Left", "Center", "Right")
				);

$of_options[] = array( 	"name" 		=> "Gallery Auto-Switch",
						"desc" 		=> "Set the interval of auto-switch for gallery images (in posts, 0 - disable).",
						"id" 		=> "blog_gallery_autoswitch",
						"std" 		=> "",
						"plc"		=> "Default: 5 (seconds)",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Thumbnail Height",
						"desc" 		=> "Featured image thumbnail height (applied on single post only).",
						"id" 		=> "blog_thumbnail_height",
						"std" 		=> "",
						"plc"		=> "If you set blank, it will generate proportional height.",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Share Story",
						"desc" 		=> "Enable or disable sharing the story in popular Social Networks.",
						"id" 		=> "blog_share_story",
						"std" 		=> 0,
						"on" 		=> "Allow Share",
						"off" 		=> "No",
						"type" 		=> "switch",
						"folds"		=> 1
				);

$share_story_networks = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
				"lin"       => "LinkedIn",
				"pi"        => "Pinterest",
				"tlr"       => "Tumblr",
				"gp"       	=> "Google Plus",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"pi"       	=> "Pinterest",
				"em"       	=> "Email",
				"vk"       	=> "VKontakte",
			),
);

$of_options[] = array( 	"name" 		=> "Share Story Networks",
						"desc" 		=> "Select social networks that you allow users to share the content of your blog posts.",
						"id" 		=> "blog_share_story_networks",
						"std" 		=> $share_story_networks,
						"type" 		=> "sorter",
						"fold"		=> "blog_share_story"
				);


$of_options[] = array( 	"name" 		=> "Other Settings",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name"		=> "Search results",
						"desc" 		=> "Set how many rows you want to display on search page.",
						"id" 		=> "search_results_count",
						"std" 		=> 4,
						"type" 		=> "select",
						"options" 	=> range(12, 1)
				);

$post_types_obj = get_post_types(array('_builtin' => false, 'publicly_queryable' => true, 'exclude_from_search' => false), 'objects');

$post_types = array();

$post_types['post'] = __('Posts', TD);
$post_types['page'] = __('Pages', TD);

foreach($post_types_obj as $pt => $obj)
{
	$post_types[$pt] = $obj->labels->name;
}


$of_options[] = array( 	"desc" 		=> "Set available post types in search results.",
						"id" 		=> "search_post_types",
						"std" 		=> array('post', 'page', 'product'),
						"type" 		=> "multicheck",
						"options" 	=> $post_types
				);


$of_options[] = array(	"name" 		=> "Favicon",
						"desc" 		=> "Select 64x64 favicon of the PNG format.",
						"id" 		=> "favicon_image",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min"
					);


$of_options[] = array(	"name" 		=> "Apple Touch Icon",
						"desc" 		=> "Required image size 114x114 (png only)",
						"id" 		=> "apple_touch_icon",
						"std" 		=> "",
						"type" 		=> "media",
						"mod" 		=> "min"
					);


$of_options[] = array( 	"name"		=> 'Google Maps API Key',
						"desc" 		=> "Google maps requires unique API key for each site, click here to learn more about generating <a href='https://developers.google.com/maps/documentation/javascript/get-api-key' target='_blank'>Google API Key</a>",
						"id" 		=> "google_maps_api",
						"std" 		=> "",
						"plc"		=> "",
						"type" 		=> "text"
				);


/*$of_options[] = array( 	"name"		=> "Thumbnails Generator",
						"desc" 		=> "Image quality for JPEG thumbnails (higher value = better quality = bigger size).<br /><br /><em>Note: If you change thumbnails quality, current thumbnails will still be at the same quality. <br />The changes will take effect only if you delete all generated thumbnails by <a href='".admin_url()."?lab_img_clear_cache=1' target='_blank' onclick='return confirm(\"Are you sure?\");'>clicking here</a>, they will be created automatically.</em>",
						"id" 		=> "image_resizer_jpeg_quality",
						"std" 		=> 90,
						"type" 		=> "select",
						"options" 	=> range(100, 60)
				);*/



$of_options[] = array( 	"name" 		=> "Typography",
						"type" 		=> "heading"
				);

$font_primary_list = array(
	"Open Sans"           => "Open Sans",
	"PT Sans"             => "PT Sans",
	"Source Sans Pro"     => "Source Sans Pro",
	"Arimo"               => "Arimo",
	"Arvo"                => "Arvo",
	"Roboto Slab"         => "Roboto Slab",
	"Playfair Display"    => "Playfair Display",
	"Montserrat"          => "Montserrat",
	"Raleway"             => "Raleway"
);

$font_secondary_list = array(
	"Arvo"                => "Arvo",
	"Roboto Slab"         => "Roboto Slab",
	"Playfair Display"    => "Playfair Display",
	"Montserrat"          => "Montserrat",
	"Raleway"             => "Raleway",
	"Arimo"               => "Arimo"
);

$sep = array( '----' => '----------' );

$google_fonts_list = array(
	"ABeeZee" => "ABeeZee",
	"Abel" => "Abel",
	"Abril Fatface" => "Abril Fatface",
	"Aclonica" => "Aclonica",
	"Acme" => "Acme",
	"Actor" => "Actor",
	"Adamina" => "Adamina",
	"Advent Pro" => "Advent Pro",
	"Aguafina Script" => "Aguafina Script",
	"Akronim" => "Akronim",
	"Aladin" => "Aladin",
	"Aldrich" => "Aldrich",
	"Alef" => "Alef",
	"Alegreya" => "Alegreya",
	"Alegreya SC" => "Alegreya SC",
	"Alegreya Sans" => "Alegreya Sans",
	"Alegreya Sans SC" => "Alegreya Sans SC",
	"Alex Brush" => "Alex Brush",
	"Alfa Slab One" => "Alfa Slab One",
	"Alice" => "Alice",
	"Alike" => "Alike",
	"Alike Angular" => "Alike Angular",
	"Allan" => "Allan",
	"Allerta" => "Allerta",
	"Allerta Stencil" => "Allerta Stencil",
	"Allura" => "Allura",
	"Almendra" => "Almendra",
	"Almendra Display" => "Almendra Display",
	"Almendra SC" => "Almendra SC",
	"Amarante" => "Amarante",
	"Amaranth" => "Amaranth",
	"Amatic SC" => "Amatic SC",
	"Amethysta" => "Amethysta",
	"Amiri" => "Amiri",
	"Amita" => "Amita",
	"Anaheim" => "Anaheim",
	"Andada" => "Andada",
	"Andika" => "Andika",
	"Angkor" => "Angkor",
	"Annie Use Your Telescope" => "Annie Use Your Telescope",
	"Anonymous Pro" => "Anonymous Pro",
	"Antic" => "Antic",
	"Antic Didone" => "Antic Didone",
	"Antic Slab" => "Antic Slab",
	"Anton" => "Anton",
	"Arapey" => "Arapey",
	"Arbutus" => "Arbutus",
	"Arbutus Slab" => "Arbutus Slab",
	"Architects Daughter" => "Architects Daughter",
	"Archivo Black" => "Archivo Black",
	"Archivo Narrow" => "Archivo Narrow",
	"Arimo" => "Arimo",
	"Arizonia" => "Arizonia",
	"Armata" => "Armata",
	"Artifika" => "Artifika",
	"Arvo" => "Arvo",
	"Arya" => "Arya",
	"Asap" => "Asap",
	"Asar" => "Asar",
	"Asset" => "Asset",
	"Astloch" => "Astloch",
	"Asul" => "Asul",
	"Atomic Age" => "Atomic Age",
	"Aubrey" => "Aubrey",
	"Audiowide" => "Audiowide",
	"Autour One" => "Autour One",
	"Average" => "Average",
	"Average Sans" => "Average Sans",
	"Averia Gruesa Libre" => "Averia Gruesa Libre",
	"Averia Libre" => "Averia Libre",
	"Averia Sans Libre" => "Averia Sans Libre",
	"Averia Serif Libre" => "Averia Serif Libre",
	"Bad Script" => "Bad Script",
	"Balthazar" => "Balthazar",
	"Bangers" => "Bangers",
	"Basic" => "Basic",
	"Battambang" => "Battambang",
	"Baumans" => "Baumans",
	"Bayon" => "Bayon",
	"Belgrano" => "Belgrano",
	"Belleza" => "Belleza",
	"BenchNine" => "BenchNine",
	"Bentham" => "Bentham",
	"Berkshire Swash" => "Berkshire Swash",
	"Bevan" => "Bevan",
	"Bigelow Rules" => "Bigelow Rules",
	"Bigshot One" => "Bigshot One",
	"Bilbo" => "Bilbo",
	"Bilbo Swash Caps" => "Bilbo Swash Caps",
	"Biryani" => "Biryani",
	"Bitter" => "Bitter",
	"Black Ops One" => "Black Ops One",
	"Bokor" => "Bokor",
	"Bonbon" => "Bonbon",
	"Boogaloo" => "Boogaloo",
	"Bowlby One" => "Bowlby One",
	"Bowlby One SC" => "Bowlby One SC",
	"Brawler" => "Brawler",
	"Bree Serif" => "Bree Serif",
	"Bubblegum Sans" => "Bubblegum Sans",
	"Bubbler One" => "Bubbler One",
	"Buda" => "Buda",
	"Buenard" => "Buenard",
	"Butcherman" => "Butcherman",
	"Butterfly Kids" => "Butterfly Kids",
	"Cabin" => "Cabin",
	"Cabin Condensed" => "Cabin Condensed",
	"Cabin Sketch" => "Cabin Sketch",
	"Caesar Dressing" => "Caesar Dressing",
	"Cagliostro" => "Cagliostro",
	"Calligraffitti" => "Calligraffitti",
	"Cambay" => "Cambay",
	"Cambo" => "Cambo",
	"Candal" => "Candal",
	"Cantarell" => "Cantarell",
	"Cantata One" => "Cantata One",
	"Cantora One" => "Cantora One",
	"Capriola" => "Capriola",
	"Cardo" => "Cardo",
	"Carme" => "Carme",
	"Carrois Gothic" => "Carrois Gothic",
	"Carrois Gothic SC" => "Carrois Gothic SC",
	"Carter One" => "Carter One",
	"Catamaran" => "Catamaran",
	"Caudex" => "Caudex",
	"Caveat" => "Caveat",
	"Caveat Brush" => "Caveat Brush",
	"Cedarville Cursive" => "Cedarville Cursive",
	"Ceviche One" => "Ceviche One",
	"Changa One" => "Changa One",
	"Chango" => "Chango",
	"Chau Philomene One" => "Chau Philomene One",
	"Chela One" => "Chela One",
	"Chelsea Market" => "Chelsea Market",
	"Chenla" => "Chenla",
	"Cherry Cream Soda" => "Cherry Cream Soda",
	"Cherry Swash" => "Cherry Swash",
	"Chewy" => "Chewy",
	"Chicle" => "Chicle",
	"Chivo" => "Chivo",
	"Chonburi" => "Chonburi",
	"Cinzel" => "Cinzel",
	"Cinzel Decorative" => "Cinzel Decorative",
	"Clicker Script" => "Clicker Script",
	"Coda" => "Coda",
	"Coda Caption" => "Coda Caption",
	"Codystar" => "Codystar",
	"Combo" => "Combo",
	"Comfortaa" => "Comfortaa",
	"Coming Soon" => "Coming Soon",
	"Concert One" => "Concert One",
	"Condiment" => "Condiment",
	"Content" => "Content",
	"Contrail One" => "Contrail One",
	"Convergence" => "Convergence",
	"Cookie" => "Cookie",
	"Copse" => "Copse",
	"Corben" => "Corben",
	"Courgette" => "Courgette",
	"Cousine" => "Cousine",
	"Coustard" => "Coustard",
	"Covered By Your Grace" => "Covered By Your Grace",
	"Crafty Girls" => "Crafty Girls",
	"Creepster" => "Creepster",
	"Crete Round" => "Crete Round",
	"Crimson Text" => "Crimson Text",
	"Croissant One" => "Croissant One",
	"Crushed" => "Crushed",
	"Cuprum" => "Cuprum",
	"Cutive" => "Cutive",
	"Cutive Mono" => "Cutive Mono",
	"Damion" => "Damion",
	"Dancing Script" => "Dancing Script",
	"Dangrek" => "Dangrek",
	"Dawning of a New Day" => "Dawning of a New Day",
	"Days One" => "Days One",
	"Dekko" => "Dekko",
	"Delius" => "Delius",
	"Delius Swash Caps" => "Delius Swash Caps",
	"Delius Unicase" => "Delius Unicase",
	"Della Respira" => "Della Respira",
	"Denk One" => "Denk One",
	"Devonshire" => "Devonshire",
	"Dhurjati" => "Dhurjati",
	"Didact Gothic" => "Didact Gothic",
	"Diplomata" => "Diplomata",
	"Diplomata SC" => "Diplomata SC",
	"Domine" => "Domine",
	"Donegal One" => "Donegal One",
	"Doppio One" => "Doppio One",
	"Dorsa" => "Dorsa",
	"Dosis" => "Dosis",
	"Dr Sugiyama" => "Dr Sugiyama",
	"Droid Sans" => "Droid Sans",
	"Droid Sans Mono" => "Droid Sans Mono",
	"Droid Serif" => "Droid Serif",
	"Duru Sans" => "Duru Sans",
	"Dynalight" => "Dynalight",
	"EB Garamond" => "EB Garamond",
	"Eagle Lake" => "Eagle Lake",
	"Eater" => "Eater",
	"Economica" => "Economica",
	"Eczar" => "Eczar",
	"Ek Mukta" => "Ek Mukta",
	"Electrolize" => "Electrolize",
	"Elsie" => "Elsie",
	"Elsie Swash Caps" => "Elsie Swash Caps",
	"Emblema One" => "Emblema One",
	"Emilys Candy" => "Emilys Candy",
	"Engagement" => "Engagement",
	"Englebert" => "Englebert",
	"Enriqueta" => "Enriqueta",
	"Erica One" => "Erica One",
	"Esteban" => "Esteban",
	"Euphoria Script" => "Euphoria Script",
	"Ewert" => "Ewert",
	"Exo" => "Exo",
	"Exo 2" => "Exo 2",
	"Expletus Sans" => "Expletus Sans",
	"Fanwood Text" => "Fanwood Text",
	"Fascinate" => "Fascinate",
	"Fascinate Inline" => "Fascinate Inline",
	"Faster One" => "Faster One",
	"Fasthand" => "Fasthand",
	"Fauna One" => "Fauna One",
	"Federant" => "Federant",
	"Federo" => "Federo",
	"Felipa" => "Felipa",
	"Fenix" => "Fenix",
	"Finger Paint" => "Finger Paint",
	"Fira Mono" => "Fira Mono",
	"Fira Sans" => "Fira Sans",
	"Fjalla One" => "Fjalla One",
	"Fjord One" => "Fjord One",
	"Flamenco" => "Flamenco",
	"Flavors" => "Flavors",
	"Fondamento" => "Fondamento",
	"Fontdiner Swanky" => "Fontdiner Swanky",
	"Forum" => "Forum",
	"Francois One" => "Francois One",
	"Freckle Face" => "Freckle Face",
	"Fredericka the Great" => "Fredericka the Great",
	"Fredoka One" => "Fredoka One",
	"Freehand" => "Freehand",
	"Fresca" => "Fresca",
	"Frijole" => "Frijole",
	"Fruktur" => "Fruktur",
	"Fugaz One" => "Fugaz One",
	"GFS Didot" => "GFS Didot",
	"GFS Neohellenic" => "GFS Neohellenic",
	"Gabriela" => "Gabriela",
	"Gafata" => "Gafata",
	"Galdeano" => "Galdeano",
	"Galindo" => "Galindo",
	"Gentium Basic" => "Gentium Basic",
	"Gentium Book Basic" => "Gentium Book Basic",
	"Geo" => "Geo",
	"Geostar" => "Geostar",
	"Geostar Fill" => "Geostar Fill",
	"Germania One" => "Germania One",
	"Gidugu" => "Gidugu",
	"Gilda Display" => "Gilda Display",
	"Give You Glory" => "Give You Glory",
	"Glass Antiqua" => "Glass Antiqua",
	"Glegoo" => "Glegoo",
	"Gloria Hallelujah" => "Gloria Hallelujah",
	"Goblin One" => "Goblin One",
	"Gochi Hand" => "Gochi Hand",
	"Gorditas" => "Gorditas",
	"Goudy Bookletter 1911" => "Goudy Bookletter 1911",
	"Graduate" => "Graduate",
	"Grand Hotel" => "Grand Hotel",
	"Gravitas One" => "Gravitas One",
	"Great Vibes" => "Great Vibes",
	"Griffy" => "Griffy",
	"Gruppo" => "Gruppo",
	"Gudea" => "Gudea",
	"Gurajada" => "Gurajada",
	"Habibi" => "Habibi",
	"Halant" => "Halant",
	"Hammersmith One" => "Hammersmith One",
	"Hanalei" => "Hanalei",
	"Hanalei Fill" => "Hanalei Fill",
	"Handlee" => "Handlee",
	"Hanuman" => "Hanuman",
	"Happy Monkey" => "Happy Monkey",
	"Headland One" => "Headland One",
	"Henny Penny" => "Henny Penny",
	"Herr Von Muellerhoff" => "Herr Von Muellerhoff",
	"Hind" => "Hind",
	"Hind Siliguri" => "Hind Siliguri",
	"Hind Vadodara" => "Hind Vadodara",
	"Holtwood One SC" => "Holtwood One SC",
	"Homemade Apple" => "Homemade Apple",
	"Homenaje" => "Homenaje",
	"IM Fell DW Pica" => "IM Fell DW Pica",
	"IM Fell DW Pica SC" => "IM Fell DW Pica SC",
	"IM Fell Double Pica" => "IM Fell Double Pica",
	"IM Fell Double Pica SC" => "IM Fell Double Pica SC",
	"IM Fell English" => "IM Fell English",
	"IM Fell English SC" => "IM Fell English SC",
	"IM Fell French Canon" => "IM Fell French Canon",
	"IM Fell French Canon SC" => "IM Fell French Canon SC",
	"IM Fell Great Primer" => "IM Fell Great Primer",
	"IM Fell Great Primer SC" => "IM Fell Great Primer SC",
	"Iceberg" => "Iceberg",
	"Iceland" => "Iceland",
	"Imprima" => "Imprima",
	"Inconsolata" => "Inconsolata",
	"Inder" => "Inder",
	"Indie Flower" => "Indie Flower",
	"Inika" => "Inika",
	"Inknut Antiqua" => "Inknut Antiqua",
	"Irish Grover" => "Irish Grover",
	"Istok Web" => "Istok Web",
	"Italiana" => "Italiana",
	"Italianno" => "Italianno",
	"Itim" => "Itim",
	"Jacques Francois" => "Jacques Francois",
	"Jacques Francois Shadow" => "Jacques Francois Shadow",
	"Jaldi" => "Jaldi",
	"Jim Nightshade" => "Jim Nightshade",
	"Jockey One" => "Jockey One",
	"Jolly Lodger" => "Jolly Lodger",
	"Josefin Sans" => "Josefin Sans",
	"Josefin Slab" => "Josefin Slab",
	"Joti One" => "Joti One",
	"Judson" => "Judson",
	"Julee" => "Julee",
	"Julius Sans One" => "Julius Sans One",
	"Junge" => "Junge",
	"Jura" => "Jura",
	"Just Another Hand" => "Just Another Hand",
	"Just Me Again Down Here" => "Just Me Again Down Here",
	"Kadwa" => "Kadwa",
	"Kalam" => "Kalam",
	"Kameron" => "Kameron",
	"Kanit" => "Kanit",
	"Kantumruy" => "Kantumruy",
	"Karla" => "Karla",
	"Karma" => "Karma",
	"Kaushan Script" => "Kaushan Script",
	"Kavoon" => "Kavoon",
	"Kdam Thmor" => "Kdam Thmor",
	"Keania One" => "Keania One",
	"Kelly Slab" => "Kelly Slab",
	"Kenia" => "Kenia",
	"Khand" => "Khand",
	"Khmer" => "Khmer",
	"Khula" => "Khula",
	"Kite One" => "Kite One",
	"Knewave" => "Knewave",
	"Kotta One" => "Kotta One",
	"Koulen" => "Koulen",
	"Kranky" => "Kranky",
	"Kreon" => "Kreon",
	"Kristi" => "Kristi",
	"Krona One" => "Krona One",
	"Kurale" => "Kurale",
	"La Belle Aurore" => "La Belle Aurore",
	"Laila" => "Laila",
	"Lakki Reddy" => "Lakki Reddy",
	"Lancelot" => "Lancelot",
	"Lateef" => "Lateef",
	"Lato" => "Lato",
	"League Script" => "League Script",
	"Leckerli One" => "Leckerli One",
	"Ledger" => "Ledger",
	"Lekton" => "Lekton",
	"Lemon" => "Lemon",
	"Libre Baskerville" => "Libre Baskerville",
	"Life Savers" => "Life Savers",
	"Lilita One" => "Lilita One",
	"Lily Script One" => "Lily Script One",
	"Limelight" => "Limelight",
	"Linden Hill" => "Linden Hill",
	"Lobster" => "Lobster",
	"Lobster Two" => "Lobster Two",
	"Londrina Outline" => "Londrina Outline",
	"Londrina Shadow" => "Londrina Shadow",
	"Londrina Sketch" => "Londrina Sketch",
	"Londrina Solid" => "Londrina Solid",
	"Lora" => "Lora",
	"Love Ya Like A Sister" => "Love Ya Like A Sister",
	"Loved by the King" => "Loved by the King",
	"Lovers Quarrel" => "Lovers Quarrel",
	"Luckiest Guy" => "Luckiest Guy",
	"Lusitana" => "Lusitana",
	"Lustria" => "Lustria",
	"Macondo" => "Macondo",
	"Macondo Swash Caps" => "Macondo Swash Caps",
	"Magra" => "Magra",
	"Maiden Orange" => "Maiden Orange",
	"Mako" => "Mako",
	"Mallanna" => "Mallanna",
	"Mandali" => "Mandali",
	"Marcellus" => "Marcellus",
	"Marcellus SC" => "Marcellus SC",
	"Marck Script" => "Marck Script",
	"Margarine" => "Margarine",
	"Marko One" => "Marko One",
	"Marmelad" => "Marmelad",
	"Martel" => "Martel",
	"Martel Sans" => "Martel Sans",
	"Marvel" => "Marvel",
	"Mate" => "Mate",
	"Mate SC" => "Mate SC",
	"Maven Pro" => "Maven Pro",
	"McLaren" => "McLaren",
	"Meddon" => "Meddon",
	"MedievalSharp" => "MedievalSharp",
	"Medula One" => "Medula One",
	"Megrim" => "Megrim",
	"Meie Script" => "Meie Script",
	"Merienda" => "Merienda",
	"Merienda One" => "Merienda One",
	"Merriweather" => "Merriweather",
	"Merriweather Sans" => "Merriweather Sans",
	"Metal" => "Metal",
	"Metal Mania" => "Metal Mania",
	"Metamorphous" => "Metamorphous",
	"Metrophobic" => "Metrophobic",
	"Michroma" => "Michroma",
	"Milonga" => "Milonga",
	"Miltonian" => "Miltonian",
	"Miltonian Tattoo" => "Miltonian Tattoo",
	"Miniver" => "Miniver",
	"Miss Fajardose" => "Miss Fajardose",
	"Modak" => "Modak",
	"Modern Antiqua" => "Modern Antiqua",
	"Molengo" => "Molengo",
	"Molle" => "Molle",
	"Monda" => "Monda",
	"Monofett" => "Monofett",
	"Monoton" => "Monoton",
	"Monsieur La Doulaise" => "Monsieur La Doulaise",
	"Montaga" => "Montaga",
	"Montez" => "Montez",
	"Montserrat" => "Montserrat",
	"Montserrat Alternates" => "Montserrat Alternates",
	"Montserrat Subrayada" => "Montserrat Subrayada",
	"Moul" => "Moul",
	"Moulpali" => "Moulpali",
	"Mountains of Christmas" => "Mountains of Christmas",
	"Mouse Memoirs" => "Mouse Memoirs",
	"Mr Bedfort" => "Mr Bedfort",
	"Mr Dafoe" => "Mr Dafoe",
	"Mr De Haviland" => "Mr De Haviland",
	"Mrs Saint Delafield" => "Mrs Saint Delafield",
	"Mrs Sheppards" => "Mrs Sheppards",
	"Muli" => "Muli",
	"Mystery Quest" => "Mystery Quest",
	"NTR" => "NTR",
	"Neucha" => "Neucha",
	"Neuton" => "Neuton",
	"New Rocker" => "New Rocker",
	"News Cycle" => "News Cycle",
	"Niconne" => "Niconne",
	"Nixie One" => "Nixie One",
	"Nobile" => "Nobile",
	"Nokora" => "Nokora",
	"Norican" => "Norican",
	"Nosifer" => "Nosifer",
	"Nothing You Could Do" => "Nothing You Could Do",
	"Noticia Text" => "Noticia Text",
	"Noto Sans" => "Noto Sans",
	"Noto Serif" => "Noto Serif",
	"Nova Cut" => "Nova Cut",
	"Nova Flat" => "Nova Flat",
	"Nova Mono" => "Nova Mono",
	"Nova Oval" => "Nova Oval",
	"Nova Round" => "Nova Round",
	"Nova Script" => "Nova Script",
	"Nova Slim" => "Nova Slim",
	"Nova Square" => "Nova Square",
	"Numans" => "Numans",
	"Nunito" => "Nunito",
	"Odor Mean Chey" => "Odor Mean Chey",
	"Offside" => "Offside",
	"Old Standard TT" => "Old Standard TT",
	"Oldenburg" => "Oldenburg",
	"Oleo Script" => "Oleo Script",
	"Oleo Script Swash Caps" => "Oleo Script Swash Caps",
	"Open Sans" => "Open Sans",
	"Open Sans Condensed" => "Open Sans Condensed",
	"Oranienbaum" => "Oranienbaum",
	"Orbitron" => "Orbitron",
	"Oregano" => "Oregano",
	"Orienta" => "Orienta",
	"Original Surfer" => "Original Surfer",
	"Oswald" => "Oswald",
	"Over the Rainbow" => "Over the Rainbow",
	"Overlock" => "Overlock",
	"Overlock SC" => "Overlock SC",
	"Ovo" => "Ovo",
	"Oxygen" => "Oxygen",
	"Oxygen Mono" => "Oxygen Mono",
	"PT Mono" => "PT Mono",
	"PT Sans" => "PT Sans",
	"PT Sans Caption" => "PT Sans Caption",
	"PT Sans Narrow" => "PT Sans Narrow",
	"PT Serif" => "PT Serif",
	"PT Serif Caption" => "PT Serif Caption",
	"Pacifico" => "Pacifico",
	"Palanquin" => "Palanquin",
	"Palanquin Dark" => "Palanquin Dark",
	"Paprika" => "Paprika",
	"Parisienne" => "Parisienne",
	"Passero One" => "Passero One",
	"Passion One" => "Passion One",
	"Pathway Gothic One" => "Pathway Gothic One",
	"Patrick Hand" => "Patrick Hand",
	"Patrick Hand SC" => "Patrick Hand SC",
	"Patua One" => "Patua One",
	"Paytone One" => "Paytone One",
	"Peddana" => "Peddana",
	"Peralta" => "Peralta",
	"Permanent Marker" => "Permanent Marker",
	"Petit Formal Script" => "Petit Formal Script",
	"Petrona" => "Petrona",
	"Philosopher" => "Philosopher",
	"Piedra" => "Piedra",
	"Pinyon Script" => "Pinyon Script",
	"Pirata One" => "Pirata One",
	"Plaster" => "Plaster",
	"Play" => "Play",
	"Playball" => "Playball",
	"Playfair Display" => "Playfair Display",
	"Playfair Display SC" => "Playfair Display SC",
	"Podkova" => "Podkova",
	"Poiret One" => "Poiret One",
	"Poller One" => "Poller One",
	"Poly" => "Poly",
	"Pompiere" => "Pompiere",
	"Pontano Sans" => "Pontano Sans",
	"Poppins" => "Poppins",
	"Port Lligat Sans" => "Port Lligat Sans",
	"Port Lligat Slab" => "Port Lligat Slab",
	"Pragati Narrow" => "Pragati Narrow",
	"Prata" => "Prata",
	"Preahvihear" => "Preahvihear",
	"Press Start 2P" => "Press Start 2P",
	"Princess Sofia" => "Princess Sofia",
	"Prociono" => "Prociono",
	"Prosto One" => "Prosto One",
	"Puritan" => "Puritan",
	"Purple Purse" => "Purple Purse",
	"Quando" => "Quando",
	"Quantico" => "Quantico",
	"Quattrocento" => "Quattrocento",
	"Quattrocento Sans" => "Quattrocento Sans",
	"Questrial" => "Questrial",
	"Quicksand" => "Quicksand",
	"Quintessential" => "Quintessential",
	"Qwigley" => "Qwigley",
	"Racing Sans One" => "Racing Sans One",
	"Radley" => "Radley",
	"Rajdhani" => "Rajdhani",
	"Raleway" => "Raleway",
	"Raleway Dots" => "Raleway Dots",
	"Ramabhadra" => "Ramabhadra",
	"Ramaraja" => "Ramaraja",
	"Rambla" => "Rambla",
	"Rammetto One" => "Rammetto One",
	"Ranchers" => "Ranchers",
	"Rancho" => "Rancho",
	"Ranga" => "Ranga",
	"Rationale" => "Rationale",
	"Ravi Prakash" => "Ravi Prakash",
	"Redressed" => "Redressed",
	"Reenie Beanie" => "Reenie Beanie",
	"Revalia" => "Revalia",
	"Rhodium Libre" => "Rhodium Libre",
	"Ribeye" => "Ribeye",
	"Ribeye Marrow" => "Ribeye Marrow",
	"Righteous" => "Righteous",
	"Risque" => "Risque",
	"Roboto" => "Roboto",
	"Roboto Condensed" => "Roboto Condensed",
	"Roboto Mono" => "Roboto Mono",
	"Roboto Slab" => "Roboto Slab",
	"Rochester" => "Rochester",
	"Rock Salt" => "Rock Salt",
	"Rokkitt" => "Rokkitt",
	"Romanesco" => "Romanesco",
	"Ropa Sans" => "Ropa Sans",
	"Rosario" => "Rosario",
	"Rosarivo" => "Rosarivo",
	"Rouge Script" => "Rouge Script",
	"Rozha One" => "Rozha One",
	"Rubik" => "Rubik",
	"Rubik Mono One" => "Rubik Mono One",
	"Rubik One" => "Rubik One",
	"Ruda" => "Ruda",
	"Rufina" => "Rufina",
	"Ruge Boogie" => "Ruge Boogie",
	"Ruluko" => "Ruluko",
	"Rum Raisin" => "Rum Raisin",
	"Ruslan Display" => "Ruslan Display",
	"Russo One" => "Russo One",
	"Ruthie" => "Ruthie",
	"Rye" => "Rye",
	"Sacramento" => "Sacramento",
	"Sahitya" => "Sahitya",
	"Sail" => "Sail",
	"Salsa" => "Salsa",
	"Sanchez" => "Sanchez",
	"Sancreek" => "Sancreek",
	"Sansita One" => "Sansita One",
	"Sarala" => "Sarala",
	"Sarina" => "Sarina",
	"Sarpanch" => "Sarpanch",
	"Satisfy" => "Satisfy",
	"Scada" => "Scada",
	"Scheherazade" => "Scheherazade",
	"Schoolbell" => "Schoolbell",
	"Seaweed Script" => "Seaweed Script",
	"Sevillana" => "Sevillana",
	"Seymour One" => "Seymour One",
	"Shadows Into Light" => "Shadows Into Light",
	"Shadows Into Light Two" => "Shadows Into Light Two",
	"Shanti" => "Shanti",
	"Share" => "Share",
	"Share Tech" => "Share Tech",
	"Share Tech Mono" => "Share Tech Mono",
	"Shojumaru" => "Shojumaru",
	"Short Stack" => "Short Stack",
	"Siemreap" => "Siemreap",
	"Sigmar One" => "Sigmar One",
	"Signika" => "Signika",
	"Signika Negative" => "Signika Negative",
	"Simonetta" => "Simonetta",
	"Sintony" => "Sintony",
	"Sirin Stencil" => "Sirin Stencil",
	"Six Caps" => "Six Caps",
	"Skranji" => "Skranji",
	"Slabo 13px" => "Slabo 13px",
	"Slabo 27px" => "Slabo 27px",
	"Slackey" => "Slackey",
	"Smokum" => "Smokum",
	"Smythe" => "Smythe",
	"Sniglet" => "Sniglet",
	"Snippet" => "Snippet",
	"Snowburst One" => "Snowburst One",
	"Sofadi One" => "Sofadi One",
	"Sofia" => "Sofia",
	"Sonsie One" => "Sonsie One",
	"Sorts Mill Goudy" => "Sorts Mill Goudy",
	"Source Code Pro" => "Source Code Pro",
	"Source Sans Pro" => "Source Sans Pro",
	"Source Serif Pro" => "Source Serif Pro",
	"Special Elite" => "Special Elite",
	"Spicy Rice" => "Spicy Rice",
	"Spinnaker" => "Spinnaker",
	"Spirax" => "Spirax",
	"Squada One" => "Squada One",
	"Sree Krushnadevaraya" => "Sree Krushnadevaraya",
	"Stalemate" => "Stalemate",
	"Stalinist One" => "Stalinist One",
	"Stardos Stencil" => "Stardos Stencil",
	"Stint Ultra Condensed" => "Stint Ultra Condensed",
	"Stint Ultra Expanded" => "Stint Ultra Expanded",
	"Stoke" => "Stoke",
	"Strait" => "Strait",
	"Sue Ellen Francisco" => "Sue Ellen Francisco",
	"Sumana" => "Sumana",
	"Sunshiney" => "Sunshiney",
	"Supermercado One" => "Supermercado One",
	"Sura" => "Sura",
	"Suranna" => "Suranna",
	"Suravaram" => "Suravaram",
	"Suwannaphum" => "Suwannaphum",
	"Swanky and Moo Moo" => "Swanky and Moo Moo",
	"Syncopate" => "Syncopate",
	"Tangerine" => "Tangerine",
	"Taprom" => "Taprom",
	"Tauri" => "Tauri",
	"Teko" => "Teko",
	"Telex" => "Telex",
	"Tenali Ramakrishna" => "Tenali Ramakrishna",
	"Tenor Sans" => "Tenor Sans",
	"Text Me One" => "Text Me One",
	"The Girl Next Door" => "The Girl Next Door",
	"Tienne" => "Tienne",
	"Tillana" => "Tillana",
	"Timmana" => "Timmana",
	"Tinos" => "Tinos",
	"Titan One" => "Titan One",
	"Titillium Web" => "Titillium Web",
	"Trade Winds" => "Trade Winds",
	"Trocchi" => "Trocchi",
	"Trochut" => "Trochut",
	"Trykker" => "Trykker",
	"Tulpen One" => "Tulpen One",
	"Ubuntu" => "Ubuntu",
	"Ubuntu Condensed" => "Ubuntu Condensed",
	"Ubuntu Mono" => "Ubuntu Mono",
	"Ultra" => "Ultra",
	"Uncial Antiqua" => "Uncial Antiqua",
	"Underdog" => "Underdog",
	"Unica One" => "Unica One",
	"UnifrakturCook" => "UnifrakturCook",
	"UnifrakturMaguntia" => "UnifrakturMaguntia",
	"Unkempt" => "Unkempt",
	"Unlock" => "Unlock",
	"Unna" => "Unna",
	"VT323" => "VT323",
	"Vampiro One" => "Vampiro One",
	"Varela" => "Varela",
	"Varela Round" => "Varela Round",
	"Vast Shadow" => "Vast Shadow",
	"Vesper Libre" => "Vesper Libre",
	"Vibur" => "Vibur",
	"Vidaloka" => "Vidaloka",
	"Viga" => "Viga",
	"Voces" => "Voces",
	"Volkhov" => "Volkhov",
	"Vollkorn" => "Vollkorn",
	"Voltaire" => "Voltaire",
	"Waiting for the Sunrise" => "Waiting for the Sunrise",
	"Wallpoet" => "Wallpoet",
	"Walter Turncoat" => "Walter Turncoat",
	"Warnes" => "Warnes",
	"Wellfleet" => "Wellfleet",
	"Wendy One" => "Wendy One",
	"Wire One" => "Wire One",
	"Work Sans" => "Work Sans",
	"Yanone Kaffeesatz" => "Yanone Kaffeesatz",
	"Yantramanav" => "Yantramanav",
	"Yellowtail" => "Yellowtail",
	"Yeseva One" => "Yeseva One",
	"Yesteryear" => "Yesteryear",
	"Zeyada" => "Zeyada",
);

asort($font_primary_list);
asort($font_secondary_list);

$font_primary_list      = array_merge(array("none" => "Use default"), $font_primary_list, $sep, $google_fonts_list);
$font_secondary_list    = array_merge(array("none" => "Use default"), $font_secondary_list, $sep, $google_fonts_list);

$of_options[] = array( 	"name" 		=> "Primary Font",
						"desc" 		=> "Select main font to be used in paragraphs and other sections.",
						"id" 		=> "font_primary",
						"std" 		=> "Select a font",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "This is how the text looks in the site",
										"size" => "30px"
						),
						"options" 	=> $font_primary_list
				);

$of_options[] = array( 	"name" 		=> "Heading Font",
						"desc" 		=> "Font type that is used on headings.",
						"id" 		=> "font_secondary",
						"std" 		=> "Select a font",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "This is how the text looks in the site",
										"size" => "30px"
						),
						"options" 	=> $font_secondary_list
				);


$of_options[] = array( 	"name" 		=> "Base Font Size",
					 	"desc" 		=> "Increase or dececrease overall font size.",
						"id" 		=> "font_size_base",
						"std" 		=> "Use default",
						"type" 		=> "select",
						"options" 	=> array("Use default", 10, 11, 12, 13, 14, 15, 16)
				);


$of_options[] = array( 	"name" 		=> "Text Transform",
					 	"desc" 		=> "Transform the text used on heading, labels and buttons.",
						"id" 		=> "font_to_lowercase",
						"std" 		=> "Upper Case",
						"type" 		=> "select",
						"options" 	=> array("Upper Case", "Default Case")
				);


$of_options[] = array( 	"name" 		=> "Custom Google Fonts",
						"desc" 		=> "",
						"id" 		=> "custom_gf",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Including Custom Google Fonts</h3>
						If you want to add your personal font to your site (from Google Webfonts) you can apply the font parameters in the below fields.<br />
						Firstly include the font URL that is given in Google Webfonts site, then enter the name of that font (without <em>font-family:</em>) next to that field.<br />
						Otherwise, leave the field empty to use default font selected in the list above.",
						"icon" 		=> true,
						"type" 		=> "info"
				);


$of_options[] = array( 	"name" 		=> "Primary Font",
						"desc" 		=> "Primary font URL",
						"id" 		=> "custom_primary_font_url",
						"std" 		=> "",
						"plc"		=> "i.e. http://fonts.googleapis.com/css?family=Oswald",
						"type" 		=> "text"
				);


$of_options[] = array( 	"desc" 		=> "Primary font name",
						"id" 		=> "custom_primary_font_name",
						"std" 		=> "",
						"plc"		=> "'Oswald', sans-serif",
						"type" 		=> "text"
				);


$of_options[] = array( 	"name" 		=> "Heading Font",
						"desc" 		=> "Heading font URL",
						"id" 		=> "custom_heading_font_url",
						"std" 		=> "",
						"plc"		=> "i.e. http://fonts.googleapis.com/css?family=Oswald",
						"type" 		=> "text"
				);


$of_options[] = array( 	"desc" 		=> "Heading font name",
						"id" 		=> "custom_heading_font_name",
						"std" 		=> "",
						"plc"		=> "'Oswald', sans-serif",
						"type" 		=> "text"
				);



$of_options[] = array( 	"name" 		=> "Theme Styling",
						"type" 		=> "heading"
				);



$of_options[] = array( 	"name" 		=> "Theme Skin",
						"desc" 		=> "Select predefined skins to use with this theme.",
						"id" 		=> "use_skin_type",
						"std" 		=> THEMEASSETS . 'images/skin-type-1.png',
						"type" 		=> "tiles",
						"options"	=> array(
							THEMEASSETS . 'images/skin-type-1.png',
							THEMEASSETS . 'images/skin-type-2.png',
							THEMEASSETS . 'images/skin-type-3.png',
							THEMEASSETS . 'images/skin-type-4.png',
							THEMEASSETS . 'images/skin-type-5.png',
							THEMEASSETS . 'images/skin-type-6.png',
							THEMEASSETS . 'images/skin-type-7.png',
							THEMEASSETS . 'images/skin-type-8.png',
						)
				);

$of_options[] = array(  "name"		=> "Custom Skin Builder",
						"desc"   	=> "Use a custom skin with color picker.",
						"id"   		=> "use_custom_skin",
						"std"   	=> 0,
						"folds"  	=> 1,
						"on"  		=> "Yes",
						"off"  		=> "No",
						"type"   	=> "switch"
					);

$of_options[] = array(	"name"		=> "Select Skin Colors",
						"desc"   	=> "Choose main skin color.",
						"id"   		=> "custom_skin_main_color",
						"std"   	=> '',
						"fold"  	=> 'use_custom_skin',
						"type"   	=> "color"
					);

$of_options[] = array(	"desc"   	=> "Choose menu link color.",
						"id"   		=> "custom_skin_menu_link_color",
						"std"   	=> '#333333',
						"fold"  	=> 'use_custom_skin',
						"type"   	=> "color"
					);

$is_writtable_custom_skin = '';

if( ! is_writable(THEMEDIR . 'assets/css/custom-skin.less'))
{
	$is_writtable_custom_skin = '<div title="Location:'."\n".THEMEASSETS.'css/custom-skin.css" style="color: #c00; padding-top: 10px;">Warning: <strong>custom-skin.css</strong> is not writable, skin cannot be compiled!</div> ';
}

$of_options[] = array(	"desc"   	=> "Choose background color." . $is_writtable_custom_skin,
						"id"   		=> "custom_skin_background_color",
						"std"   	=> '#EEEEEE',
						"fold"  	=> 'use_custom_skin',
						"type"   	=> "color"
					);


$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "",
						"id" 		=> "custom_css_feature",
						"std" 		=> "<h3 style=\"margin: 0 0 10px;\">Custom CSS in a New Interface</h3>
						We have created a better interface for adding your custom CSS which is more flexible and includes syntax highlighting. However you can still add custom CSS in the fields below.
						<br />
						<br />
						<a href=\"admin.php?page=laborator_custom_css\" class=\"button\">Go to new Custom CSS Editor</a>",
						"icon" 		=> true,
						"type" 		=> "info"
				);


$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Apply your own custom CSS to all site pages.<br /><br />CSS is automatically wrapped with &lt;style&gt;&lt;/style&gt; tags.",
						"id" 		=> "custom_css_general",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"name" 		=> "Media Queries CSS",
						"desc" 		=> "Large Screen<br />For screen width: <strong>1200px</strong> - <strong>larger size</strong>.",
						"id" 		=> "custom_css_general_lg",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"desc" 		=> "Laptop<br />For screen width: <strong>992px</strong> - <strong>larger size</strong>.",
						"id" 		=> "custom_css_general_md",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"desc" 		=> "Tablet<br />For screen width: <strong>768px</strong> - <strong>991px</strong>.",
						"id" 		=> "custom_css_general_sm",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"desc" 		=> "Mobile<br />For screen width: <strong>480px</strong> - <strong>767px</strong>.",
						"id" 		=> "custom_css_general_xs",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"desc" 		=> "Mobile<br />For screen width: <strong>0px</strong> - <strong>479px</strong>.",
						"id" 		=> "custom_css_general_xxs",
						"std" 		=> "",
						"type" 		=> "textarea"
				);


$of_options[] = array( 	"name" 		=> "Social Networks",
						"type" 		=> "heading"
				);

$social_networks_ordering = array(
			"visible" => array (
				"placebo"	=> "placebo",
				"fb"   	 	=> "Facebook",
				"tw"   	 	=> "Twitter",
			),

			"hidden" => array (
				"placebo"   => "placebo",
				"gp"        => "Google+",
				"lin"       => "LinkedIn",
				"yt"        => "YouTube",
				"vm"        => "Vimeo",
				"drb"       => "Dribbble",
				"ig"        => "Instagram",
				"pi"        => "Pinterest",
				"vk"        => "VKontakte",
				"tu"        => "Tumblr",
			),
);

$of_options[] = array( 	"name" 		=> "Social Networks Ordering",
						"desc" 		=> "Set the appearing order of social networks in the footer. To use social networks links list copy this shortcode: <code style='font-size: 10px; display: inline-block; margin-top: 10px;'>[lab_social_networks]</code>",
						"id" 		=> "social_order",
						"std" 		=> $social_networks_ordering,
						"type" 		=> "sorter"
				);

$of_options[] = array( 	"name" 		=> "Social Networks",
						"desc" 		=> "Facebook",
						"id" 		=> "social_network_link_fb",
						"std" 		=> "",
						"plc"		=> "http://facebook.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Twitter",
						"id" 		=> "social_network_link_tw",
						"std" 		=> "",
						"plc"		=> "http://twitter.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "LinkedIn",
						"id" 		=> "social_network_link_lin",
						"std" 		=> "",
						"plc"		=> "http://linkedin.com/in/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "YouTube",
						"id" 		=> "social_network_link_yt",
						"std" 		=> "",
						"plc"		=> "http://youtube.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Vimeo",
						"id" 		=> "social_network_link_vm",
						"std" 		=> "",
						"plc"		=> "http://vimeo.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Dribble",
						"id" 		=> "social_network_link_drb",
						"std" 		=> "",
						"plc"		=> "http://dribbble.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Instagram",
						"id" 		=> "social_network_link_ig",
						"std" 		=> "",
						"plc"		=> "http://instagram.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Pinterest",
						"id" 		=> "social_network_link_pi",
						"std" 		=> "",
						"plc"		=> "http://pinterest.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Google Plus",
						"id" 		=> "social_network_link_gp",
						"std" 		=> "",
						"plc"		=> "http://plus.google.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "VKontakte",
						"id" 		=> "social_network_link_vk",
						"std" 		=> "",
						"plc"		=> "http://vk.com/username",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "",
						"desc" 		=> "Tumblr",
						"id" 		=> "social_network_link_tu",
						"std" 		=> "",
						"plc"		=> "http://username.tumblr.com",
						"type" 		=> "text"
				);

### END: OXYGEN ###


// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
						"icon"		=> ADMIN_IMAGES . "icon-slider.png"
				);
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);

$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);

$of_options[] = array( 	"name" 		=> "Changelog",
						"type" 		=> "heading",
				);

	}//End function: of_options()
}//End chack if function exists: of_options()
