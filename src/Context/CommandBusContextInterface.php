<?php

namespace Brandfil\ActiveBundle\Context;

use Brandfil\ActiveBundle\CommandBusInterface;
use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface CommandBusContextInterface
 * @package Brandfil\ActiveBundle\Context
 */
interface CommandBusContextInterface
{
    /**
     * @param ContainerInterface $container
     * @return mixed
     */
    public function setContainer(ContainerInterface $container): CommandBusContextInterface;

    /**
     * @param AbstractService $service
     * @param null $input
     * @param bool $ignoreTypes
     * @param CommandBusInterface $commandBus
     * @return CommandBusContextInterface
     */
    public function handle(AbstractService $service, $input = null, $ignoreTypes = false, CommandBusInterface $commandBus): CommandBusContextInterface;

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface;
}
