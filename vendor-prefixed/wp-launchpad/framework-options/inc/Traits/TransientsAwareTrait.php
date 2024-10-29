<?php
/**
 * @license proprietary?
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\LaunchpadFrameworkOptions\Traits;

use Bastion\Dependencies\LaunchpadOptions\Interfaces\TransientsInterface;

trait TransientsAwareTrait
{
    /**
     * Transients facade.
     *
     * @var TransientsInterface
     */
    protected $transients;

    /**
     * Set transients facade.
     *
     * @param TransientsInterface $transients Transients facade.
     * @return void
     */
    public function set_transients(TransientsInterface $transients)
    {
        $this->transients = $transients;
    }
}