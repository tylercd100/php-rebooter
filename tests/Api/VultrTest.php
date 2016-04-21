<?php

namespace Tylercd100\Rebooter\Tests\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\Drivers\Api\VultrRebooter;

class VultrTest extends ApiTest
{
    protected $actions = ['reboot','boot','shutdown'];
    protected $rebooterClass = VultrRebooter::class;
    protected $server_id = 123456789;

    protected function getCorrectUrl($action,$server_id){
        return "https://api.vultr.com/v1/server/{$action}";
    }

    protected function getInstance(){
        return new VultrRebooter("token",$this->server_id);
    }
}