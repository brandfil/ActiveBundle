<?php

namespace Brandfil\ActiveBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ContainerAwareService extends AbstractService
{
    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * @return ContainerInterface
     * @throws \LogicException
     */
    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null): void
    {
        $this->container = $container;
    }
}