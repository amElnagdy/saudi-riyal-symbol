<?php

/**
 * Plugin Name: Saudi Riyal Symbol for WooCommerce
 * Plugin URI: https://github.com/amElnagdy/saudi-riyal-symbol
 * Description: Updates the Saudi Riyal currency symbol in WooCommerce
 * Version: 1.0.0
 * Author: Nagdy
 * Author URI: https://nagdy.me
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: saudi-riyal-symbol
 * Domain Path: /languages
 *
 * WC requires at least: 3.0.0
 * WC tested up to: 9.7.0
 */

// If this file is called directly, abort.
use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Filter WooCommerce currency symbols to add the new Saudi Riyal symbol.
 *
 * @param array $symbols Array of currency symbols.
 *
 * @return array Modified array of currency symbols.
 */
function sar_add_currency_symbol( $symbols ): array {
	if ( ! is_admin() ) {
		$symbols['SAR'] = '<span class="saudi-riyal-symbol"></span>';
	}

	return $symbols;
}

add_filter( 'woocommerce_currency_symbols', 'sar_add_currency_symbol' );

/**
 * Add CSS for proper display of the new Saudi Riyal symbol.
 */
function sar_symbol_css(): void {
	if ( get_woocommerce_currency() === 'SAR' ) {
		$plugin_url = plugin_dir_url( __FILE__ );
		?>
        <style type="text/css">
            .saudi-riyal-symbol {
                display: inline-block;
                width: 0.8em;
                height: 0.9em;
                background-image: url('<?php echo $plugin_url; ?>assets/saudi-riyal-symbol.svg');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                vertical-align: middle;
                margin-right: 0.15em;
                position: relative;
                top: -0.05em;
            }
        </style>
		<?php
	}
}

add_action( 'wp_head', 'sar_symbol_css' );

/**
 * Declare compatibility with WooCommerce Custom Order Tables.
 */
add_action(
	'before_woocommerce_init',
	function () {
		if ( class_exists( 'Automattic\WooCommerce\Utilities\FeaturesUtil' ) ) {
			FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}
);
