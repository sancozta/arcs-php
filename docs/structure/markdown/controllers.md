## Controller

<p style="text-align: justify;">
Nesse diretório é possível encontrar todas as controllers do sistema, a controller principal é a <code class="markdown">pageController</code> ela é a chamanda quando a rota é a raiz <code class="markdown">/</code>, o metodo padrão excutado é o <code class="markdown">index</code>. 
</p>

<p style="text-align: justify;">
As controller basicamente classes composta por métodos que são executado baseados em suas chamadas. É importante que o nome da classe seja o mesmo do arquivo.php isso é necessário devido ao controller de rotas da aplicação. O nome da classe como também do arquivo devem conter o sufixo <code class="markdown">Controller</code> para que não ocorra erros.
</p>

<p style="text-align: justify;">
Quando o rota não é encontrada a controller padrão executada é a <code class="markdown">notfoundController</code>, seu método index expõem a view <code class="markdown">noutfound</code> utilizando o método loadView da classe controller (extendida por notfoundController).
</p>

### Nota !

><p style="text-align: justify;">Por favor manténha os arquivos sempre atualizados com a versão do sistema. Sempre documente os objetos criados e caso ocorra alteração especifique a nova função do elemento criado. Os arquivos contidos nesse diretório devem ser uma cópia fiel dos arquivos sendo utilizados pela aplicação, com o objetivo de facilitar o entendimento de novos desenvolvedores da situação atual do projeto.</p>