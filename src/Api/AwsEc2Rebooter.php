<?php

namespace Tylercd100\Rebooter\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\ApiRebooter;

class AwsEc2Rebooter extends ApiRebooter {

    protected $token;
    protected $serverId;
    protected $host;
    protected $client;
    
    /**
     * @param string $token    API Token from Linode.com
     * @param [type] $serverId The ID of the linode you want to control
     * @param string $host     The api host
     * @param Client $client   The guzzle client to use
     */
    public function __construct($token, $serverId, $host = "ec2.amazonaws.com", Client $client = null){

        if(!$client instanceof Client){
            $client = new Client();
        }

        $this->client = $client;
        $this->token = $token;
        $this->serverId = $serverId;
        $this->host = $host;
    }

    /**
     * Executes a Boot command
     * @return GuzzleHttp\Psr7\Response
     */
    public function boot(){
        return $this->exec("StartInstances");
    }

    /**
     * Executes a Reboot command
     * @return GuzzleHttp\Psr7\Response
     */
    public function reboot(){
        return $this->exec("RebootInstances");
    }

    /**
     * Executes a Shutdown command
     * @return GuzzleHttp\Psr7\Response
     */
    public function shutdown(){
        return $this->exec("StopInstances");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The Linode API action
     * @return string
     */
    protected function buildRequestUrl($action){
        return "https://{$this->host}/?Action={$action}&InstanceId.1={$this->serverId}&AUTHPARAMS"
    }

    /**
     * Executes a command on the API
     * @return GuzzleHttp\Psr7\Response
     */
    protected function exec($action){
        $url = $this->buildRequestUrl($action);
        return $res = $this->client->request('GET', $url);
    }
}