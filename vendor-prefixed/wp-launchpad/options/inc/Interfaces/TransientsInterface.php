<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */
declare(strict_types=1);

namespace Bastion\Dependencies\LaunchpadOptions\Interfaces;

use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\DeleteInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\FetchInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\FetchPrefixInterface;

/**
 * Define mandatory methods to implement when using this package
 */
interface TransientsInterface extends FetchPrefixInterface, DeleteInterface, FetchInterface {

	/**
	 * Sets the value of an transient. Update the value if the transient for the given name already exists.
	 *
	 * @param string $name Name of the transient to set.
	 * @param mixed  $value Value to set for the transient.
	 * @param int    $expiration Time until expiration in seconds. Default 0 (no expiration).
	 *
	 * @return void
	 */
	public function set( string $name, $value, int $expiration = 0 );
}
