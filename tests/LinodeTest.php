<?php

namespace Tylercd100\Rebooter\Tests;

use Tylercd100\Rebooter\Api\LinodeRebooter;
use GuzzleHttp\Client;

class LinodeTest extends TestCase
{
    public function testItCreatesInstanceSuccessfully(){
        $obj = new LinodeRebooter("token",123456789);
        $this->assertInstanceOf(LinodeRebooter::class,$obj);
    }

    public function testItBuildsCorrectUrl(){
        $obj = new LinodeRebooter("token",123456789);
        $actions = ['reboot','boot','shutdown'];
        foreach($actions as $action){
            $result = $this->invokeMethod($obj, 'buildRequestUrl', [$action]);
            $expected = "https://api.linode.com/?api_key=token&api_action={$action}&LinodeID=123456789";
            $this->assertEquals($expected,$result);
        }
    }

    public function testItCallServerControllerMethods(){
        $methods = ['reboot','boot','shutdown'];

        foreach ($methods as $m) {
            $mock = $this->getMock(LinodeRebooter::class, array('exec'), ['token',1234]);
            $mock->expects($this->once())
                 ->method('exec');

            $mock->{$m}();
        }
    }

    public function testItCallsClientRequest(){
        $mock = $this->getMock(Client::class, array('request'));

        $mock->expects($this->once())
             ->method('request');

        $obj = new LinodeRebooter('token',1234,'asdf.com',$mock);
        $obj->reboot();
    }
}