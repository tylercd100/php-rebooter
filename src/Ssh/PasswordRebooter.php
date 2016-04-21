<?php

namespace Tylercd100\Rebooter\Ssh;

use Ssh\Authentication\Password;
use Ssh\Configuration;
use Ssh\Session;
use Tylercd100\Rebooter\SshRebooter;

class PasswordRebooter extends SshRebooter
{
    /**
     * @param string  $host     The host, url or IP address to use
     * @param string  $username The username to use
     * @param string  $password The password to use
     * @param integer $port     The port to use
     */
    public function __construct($host, $username, $password, $port = 22) {
        $config        = new Configuration($host, $port);
        $auth          = new Password($username, $password);
        $this->session = new Session($config, $auth);
    }
}