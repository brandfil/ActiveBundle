<?php

namespace Brandfil\ActiveBundle;

/**
 * Class PropTypes
 * @package Brandfil\ActiveBundle
 */
abstract class PropTypes
{
    public const ArrayType          = 'array';
    public const StringType         = 'string';
    public const IntegerType        = 'integer';
    public const FloatType          = 'float';
    public const DoubleType         = 'double';
    public const ObjectType         = 'object';
    public const NumericType        = 'numeric';
    public const AnyType            = 'any';

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function getTypes()
    {
        $reflector = new \ReflectionClass(self::class);
        return array_values($reflector->getConstants());
    }

    /**
     * @param string $type
     * @return bool
     * @throws \ReflectionException
     */
    public static function isValidType(string $type)
    {
        return in_array($type, static::getTypes());
    }
}
