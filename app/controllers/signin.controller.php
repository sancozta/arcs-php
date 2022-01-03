<?php 

class SigninController extends Controller {

    //MOSTRAR FORMULARIO DE CRIACAO DE CONTA
    public function index() {

        $this->loadViewTwig("signin");

    }

    //METODO PARA CRIAR UM USUARIO
    public function create(){

        $name               = (isset($_POST["name"]))               ? $_POST["name"]                : "" ;
        $mail               = (isset($_POST["mail"]))               ? $_POST["mail"]                : "" ;
        $password           = (isset($_POST["password"]))           ? $_POST["password"]            : "" ;
        $password_confirm   = (isset($_POST["password_confirm"]))   ? $_POST["password_confirm"]    : "" ;
        $language_id        = (isset($_POST["language_id"]))        ? $_POST["language_id"]         : "BR" ;
        
        if($password != $password_confirm){

            $this->loadView("signin", array(
                "message" => "Ops! As senhas tem que ser iguais !"
            ));

            exit();

        }

        //ENCRYPITANDO SENHA COM 10 ROUNDS
        $password_encrypted = password_hash($password, PASSWORD_BCRYPT);

        $UsersModel     = new UsersModel();
        $returnCreate   = $UsersModel->setUser($name, $mail, $password_encrypted, $language_id);

        if(!$returnCreate["response"]){

            $this->loadView("signin", array(
                "message" => "Erro ao realizar a inclusão !"
            ));

        } else {
            
            $this->redirectRoute("/page");

        }

    }

    public function loginGoogle(){

        $id                 = (isset($_POST["id"]))                 ? $_POST["id"]                  : "" ;
        $name               = (isset($_POST["name"]))               ? $_POST["name"]                : "" ;
        $mail               = (isset($_POST["mail"]))               ? $_POST["mail"]                : "" ;
        $photo              = (isset($_POST["photo"]))              ? $_POST["photo"]               : "" ;
        $language_id        = (isset($_POST["language_id"]))        ? $_POST["language_id"]         : "BR" ;
        $type               = (isset($_POST["type"]))               ? $_POST["type"]                : "GOOGLE" ;

        $_SESSION["log"]    = true ;
        $_SESSION["id"]     = $id;
        $_SESSION["name"]   = $name;
        $_SESSION["mail"]   = $mail;
        $_SESSION["lang"]   = $language_id;
        $_SESSION["type"]   = $type;
        $_SESSION["photo"]  = $photo;

        $this->returnJson(array(
            "response" => "sucess"
        ));

    }

}