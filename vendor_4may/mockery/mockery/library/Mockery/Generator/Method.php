<?php

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link https://github.com/mockery/mockery for the canonical source repository
 */

namespace Mockery\Generator;

use Mockery\Reflector;
use ReflectionMethod;
use ReflectionParameter;

use function array_map;

class Method
{
    /**
     * @var ReflectionMethod
     */
    private $method;

    public function __construct(ReflectionMethod $method)
    {
        $this->method = $method;
    }

    public function __call($method, $args)
    {
        return $this->method->{$method}(...$args);
    }

    /**
     * @return Parameter[]
     */
    public function getParameters()
    {
        return array_map(static function (ReflectionParameter $parameter) {
            return new Parameter($parameter);
        }, $this->method->getParameters());
    }

    /**
     * @return null|string
     */
    public function getReturnType()
    {
        return Reflector::getReturnType($this->method);
    }
}
