<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions;

interface FetchPrefixInterface {

	/**
	 * Gets the transient name used to store the transient in the WordPress database.
	 *
	 * @param string $name Unprefixed name of the transient.
	 *
	 * @return string
	 */
	public function get_full_key( string $name ): string;
}
