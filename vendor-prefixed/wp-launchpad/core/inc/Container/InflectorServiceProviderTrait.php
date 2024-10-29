<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadCore\Container;

use Bastion\Dependencies\League\Container\Container;

trait InflectorServiceProviderTrait {


	/**
	 * Returns inflectors mapping.
	 *
	 * @return array<string,array>
	 */
	public function get_inflectors(): array {
		return [];
	}

	/**
	 * Register inflectors.
	 *
	 * @return void
	 */
	public function register_inflectors(): void {
		foreach ( $this->get_inflectors() as $class => $data ) {
			if ( ! is_array( $data ) || ! key_exists( 'method', $data ) ) {
				continue;
			}
			$method = $data['method'];

			if ( ! key_exists( 'args', $data ) || ! is_array( $data['args'] ) ) {
				$this->getLeagueContainer()->inflector( $class )->invokeMethod( $method, [] );
				continue;
			}

			$this->getLeagueContainer()->inflector( $class )->invokeMethod( $method, $data['args'] );
		}
	}

	/**
	 * Get the container.
	 *
	 * @return Container
	 */
	abstract public function getLeagueContainer(): Container; // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.MethodNameInvalid
}
