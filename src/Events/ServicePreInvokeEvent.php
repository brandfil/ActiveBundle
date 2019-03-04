<?php

namespace Brandfil\ActiveBundle\Events;

/**
 * Class ServicePreInvokeEvent
 * @package Brandfil\ActiveBundle\Events
 */
final class ServicePreInvokeEvent extends AbstractEvent
{
    protected $type = 'service_pre_invoke';
}