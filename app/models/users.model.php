<?php

class UsersModel extends model {

    //SELECT USUARIO
    public function getLogin($params = array()){
        return $this->executarQuery("
            SELECT
                ID,
                NAME,
                MAIL,
                PASSWORD,
                LANGUAGE_ID
            FROM USER
            WHERE MAIL = :MAIL
        ", $params);
    }

    //GET TOKEN
    public function getToken($params = array()){
        return $this->executarQuery("
            SELECT
                ID,
                NAME,
                MAIL,
                PASSWORD,
                LANGUAGE_ID
            FROM USER
            WHERE AUTHORIZATION = :AUTHORIZATION
        ", $params);
    }

    //PUT TOKEN
    public function putToken($params = array()){
        return $this->executarQuery("
            UPDATE USER SET
                AUTHORIZATION = :AUTHORIZATION
            WHERE ID = :ID;
        ", $params);
    }

    //LISTAR USUARIOS
    public function getUsers(){
        return $this->executarQuery("
            SELECT
                ID,
                NAME,
                MAIL,
                PASSWORD,
                LANGUAGE_ID,
                CREATEAT
            FROM USER ;
        ");
    }

    //LISTAR USUARIO
    public function getUser($params = array()){
        return $this->executarQuery("
            SELECT
                ID,
                NAME,
                MAIL,
                PASSWORD,
                LANGUAGE_ID,
                CREATEAT
            FROM USER
            WHERE ID = :ID ;
        ", $params);
    }

    //DELETAR USUARIO
    public function deleteUser($params = array()){
        return $this->executarQuery("
            DELETE
            FROM USER
            WHERE ID = :ID ;
        ", $params);
    }

    //ALTERAR USUARIO
    public function putUser($params = array(), $bind = ""){

        if (isset($params["id"])){

            foreach($params as $keys => $values){
                if($keys != "id"){
                    $bind .= "{$keys} = :{$keys}, ";
                }
            }

            return $this->executarQuery("
                update user set
                    ".(trim($bind, ", "))."
                where id = :id ;
            ",
            $params);

        } else {

            return array(
                "response"  => false,
                "message"   => "O indentificador [id] não foi informado !",
                "affect"    => 0,
                "data"      => []
            );

        }

    }

    //INSERIR UM NOVO USUARIO
    public function setUser($params = array()){
        return $this->executarQuery("
            INSERT INTO USER (
                NAME,
                MAIL,
                PASSWORD,
                LANGUAGE_ID,
                CREATEAT
            ) VALUES (
                :NAME,
                :MAIL,
                :PASSWORD,
                :LANGUAGE_ID,
                SYSDATE()
            );
        ", $params);
    }

    //INSERIR HASH PARA RESET DE SENHA
    public function putHashPassword($params = array()){
        return $this->executarQuery("
            UPDATE USER SET
                PASSWORD_RESET = :PASSWORD_RESET
            WHERE ID = :ID;
        ", $params);
    }

    //SELECT USUARIO POR HASH
    public function getForgotPassword($params = array()){
        return $this->executarQuery("
            SELECT
                ID,
                NAME,
                MAIL,
                PASSWORD_RESET
            FROM USER
            WHERE PASSWORD_RESET = :PASSWORD_RESET
        ", $params);
    }

    //ALTERAR PASSWORD
    public function putPassword($params = array()){
        return $this->executarQuery("
            UPDATE USER SET
            PASSWORD = :PASSWORD
            WHERE ID = :ID AND PASSWORD_RESET = :PASSWORD_RESET;
        ", $params);
    }

}
