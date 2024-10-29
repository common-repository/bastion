<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadOptions\Interfaces;

use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\DeleteInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\FetchInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\Actions\SetInterface;

interface SettingsInterface extends DeleteInterface, FetchInterface, SetInterface {

	/**
	 * Import multiple values at once.
	 *
	 * @param array<string,mixed> $values Values to import.
	 *
	 * @return void
	 */
	public function import( array $values );

	/**
	 * Export settings values.
	 *
	 * @return array<string,mixed>
	 */
	public function dumps(): array;
}
