<?php

namespace Brandfil\ActiveBundle\Context;

use Brandfil\ActiveBundle\CommandBusInterface;
use Brandfil\ActiveBundle\Events\AbstractEvent;
use Brandfil\ActiveBundle\Events\ServicePostInvokeEvent;
use Brandfil\ActiveBundle\Events\ServicePreInvokeEvent;
use Brandfil\ActiveBundle\PropTypes;
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
     * {@inheritdoc}
     */
    public function handle(AbstractService $service, $input = null, $ignoreTypes = false): CommandBusContextInterface
    {
        $this->input->setContent($input);
        $service = $service->setInput($this->input);

        if($service instanceof ContainerAwareService) {
            $service->setContainer($this->container);
        }

        // Pre Invoke event
        $this->fireEvent(get_class($service), ServicePreInvokeEvent::class);

        // $ignoreTypes flag should be set as false (default behaviour) to check prop types
        $ignoreTypes === false && $this->checkPropTypes($service->getPropTypes());

        // invoke service and set output
        $this->output->setBody($service());

        // Post Invoke event
        $this->fireEvent(get_class($service), ServicePostInvokeEvent::class);

        return $this;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface
    {
        return $this->output;
    }

    /**
     * @param array $types
     * @throws InvalidPropertyException
     * @throws \ReflectionException
     */
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

            if(is_callable($type)) {
                $type($value, $property, $exception);
            } else if(is_string($type) && PropTypes::isValidType($type)) {
                switch (true) {
                    case $type === PropTypes::ArrayType && !is_array($value):
                    case $type === PropTypes::StringType && !is_string($value):
                    case $type === PropTypes::IntegerType && !is_integer($value):
                    case $type === PropTypes::FloatType && !is_float($value):
                    case $type === PropTypes::DoubleType && !is_double($value):
                    case $type === PropTypes::ObjectType && !is_object($value):
                    case $type === PropTypes::NumericType && !is_numeric($value):
                        $exception->setMessage('The property `'.$property.'` must be '.$type.' type, '.$desiredType.' given.');
                        throw $exception;
                }
            } else if(!($value instanceof $type)) {
                $exception->setMessage('The property `'.$property.'` must be an instance of '.$type.', '.$desiredType.' given.');
                throw $exception;
            }
        }
    }

    /**
     * @return CommandBusInterface
     * @throws \Exception
     */
    private function getCommandBus(): CommandBusInterface
    {
        if(!($this->container instanceof ContainerInterface)) {
            throw new \Exception('Could not reach Service Container.');
        }

        return $this->container->get('brandfil_active.command_bus');
    }

    /**
     * @param string $service
     * @param string $type
     */
    private function fireEvent(string $service, string $type)
    {
        try {
            $events = $this->getCommandBus()
                ->getRegisteredEvents($service)
                ->filter(function (AbstractEvent $event) use ($type) {
                    return get_class($event) === $type;
                });

            /** @var AbstractEvent $event */
            foreach($events as $event) {
                $e = $event->getEvent();
                switch($type) {
                    case ServicePreInvokeEvent::class:
                        $e($event->getType(), $this->input);
                        break;

                    case ServicePostInvokeEvent::class:
                        $e($event->getType(), $this->output);
                        break;
                }
            }
        } catch (\Exception $e) {

        }
    }
}