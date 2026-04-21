<?php
/**
 * Plugin Name:       Lexington Alarm Custom
 * Plugin URI:        https://github.com/tobysackton/lexington_alarm
 * Description:       Site-specific customizations for lexingtonalarm.org — WooCommerce integrations, news system, newsletter archive, campaign tooling, performance snippets. Gradually absorbing logic currently living in WPCode snippets.
 * Version:           0.1.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Lexington Alarm (Toby Sackton)
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       la-custom
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin version and base path constants.
define( 'LA_CUSTOM_VERSION', '0.1.0' );
define( 'LA_CUSTOM_PATH', plugin_dir_path( __FILE__ ) );
define( 'LA_CUSTOM_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin modules.
 *
 * Each module is a subdirectory under includes/ that corresponds to a
 * functional area. Modules register their own hooks when loaded.
 *
 * Keep this list in the same order as docs/ — woocommerce, news, newsletter,
 * campaigns, performance — so contributors can map behavior to docs quickly.
 *
 * As WPCode snippets migrate into this plugin, add the appropriate
 * includes/<domain>/*.php and reference them here.
 */
function la_custom_load_modules() {
	$modules = array(
		// Migration targets — to be populated as snippets port over.
		// 'woocommerce/email-labels.php',
		// 'woocommerce/shipping-messages.php',
		// 'news/frontend-posting.php',
		// 'newsletter/archive-shortcode.php',
		// 'campaigns/massport-pdf.php',
		// 'performance/optimization.php',
	);

	foreach ( $modules as $module ) {
		$path = LA_CUSTOM_PATH . 'includes/' . $module;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}
add_action( 'plugins_loaded', 'la_custom_load_modules' );

/**
 * Plugin activation hook.
 */
function la_custom_activate() {
	// Reserved for future setup (option defaults, cron jobs, etc.).
}
register_activation_hook( __FILE__, 'la_custom_activate' );

/**
 * Plugin deactivation hook.
 */
function la_custom_deactivate() {
	// Reserved for future cleanup.
}
register_deactivation_hook( __FILE__, 'la_custom_deactivate' );
