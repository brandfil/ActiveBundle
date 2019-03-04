<?php

namespace Brandfil\ActiveBundle\Output;

/**
 * Interface OutputInterface
 * @package Brandfil\ActiveBundle\Output
 */
interface OutputInterface {

    /**
     * @param null $body
     * @return mixed
     */
    public function setBody($body = null);
    public function getBody();
}