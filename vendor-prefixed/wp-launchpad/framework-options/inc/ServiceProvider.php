<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFrameworkOptions;


use Bastion\Dependencies\LaunchpadCore\Container\AbstractServiceProvider;
use Bastion\Dependencies\LaunchpadCore\Container\HasInflectorInterface;
use Bastion\Dependencies\LaunchpadCore\Container\InflectorServiceProviderTrait;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\OptionsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\SettingsAwareInterface;
use Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces\TransientsAwareInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\OptionsInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\SettingsInterface;
use Bastion\Dependencies\LaunchpadOptions\Interfaces\TransientsInterface;
use Bastion\Dependencies\LaunchpadOptions\Options;
use Bastion\Dependencies\LaunchpadOptions\Settings;
use Bastion\Dependencies\LaunchpadOptions\Transients;
use Bastion\Dependencies\League\Container\Definition\DefinitionInterface;

class ServiceProvider extends AbstractServiceProvider implements HasInflectorInterface
{
    use InflectorServiceProviderTrait;

    protected function define()
    {
        $this->register_service(OptionsInterface::class)
            ->share()
            ->set_concrete(Options::class)
            ->set_definition(function (DefinitionInterface $definition) {
            $definition->addArgument('prefix');
        });

        $this->register_service(TransientsInterface::class)
            ->share()
            ->set_concrete(Transients::class)
            ->set_definition(function (DefinitionInterface $definition) {
            $definition->addArgument('prefix');
        });

        $this->register_service(SettingsInterface::class)
            ->share()
            ->set_concrete(Settings::class)
            ->set_definition(function (DefinitionInterface $definition) {
            $prefix = $this->container->get('prefix');
            $definition->addArguments([OptionsInterface::class, "{$prefix}settings"]);
        });
    }

    /**
     * Returns inflectors.
     *
     * @return array[]
     */
    public function get_inflectors(): array
    {
        return [
            OptionsAwareInterface::class => [
                'method' => 'set_options',
                'args' => [
                    OptionsInterface::class,
                ],
            ],
            TransientsAwareInterface::class => [
                'method' => 'set_transients',
                'args' => [
                    TransientsInterface::class,
                ],
            ],
            SettingsAwareInterface::class => [
                'method' => 'set_settings',
                'args' => [
                    SettingsInterface::class,
                ],
            ],
        ];
    }
}