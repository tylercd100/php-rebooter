<?php

namespace Tylercd100\Rebooter\Tests;

use Exception;
use Tylercd100\Rebooter\Tests\TestCase;
use GuzzleHttp\Client;

abstract class ApiTest extends TestCase
{
    protected $actions = ['reboot','boot','shutdown'];
    protected $correctUrl = "";

    public function testItCreatesInstanceSuccessfully(){
        $obj = $this->getInstance();
        $this->assertInstanceOf($this->rebooterClass,$obj);
    }

    public function testItBuildsCorrectUrl(){
        $obj = $this->getInstance();
        $server_id = $this->server_id;
        foreach($this->actions as $action){
            $result = $this->invokeMethod($obj, 'buildRequestUrl', [$action]);
            $expected = $this->getCorrectUrl($action,$server_id);
            $this->assertEquals($expected,$result);
        }
    }

    public function testItCallServerControllerMethods(){
        $methods = ['reboot','boot','shutdown'];

        foreach ($methods as $m) {
            $mock = $this->getMock($this->rebooterClass, array('exec'), ['token',1234]);
            $mock->expects($this->once())
                 ->method('exec');

            $mock->{$m}();
        }
    }

    public function testItCallsClientRequest(){
        $mock = $this->getMock(Client::class, array('request'));

        $mock->expects($this->once())
             ->method('request');

        $obj = new $this->rebooterClass('token',1234,'asdf.com',$mock);
        $obj->reboot();
    }
}