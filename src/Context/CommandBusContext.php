<?php

namespace Brandfil\ActiveBundle\Context;

use Brandfil\ActiveBundle\CommandBusExpr;
use Brandfil\ActiveBundle\Service\AbstractService;
use Brandfil\ActiveBundle\Service\ContainerAwareService;
use Brandfil\ActiveBundle\Exceptions\InvalidPropertyException;
use Brandfil\ActiveBundle\Input\Input;
use Brandfil\ActiveBundle\Input\InputInterface;
use Brandfil\ActiveBundle\Output\Output;
use Brandfil\ActiveBundle\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CommandBusContext
 * @package Brandfil\ActiveBundle\Context
 */
class CommandBusContext implements CommandBusContextInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var InputInterface
     */
    private $input;


    /**
     * CommandBusContext constructor.
     */
    public function __construct()
    {
        $this->input = new Input();
        $this->output = new Output();
    }

    /**
     * @param ContainerInterface $container
     * @return CommandBusContextInterface
     */
    public function setContainer(ContainerInterface $container): CommandBusContextInterface
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param AbstractService $service
     * @param null $input
     * @return CommandBusContextInterface
     */
    public function handle(AbstractService $service, $input = null): CommandBusContextInterface
    {
        $this->input->setContent($input);
        $service = $service->setInput($this->input);

        $this->checkPropTypes($service->getPropTypes());

        if($service instanceof ContainerAwareService) {
            $service->setContainer($this->container);
        }

        $this->output->setBody($service());

        return $this;
    }

    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    private function checkPropTypes(array $types): void
    {
        $input = $this->input->getContent();

        foreach ($types as $property => $type) {
            $value = $input->get($property);
            $desiredType = is_object($value) ? get_class($value) : gettype($value);

            $exception = new InvalidPropertyException();
            $exception->setProperty($property);
            $exception->setType($type);
            $exception->setValue($value);
            $exception->setDesiredType($desiredType);

            switch(true) {
                case is_callable($type):
                    $type($value, $property, $exception);
                    break;
                case $type instanceof CommandBusExpr:
                    if($type->getType() === CommandBusExpr::ONE_OF && !in_array($value, $type->getParams())) {
                        $exception->setMessage('The property `'.$property.'` must be one of '.join(', ', $type->getParams()).'; passed '.$value.'.');
                        throw $exception;
                    }
                    break;
                case $type === 'array' && !is_array($value):
                case $type === 'string' && !is_string($value):
                case $type === 'integer' && !is_integer($value):
                case $type === 'float' && !is_float($value):
                case $type === 'double' && !is_double($value):
                case $type === 'object' && !is_object($value):
                case $type === 'numeric' && !is_numeric($value):
                case is_object($value) && !($value instanceof $type):
                    $exception->setMessage('The property `'.$property.'` must be an instance of '.$type.', '.$desiredType.' given.');
                    throw $exception;
            }
        }
    }
}