<?php

namespace Brandfil\ActiveBundle\Input;

use Doctrine\Common\Collections\Collection;

/**
 * Interface InputInterface
 * @package Brandfil\ActiveBundle\Input
 */
interface InputInterface {

    /**
     * @param null $content
     * @return mixed
     */
    public function setContent($content = null);

    /**
     * @return Collection
     */
    public function getContent(): Collection;
}