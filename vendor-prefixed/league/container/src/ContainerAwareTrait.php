<?php
/**
 * @license MIT
 *
 * Modified by CrochetFeve0251 on 22-July-2024 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Bastion\Dependencies\League\Container;

use Bastion\Dependencies\League\Container\Exception\ContainerException;
use Bastion\Dependencies\Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Container
     */
    protected $leagueContainer;

    /**
     * Set a container.
     *
     * @param ContainerInterface $container
     *
     * @return ContainerAwareInterface
     */
    public function setContainer(ContainerInterface $container) : ContainerAwareInterface
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the container.
     *
     * @return ContainerInterface
     */
    public function getContainer() : ContainerInterface
    {
        if ($this->container instanceof ContainerInterface) {
            return $this->container;
        }

        throw new ContainerException('No container implementation has been set.');
    }

    /**
     * Set a container.
     *
     * @param Container $container
     *
     * @return self
     */
    public function setLeagueContainer(Container $container) : ContainerAwareInterface
    {
        $this->container = $container;
        $this->leagueContainer = $container;

        return $this;
    }

    /**
     * Get the container.
     *
     * @return Container
     */
    public function getLeagueContainer() : Container
    {
        if ($this->leagueContainer instanceof Container) {
            return $this->leagueContainer;
        }

        throw new ContainerException('No container implementation has been set.');
    }
}
