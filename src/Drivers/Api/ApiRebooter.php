<?php

namespace Tylercd100\Rebooter\Drivers\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\Drivers\ServerController;

abstract class ApiRebooter implements ServerController
{
    protected $token;
    protected $server_id;
    protected $host;
    protected $client;

    /**
     * @param string $token     API Token
     * @param number $server_id The ID of the server
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $server_id, $host, Client $client = null) {

        if (!$client instanceof Client) {
            $client = new Client();
        }

        $this->client = $client;
        $this->token = $token;
        $this->server_id = $server_id;
        $this->host = $host;
    }
}