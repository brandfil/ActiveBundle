<?php

namespace Brandfil\ActiveBundle;

use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Context\CommandBusContextInterface;

/**
 * Interface CommandBusInterface
 * @package Brandfil\ActiveBundle
 */
interface CommandBusInterface
{
    /**
     * @param AbstractService $service
     * @param null $input
     * @return CommandBusContextInterface
     */
    public function handle(AbstractService $service, $input = null): CommandBusContextInterface;

    /**
     * @param string $class
     * @param callable $event
     */
    public function addEventListener(string $class, callable $event): void;

    /**
     * @param string $class
     */
    public function removeEventListener(string $class): void;
}