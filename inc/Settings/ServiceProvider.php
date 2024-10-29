<?php

namespace Bastion\Settings;

use Bastion\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\SettingsInterface;
use Bastion\Dependencies\League\Container\Definition\DefinitionInterface;

class ServiceProvider extends AbstractServiceProvider {

	public function get_common_subscribers(): array {
		return [
			Subscriber::class,
		];
	}

	/**
	 * @inheritDoc
	 */
	protected function define() {
		$this->register_service( Subscriber::class )->set_definition(
			function ( DefinitionInterface $definition ) {
				$definition->addArgument( SettingsInterface::class );
			}
			);
	}
}
