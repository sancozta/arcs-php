<?php 

class PageController extends session {

    public function index() {

        $this->loadViewTwig("pages", array(
            "ENV" => getenv("APP_ENV"),
            "ROTA" => "/page/hello/T2zDoSBldSBTb3UgdW1hIE1lbnNhZ2VtIEVudmlhZGEgUG9yIFZvY8OqICE=",

        ));

    }

    public function hello($msg) {

        $this->loadViewTwig("pages", array(
            "MSG" => $msg
        ));

    }

}