<?php

namespace Tylercd100\Rebooter\Drivers\Api;

use GuzzleHttp\Client;

class DigitalOceanRebooter extends ApiRebooter 
{
    
    /**
     * @param string $token     API Token from DigitalOcean.com
     * @param number $server_id The ID of the droplet you want to control
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $server_id, $host = "api.digitalocean.com", Client $client = null) {
        parent::__construct($token, $server_id, $host, $client);
    }

    /**
     * Executes a Boot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function boot() {
        return $this->exec("power_on");
    }

    /**
     * Executes a Reboot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reboot() {
        return $this->exec("reboot");
    }

    /**
     * Executes a Shutdown command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function shutdown() {
        return $this->exec("power_off");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The DigitalOcean API action
     * @return string
     */
    protected function buildRequestUrl($action) {
        return "https://{$this->host}/v2/droplets/{$this->server_id}/actions";
    }

    /**
     * Builds the request data for the API call
     * @param  string $action The DigitalOcean API action
     * @return array
     */
    protected function buildRequestData($action) {
        return ["type"=>$action];
    }

    /**
     * Executes a command on the API
     * @param string $action
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function exec($action) {
        $url  = $this->buildRequestUrl($action);
        $data = $this->buildRequestData($action);
        return $this->client->request('POST', $url, [
            'auth' => [$this->token, ""],
            'form_params' => $data,
        ]);
    }
}