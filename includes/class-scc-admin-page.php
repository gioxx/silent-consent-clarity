<?php
/**
 * Settings page and admin notices for Silent Consent for Microsoft Clarity.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SCC_Admin_Page {

	private $detector;

	public function __construct( SCC_Detector $detector ) {
		$this->detector = $detector;
	}

	public function init() {
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'admin_notices', array( $this, 'show_status_notice' ) );
	}

	public function add_admin_menu() {
		add_options_page(
			esc_html__( 'Silent Consent for Microsoft Clarity', 'silent-consent-clarity' ),
			esc_html__( 'Clarity Consent', 'silent-consent-clarity' ),
			'manage_options',
			'silent-consent-clarity',
			array( $this, 'render_page' )
		);
	}

	/**
	 * Status notice shown only if the Microsoft Clarity plugin is active but no Project ID was found yet.
	 */
	public function show_status_notice() {
		if ( $this->detector->get_source() === esc_html__( 'Microsoft Clarity Plugin (active)', 'silent-consent-clarity' ) && ! $this->detector->get_project_id() ) {
			?>
			<div class="notice notice-info is-dismissible">
				<p>
					<strong>Silent Consent for Microsoft Clarity:</strong>
					<?php esc_html_e( 'Microsoft Clarity plugin detected. Please complete setup to start using the consent layer.', 'silent-consent-clarity' ); ?>
				</p>
			</div>
			<?php
		}
	}

	public function render_page() {
		// Re-detect on every load.
		$this->detector->detect();
		$is_ms_plugin_active = $this->detector->is_ms_plugin_active();
		$project_id           = $this->detector->get_project_id();
		$source                = $this->detector->get_source();
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Silent Consent for Microsoft Clarity', 'silent-consent-clarity' ); ?></h1>
			<p class="description"><?php esc_html_e( 'Automatic consent layer for Microsoft Clarity.', 'silent-consent-clarity' ); ?></p>

			<p class="description">
				<?php esc_html_e( 'Learn more', 'silent-consent-clarity' ); ?>:<br />
				<span class="dashicons dashicons-external"></span> <a href="https://learn.microsoft.com/en-us/clarity/setup-and-installation/consent-management" target="_blank">Clarity Consent Management</a><br>
				<span class="dashicons dashicons-external"></span> <a href="https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-consent-api-v2" target="_blank">Clarity Consent API v2</a>
			</p>

			<!-- CLARITY STATUS -->
			<div class="card" style="margin-bottom: 20px;">
				<h2 class="title">📊 <?php esc_html_e( 'Microsoft Clarity Status', 'silent-consent-clarity' ); ?></h2>
				<table class="form-table" style="margin-top: 0;">
					<tr>
						<th scope="row" style="width: 200px;"><?php esc_html_e( 'Microsoft Clarity Plugin', 'silent-consent-clarity' ); ?></th>
						<td>
							<?php if ( $is_ms_plugin_active ) : ?>
								<span style="color: #46b450; font-weight: 500;">✅ <?php esc_html_e( 'Active', 'silent-consent-clarity' ); ?></span>
							<?php else : ?>
								<span style="color: #dc3232; font-weight: 500;">❌ <?php esc_html_e( 'Not installed/active', 'silent-consent-clarity' ); ?></span>
							<?php endif; ?>
						</td>
					</tr>

					<?php if ( $is_ms_plugin_active ) : ?>
					<tr>
						<th scope="row"><?php esc_html_e( 'Project ID', 'silent-consent-clarity' ); ?></th>
						<td>
							<?php if ( $project_id ) : ?>
								<code style="font-size: 14px; background: #e7f7e7; padding: 5px 8px; border-radius: 3px;">
									<?php echo esc_html( $project_id ); ?>
								</code>
								<span class="dashicons dashicons-yes-alt" style="color: #46b450; margin-left: 5px;"></span>
								<br><small><?php
									// translators: %s is the source/origin of the detected Project ID (e.g., "Previously saved ID", "Microsoft Clarity Plugin").
									echo sprintf( esc_html__( 'Source: %s', 'silent-consent-clarity' ), esc_html( $source ) );
								?></small>
							<?php else : ?>
								<span style="color: #f56e28; font-weight: 500;">⚠️ <?php esc_html_e( 'Not detected', 'silent-consent-clarity' ); ?></span>
								<br><small><?php esc_html_e( 'Configure Microsoft Clarity plugin with a Project ID first', 'silent-consent-clarity' ); ?></small>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Consent Layer', 'silent-consent-clarity' ); ?></th>
						<td>
							<?php if ( $project_id ) : ?>
								<span style="color: #46b450; font-weight: 500;">✅ <?php esc_html_e( 'Active', 'silent-consent-clarity' ); ?></span>
								<br><small><?php esc_html_e( 'Consent is automatically passed to Clarity', 'silent-consent-clarity' ); ?></small>
							<?php else : ?>
								<span style="color: #dc3232; font-weight: 500;">⏸️ <?php esc_html_e( 'On Standby', 'silent-consent-clarity' ); ?></span>
								<br><small><?php esc_html_e( 'Waiting for Project ID from Microsoft Clarity plugin', 'silent-consent-clarity' ); ?></small>
							<?php endif; ?>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			</div>

			<?php if ( ! $is_ms_plugin_active ) : ?>
				<!-- MICROSOFT CLARITY PLUGIN NOT ACTIVE - SETUP INSTRUCTIONS -->
				<div class="notice notice-warning">
					<h3 style="margin-top: 15px;">👉 <?php esc_html_e( 'Microsoft Clarity Plugin Required', 'silent-consent-clarity' ); ?></h3>
					<p><?php esc_html_e( 'This consent layer requires the official Microsoft Clarity plugin to be installed and active.', 'silent-consent-clarity' ); ?></p>
					<p><strong><?php esc_html_e( 'Setup steps:', 'silent-consent-clarity' ); ?></strong></p>
					<ol style="margin-left: 20px;">
						<li><?php esc_html_e( 'Install the official Microsoft Clarity plugin from WordPress repository', 'silent-consent-clarity' ); ?></li>
						<li><?php esc_html_e( 'Activate the Microsoft Clarity plugin', 'silent-consent-clarity' ); ?></li>
						<li><?php esc_html_e( 'Configure Microsoft Clarity with your Project ID', 'silent-consent-clarity' ); ?></li>
						<li><?php esc_html_e( 'Return to this page to configure consent settings', 'silent-consent-clarity' ); ?></li>
					</ol>

					<p style="margin-top: 20px;">
						<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=microsoft+clarity&tab=search&type=term' ) ); ?>" class="button button-primary">
							🔍 <?php esc_html_e( 'Search for Microsoft Clarity Plugin', 'silent-consent-clarity' ); ?>
						</a>
						<a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-secondary" style="margin-left: 10px;">
							🔧 <?php esc_html_e( 'Manage Plugins', 'silent-consent-clarity' ); ?>
						</a>
					</p>

					<hr style="margin: 20px 0;">
					<p>⚠️ <em><?php esc_html_e( 'Once the Microsoft Clarity plugin is active, configuration options will appear below.', 'silent-consent-clarity' ); ?></em></p>
				</div>

			<?php else : ?>
				<!-- MICROSOFT CLARITY PLUGIN IS ACTIVE - SHOW CONFIGURATION -->

				<?php if ( ! $project_id ) : ?>
				<!-- PROJECT ID MISSING -->
				<div class="notice notice-info inline">
					<p>
						<strong>🔧 <?php esc_html_e( 'Configuration needed:', 'silent-consent-clarity' ); ?></strong><br>
						<?php esc_html_e( 'Microsoft Clarity plugin is active but no Project ID was detected.', 'silent-consent-clarity' ); ?>
						<br><?php esc_html_e( 'Please configure your Project ID in the Microsoft Clarity plugin settings.', 'silent-consent-clarity' ); ?>
					</p>
				</div>
				<?php endif; ?>

				<!-- CONFIGURATION FORM - ONLY SHOWN WHEN MS CLARITY IS ACTIVE -->
				<h2>⚙️ <?php esc_html_e( 'Consent Configuration', 'silent-consent-clarity' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Configure how consent is automatically granted to Microsoft Clarity:', 'silent-consent-clarity' ); ?></p>

				<form method="post" action="options.php">
					<?php settings_fields( SCC_Settings::OPTION_GROUP ); ?>
					<table class="form-table">
						<tr>
							<th scope="row"><?php esc_html_e( 'Ad Storage Consent', 'silent-consent-clarity' ); ?></th>
							<td>
								<select name="clarity_ad_storage">
									<option value="granted" <?php selected( get_option( 'clarity_ad_storage', 'granted' ), 'granted' ); ?>><?php esc_html_e( 'Granted (Allow)', 'silent-consent-clarity' ); ?></option>
									<option value="denied" <?php selected( get_option( 'clarity_ad_storage', 'granted' ), 'denied' ); ?>><?php esc_html_e( 'Denied (Deny)', 'silent-consent-clarity' ); ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'Consent for storing advertising-related data', 'silent-consent-clarity' ); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php esc_html_e( 'Analytics Storage Consent', 'silent-consent-clarity' ); ?></th>
							<td>
								<select name="clarity_analytics_storage">
									<option value="granted" <?php selected( get_option( 'clarity_analytics_storage', 'granted' ), 'granted' ); ?>><?php esc_html_e( 'Granted (Allow)', 'silent-consent-clarity' ); ?></option>
									<option value="denied" <?php selected( get_option( 'clarity_analytics_storage', 'granted' ), 'denied' ); ?>><?php esc_html_e( 'Denied (Deny)', 'silent-consent-clarity' ); ?></option>
								</select>
								<p class="description"><?php esc_html_e( 'Consent for storing analytics data', 'silent-consent-clarity' ); ?></p>
							</td>
						</tr>
					</table>

					<?php submit_button( '💾 ' . esc_html__( 'Save settings', 'silent-consent-clarity' ) ); ?>
				</form>
			<?php endif; ?>

			<div class="footer" style="padding-top: 35px;">
				<hr>
				<span class="dashicons dashicons-superhero"></span> Gioxx, <?php echo esc_html( gmdate( 'Y' ) ); ?> &#x2022;
				<span class="dashicons dashicons-wordpress"></span>
				<a href="<?php echo esc_url( 'https://go.gioxx.org/silentconsentclarity' ); ?>">Gioxx.org</a> &#x2022;
				<span class="dashicons dashicons-heart"></span>
				<a href="<?php echo esc_url( 'https://github.com/gioxx/silent-consent-clarity' ); ?>">GitHub</a>
			</div>
		</div>

		<style>
		.card {
			background: #fff;
			border: 1px solid #ccd0d4;
			padding: 15px;
			border-radius: 4px;
		}
		.card .title {
			margin-top: 0;
			font-size: 16px;
		}
		</style>
		<?php
	}
}
