<?php
/**
 * @license MIT
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\League\Plates\Exception;

final class TemplateNotFound extends \LogicException
{
    private $template;
    private $paths;

    public function __construct(string $template, array $paths, string $message) {
        $this->template = $template;
        $this->paths = $paths;
        parent::__construct($message);
    }

    public function template(): string {
        return $this->template;
    }

    public function paths(): array {
        return $this->paths;
    }
}
