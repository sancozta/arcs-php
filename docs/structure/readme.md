## Documentação Padrão

<p style="text-align: justify;">
É uma estrutura criada para a inicialização de projetos fast, buscando facilitar o desenvolvimento de pequenas soluções com a utilização do php como linguagem base. Essa estrutura trabalha com o padrão MVC bastante testado e aprovado pela comunidade de software.
</p>

### Pré-Requisitos

- Php 7 >=
- Extensão pdo_mysql
- Extensão mb_string
- Mysql 5.6 >=
- Apache 2.4 >= (Caso queira utilizar o Apache)
- Módulo mod-rewrite Habilitado (Caso queira utilizar o Apache)

### Executar Localmente

<p style="text-align: justify;">
Para executar localmente este projeto basta ter em sua linha de comando o php ou um ambiente apache disponível. Caso tenha o ambiente apache basta colocar o projeto na pasta raiz do localhost oferecido pelo apache <code class="markdown">/var/www/ ou htdocs/</code>. Caso tenha o php em sua linha de comando basta executar <code class="markdown">php -S localhost:8080</code> na raiz da pasta do projeto.
</p>

### Nota

<p style="text-align: justify;">
A aplicação aqui em questão funciona baseada no php aplicada a metodologia mvc, portanto o requisto minimo para entendimento completo do projeto e conhecimentos minimus em php e o conceito mvc. Com isso você será capaz de realizar alterações e evoluções código deste projeto.
</p>

### Composer

<p style="text-align: justify;">
Essa estrutura tem integração com o gerenciador de dependencia do php chamado composer, portanto fique avontade para utilizar as dependencias disponiveis no composer, sendo uma infinidade de possibilidades a serem exploradas. Portanto antes de roda o projeto execute <code class="markdown">composer install</code> na raiz do projeto por linha de comando para que o projeto baixe a dependencias necessárias para o seu perfeito funcionamento.
</p>

### Banco de Dados

<p style="text-align: justify;">
Foi reservado um pasta especifica para reter todos os documentos relacionados ao banco de dados, essa pasta chama-se <b>database</b>. Nesta pasta você encontrará arquivos relacionados ao banco de dados, podendo evolui-los de acordo com a nessecidade que possa aparecer. Modelo de dados, cargas iniciais, estrutura atual em sql enfim, toda a documentação necessária para o entendimento e evolução da base de dados.
</p>

### Uploads

<p style="text-align: justify;">
Esse projeto contém funcionalidades de upload de arquivos, para a retenção destes arquivos existe a pasta <b>/assets/files/</b> todos os arquivos que são acomodados pelo sistema fica salvos fisicamente nesta pasta, por favor trate-a com carinho.
</p>

### Ambiente

<p style="text-align: justify;">
Mais um ponto de atenção antes de começar é sobre o arquivo de configuração do ambiente, esse arquivo fica localizado em <b>/core/environment.php</b> esse arquivo contem sinalizações sobre o ambiente onde a aplicação esta sendo excutada (em desenvolvimento ou produção). Também temos a opção de alterar o a conexão com o banco de dados para um banco de desenvolvimento ou banco de produção. Para inserir os dados de conexão utilize o arquivo <b>/core/config.php</b>, nele é possivel alterar os dados host, user, password e port.
</p>

### Gitbook

<p style="text-align: justify;">
Essa documentação foi construida com base na ferramenta gitbook. Buscamos aqui utilizar os recursos desta ferramenta para poder expressar nossa base de conhecimento e facilitar o acesso daqueles que necessitem.
</p>

##### Instalação de Pacotes Para o Gitbook

- Para Utilizar Todo o Potêncial do Gitbook Execute os Seguintes Comandos.


      npm install gitbook-cli -g
      npm install ebook-convert
      sudo -v && wget -nv -O- https://download.calibre-ebook.com/linux-installer.py | 
      sudo python -c "import sys; main=lambda:sys.stderr.write('Download failed\n'); exec(sys.stdin.read()); main()"
      sudo apt-get install calibre

##### Build da Documentação Utilizando o Gitbook

- Dentro da Pasta **docs** Execute o Comando Abaixo para Gerar a Build.


      gitbook build ./ ./book


- Dentro da Pasta **docs** Execute o Comando Abaixo para Iniciar o Serve.


      gitbook serve ./ ./book

- Dentro da Pasta **docs** Execute o Comando Abaixo para Gerar o Arquivo Pdf do Conteúdo.


      gitbook pdf ./ ./book.pdf

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>