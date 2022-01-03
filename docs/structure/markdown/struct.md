## Estrutura

<p style="text-align: justify;">
A estrutura dessas aplicação e baseada nos padrões mvc (model, view e controller) adaptada para a necessidade e baseada no php aplicando alguns conceitos bem utilizados pela comunidade. Sua estrutura e enxuta e buscad ser a simplicidade sem deixa padrões para trás. Como é de pranche essa aplicação trabalha urls amigáveis e direcionam a requicisão para uma controller que por sua vez realizar a utilização da  model para montar a view que é retornada para o lado do cliente. Esse é o fluxo das requisições realizadas por esta aplicação.
</p>

<p style="text-align: justify;">
Antes da demonstração do fluxo padrão vamos entender a estrutura de diretórios deste projeto:
</p>

```
+---+ assets
|   |--- css
|   |--- files
|   |--- fonts
|   |--- icons
|   |--- img
|   |--- js
|   +--- plugins
|
+---+ controllers
|   +--- exampleController.php
|
+---+ core
|   |--- config.php
|   |--- controller.php
|   |--- core.php
|   |--- environment.php
|   |--- info.php
|   |--- model.php
|   +--- session.php
|    
+---+ database
|   |--- modelo.sql
|   |--- modelo.mwb
|   +--- modelo.pdf
|
+--- docs
|
+---+ models
|   +--- exampleModel.php
|
+---+ vendor
|   +--- autoload.php
|
+---+ views
|   +--- example.php
|
+--- .gitignore
+--- .htaccess
+--- composer.json
+--- composer.lock
+--- index.php
+--- readme.md
```

<p style="text-align: justify;">
Resumindo a função de cada diretório :
</p>

- **assets :** Conter todos os arquivos realacionados a interface com o cliente (js, css, img, plugins).
- **controllers** : Conter todas as controllers do sistema.
- **core** : Conter todos os arquivos de configurações gerais da estrutura.
- **database** : Conter todos os arquivos relacionados ao banco de dados do sistema.
- **docs** : Conter a documentação da aplicação.
- **models** : Conter todas a models necessárias do sistema.
- **vendor** : Conter todas as dependências relacionadas ao composer, podendo ser utilizadas pelo sistema.
- **views** : Conter todas as views do sistema.
- **.gitignore** : Conter quais arquivos devem ser ignorados no versionamento do código.
- **.htaccess** : Necessário na executação da aplicação em servidores que utilizem mod_rewrite (apache e nginx)
- **composer.json** : Contém a marcação das dependência do composer utilizadas no projeto. 
- **composer.lock** : Mantém a versão das dependências do composer utilizadas no projeto.
- **index.php** : Contém a logica inicial do esquema de rotas adotado para o projeto.
- **readme.md** : Documentação de execução do projeto.

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>