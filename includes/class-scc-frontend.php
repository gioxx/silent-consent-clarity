<?php
/**
 * Injects the front-end consent script when a Clarity Project ID has been detected.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCC_Frontend {

	private $detector;

	public function __construct( SCC_Detector $detector ) {
		$this->detector = $detector;
	}

	public function init() {
		add_action( 'wp_enqueue_scripts', array( $this, 'inject_consent_script' ) );
	}

	/**
	 * Inject only the consent script (not Clarity itself).
	 */
	public function inject_consent_script() {
		if ( ! $this->detector->get_project_id() ) {
			return;
		}

		wp_enqueue_script(
			'silent-consent-clarity',
			SCC_PLUGIN_URL . 'js/silent-consent-clarity.js',
			array(),
			SCC_VERSION,
			true
		);

		wp_localize_script(
			'silent-consent-clarity',
			'clarityConsent',
			array(
				'adStorage'        => get_option( 'clarity_ad_storage', 'granted' ),
				'analyticsStorage' => get_option( 'clarity_analytics_storage', 'granted' ),
			)
		);
	}
}
