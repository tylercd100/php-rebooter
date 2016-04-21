<?php

namespace Tylercd100\Rebooter\Drivers\Api;

use GuzzleHttp\Client;

class Linode extends Api 
{

    /**
     * @param string $token     API Token from Linode.com
     * @param number $server_id The ID of the linode you want to control
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $server_id, $host = "api.linode.com", Client $client = null) {
        parent::__construct($token, $server_id, $host, $client);
    }

    /**
     * Executes a Boot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function boot() {
        return $this->exec("linode.boot");
    }

    /**
     * Executes a Reboot command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function reboot() {
        return $this->exec("linode.reboot");
    }

    /**
     * Executes a Shutdown command
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function shutdown() {
        return $this->exec("linode.shutdown");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The Linode API action
     * @return string
     */
    protected function buildRequestUrl($action) {
        return "https://{$this->host}/?api_key={$this->token}&api_action={$action}&LinodeID={$this->server_id}";
    }

    /**
     * Executes a command on the API
     * @param string $action
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function exec($action) {
        $url = $this->buildRequestUrl($action);
        return $this->client->request('GET', $url);
    }
}