<?php

namespace Brandfil\ActiveBundle\Output;

/**
 * Class Output
 * @package Brandfil\ActiveBundle\Output
 */
class Output implements OutputInterface
{
    /**
     * @var mixed
     */
    private $body;

    /**
     * {@inheritdoc}
     */
    public function setBody($body = null)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}