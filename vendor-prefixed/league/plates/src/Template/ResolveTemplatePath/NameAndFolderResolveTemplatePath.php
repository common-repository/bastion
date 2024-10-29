<?php
/**
 * @license MIT
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Bastion\Dependencies\League\Plates\Template\ResolveTemplatePath;

use Bastion\Dependencies\League\Plates\Exception\TemplateNotFound;
use Bastion\Dependencies\League\Plates\Template\Name;
use Bastion\Dependencies\League\Plates\Template\ResolveTemplatePath;

/** Resolves the path from the logic in the Name class which resolves via folder lookup, and then the default directory */
final class NameAndFolderResolveTemplatePath implements ResolveTemplatePath
{
    public function __invoke(Name $name): string {
        $path = $name->getPath();
        if (is_file($path)) {
            return $path;
        }

        throw new TemplateNotFound($name->getName(), [$name->getPath()], 'The template "' . $name->getName() . '" could not be found at "' . $name->getPath() . '".');
    }
}
