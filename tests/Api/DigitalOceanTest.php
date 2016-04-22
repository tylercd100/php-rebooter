<?php

namespace Tylercd100\Rebooter\Tests\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\Drivers\Api\DigitalOcean;

class DigitalOceanTest extends ApiTest
{
    protected $actions = ['reboot','boot','shutdown'];
    protected $rebooterClass = DigitalOcean::class;
    protected $server_id = 123456789;

    protected function getCorrectUrl($action,$server_id){
        return "https://api.digitalocean.com/v2/droplets/{$server_id}/actions";
    }

    protected function getInstance(){
        return new DigitalOcean("token",$this->server_id);
    }
}