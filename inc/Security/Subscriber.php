<?php

namespace Bastion\Security;

use Bastion\Dependencies\LaunchpadCore\Container\PrefixAware;
use Bastion\Dependencies\LaunchpadCore\Container\PrefixAwareInterface;
use Bastion\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareInterface;
use Bastion\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareTrait;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\OptionsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\SettingsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Traits\OptionsAwareTrait;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Traits\SettingsAwareTrait;

class Subscriber implements PrefixAwareInterface, DispatcherAwareInterface, SettingsAwareInterface, OptionsAwareInterface {

	use PrefixAware, DispatcherAwareTrait, SettingsAwareTrait, OptionsAwareTrait;

	/**
	 * @hook login_url
	 */
	public function change_admin_url( $login_url, $redirect, $force_reauth ) {
		if ( ! $this->is_active() ) {
			return $login_url;
		}

		if( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return $login_url;
		}

		$request_uri =  sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) );

		if ( mb_strpos( $request_uri, 'wp-admin/install.php' ) !== false ) {
			return admin_url();
		}

		if ( is_404() ) {
			nocache_headers();
			return '#';
		}

		if ( $force_reauth === false ) {
			return $login_url;
		}

		$admin_url = home_url( $this->dispatcher->apply_string_filters( "{$this->prefix}admin_slug", $login_url ) );

		if ( empty( $redirect ) ) {
			return $admin_url;
		}

		return add_query_arg( 'redirect_to', $redirect, $admin_url );
	}

	/**
	 * @hook $prefixadmin_slug
	 */
	public function generate_admin_slug() {
		if ( ! $this->is_active() ) {
			return;
		}

		return (string) $this->settings->get( 'hide_login_slug', 'admin' );
	}

	/**
	 * @hook init
	 * @hook admin_init
	 */
	public function init() {
		if ( ! $this->is_active() ) {
			return;
		}

		remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
	}

	/**
	 * @hook wp_redirect
	 * @hook site_url
	 */
	public function wp_redirect( $location, $status ) {
		if ( ! $this->is_active() ) {
			return $location;
		}

		if ( strpos( $location, 'https://wordpress.com/wp-login.php' ) !== false ) {
			return $location;
		}

		if ( strpos( $location, 'wp-login.php?action=postpass' ) !== false ) {
			return $location;
		}

		$admin_slug = $this->dispatcher->apply_string_filters( "{$this->prefix}admin_slug", '' );

		if ( strpos( $location, 'wp-login.php' ) !== false && strpos( wp_get_referer(), 'wp-login.php' ) === false ) {

			$queries = wp_parse_url( $location, PHP_URL_QUERY );

			if ( $queries ) {
				$admin_slug .= "?$queries";
			}

			return get_site_url() . "/$admin_slug";
		}

		return $location;
	}

	/**
	 * @hook $prefixis_login
	 */
	public function setup_login( $is_login ) {
		if ( ! $this->is_active() ) {
			return $is_login;
		}

		if( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return $is_login;
		}

		$request_uri = rawurldecode( sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );

		$request = wp_parse_url( $request_uri );

		if ( ( strpos( $request_uri, 'wp-login.php' ) || $request['path'] == site_url( 'wp-login', 'relative' ) ) && ! is_admin() ) {
			return true;
		}

		if ( ( strpos( $request_uri, 'wp-register.php' ) || $request['path'] == site_url( 'wp-register', 'relative' ) ) && ! is_admin() ) {
			return true;
		}

		$login_slug = $this->dispatcher->apply_string_filters( "{$this->prefix}admin_slug", '' );

		if ( $request['path'] == site_url( $login_slug, 'relative' ) ) {
			return false;
		}

		return $is_login;
	}

	/**
	 * @hook $prefixcurrent_page
	 */
	public function fetch_current_page( $current_page ) {
		if ( ! $this->is_active() ) {
			return $current_page;
		}

		if( ! isset( $_SERVER['REQUEST_URI'] ) ) {
			return $current_page;
		}

		$request_uri = rawurldecode( sanitize_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );

		$request = wp_parse_url( $request_uri );

		if ( ( strpos( $request_uri, 'wp-login.php' ) || $request['path'] == site_url( 'wp-login', 'relative' ) ) && ! is_admin() ) {
			return 'index.php';
		}
		if ( ( strpos( $request_uri, 'wp-register.php' ) || $request['path'] == site_url( 'wp-register', 'relative' ) ) && ! is_admin() ) {
			return 'index.php';
		}

		$login_slug = $this->dispatcher->apply_string_filters( "{$this->prefix}admin_slug", '' );

		if ( $request['path'] == site_url( $login_slug, 'relative' ) ) {
			return 'wp-login.php';
		}

		return $current_page;
	}

	/**
	 * @hook wp_loaded
	 */
	public function hide_login() {
		if ( ! $this->is_active() ) {
			return;
		}

		if ( isset( $_GET['action'] ) && isset( $_POST['post_password'] ) && $_GET['action'] == 'postpass' ) {
			return;
		}

		$is_login = $this->dispatcher->apply_bool_filters( "{$this->prefix}is_login", false );

		if ( $is_login ) {
			nocache_headers();
			wp_safe_redirect( get_site_url() . '/404' );
			exit;
		}

		$current_page = $this->dispatcher->apply_string_filters( "{$this->prefix}current_page", '' );

		if ( $current_page == 'wp-login.php' ) {
			global $user_login, $error;
			$redirect_admin = admin_url();
			$redirect_url   = isset( $_REQUEST['redirect_to'] ) ? sanitize_url( wp_unslash( $_REQUEST['redirect_to'] ) ) : '';

			if ( is_user_logged_in() && ! isset( $_REQUEST['action'] ) ) {
				nocache_headers();
				wp_safe_redirect( $redirect_admin );
				exit;
			}

			require_once ABSPATH . 'wp-login.php';
			exit;
		}

		if ( is_admin() && ! is_user_logged_in() && ! defined( 'WP_CLI' ) && ! wp_doing_ajax() && ! defined( 'DOING_CRON' ) && $current_page !== 'admin-post.php' ) {
			nocache_headers();
			wp_safe_redirect( get_site_url() . '/404' );
			exit;
		}
	}

	protected function is_active() {
		return $this->settings->get( 'hide_login', false ) && get_option( 'permalink_structure', false );
	}
}
