<?php
/**
 * Shared list of options/transients to remove on uninstall.
 *
 * Kept separate from uninstall.php so the same source of truth can be
 * required without loading the rest of the plugin.
 */

class SCC_Uninstall_Data {

	const OPTIONS = array(
		// Current plugin options.
		'clarity_ad_storage',
		'clarity_analytics_storage',

		// Legacy cleanup.
		'clarity_project_id',
		'clarity_auto_project_id',
		'clarity_detected_from',
		'clarity_detection_notice_dismissed',
		'clarity_wordpress_site_id',
	);

	const TRANSIENTS = array(
		'clarity_consent_temp',
		'clarity_consent_cache',
		'clarity_layer_temp',
		'clarity_consent_auto_detection',
	);
}
