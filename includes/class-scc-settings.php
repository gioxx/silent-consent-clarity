<?php
/**
 * Registers and sanitizes the plugin's consent settings.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCC_Settings {

	const OPTION_GROUP = 'clarity_consent_settings';

	public static function init() {
		add_action( 'admin_init', array( __CLASS__, 'register_settings' ) );
	}

	public static function register_settings() {
		register_setting(
			self::OPTION_GROUP,
			'clarity_ad_storage',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( __CLASS__, 'sanitize_consent_option' ),
				'default'           => 'granted',
			)
		);

		register_setting(
			self::OPTION_GROUP,
			'clarity_analytics_storage',
			array(
				'type'              => 'string',
				'sanitize_callback' => array( __CLASS__, 'sanitize_consent_option' ),
				'default'           => 'granted',
			)
		);
	}

	/**
	 * Sanitize consent options - only 'granted' or 'denied' are accepted.
	 */
	public static function sanitize_consent_option( $input ) {
		$valid_options = array( 'granted', 'denied' );
		$sanitized     = sanitize_text_field( $input );

		if ( in_array( $sanitized, $valid_options, true ) ) {
			return $sanitized;
		}

		return 'granted';
	}
}
