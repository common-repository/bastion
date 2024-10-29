<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces;

use Bastion\Dependencies\LaunchpadOptions\Interfaces\SettingsInterface;

interface SettingsAwareInterface
{
    /**
     * Set settings facade.
     *
     * @param SettingsInterface $settings Settings facade.
     * @return void
     */
    public function set_settings(SettingsInterface $settings);
}