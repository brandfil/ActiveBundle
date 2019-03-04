<?php

namespace Brandfil\ActiveBundle\Input;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Input
 * @package Brandfil\ActiveBundle\Input
 */
class Input implements InputInterface {

    /**
     * @var mixed
     */
    private $content;

    /**
     * {@inheritdoc}
     */
    public function setContent($content = null)
    {
        if(!is_array($content)) {
            $content = [$content];
        }

        $this->content = new ArrayCollection($content);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): Collection
    {
        return $this->content;
    }
}