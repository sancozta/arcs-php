<?php

//HABILITANDO TIPOS ESCALARES PARA O PHP
declare(strict_types = 1);

//UTILIZACAO DO COMPOSER
if(file_exists("vendor/autoload.php")){
    require("vendor/autoload.php");
    error_log("Load Vendor...");
}

//LOAD ENV NO SERVER LOCAL
if(php_sapi_name() == "cli-server") {
    $dotenv = Dotenv\Dotenv::create(".");
    $dotenv->load();
    error_log("Load Envs...");
}

//FUNCTION PARA CARREGAMENTO DAS CLASS UTILIZADOS NO PROJETO WEB
spl_autoload_register(function($class){

    if((strstr($class, "Controller") !== FALSE) && (file_exists("app/controllers/".(strtolower(str_replace("Controller", "", $class))).".controller.php"))){

        $controller = str_replace("Controller", "", $class);
        require("app/controllers/{$controller}.controller.php");

    } else if((strstr($class, "Model") !== FALSE) && (file_exists("app/models/".(strtolower(str_replace("Model", "", $class))).".model.php"))){

        $model = str_replace("Model", "", $class);
        require("app/models/{$model}.model.php");

    } else if(file_exists("config/{$class}.php")) {

        require("config/{$class}.php");

    }

});

//EXECUTANDO CONTROLE DE ROTAS
$router = new router();
$router->run();