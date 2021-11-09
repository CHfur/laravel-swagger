<?php

namespace RonasIT\Support\AutoDoc\Traits;

use ReflectionMethod;
use ReflectionFunctionAbstract;
use ReflectionParameter;

trait GetDependenciesTrait
{
    protected function resolveClassMethodDependencies(array $parameters, $instance, $method): array
    {
        if (!method_exists($instance, $method)) {
            return $parameters;
        }

        return $this->getDependencies(
            new ReflectionMethod($instance, $method)
        );
    }

    public function getDependencies(ReflectionFunctionAbstract $reflector): array
    {
        return array_map(function ($parameter) {
            return $this->transformDependency($parameter);
        }, $reflector->getParameters());
    }

    protected function transformDependency(ReflectionParameter $parameter): ?string
    {
        return ($parameter->getType() && !$parameter->getType()->isBuiltin())
            ? $parameter->getType()->getName()
            : null;
    }
}
