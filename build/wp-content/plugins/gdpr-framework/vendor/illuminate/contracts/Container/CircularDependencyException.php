<?php

namespace Data443\gdpr\framework\Illuminate\Contracts\Container;

use Exception;
use Data443\gdpr\framework\Psr\Container\ContainerExceptionInterface;
class CircularDependencyException extends Exception implements ContainerExceptionInterface
{
    //
}
