<?php

namespace Brandfil\ActiveBundle\Exceptions;

use Throwable;

/**
 * Class InvalidPropertyException
 * @package Brandfil\ActiveBundle\Exceptions
 */
final class InvalidPropertyException extends \LogicException
{
    private $property;
    private $type;
    private $desiredType;
    private $value;
    protected $message;


    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     */
    public function setProperty($property): void
    {
        $this->property = $property;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getDesiredType()
    {
        return $this->desiredType;
    }

    /**
     * @param mixed $desiredType
     */
    public function setDesiredType($desiredType): void
    {
        $this->desiredType = $desiredType;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}