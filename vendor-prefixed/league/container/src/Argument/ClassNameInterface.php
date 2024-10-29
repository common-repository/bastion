<?php
/**
 * @license MIT
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Bastion\Dependencies\League\Container\Argument;

interface ClassNameInterface
{
    /**
     * Return the class name.
     *
     * @return string
     */
    public function getClassName() : string;
}
