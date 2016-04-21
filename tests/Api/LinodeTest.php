<?php

namespace Tylercd100\Rebooter\Tests\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\Drivers\Api\LinodeRebooter;

class LinodeTest extends ApiTest
{
    protected $actions = ['reboot','boot','shutdown'];
    protected $rebooterClass = LinodeRebooter::class;
    protected $server_id = 123456789;

    protected function getCorrectUrl($action,$server_id){
        return "https://api.linode.com/?api_key=token&api_action={$action}&LinodeID={$server_id}";
    }

    protected function getInstance(){
        return new LinodeRebooter("token",$this->server_id);
    }
}