<?php
/**
 * Detects an existing Microsoft Clarity Project ID from the site's configuration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCC_Detector {

	/**
	 * Options checked (in order) for a Clarity Project ID left behind by other plugins/SEO suites.
	 */
	const KNOWN_CLARITY_OPTIONS = array(
		'microsoft_clarity_project_id',
		'microsoft_clarity_settings',
		'clarity_settings',
		'seopress_analytics_option_name',
		'seopress_analytics_clarity',
		'siteseo_analytics_clarity_project_id',
		'aioseo_options',
	);

	private $project_id = null;
	private $source     = null;

	public function __construct() {
		$this->detect();
	}

	/**
	 * Re-run detection (e.g. before rendering the admin page, in case options changed).
	 */
	public function detect() {
		$this->project_id = null;
		$this->source     = null;

		// METHOD 1: Check if we already have a saved ID.
		$saved_id = get_option( 'clarity_project_id' );
		if ( $saved_id && $this->is_valid_clarity_id( $saved_id ) ) {
			$this->project_id = $saved_id;
			$this->source     = esc_html__( 'Previously saved ID', 'silent-consent-clarity' );
			return;
		}

		// METHOD 2: Check if Microsoft Clarity plugin is active.
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( is_plugin_active( 'microsoft-clarity/clarity.php' ) ) {
			$this->source = esc_html__( 'Microsoft Clarity Plugin (active)', 'silent-consent-clarity' );
			return;
		}

		// METHOD 3: Check specific known options from other plugins/SEO suites.
		foreach ( self::KNOWN_CLARITY_OPTIONS as $option_name ) {
			$option_value = get_option( $option_name );
			if ( $option_value ) {
				$project_id = $this->extract_project_id( $option_value );
				if ( $project_id ) {
					$this->project_id = $project_id;
					$this->source     = esc_html__( 'Detected from:', 'silent-consent-clarity' ) . ' ' . $option_name;
					return;
				}
			}
		}
	}

	/**
	 * Extract a Project ID from a raw option value (string, array or object).
	 */
	private function extract_project_id( $value ) {
		if ( empty( $value ) ) {
			return false;
		}

		if ( is_array( $value ) || is_object( $value ) ) {
			$value = maybe_serialize( $value );
		}

		$value = (string) $value;

		$patterns = array(
			'/clarity\.ms\/tag\/([a-zA-Z0-9]{8,15})/',
			'/([a-zA-Z0-9]{8,15})/', // Generic pattern for IDs like "aq9itx5whc".
		);

		foreach ( $patterns as $pattern ) {
			if ( preg_match( $pattern, $value, $matches ) ) {
				if ( isset( $matches[1] ) && $this->is_valid_clarity_id( $matches[1] ) ) {
					return $matches[1];
				}
			}
		}

		return false;
	}

	/**
	 * Validate a candidate Clarity Project ID.
	 */
	private function is_valid_clarity_id( $id ) {
		return (
			strlen( $id ) >= 8 && strlen( $id ) <= 15 &&
			preg_match( '/^[a-zA-Z0-9]+$/', $id ) &&
			preg_match( '/[0-9]/', $id ) &&
			! in_array( strtolower( $id ), array( 'switching', 'wordpress', 'settings' ), true )
		);
	}

	public function get_project_id() {
		return $this->project_id;
	}

	public function get_source() {
		return $this->source;
	}

	public function is_ms_plugin_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		return is_plugin_active( 'microsoft-clarity/clarity.php' );
	}
}
