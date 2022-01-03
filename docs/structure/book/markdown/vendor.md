## Vendor

<p style="text-align: justify;">
Esse diretório abriga as dependências instaladas pelo composer. Ele não é versionado e só estará disponível após a execução da linha de comando abaixo.
</p>

    composer install

<p style="text-align: justify;">
Dentro desse arquivo contém o arquivo autoload.php que é carregado para realizar a integração das dependências com a aplicação. Esse carregamento ocorre dentro do arquivo index.php na raiz do projeto. Com isso conseguimos uma instância de qualquer classe da depedências instaladas.
</p>

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>