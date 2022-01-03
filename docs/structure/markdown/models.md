## Models

<p style="text-align: justify;">
Esse diretório retem todas as models utilizadas pela aplicação, Todas as models presentes aqui deve extender a classe <b>model</b>. Com isso a model ganha a possisibilidade de utilizar o método `executar` da classe model que executar scripts sql no banco de dados conectado.
</p>

<p style="text-align: justify;">
As models são basicamente classes que tem como cada um de seus métodos direcionados a uma determinada execução de script sql. Podendo ser eles de qualquer natureza. Os métodos de uma model deve utilizar o método <code class="markdown">executar</code> herdado da classe <b>model</b>. O retorno deste metodo caso ele seja excutado com sucesso é um array contendo os dados retornados de um <b>select</b> ou <b>false</b> em caso da execução do script tenha falhado. 
</p>

<p style="text-align: justify;">
Em muitos casos ocorre a necessidade de executar uma script onde temos que passar parametros, e não é muito seguro passa esses valores concatenados no sql, isso abre espaço para scripts maliciosos e práticas mal intecionadas como  o sql injection para isso utilizamos o bind do próprio pdo. <code class="markdown">Para utilizar o bind, basta colocar uma <b>?</b> nos lugares onde deverá haver um valores dinâmico</code>, os valores deve ser colocados no segundo parametro da função <code class="markdown">executar</code> agrupados em um array. O pdo interpreta o sql de cima para baixo da esquerda para direita, com isso o primerio ? encontrado será substituido pelo primeiro elemento do array e assim sucessivamente até o fim do script.
</p>

    Example : 
    
    $this->executar("
            select * from tb_user where id = ? and type = ?
        ",
        array(3, "S")
    );

    Perceba que a quantidade de ? é a mesma de elementos passados no array do segundo parametro.

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>