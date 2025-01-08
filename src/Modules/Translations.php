<?php

namespace Base\Modules;

class Translations extends Module
{
    /**
     * Boot the module.
     */
    public function boot(): void
    {
        __('Translation', 'base');
    }
}
