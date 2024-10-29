<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFrameworkOptions\Interfaces;

use Bastion\Dependencies\LaunchpadOptions\Interfaces\OptionsInterface;

interface OptionsAwareInterface
{
    /**
     * Set options facade.
     *
     * @param OptionsInterface $options Options facade.
     * @return void
     */
    public function set_options(OptionsInterface $options);
}