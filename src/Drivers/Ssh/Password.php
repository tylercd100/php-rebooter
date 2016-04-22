<?php

namespace Tylercd100\Rebooter\Drivers\Ssh;

use Ssh\Authentication\Password as SshPassword;
use Ssh\Configuration;
use Ssh\Session;

class Password extends Ssh
{
    /**
     * @param string  $host     The host, url or IP address to use
     * @param string  $username The username to use
     * @param string  $password The password to use
     * @param integer $port     The port to use
     */
    public function __construct($host, $username, $password, $port = 22) {
        $config        = new Configuration($host, $port);
        $auth          = new SshPassword($username, $password);
        $this->session = new Session($config, $auth);
    }
}