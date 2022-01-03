<?php

class router {

	//CONSTRUTOR
    public function __construct() {}

    //FUNCAO RESPONSAVEL POR INTERPRETAR A ROTA
	public function run() {

		$url = "";

		//METODO DE CAPTURAR AS ROTA DIFERENCA DE AMBIENTE
		if(php_sapi_name() == "cli-server") {

			if(isset($_SERVER["REQUEST_URI"])) {
				$url .= trim($_SERVER["REQUEST_URI"], "/");
			}

		} else {

			if(isset($_GET["url"])) {
				$url .= trim($_GET["url"], "/");
			}

		}

		//METODO PARA TRABALHAR COM PARAMETROS NA URL?PARAMS
		$arrayUrl   = parse_url($url);
		$url        = $arrayUrl["path"];
		(isset($arrayUrl["query"])) ? parse_str($arrayUrl["query"], $_GET) : "" ;

		//TRATAMENTO DO FLUXO PADRAO DA ESTRUTURA
		$params = array();
		$url 	= (empty($url)) ? $url : explode("/", $url);

		if(!empty($url)) {

            $currentController  = ucfirst($url[0])."Controller";
            $currentFile        = $url[0].".controller";

			array_shift($url);

			if(isset($url[0]) && !empty($url[0])) {
				$currentAction = $url[0];
				array_shift($url);
			} else {
				$currentAction = "index";
			}

			if(count($url) > 0) {
				$params = $url;
			}

		} else {

            $currentFile        = "page.controller";
			$currentController  = "PageController";
			$currentAction      = "index";

        }
        
		if(!file_exists("app/controllers/{$currentFile}.php") || !method_exists($currentController, $currentAction)) {

			$currentController  = "NotfoundController";
			$currentAction      = "index";

        }
        
		$instanceClass = new $currentController();

        //DECODIFICANDO PARAMETROS BASE64 - TEM QUE SE AJUSTADO NA URL TAMBEM
        $params = array_map("base64_decode", $params);

		call_user_func_array(array($instanceClass, $currentAction), $params);

	}

}
