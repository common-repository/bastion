<?php
/**
 * @license GPL-2.0-or-later
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadDispatcher\Sanitizers;

use Bastion\Dependencies\LaunchpadDispatcher\Interfaces\SanitizerInterface;
use Bastion\Dependencies\LaunchpadDispatcher\Traits\IsDefault;

class StringSanitizer implements SanitizerInterface
{
    use IsDefault;

    public function sanitize($value)
    {
        if ( is_object($value) && ! method_exists($value, '__toString')) {
            return false;
        }

        if (is_array($value)) {
            return false;
        }

        return (string) $value;
    }
}