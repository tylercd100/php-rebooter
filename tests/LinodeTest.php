<?php

namespace Tylercd100\Rebooter\Tests;

use Tylercd100\Rebooter\Api\LinodeRebooter;

class LinodeTest extends TestCase
{
    public function testItCreatesInstanceSuccessfully(){
        $obj = new LinodeRebooter();
        $this->assertInstanceOf(LinodeRebooter::class,$obj);
    }
}