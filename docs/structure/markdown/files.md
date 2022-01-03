### Files

#### .gitignore

<p style="text-align: justify;">
Esse arquivo é padrão em projeto que utilizem o versionamento git, ele é utilizado para ignorar determinados arquivos no versionamento do código, como neste projeto utilizamos o composer, a pasta <b>vendor</b> que sempre é criada pelo composer quando executamos <code class="markdown">composer install</code> sendo assim ela faz parte destes diretórios/arquivos ignorados.
</p>

#### .htaccess

<p style="text-align: justify;">
A utilização deste arquivo é necessário quando mudamos nosso ambiente para PRD (produção) no arquivo <b>/core/environment.php</b> passando assim aplicação entender que estamos em um servidor apache ou ngnix. Neste caso estamos dizendo a nossa a aplicação que seu sistema de rotas estará sendo baseado no módulo <b>mod_rewrite</b>. Para que a aplicação realize a utilização deste módulo é necessário o arquivo .htaccess.
</p>

#### composer.json

<p style="text-align: justify;">
O arquivo composer.json é utilizado pelo composer para verificar a dependência que o projeto utiliza e baixa-lás, esse arquivo também contém informações do projeto e pode ser utilizado para outras finalidades, para rodar scripts durante a instalação do projeto por exemplo. Para mais informações acesse <a href="https://getcomposer.org/doc/04-schema.md">aqui</a>.
</p>

#### composer.lock

<p style="text-align: justify;">
O arquivo composer.lock existe pelo motivo de registrar a versão das dependência utilizadas pela aplicação, onde essas depedências estavam estáveis. Com ele asseguramos a ultíma versão estável das dependências do nosso projeto.
</p>

#### index.php

<p style="text-align: justify;">
Esse arquivo é sempre o primeiro arquivo executado em todas requisições realizadas pelo sistema de rotas, portanto é ele a origim dos gerênciamento de rotas do sistema. Nele também é carregado os dados de conexão e as indicações de ambiente.
</p>

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>