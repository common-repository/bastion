<?php

namespace Bastion;

use Bastion\Security\APISubscriber;
use Bastion\Security\AuthorSubscriber;
use Bastion\Security\LimitLoginSubscriber;

class ServiceProvider extends Dependencies\LaunchpadAutoresolver\ServiceProvider {

	public function get_common_subscribers(): array {
		return [
			\Bastion\Security\Subscriber::class,
			LimitLoginSubscriber::class,
		];
	}
}
