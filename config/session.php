<?php

class session extends controller {

    //INICIALIZACAO
    public function __construct() {

        parent::__construct();

    }

    //REALIZAR LOGIN
    public function login() {

        $this->redirectRoute("/page");

    }

    //REALIZAR LOGOUT
    public function logout() {

        $_SESSION = array();

        session_destroy();

        $this->redirectRoute("/page");

    }

}
