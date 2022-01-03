<?php 

class NotfoundController extends controller {

    public function index() {

        $this->loadViewTwig("pages", array(
            "MSG" => "NOT FOUND!"
        ));

    }
    
}