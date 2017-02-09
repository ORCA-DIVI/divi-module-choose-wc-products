<?php
/**
 * Plugin Name: Divi Module Choose WC Products 
 * Description: Custom module for Divi theme allow you to choose which WooCommerce products you want to show by checkbox. Requires first Divi theme to work !
 * Version: 1.0.0
 * Author: Marie Comet
 * License: MIT License
 * Text Domain: Divi
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
function MC_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'Divi Module Choose WC Products requires Divi theme to work !', 'Divi' ); ?></p>
    </div>  
    <?php
}
function MC_Custom_Module() {
	if(class_exists("ET_Builder_Module")){
		class ET_Builder_Module_Product_Choose extends ET_Builder_Module {
			function init() {
				$this->name = esc_html__( 'Produits choisis', 'et_builder' );
				$this->slug = 'et_pb_choose_shop';
				$this->custom_css_tab = false;

				$this->whitelisted_fields = array(
					'type',
					'include_products',
					'columns_number',
					'orderby',
					'admin_label',
					'module_id',
					'module_class',
					'sale_badge_color',
					'icon_hover_color',
					'hover_overlay_color',
					'hover_icon',
				);

				$this->fields_defaults = array(
					'type'           => array( 'recent' ),
					'columns_number' => array( '0' ),
					'orderby'        => array( 'menu_order' ),
				);

				$this->main_css_element = '%%order_class%%.et_pb_choose_shop';
			}

			function get_fields() {
				$fields = array(
					'type' => array(
						'label'           => esc_html__( 'Type', 'et_builder' ),
						'type'            => 'select',
						'option_category' => 'basic_option',
						'options'         => array(
							'recent'  => esc_html__( 'Recent Products', 'et_builder' ),
							'featured' => esc_html__( 'Featured Products', 'et_builder' ),
							'sale' => esc_html__( 'Sale Products', 'et_builder' ),
							'best_selling' => esc_html__( 'Best Selling Products', 'et_builder' ),
							'top_rated' => esc_html__( 'Top Rated Products', 'et_builder' ),
							'product_category' => esc_html__( 'Product Category', 'et_builder' ),
						),
						'affects'            => array(
							'input[name="et_pb_include_categories"]',
						),
						'description'        => esc_html__( 'Choose which type of products you would like to display.', 'et_builder' ),
					),
					'include_products' => array(
						'label'            => __( 'Produits à afficher', 'et_builder' ),
						'option_category'  => 'basic_option',
						'renderer'         => 'et_builder_include_products_option',				
						'description'      => __( 'Choose which products you would like to include in the feed.', 'et_builder' ),
					),
					'columns_number' => array(
						'label'             => esc_html__( 'Columns Number', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'layout',
						'options'           => array(
							'0' => esc_html__( 'default', 'et_builder' ),
							'6' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '6' ) ),
							'5' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '5' ) ),
							'4' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '4' ) ),
							'3' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '3' ) ),
							'2' => sprintf( esc_html__( '%1$s Columns', 'et_builder' ), esc_html( '2' ) ),
							'1' => esc_html__( '1 Column', 'et_builder' ),
						),
						'description'        => esc_html__( 'Choose how many columns to display.', 'et_builder' ),
					),
					'orderby' => array(
						'label'             => esc_html__( 'Order By', 'et_builder' ),
						'type'              => 'select',
						'option_category'   => 'configuration',
						'options'           => array(
							'menu_order'  => esc_html__( 'Default Sorting', 'et_builder' ),
							'popularity' => esc_html__( 'Sort By Popularity', 'et_builder' ),
							'rating' => esc_html__( 'Sort By Rating', 'et_builder' ),
							'date' => esc_html__( 'Sort By Date', 'et_builder' ),
							'price' => esc_html__( 'Sort By Price: Low To High', 'et_builder' ),
							'price-desc' => esc_html__( 'Sort By Price: High To Low', 'et_builder' ),
						),
						'description'        => esc_html__( 'Choose how your products should be ordered.', 'et_builder' ),
					),
					'sale_badge_color' => array(
						'label'             => esc_html__( 'Sale Badge Color', 'et_builder' ),
						'type'              => 'color',
						'custom_color'      => true,
						'tab_slug'          => 'advanced',
					),
					'icon_hover_color' => array(
						'label'             => esc_html__( 'Icon Hover Color', 'et_builder' ),
						'type'              => 'color',
						'custom_color'      => true,
						'tab_slug'          => 'advanced',
					),
					'hover_overlay_color' => array(
						'label'             => esc_html__( 'Hover Overlay Color', 'et_builder' ),
						'type'              => 'color-alpha',
						'custom_color'      => true,
						'tab_slug'          => 'advanced',
					),
					'hover_icon' => array(
						'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
						'type'                => 'text',
						'option_category'     => 'configuration',
						'class'               => array( 'et-pb-font-icon' ),
						'renderer'            => 'et_pb_get_font_icon_list',
						'renderer_with_field' => true,
						'tab_slug'            => 'advanced',
					),
					'disabled_on' => array(
						'label'           => esc_html__( 'Disable on', 'et_builder' ),
						'type'            => 'multiple_checkboxes',
						'options'         => array(
							'phone'   => esc_html__( 'Phone', 'et_builder' ),
							'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
							'desktop' => esc_html__( 'Desktop', 'et_builder' ),
						),
						'additional_att'  => 'disable_on',
						'option_category' => 'configuration',
						'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
					),
					'admin_label' => array(
						'label'       => esc_html__( 'Admin Label', 'et_builder' ),
						'type'        => 'text',
						'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
					),
					'module_id' => array(
						'label'           => esc_html__( 'CSS ID', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
					'module_class' => array(
						'label'           => esc_html__( 'CSS Class', 'et_builder' ),
						'type'            => 'text',
						'option_category' => 'configuration',
						'tab_slug'        => 'custom_css',
						'option_class'    => 'et_pb_custom_css_regular',
					),
				);
				return $fields;
			}

			function add_product_class_name( $classes ) {
				$classes[] = 'product';

				return $classes;
			}

			function get_shop() {
				$type                    = $this->shortcode_atts['type'];
				$include_products      = $this->shortcode_atts['include_products'];
				$orderby                 = $this->shortcode_atts['orderby'];
				$columns                 = $this->shortcode_atts['columns_number'];

				$woocommerce_shortcodes_types = array(
					'recent'       => 'recent_products',
					'featured'     => 'featured_products',
					'sale'         => 'sale_products',
					'best_selling' => 'best_selling_products',
					'top_rated'    => 'top_rated_products',
				);

				/**
				 * Actually, orderby parameter used by WooCommerce shortcode is equal to orderby parameter used by WP_Query
				 * Hence customize WooCommerce' product query via modify_woocommerce_shortcode_products_query method
				 * @see http://docs.woothemes.com/document/woocommerce-shortcodes/#section-5
				 */
				$modify_woocommerce_query = in_array( $orderby, array( 'menu_order', 'price', 'price-desc', 'rating', 'popularity' ) );

				if ( $modify_woocommerce_query ) {
					add_filter( 'woocommerce_shortcode_products_query', array( $this, 'modify_woocommerce_shortcode_products_query' ), 10, 2 );
				}

				do_action( 'et_pb_shop_before_print_shop' );

				$shop = do_shortcode(
					sprintf( '[products ids="%1$s" orderby="%2$s" columns="%3$s"]',
						esc_attr( $include_products ),
						esc_attr( $orderby ),
						esc_attr( $columns )
					)
				);

				do_action( 'et_pb_shop_after_print_shop' );

				/**
				 * Remove modify_woocommerce_shortcode_products_query method after being used
				 */
				if ( $modify_woocommerce_query ) {
					remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'modify_woocommerce_shortcode_products_query' ) );

					if ( function_exists( 'WC' ) ) {
						WC()->query->remove_ordering_args(); // remove args added by woocommerce to avoid errors in sql queries performed afterwards
					}
				}

				return $shop;
			}

			/**
			 * Get shop HTML for shp module
			 *
			 * @param array   arguments that affect shop output
			 * @param array   passed conditional tag for update process
			 * @param array   passed current page params
			 * @return string HTML markup for shop module
			 */
			static function get_shop_html( $args = array(), $conditional_tags = array(), $current_page = array() ) {
				$shop = new self();

				do_action( 'et_pb_get_shop_html_before' );

				$shop->shortcode_atts = $args;

				// Force product loop to have 'product' class name. It appears that 'product' class disappears
				// when $this->get_shop() is being called for update / from admin-ajax.php
				add_filter( 'post_class', array( $shop, 'add_product_class_name' ) );

				// Get product HTML
				$output = $shop->get_shop();

				// Remove 'product' class addition to product loop's post class
				remove_filter( 'post_class', array( $shop, 'add_product_class_name' ) );

				do_action( 'et_pb_get_shop_html_after' );

				return $output;
			}

			function shortcode_callback( $atts, $content = null, $function_name ) {
				$module_id               = $this->shortcode_atts['module_id'];
				$module_class            = $this->shortcode_atts['module_class'];
				$type                    = $this->shortcode_atts['type'];
				$include_products	     = $this->shortcode_atts['include_products'];
				$orderby                 = $this->shortcode_atts['orderby'];
				$columns                 = $this->shortcode_atts['columns_number'];
				$sale_badge_color        = $this->shortcode_atts['sale_badge_color'];
				$icon_hover_color        = $this->shortcode_atts['icon_hover_color'];
				$hover_overlay_color     = $this->shortcode_atts['hover_overlay_color'];
				$hover_icon              = $this->shortcode_atts['hover_icon'];

				$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

				if ( '' !== $sale_badge_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% span.onsale',
						'declaration' => sprintf(
							'background-color: %1$s !important;',
							esc_html( $sale_badge_color )
						),
					) );
				}

				if ( '' !== $icon_hover_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay:before',
						'declaration' => sprintf(
							'color: %1$s !important;',
							esc_html( $icon_hover_color )
						),
					) );
				}

				if ( '' !== $hover_overlay_color ) {
					ET_Builder_Element::set_style( $function_name, array(
						'selector'    => '%%order_class%% .et_overlay',
						'declaration' => sprintf(
							'background-color: %1$s !important;
							border-color: %1$s;',
							esc_html( $hover_overlay_color )
						),
					) );
				}

				$data_icon = '' !== $hover_icon
					? sprintf(
						' data-icon="%1$s"',
						esc_attr( et_pb_process_font_icon( $hover_icon ) )
					)
					: '';

				$woocommerce_shortcodes_types = array(
					'recent'       => 'recent_products',
					'featured'     => 'featured_products',
					'sale'         => 'sale_products',
					'best_selling' => 'best_selling_products',
					'top_rated'    => 'top_rated_products',
					'product_category' => 'product_category',
				);

				/**
				 * Actually, orderby parameter used by WooCommerce shortcode is equal to orderby parameter used by WP_Query
				 * Hence customize WooCommerce' product query via modify_woocommerce_shortcode_products_query method
				 * @see http://docs.woothemes.com/document/woocommerce-shortcodes/#section-5
				 */
				$modify_woocommerce_query = in_array( $orderby, array( 'menu_order', 'price', 'price-desc', 'rating', 'popularity' ) );

				if ( $modify_woocommerce_query ) {
					add_filter( 'woocommerce_shortcode_products_query', array( $this, 'modify_woocommerce_shortcode_products_query' ), 10, 2 );
				}

				$output = sprintf(
					'<div%2$s class="et_pb_module et_pb_shop%3$s%4$s"%5$s>
						%1$s
					</div>',
					$this->get_shop(),
					( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
					( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
					'0' === $columns ? ' et_pb_shop_grid' : '',
					$data_icon
				);

				return $output;
			}

			/**
			 * Modifying WooCommerce' product query filter based on $orderby value given
			 * @see WC_Query->get_catalog_ordering_args()
			 */
			function modify_woocommerce_shortcode_products_query( $args, $atts ) {

				if ( function_exists( 'WC' ) ) {
					// By default, all order is ASC except for price-desc
					$order = 'price-desc' === $this->shortcode_atts['orderby'] ? 'DESC' : 'ASC';

					// Supported orderby arguments (as defined by WC_Query->get_catalog_ordering_args() ): rand | date | price | popularity | rating | title
					$orderby = in_array( $this->shortcode_atts['orderby'], array( 'price-desc' ) ) ? 'price' : $this->shortcode_atts['orderby'];

					// Get arguments for the given non-native orderby
					$query_args = WC()->query->get_catalog_ordering_args( $orderby, $order );

					// Confirm that returned argument isn't empty then merge returned argument with default argument
					if( is_array( $query_args ) && ! empty( $query_args ) ) {
						$args = array_merge( $args, $query_args );
					}
				}

				return $args;
			}
		}
		new ET_Builder_Module_Product_Choose;

		function et_builder_include_products_option( $args = array() ) {
				  
			$output = "\t" . "<% var et_pb_include_products_temp = typeof et_pb_include_products !== 'undefined' ? et_pb_include_products.split( ',' ) : []; %>" . "\n";
			$myproducts = get_posts( array( 'posts_per_page' => -1, 'post_type' => 'product' ) );
				foreach ( $myproducts as $post ) {
				    $contains = sprintf(
				      '<%%= _.contains( et_pb_include_products_temp, "%1$s" ) ? checked="checked" : "" %%>',
				      esc_html( $post->ID )
				    );

				    $output .= sprintf(
				      '%4$s<label><input type="checkbox" name="et_pb_include_products" value="%1$s"%3$s> %2$s</label><br/>',
				      esc_attr( $post->ID ),
				      esc_html( get_the_title($post) ),
				      $contains,
				      "\n\t\t\t\t\t"
				    );
				}
			$output = '<div id="et_pb_include_products">' . $output . '</div>';
			return $output;
		}
	} else {
		add_action( 'admin_notices', 'MC_admin_notice' );      
		return;
	}
}

add_action('after_setup_theme', 'MC_prepareCustomModule', 999);
function MC_prepareCustomModule(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' ); // list of admin pages where we need more specific filtering
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import']; // Page Builder files should be loaded on import page as well to register the et_pb_layout post type properly
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'MC_Custom_Module', 9789);
	}
}