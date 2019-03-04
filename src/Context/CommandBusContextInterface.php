<?php

namespace Brandfil\ActiveBundle\Context;

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
     * @return CommandBusContextInterface
     */
    public function handle(AbstractService $service, $input = null): CommandBusContextInterface;

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface;
}