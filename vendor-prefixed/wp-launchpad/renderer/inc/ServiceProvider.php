<?php
/**
 * @license proprietary
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadRenderer;

use Bastion\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;
use Bastion\Dependencies\LaunchpadFilesystem\WPFilesystemDirect;
use Bastion\Dependencies\LaunchpadRenderer\Cache\WPFilesystemCache;
use Bastion\Dependencies\LaunchpadRenderer\Configuration\Factory;
use Bastion\Dependencies\League\Container\Definition\Definition;
use Bastion\Dependencies\League\Plates\Engine;

/**
 * Service provider.
 */
class ServiceProvider extends AbstractServiceProvider
{

    /**
     * Return IDs from common subscribers.
     *
     * @return string[]
     */
    public function get_common_subscribers(): array {
        return [
            Subscriber::class,
        ];
    }

    /**
     * Registers items with the container
     *
     * @return void
     */
    public function define()
    {

        $this->register_service(WPFilesystemDirect::class);

        $this->register_service(WPFilesystemCache::class, function (Definition $definition) {
            $definition
                ->addArgument(WPFilesystemDirect::class)
                ->addArgument('root_directory')
                ->addArgument('prefix');
        });

        $this->register_service(Factory::class);

        $this->register_service(Engine::class, function (Definition $definition) {
            $definition
                ->addArgument('template_path');
        });

        $this->register_service(Subscriber::class, function (Definition $definition) {
            $renderer_caching_solutions = $this->getContainer()->get('renderer_caching_solution') ?: [];
            $renderer_caching_solution = array_pop($renderer_caching_solutions);
            if(! $renderer_caching_solution) {
                $renderer_caching_solution = WPFilesystemCache::class;
            }
            $definition
                ->addArgument('prefix')
                ->addArgument('renderer_cache_enabled')
                ->addArgument($renderer_caching_solution)
                ->addArgument(Engine::class)
                ->addArgument(Factory::class);
        });
    }
}
