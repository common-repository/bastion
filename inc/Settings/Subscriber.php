<?php

namespace Bastion\Settings;

use Bastion\Dependencies\LaunchpadCore\Container\PrefixAware;
use Bastion\Dependencies\LaunchpadCore\Container\PrefixAwareInterface;
use Bastion\Dependencies\LaunchpadFront\UseAssets;
use Bastion\Dependencies\LaunchpadFront\UseAssetsInterface;
use Bastion\Dependencies\LaunchpadOptions\Settings;

class Subscriber implements PrefixAwareInterface, UseAssetsInterface {

	use PrefixAware, UseAssets;

	/**
	 * @var Settings
	 */
	protected $settings;

	/**
	 * @param Settings $settings
	 */
	public function __construct( Settings $settings ) {
		$this->settings = $settings;
	}

	public function register_page() {
		do_action(
			"{$this->prefix}render_template",
			'settings',
			[
				'parameters' => [
					'prefix' => $this->prefix,
				],
			]
			);
	}

	/**
	 * @hook admin_menu
	 */
	public function add_page() {
		add_options_page( 'Bastion', 'Bastion', 'manage_options', 'bastion', [ $this, 'register_page' ] );
	}

	/**
	 * @hook admin_enqueue_scripts
	 */
	public function enqueue_scripts() {

		$data = [
			'hide_login'      => $this->settings->get( 'hide_login', false ),
			'hide_login_slug' => $this->settings->get( 'hide_login_slug', 'admin' ),
			'limit_login'     => $this->settings->get( 'limit_login', false ),
		];

		$this->assets->enqueue_script( 'settings', 'app.js', [ 'wp-element' ] );
		wp_localize_script(
			$this->assets->get_full_key( 'settings' ),
			$this->assets->get_full_key( 'settings' ),
			[
				'ajax_endpoint' => admin_url( 'admin-ajax.php' ),
				'nonce'         => wp_create_nonce( "{$this->prefix}settings" ),
				'data'          => $data,
			]
			);
		wp_enqueue_style( 'wp-components' );
	}

	/**
	 * @hook wp_ajax_$prefixsave_settings
	 */
	public function save_options() {
		if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['nonce'] ) ), "{$this->prefix}settings" ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized, WordPress.Security.ValidatedSanitizedInput.MissingUnslash
			wp_nonce_ays( '' );
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_nonce_ays( '' );
		}

		if ( ! isset( $_POST['hide_login'] ) || ! isset( $_POST['limit_login'] ) || ! isset( $_POST['hide_login_slug'] ) ) {
			wp_nonce_ays( '' );
		}

		$this->settings->set( 'hide_login', $_POST['hide_login'] !== 'false' );
		$this->settings->set( 'hide_login_slug', sanitize_text_field( wp_unslash( $_POST['hide_login_slug'] ) ) );
		$this->settings->set( 'limit_login', $_POST['limit_login'] !== 'false' );

		wp_send_json_success( [] );
	}
}
