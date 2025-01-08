<?php

namespace Base\Modules;

abstract class Module
{
    /**
     * Boot the module.
     */
    abstract public function boot(): void;
}
