<?php

namespace Brandfil\ActiveBundle\Service;

use Brandfil\ActiveBundle\Input\InputInterface;

abstract class AbstractService
{
    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @return InputInterface
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }

    /**
     * @param InputInterface $input
     * @return AbstractService
     */
    public function setInput(InputInterface $input): AbstractService
    {
        if(method_exists($this, 'initialize')) {
            $this->initialize($input);
        }

        $this->input = $input;
        return $this;
    }

    /**
     * @return array
     */
    public function getPropTypes(): array
    {
        return [];
    }

    protected function initialize(InputInterface $input)
    {
        return false;
    }

    /**
     * @return mixed
     */
    abstract public function __invoke();
}