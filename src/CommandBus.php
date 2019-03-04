<?php

namespace Brandfil\ActiveBundle;

use Brandfil\ActiveBundle\Events\AbstractEvent;
use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Context\CommandBusContext;
use Brandfil\ActiveBundle\Context\CommandBusContextInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @var array
     */
    private $events = [];


    /**
     * CommandBus constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->events = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function handle(AbstractService $service, $input = null, $ignoreTypes = false): CommandBusContextInterface
    {
        $context = new CommandBusContext;
        $context->setContainer($this->container);
        return $context->handle($service, $input, $ignoreTypes);
    }

    /**
     * {@inheritdoc}
     */
    public function addEventListener(AbstractEvent $event): void
    {
        $this->events->add($event);
    }

    /**
     * {@inheritdoc}
     */
    public function removeEventListener(AbstractEvent $event): void
    {
        if($this->events->contains($event)) {
            $this->events->removeElement($event);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRegisteredEvents(string $service = null): Collection
    {
        $events = $this->events;
        if($service !== null) {
            $events = $events->filter(function (AbstractEvent $event) use ($service) {
                return $event->getService() === $service;
            });
        }

        return $events;
    }

    public function removeAllEventListeners(): void
    {
        $this->events->clear();
    }
}