## Views

<p style="text-align: justify;">
O diretório views é destinado a conter todas as views do sistemas. Mesmo elas terminando com .php sua finalidade e conter apenas html e as tecnologias css e javascript. Porém por serem .php é possivel executar scripts com a linguagem dentro deste arquivos, com isso podendos montar lógicas mais complexas com o auxílo do php.
</p>

<p style="text-align: justify;">
Para carregar um view pasta utilizar o metodo <code class="markdown">loadView($view [, $data = array()])</code>, com esse metodo é possivel chamar uma view passando dados para ela pelo seu segundo parametro. Com isso podemos acessas esses utilizando a variavel <code class="markdown">$data</code> do lado da view e montar diferentes lógicas.
</p>

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>