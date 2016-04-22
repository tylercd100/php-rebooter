<?php

namespace Tylercd100\Rebooter\Drivers;

interface ServerController
{
    public function boot();
    public function reboot();
    public function shutdown();
}