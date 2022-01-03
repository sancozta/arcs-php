<?php

class model {

    protected $db;

	//CONSTRUTOR
	public function __construct() {

		$this->connectDataBase();

	}

	//CONECTAR AO BANCO DE DADOS
	public function conectarDataBase(){

		//CONEXAO PDO
		try {

			//CONEXAO
            $this->db = new PDO(
                "mysql:host=".(getenv('DB_ENV_HOST')).";dbname=".(getenv('DB_ENV_NAME')),
                getenv('DB_ENV_USER'),
                getenv('DB_ENV_PASS'),
                array(
                    // MANTER CONEXAO PERSISTENTE NO BANCO DE DADOS
                    PDO::ATTR_PERSISTENT            => true,
                    // MANTER CODIFICACAO PADRAO DURANTE A CONEXAO
                    PDO::MYSQL_ATTR_INIT_COMMAND    => "SET NAMES utf8",
                    // DEFININDO O MODO DE ERRO PARA LANCAR EXCECOES
                    PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
                    //DEFINE CASE COLUNM
                    PDO::ATTR_CASE                  => PDO::CASE_LOWER
                )
            );

		//POSSIBILIDADE DE ERRO
		} catch (Exception $log) {

            //DESCRICAO DO ERRO NA CONEXAO
            print_r("<pre>");

			print_r(array(
                "response"  => false,
                "message"   => "Não foi possível conectar-se ao Banco de Dados.",
                "code"      => $log->getCode()
            ));

            print_r("</pre>");

			exit();

		}

	}

	//EXECUTAR SCRIPTS SQL
	public function executarQuery($sql, $params = array()){

		//EXECUTANDO QUERY POR PDO
		try {

			//PREPARAR OPERACAO
			$operation = $this->db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            //BIND VALUES PARAMS
            foreach($params as $key => $value){

                $operation->bindValue($key, $value);

            }

			//EXECUTANDO OPERACAO
			if($operation->execute()){

                $type = current(str_word_count($sql, 2));
                $data = (strcasecmp($type, "select") == 0) ? $operation->fetchAll(PDO::FETCH_ASSOC) : [] ;
                $rows = $operation->rowCount();

                //RETORNAR RESULTADO
                return array(
                    "response"  => true,
                    "message"   => "Operation is Sucess",
                    "affect"    => $rows,
                    "data"      => $data
                );

			} else {

				//RETORNANDO FALSE CASO OCORRA ERRO
                $logs = $operation->errorInfo();

                //LOG CODE SYSTEM
                error_log("CODE ERRO: {$logs[1]}");

                //LOG MSG SYSTEM
                error_log("MESG ERRO: {$logs[2]}");

                //RETURN ERRO ARRAY
                return array(
                    "response"  => false,
                    "message"   => $logs[2],
                    "code"      => $logs[1]
                );

			}

			//O PDO FECHA A CONEXAO APOS A EXCUÇÃO DO SCRIPT

		//POSSIBILIDADE DE ERRO
		} catch(PDOException $log) {

            //TRATANDO MESSAGEM DE ERRO
            $message = $log->getMessage();
            $arraymg = explode(":", $message);
            $fistmsg = array_shift($arraymg);
            $message = trim(implode(" ", $arraymg));

            //RETURN ERRO ARRAY
            return array(
                "response"  => false,
                "message"   => $message,
                "code"      => $log->getCode()
            );

		}

    }

    //RETORNA O ULTIMO ID INSERIDO
    public function returnLastId(){
        return $this->db->lastInsertId();
    }

}
