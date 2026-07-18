<?php
/**
 * uninstall.php - Silent Consent for Microsoft Clarity cleanup
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

require_once __DIR__ . '/includes/class-scc-uninstall-data.php';

foreach ( SCC_Uninstall_Data::OPTIONS as $option ) {
	delete_option( $option );
	delete_site_option( $option ); // Multisite support.
}

foreach ( SCC_Uninstall_Data::TRANSIENTS as $transient ) {
	delete_transient( $transient );
	delete_site_transient( $transient );
}
