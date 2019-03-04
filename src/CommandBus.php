<?php

namespace Brandfil\ActiveBundle;

use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Context\CommandBusContext;
use Brandfil\ActiveBundle\Context\CommandBusContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandBus
 * @package Brandfil\ActiveBundle
 */
class CommandBus implements CommandBusInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * CommandBus constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractService $service, $input = null): CommandBusContextInterface
    {
        $context = new CommandBusContext;
        $context->setContainer($this->container);
        return $context->handle($service, $input);
    }

    /**
     * {@inheritdoc}
     */
    public function addEventListener(string $class, callable $event): void
    {
        // TODO: Implement addEventListener() method.
    }

    /**
     * {@inheritdoc}
     */
    public function removeEventListener(string $class): void
    {
        // TODO: Implement removeEventListener() method.
    }
}