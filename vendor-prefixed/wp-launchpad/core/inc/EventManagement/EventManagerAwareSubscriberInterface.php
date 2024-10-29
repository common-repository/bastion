<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */
namespace Bastion\Dependencies\LaunchpadCore\EventManagement;

interface EventManagerAwareSubscriberInterface extends SubscriberInterface {
	/**
	 * Set the WordPress event manager for the subscriber.
	 *
	 * @author Remy Perona
	 *
	 * @param EventManager $event_manager Event_Manager instance.
	 */
	public function set_event_manager( EventManager $event_manager );
}
