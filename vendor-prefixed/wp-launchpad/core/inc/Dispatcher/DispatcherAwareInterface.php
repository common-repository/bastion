<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadCore\Dispatcher;

use Bastion\Dependencies\LaunchpadDispatcher\Dispatcher;

interface DispatcherAwareInterface {

	/**
	 * Setup WordPress hooks dispatcher.
	 *
	 * @param Dispatcher $dispatcher WordPress hooks dispatcher.
	 *
	 * @return void
	 */
	public function set_dispatcher( Dispatcher $dispatcher ): void;
}
