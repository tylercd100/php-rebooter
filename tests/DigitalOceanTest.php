<?php

namespace Tylercd100\Rebooter\Tests;

use Tylercd100\Rebooter\Api\DigitalOceanRebooter;
use GuzzleHttp\Client;

class DigitalOceanTest extends TestCase
{
    public function testItCreatesInstanceSuccessfully(){
        $obj = new DigitalOceanRebooter("token",123456789);
        $this->assertInstanceOf(DigitalOceanRebooter::class,$obj);
    }

    public function testItBuildsCorrectUrl(){
        $obj = new DigitalOceanRebooter("token",123456789);
        $actions = ['reboot','boot','shutdown'];
        foreach($actions as $action){
            $result = $this->invokeMethod($obj, 'buildRequestUrl', [$action]);
            $expected = "https://api.digitalocean.com/v2/droplets/123456789/actions";
            $this->assertEquals($expected,$result);
        }
    }

    public function testItCallServerControllerMethods(){
        $methods = ['reboot','boot','shutdown'];

        foreach ($methods as $m) {
            $mock = $this->getMock(DigitalOceanRebooter::class, array('exec'), ['token',1234]);
            $mock->expects($this->once())
                 ->method('exec');

            $mock->{$m}();
        }
    }

    public function testItCallsClientRequest(){
        $mock = $this->getMock(Client::class, array('request'));

        $mock->expects($this->once())
             ->method('request');

        $obj = new DigitalOceanRebooter('token',1234,'asdf.com',$mock);
        $obj->reboot();
    }
}