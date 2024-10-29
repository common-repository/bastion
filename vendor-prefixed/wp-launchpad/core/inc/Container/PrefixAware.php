<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadCore\Container;

trait PrefixAware {

	/**
	 * Plugin prefix.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Set the plugin prefix.
	 *
	 * @param string $prefix Plugin prefix.
	 * @return void
	 */
	public function set_prefix( string $prefix ): void {
		$this->prefix = $prefix;
	}
}
