<?php

namespace Tylercd100\Rebooter\Api;

use GuzzleHttp\Client;
use Tylercd100\Rebooter\ApiRebooter;

class LinodeRebooter extends ApiRebooter {

    protected $token;
    protected $linodeId;
    protected $host;
    protected $client;
    
    /**
     * @param string $token    API Token from Linode.com
     * @param [type] $linodeId The ID of the linode you want to control
     * @param string $host     The api host
     * @param Client $client   The guzzle client to use
     */
    public function __construct($token, $linodeId, $host = "api.linode.com", Client $client = null){

        if(!$client instanceof Client){
            $client = new Client();
        }

        $this->client = $client;
        $this->token = $token;
        $this->linodeId = $linodeId;
        $this->host = $host;
    }

    /**
     * Executes a Boot command
     * @return asdfasdfkdkdkdkd
     */
    public function boot(){
        return $this->exec("linode.boot");
    }

    /**
     * Executes a Reboot command
     * @return asdfasdfkdkdkdkd
     */
    public function reboot(){
        return $this->exec("linode.reboot");
    }

    /**
     * Executes a Shutdown command
     * @return asdfasdfkdkdkdkd
     */
    public function shutdown(){
        return $this->exec("linode.shutdown");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The Linode API action
     * @return string
     */
    protected function buildRequestUrl($action){
        return "https://{$this->host}/?api_key={$this->token}&api_action={$action}&LinodeID={$this->linodeId}";
    }

    /**
     * Executes a command on the API
     * @return asdfasdfkdkdkdkd
     */
    protected function exec($action){
        $url = $this->buildRequestUrl($action);
        $res = $this->client->request('GET', $url);

        var_dump($url);
        var_dump($res->getStatusCode());
        var_dump($res->getBody());
        var_dump(get_class($res));
    }
}