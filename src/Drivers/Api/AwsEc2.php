<?php

namespace Tylercd100\Rebooter\Drivers\Api;

use GuzzleHttp\Client;
use Carbon\Carbon;

class AwsEc2 extends Api {

    /**
     * @param string $token     API Token from Linode.com
     * @param number $server_id The ID of the linode you want to control
     * @param string $host      The api host
     * @param Client $client    The guzzle client to use
     */
    public function __construct($token, $secret, $server_id, $host = "ec2.amazonaws.com", Client $client = null)
    {
        $this->secret = $secret;
        parent::__construct($token, $server_id, $host, $client);
    }

    /**
     * Executes a Boot command
     * @return GuzzleHttp\Psr7\Response
     */
    public function boot()
    {
        return $this->exec("StartInstances");
    }

    /**
     * Executes a Reboot command
     * @return GuzzleHttp\Psr7\Response
     */
    public function reboot()
    {
        return $this->exec("RebootInstances");
    }

    /**
     * Executes a Shutdown command
     * @return GuzzleHttp\Psr7\Response
     */
    public function shutdown()
    {
        return $this->exec("StopInstances");
    }

    /**
     * Builds the request URL for the API call
     * @param  string $action The Linode API action
     * @return string
     */
    protected function buildRequestUrl($action)
    {
        $now = Carbon::now();

        $params = [
            "Action" => $action,
            "InstanceId.1" => $this->server_id,
            "Version"=>"2015-10-01",
            "AWSAccessKeyId"=>$this->token,
            "SignatureVersion"=>"2",
            "SignatureMethod"=>"HmacSHA256",
            "Timestamp"=>$now->toIso8601String(),
        ];

        $params["Signature"] = $this->getSignature($params);

        $paramString = $this->getParamString($params);

        return "https://{$this->host}/?{$paramString}";
    }

    /**
     * Executes a command on the API
     * @return GuzzleHttp\Psr7\Response
     */
    protected function exec($action)
    {
        $url = $this->buildRequestUrl($action);
        return $res = $this->client->request('GET', $url);
    }

    private function getSignature($params)
    {
        $data = $this->getRawSignature($params);
        return urlencode(base64_encode(hash_hmac("sha256",$data,$this->secret)));
    }

    private function getRawSignature($params)
    {
        $paramString = $this->getParamString($params);
        $raw = "GET\n{$this->host}\n/\n{$paramString}";
        return $raw;
    }

    private function getParamString($paramsA)
    {
        ksort($paramsA);
        $paramsB = [];
        foreach ($paramsA as $key => $value) {
            $value = urlencode($value);
            $paramsB[] = "{$key}={$value}";
        }
        $paramString = implode("&", $paramsB);
        return $paramString;
    }
}