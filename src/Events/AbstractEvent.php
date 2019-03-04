<?php

namespace Brandfil\ActiveBundle\Events;

/**
 * Class AbstractEvent
 * @package Brandfil\ActiveBundle\Events
 */
abstract class AbstractEvent
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $service;

    /**
     * @var callable
     */
    protected $event;


    /**
     * AbstractEvent constructor.
     * @param string $service
     * @param callable|null $event
     */
    public function __construct(string $service, callable $event = null)
    {
        $this->service = $service;
        $this->event = $event;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return callable
     */
    public function getEvent(): callable
    {
        return $this->event;
    }
}