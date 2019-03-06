<?php

namespace Brandfil\ActiveBundle\Events;

/**
 * Class ServicePostInvokeEvent
 * @package Brandfil\ActiveBundle\Events
 */
final class ServicePostInvokeEvent extends AbstractEvent
{
    protected $type = 'service_post_invoke';
}