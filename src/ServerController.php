<?php

namespace Tylercd100\Rebooter;

interface ServerController
{
    public function boot();
    public function reboot();
    public function shutdown();
}