<?php

namespace Tylercd100\Rebooter\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\ApiRebooter;

class VultrRebooter extends ApiRebooter {

    protected $token;
    protected $server_id;
    protected $host;
    protected $client;
    
    /**
     * @param string $token     API Token from DigitalOcean.com
     * @param number $server_id The ID of the droplet you want to control
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $server_id, $host = "api.vultr.com", Client $client = null){

        if(!$client instanceof Client){
            $client = new Client();
        }

        $this->client = $client;
        $this->token = $token;
        $this->server_id = $server_id;
        $this->host = $host;
    }

    /**
     * Executes a Boot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function boot(){
        return $this->exec("start");
    }

    /**
     * Executes a Reboot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reboot(){
        return $this->exec("reboot");
    }

    /**
     * Executes a Shutdown command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function shutdown(){
        return $this->exec("halt");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The DigitalOcean API action
     * @return string
     */
    protected function buildRequestUrl($action){
        return "https://{$this->host}/v1/server/{$action}";
    }

    /**
     * Builds the request data for the API call
     * @param  string $action The DigitalOcean API action
     * @return array
     */
    protected function buildRequestData($action){
        return ["SUBID"=>$this->server_id];
    }

    /**
     * Executes a command on the API
     * @param string $action
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function exec($action){
        $url  = $this->buildRequestUrl($action);
        $data = $this->buildRequestData($action);
        return $this->client->request('POST', $url, [
            'headers' => [
                'API-Key' => $this->token,
            ],
            'form_params' => $data,
        ]);
    }
}