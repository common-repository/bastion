<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadCore\Container;

interface HasInflectorInterface {

	/**
	 * Returns inflectors mapping.
	 *
	 * @return array<string,array>
	 */
	public function get_inflectors(): array;

	/**
	 * Register inflectors.
	 *
	 * @return void
	 */
	public function register_inflectors(): void;
}
