<?php

namespace Brandfil\ActiveBundle;

/**
 * Class CommandBusExpr
 * @package Brandfil\ActiveBundle
 */
final class CommandBusExpr
{
    const ONE_OF = 'one_of';

    private $type;
    private $params;

    /**
     * CommandBusExpr constructor.
     * @param $expr
     * @param $params
     */
    public function __construct($expr, $params)
    {
        $this->type = $expr;
        $this->params = $params;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
}