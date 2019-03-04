<?php

namespace Brandfil\ActiveBundle;

use Brandfil\ActiveBundle\Events\AbstractEvent;
use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Context\CommandBusContextInterface;
use Doctrine\Common\Collections\Collection;

/**
 * Interface CommandBusInterface
 * @package Brandfil\ActiveBundle
 */
interface CommandBusInterface
{
    /**
     * @param AbstractService $service
     * @param null $input
     * @param bool $ignoreTypes The input prop types must not be valid
     * @return CommandBusContextInterface
     */
    public function handle(AbstractService $service, $input = null, $ignoreTypes = false): CommandBusContextInterface;

    /**
     * @param AbstractEvent $event
     */
    public function addEventListener(AbstractEvent $event): void;

    /**
     * @param AbstractEvent $event
     */
    public function removeEventListener(AbstractEvent $event): void;

    public function removeAllEventListeners(): void;

    /**
     * @param string|null $service
     * @return Collection
     */
    public function getRegisteredEvents(string $service = null): Collection;
}