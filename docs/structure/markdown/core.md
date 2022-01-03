## Core

<p style="text-align: justify;">
Esse diretório contém todos os arquivos que compõem o núcleo da aplicação, assim os arquivo presentes nesta pasta só devem ser alterados caso o desenvolvedor tenha um conhecimento maior sobre o comportamento da aplicação para que alterações não calculadas possam impactar a aplicação em diferentes pontos.
</p>

### info.php

<p style="text-align: justify;">
Esse arquivo é o mais simples e sua função no projeto é fornecer informações a respeito do ambiente php onde a aplicação esta sendo executada. Muito útil para verificar as extensões habilitadas assim como também as configurações disponíveis no ambiente.
</p>

### environment.php

<p style="text-align: justify;">
Esse arquivo contém definições a respeito de qual ambiente a aplicação esta sendo executada (desenvolvimento "DSV" ou produção "PRD"), utilizando a variável <code class="markdown">$envDb</code>. Nesse arquivo a definição de qual banco de dados está conectado a aplicação (desenvolvimento "DSV" ou produção "PRD") é feito pela variavel <code class="markdown">$envDb</code>, desta forma é possível alternar entre bancos de dados diferentes.
</p>

### config.php

<p style="text-align: justify;">
Esse arquivo contém as definições dos bancos de dados utilizados pela aplicação. Nesse arquivo o desenvolvedor poderá informar os dados de conexão do banco de desenvolvimento como também as informações de conexão para o banco de produção. 
</p>

    $config["dbname"] = "NOME_DO_BANCO";
	$config["dbhost"] = "HOST_DO_BANCO";
	$config["dbuser"] = "USER_PARA_CONEXAO";
	$config["dbpass"] = "SENHA_PARA_CONEXAO";
	$config["dbport"] = "PORTA_UTILIZADA";

### session.php

<p style="text-align: justify;">
Esse arquivo contém toda a lógica sobre a definição de sessão da aplicação, todas as controllers que necessitarem que autenticação precisaram extender esta class. As funções relacionadas ao controller de sessão estão implementadas nesse arquivo, portanto controllers que necessitarem de autenticação extendendo <b>session</b> automaticamente estará implementando essas funções e as aplicando.
</p>

<p style="text-align: justify;">
Uma classe que extender a class (session) presente no arquivo session.php estará herdando alguns metodos bastante utilizados pelo fluxo desenhado para esse projeto. Alguns desses métodos são :
</p>

    void loadView($view [, $data = array()]);
    Carrega uma view localizada na pasta views da estrutura do projeto.

    json returnJson($data [, $code = false [, $message = false]]);
    Retorna um json padronizado com um tratamento específico para questões 
    particulares que possam aparecer.

    void redirectRoute($route);
    Redireciona o usuário para a rota desejada.

    string returnVersion();
    Retorna um string descrevendo a versão atual do sistema

### controller.php

<p style="text-align: justify;">
Esse arquivo é destinado a implementar funções globais que são usadas por class que extendam a class controller presente neste arquivo. Esse arquivo não implementa questões de sessão portanto essa class é utilizada em paginas públicas. Devido a finalizada similares é interessante que os métodos existentes em <b>controller.php</b> também existam em <b>session.php</b> ficando disponiveis em controllers públicas como também "privadas".
</p>

<p style="text-align: justify;">
Uma classe que extender a class (controller) presente no arquivo controller.php estará herdando alguns metodos bastante utilizados pelo fluxo desenhado para esse projeto. Alguns desses métodos são :
</p>

    void loadHeader();
    Carrega o menu configurado pelas informações presentes no banco de 
    dados e alteráveis pela área administrativa.

    void loadView($view [, $data = array()]);
    Carrega uma view localizada na pasta views da estrutura do projeto.

    json returnJson($data [, $code = false [, $message = false]]);
    Retorna um json padronizado com um tratamento específico para questões 
    particulares que possam aparecer.

    void redirectRoute($route);
    Redireciona o usuário para a rota desejada.

    string returnVersion();
    Retorna um string descrevendo a versão atual do sistema

### model.php

<p style="text-align: justify;">
Esse arquivo contém a class model que é extendida por todas a models da estrutura presentes no diretório <b>models</b>. Sendo assim a models criadas no projeto devem extender esta class para que possam utilizar os metodos destinados a realizar a persistência com o banco de dados. Essa class contém dois métodos que são utilizados para realizar a interações com o banco de dados.
</p>

<p style="text-align: justify;">
Essa estrutura implementa a biblioteca PDO para realizar a integração com o banco de dados, com o objetivo de facilitar a utilização do banco de dados pela aplicação, como também ter um nível de abstração maior, possibilitando trocas futuras de SGBD. Os métodos disponíveis nesta class e que estaram disponíves para class que a extenderem são :
</p>

    void conectar($config);
    Esse método é executado pelo próprio construtor da class model e sua fazer 
    a conexão com o banco de dados.

    array executar($sql [, $params = array()]);
    Esse método é o metodo utilizado para executar scripts sql no banco de 
    dados, retorna false em caso de falha.

### core.php

<p style="text-align: justify;">
Esse arquivo é o principal arquivo da estrutura, ele é o responsável por realizar o controle das rotas do sistema, realiando a leitura da url e realizando a chamada da controller correta juntamente com o método desejado. Nesse arquivo temos a class core e o método run que realiza todo o trabalho.
</p>

<p style="text-align: justify;">
Para entendermos como o metodo `run` trabalha vamos entender como caracteriza-se uma rota. Basicamente podemos determinar uma rota por três partes.
</p>

    [¹ /controler [² /metodo [³ /parametro1 [ /parametro2 [/...] ] ] ] ]
    
    Parte 1: Determinar o nome da controller a ser requisitada, chamando 
    apenas a controller o metodo padrão executado será o método "index". 
    Lembrando que ao realizar a chamada da rota o nome da contrller
    especificado dever ser tudo antes de Controller.php.

    Example: pageController.php >> /page

    Parte 2: É a responsável por determinar qual método da controller deve ser executado. 
    Portanto deve determinar primeiro a controller antes de especificar o método.

    Example: Chamando o método "make" da controller "pageController.php" >> /page/make

    Parte 3: Após determinar o método da controller a ser chamado, é possível passar 
    valores para esse método utilizando as partes seguintes. Assim iniciando da terceira 
    para da url considerando a separação por / esses valores são convertidos em argumentos 
    que são recebidos pelo método chamado. 

    Example: /page/make/a/b

    class pageController extends controller {

        public function metodo($parametro1, $parametro2){

            //Resultará em um "a" na tela
            echo($parametro1);

        }

    }

<p style="text-align: justify;">
Com isso podemos entender como a aplicação trabalho com o mvc e aplicar os conceitos envolvidos.
</p>

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>