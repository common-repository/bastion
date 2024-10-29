<?php
/**
 * @license proprietary
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadRenderer\Configuration;

class Factory
{
    /**
     * Make a configuration class.
     *
     * @param array $data Data to send to the class.
     *
     * @return Configurations
     */
    public function make(array $data): Configurations {
        return new Configurations($data);
    }
}
