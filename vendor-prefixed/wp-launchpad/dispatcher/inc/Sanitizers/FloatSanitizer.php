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

class FloatSanitizer implements SanitizerInterface {
    use IsDefault;

    public function sanitize($value)
    {
        return (float) $value;
    }

}