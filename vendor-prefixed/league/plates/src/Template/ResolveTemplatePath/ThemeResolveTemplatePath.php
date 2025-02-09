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
use Bastion\Dependencies\League\Plates\Template\Theme;

final class ThemeResolveTemplatePath implements ResolveTemplatePath
{
    private $theme;

    public function __construct(Theme $theme) {
        $this->theme = $theme;
    }

    public function __invoke(Name $name): string {
        $searchedPaths = [];
        foreach ($this->theme->listThemeHierarchy() as $theme) {
            $path = $theme->dir() . '/' . $name->getName() . '.' . $name->getEngine()->getFileExtension();
            if (is_file($path)) {
                return $path;
            }
            $searchedPaths[] = [$theme->name(), $path];
        }

        throw new TemplateNotFound(
            $name->getName(),
            array_map(function(array $tup) {
                return $tup[1];
            }, $searchedPaths),
            sprintf('The template "%s" was not found in the following themes: %s',
                $name->getName(),
                implode(', ', array_map(function(array $tup) {
                    return implode(':', $tup);
                }, $searchedPaths))
            )
        );
    }
}
