<?php

namespace Tylercd100\Rebooter\Tests;

use Tylercd100\Rebooter\Api\DigitalOceanRebooter;
use GuzzleHttp\Client;

class DigitalOceanTest extends ApiTest
{
    protected $actions = ['reboot','boot','shutdown'];
    protected $rebooterClass = DigitalOceanRebooter::class;
    protected $server_id = 123456789;

    protected function getCorrectUrl($action,$server_id){
        return "https://api.digitalocean.com/v2/droplets/{$server_id}/actions";
    }

    protected function getInstance(){
        return new DigitalOceanRebooter("token",$this->server_id);
    }
}