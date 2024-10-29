<?php

defined( 'ABSPATH' ) || exit;

return [
	\Bastion\Dependencies\LaunchpadRenderer\ServiceProvider::class,
	\Bastion\Dependencies\LaunchpadFront\ServiceProvider::class,
	\Bastion\Dependencies\LaunchpadFrameworkOptions\ServiceProvider::class,
	\Bastion\ServiceProvider::class,
	\Bastion\Settings\ServiceProvider::class,
];
