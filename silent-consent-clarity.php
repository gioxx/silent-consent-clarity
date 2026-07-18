<?php
/**
 * Silent Consent for Microsoft Clarity
 *
 * @package           Silent_Consent_Clarity
 * @author            Gioxx
 * @copyright         2025 Gioxx
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Silent Consent for Microsoft Clarity
 * Plugin URI:        https://go.gioxx.org/silentconsentclarity
 * Description:       Consent layer for Microsoft Clarity - automatically grants consent using existing Clarity configuration.
 * Version:           2.1.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            Gioxx
 * Author URI:        https://gioxx.org
 * Text Domain:       silent-consent-clarity
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * GitHub Plugin URI: gioxx/silent-consent-clarity
 * GitHub Branch:     main
 * GitHub Languages:  true
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SCC_VERSION', '2.1.0' );
define( 'SCC_PLUGIN_FILE', __FILE__ );
define( 'SCC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SCC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once SCC_PLUGIN_DIR . 'includes/class-scc-detector.php';
require_once SCC_PLUGIN_DIR . 'includes/class-scc-settings.php';
require_once SCC_PLUGIN_DIR . 'includes/class-scc-frontend.php';
require_once SCC_PLUGIN_DIR . 'includes/class-scc-admin-page.php';

add_action(
	'plugins_loaded',
	function () {
		load_plugin_textdomain( 'silent-consent-clarity', false, dirname( plugin_basename( SCC_PLUGIN_FILE ) ) . '/languages' );

		$detector = new SCC_Detector();

		SCC_Settings::init();

		$frontend = new SCC_Frontend( $detector );
		$frontend->init();

		$admin_page = new SCC_Admin_Page( $detector );
		$admin_page->init();
	}
);
