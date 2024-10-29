<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadCore\Container;

use Bastion\Dependencies\League\Container\ServiceProvider\ServiceProviderInterface as LeagueServiceProviderInterface;


interface ServiceProviderInterface extends LeagueServiceProviderInterface {

	/**
	 * Return IDs provided by the Service Provider.
	 *
	 * @return string[]
	 */
	public function declares(): array;

	/**
	 * Return IDs from front subscribers.
	 *
	 * @return string[]
	 */
	public function get_front_subscribers(): array;

	/**
	 * Return IDs from admin subscribers.
	 *
	 * @return string[]
	 */
	public function get_admin_subscribers(): array;

	/**
	 * Return IDs from common subscribers.
	 *
	 * @return string[]
	 */
	public function get_common_subscribers(): array;

	/**
	 * Return IDs from init subscribers.
	 *
	 * @return string[]
	 */
	public function get_init_subscribers(): array;
}
