<?php

namespace RonasIT\Support\AutoDoc\Traits;

use ReflectionException;
use ReflectionMethod;
use ReflectionFunction;
use ReflectionParameter;
use Illuminate\Support\Arr;
use ReflectionFunctionAbstract;
use Illuminate\Container\Container;

trait GetDependenciesTrait
{
    /**
     * @throws ReflectionException
     */
    protected function resolveClassMethodDependencies(array $parameters, $instance, $method): array
    {
        if (!method_exists($instance, $method)) {
            return $parameters;
        }

        return $this->getDependencies(
            new ReflectionMethod($instance, $method)
        );
    }

    /**
     * @throws ReflectionException
     */
    public function getDependencies(ReflectionFunctionAbstract $reflector): array
    {
        return array_map(function ($parameter) {
            return $this->transformDependency($parameter);
        }, $reflector->getParameters());
    }

    /**
     * @throws ReflectionException
     */
    protected function transformDependency(ReflectionParameter $parameter): ?string
    {
        $class = $parameter->getClass();

        if (empty($class)) {
            return null;
        }

        return interface_exists($class->name) ? $this->getClassByInterface($class->name) : $class->name;
    }

    /**
     * @throws ReflectionException
     */
    protected function getClassByInterface($interfaceName)
    {
        $bindings = Container::getInstance()->getBindings();

        $implementation = Arr::get($bindings, "{$interfaceName}.concrete");

        $classFields = (new ReflectionFunction($implementation))->getStaticVariables();

        return $classFields['concrete'];
    }
}
