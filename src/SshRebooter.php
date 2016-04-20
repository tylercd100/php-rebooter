<?php

namespace Tylercd100\Rebooter;

use Tylercd100\Rebooter\Exceptions\MethodNotAllowedException;
use Ssh\Session;

abstract class SshRebooter implements ServerController
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * Gets the SSH session executor
     * @return \Ssh\Exec
     */
    public function getExec(){
        return $this->session->getExec();
    }

    /**
     * Throws an Exception because you cannot boot a powered down machine from ssh
     * @return void
     */
    public function boot(){
        throw new MethodNotAllowedException("You cannot use SSH to boot a powered down server.");
    }

    /**
     * Executes a Reboot command
     * @return void
     */
    public function reboot(){
        $exec = $this->getExec();
        $exec->run('reboot');
    }

    /**
     * Executes a Shutdown command
     * @return void
     */
    public function shutdown(){
        $exec = $this->getExec();
        $exec->run('shutdown -P now');
    }

    /**
     * Gets the value of session.
     *
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Sets the value of session.
     *
     * @param Session $session the session
     * @return self
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }
}