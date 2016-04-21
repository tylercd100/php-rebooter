<?php

namespace Tylercd100\Rebooter\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\ApiRebooter;

class LinodeRebooter extends ApiRebooter {

    protected $token;
    protected $server_id;
    protected $host;
    protected $client;
    
    /**
     * @param string $token     API Token from Linode.com
     * @param number $server_id The ID of the linode you want to control
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $server_id, $host = "api.linode.com", Client $client = null) {

        if (!$client instanceof Client) {
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