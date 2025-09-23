<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Vaathi WordPress theme
 */

function vaathi_tgmpa_plugins_register() {

	// Get array of recommended plugins.

	$plugins_list = array(
		array(
			'name' => esc_html__('Vaathi Plus', 'vaathi'),
			'slug' => 'vaathi-plus',
			'source' => VAATHI_MODULE_DIR . '/plugins/vaathi-plus.rar',
			'required' => true,
			'version' => '1.0.1',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Vaathi Pro', 'vaathi'),
			'slug' => 'vaathi-pro',
			'source' => VAATHI_MODULE_DIR . '/plugins/vaathi-pro.rar',
			'required' => true,
			'version' => '1.0.1',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Vaathi Shop', 'vaathi'),
			'slug' => 'vaathi-shop',
			'source' => VAATHI_MODULE_DIR . '/plugins/vaathi-shop.rar',
			'required' => true,
			'version' => '1.0.1',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('Elementor', 'vaathi'),
			'slug' => 'elementor',
			'required' => true,
		),
		array(
			'name' => esc_html__('WeDesignTech Elementor Addon', 'vaathi'),
			'slug' => 'wedesigntech-elementor-addon',
			'source' => VAATHI_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.rar',
			'required' => true,
			'version' => '1.0.1',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('WeDesignTech Ultimate Booking Addon', 'vaathi'),
			'slug' => 'wedesigntech-ultimate-booking-addon',
			'source' => VAATHI_MODULE_DIR . '/plugins/wedesigntech-ultimate-booking-addon.rar',
			'required' => true,
			'version' => '1.0.0',
			'force_activation' => false,
			'force_deactivation' => false,
		),
		array(
			'name' => esc_html__('FOX - Currency Switcher Professional for WooCommerce', 'vaathi'),
			'slug' => 'woocommerce-currency-switcher',
			'required' => true,
		),
		array(
			'name' => esc_html__('Variation Swatches for WooCommerce', 'vaathi'),
			'slug' => 'woo-variation-swatches',
			'required' => true,
		),
		array(
			'name' => esc_html__('GTranslate', 'vaathi'),
			'slug' => 'gtranslate',
			'required' => true,
		),
		array(
			'name' => esc_html__('The Events Calendar', 'vaathi'),
			'slug' => 'the-events-calendar',
			'required' => true,
		),
		array(
			'name' => esc_html__('TI WooCommerce Wishlist', 'vaathi'),
			'slug' => 'ti-woocommerce-wishlist',
			'required' => true,
		),
		array(
			'name' => esc_html__('WooCommerce', 'vaathi'),
			'slug' => 'woocommerce',
			'required' => true,
		),
		array(
			'name' => esc_html__('Contact Form 7', 'vaathi'),
			'slug' => 'contact-form-7',
			'required' => true,
		),
		array(
			'name' => esc_html__('One Click Demo Import', 'vaathi'),
			'slug' => 'one-click-demo-import',
			'required' => true,
		)
	);

    $plugins = apply_filters('vaathi_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'vaathi_theme',
		'domain'       => 'vaathi',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'vaathi_tgmpa_plugins_register' );