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
use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\SetInterface;

/**
 * Define mandatory methods to implement when using this package
 */
interface OptionsInterface extends FetchPrefixInterface, DeleteInterface, FetchInterface, SetInterface {
	/**
	 * Gets the option name used to store the option in the WordPress database.
	 *
	 * @param string $name Unprefixed name of the option.
	 * @deprecated Only for WP Rocket backward compatibility.
	 * @return string
	 */
	public function get_option_name( string $name ): string;
}
