<?php

namespace Tylercd100\Rebooter\Tests\Ssh;

use Ssh\Authentication\Password as SshPassword;
use Ssh\Configuration;
use Ssh\Exec;
use Ssh\Session;
use Tylercd100\Rebooter\Drivers\Ssh\Password;
use Tylercd100\Rebooter\Tests\TestCase;

class PasswordTest extends TestCase
{
    public function testItCreatesInstanceSuccessfully(){
        $obj = new Password("host", "username", "password", 22);
        $this->assertInstanceOf(Password::class,$obj);
    }

    public function testItCallServerControllerMethods(){
        $methods = ['reboot','shutdown'];

        foreach ($methods as $m) {
            $obj = new Password("host", "username", "password", 22);
            $session = $this->getMockedSession();
            $obj->setSession($session);
            $obj->{$m}();
        }
    }

    public function testSessionGetterAndSetter(){
        $config  = new Configuration("host",22);
        $auth    = new SshPassword("username", "password");
        $session = new Session($config,$auth);
        $obj     = new Password("host", "username", "password", 22);
        $obj->setSession($session);
        $sessionFromGetter = $obj->getSession();
        $this->assertEquals($session,$sessionFromGetter);
    }

    public function testItThrowsExceptionForBootMethod(){
        $this->setExpectedException('Tylercd100\Rebooter\Exceptions\MethodNotAllowedException');
        $obj = new Password("host", "username", "password", 22);
        $obj->boot();
    }

    protected function getMockedSession(){

        $config = new Configuration("host",22);
        $auth   = new SshPassword("username", "password");

        $session = $this->getMock(Session::class, array('getExec'), [$config, $auth]);
        $exec    = $this->getMock(Exec::class, array('run'), [$session]);
        
        $session->expects($this->once())
                ->method('getExec')
                ->willReturn($exec);
        
        $exec->expects($this->once())
             ->method('run');

        return $session;
    }
}