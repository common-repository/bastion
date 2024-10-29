<?php
namespace Bastion\Security;

use Bastion\Dependencies\LaunchpadCore\Container\PrefixAware;
use Bastion\Dependencies\LaunchpadCore\Container\PrefixAwareInterface;
use Bastion\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareInterface;
use Bastion\Dependencies\LaunchpadCore\Dispatcher\DispatcherAwareTrait;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\SettingsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\TransientsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Traits\SettingsAwareTrait;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Traits\TransientsAwareTrait;

class LimitLoginSubscriber implements DispatcherAwareInterface, PrefixAwareInterface, TransientsAwareInterface, SettingsAwareInterface {

	use DispatcherAwareTrait, PrefixAware, TransientsAwareTrait, SettingsAwareTrait;

	/**
	 * @var State
	 */
	protected $state;

	/**
	 * @param State $state
	 */
	public function __construct( State $state ) {
		$this->state = $state;
	}

	/**
	 * @hook wp_authenticate
	 */
	public function feed_state_empty_login( $user, $password ) {
		if ( ! $this->is_active() ) {
			return $user;
		}
		$this->state->set_empty_credentials( empty( $user ) && empty( $password ) );
	}

	/**
	 * @hook $prefixis_empty_credentials
	 */
	public function share_state_empty_credentials( $empty ) {
		if ( ! $this->is_active() ) {
			return $empty;
		}
		return $this->state->is_empty_credentials();
	}

	/**
	 * @hook wp_login_failed
	 */
	public function increase_counter_failures() {
		if ( ! $this->is_active() ) {
			return;
		}

		$ip         = $this->dispatcher->apply_string_filters( "{$this->prefix}ip_address", '' );
		$max        = $this->dispatcher->apply_int_filters( "{$this->prefix}counter_max", 5 );
		$expiration = $this->dispatcher->apply_int_filters( "{$this->prefix}counter_expiration", HOUR_IN_SECONDS );
		$empty      = $this->dispatcher->apply_bool_filters( "{$this->prefix}is_empty_credentials", false );

		if ( $empty ) {
			return;
		}

		$counter = (int) $this->transients->get( "counter_{$ip}" );

		$this->transients->set( "counter_{$ip}", ++ $counter, $expiration );

		if ( $counter < $max ) {
			return;
		}

		$this->transients->set( "locked_{$ip}", true, $expiration );
	}

	/**
	 * @hook $prefixip_address
	 */
	public function fetch_correct_ip_address( $ip, $client_type = '' ) {
		if ( ! $this->is_active() ) {
			return $ip;
		}

		if ( ! $client_type || ! isset( $_SERVER[$client_type] ) ) {
			$client_type = $this->dispatcher->apply_string_filters( "{$this->prefix}ip_address_client_type", 'REMOTE_ADDR' );
		}

		if ( ! isset( $_SERVER[$client_type] ) ) {
			return $ip;
		}

		return sanitize_text_field( wp_unslash($_SERVER[ $client_type ]) );
	}

	/**
	 * @hook wp_authenticate_user
	 */
	public function maybe_refuse_attempt( $user ) {
		if ( ! $this->is_active() ) {
			return $user;
		}

		$ip = $this->dispatcher->apply_string_filters( "{$this->prefix}ip_address", '' );

		if ( ! $this->transients->get( "locked_{$ip}" ) ) {
			return $user;
		}

		$error = new \WP_Error();
		$error->add( 'too_many_retries', __( '<strong>ERROR</strong>: Too many failed login attempts.', 'bastion' ) );
		return $error;
	}

	/**
	 * @hook shake_error_codes
	 */
	public function add_error_code( $errors ) {
		if ( ! $this->is_active() ) {
			return $errors;
		}

		if ( ! is_array( $errors ) ) {
			return $errors;
		}

		$errors [] = 'too_many_retries';
		return $errors;
	}

	/**
	 * @hook login_errors
	 */
	public function fix_error_messages( $errors ) {
		if ( ! $this->is_active() ) {
			return $errors;
		}

		$ip = $this->dispatcher->apply_string_filters( "{$this->prefix}ip_address", '' );

		if ( ! $this->transients->get( "locked_{$ip}" ) ) {
			return $errors;
		}

		return '<p>' . __( '<strong>ERROR</strong>: Too many failed login attempts.', 'bastion' ) . '</p>';
	}

	/**
	 * @hook wp_login
	 */
	public function reset_counter() {
		if ( ! $this->is_active() ) {
			return;
		}

		$ip = $this->dispatcher->apply_string_filters( "{$this->prefix}ip_address", '' );

		$this->transients->delete( "locked_{$ip}" );
	}

	protected function is_active() {
		return (bool) $this->settings->get( 'hide_login', false );
	}
}
