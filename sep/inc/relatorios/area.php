<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>
<?php 

include("../../inc/conect.php");
include("../../funcoes/util.php");
// variaveis vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF

$sql_brasao = mysql_query("SELECT brasao FROM configuracoes");
//preenche a variavel com os valores vindos do banco
list($BRASAO) = mysql_fetch_array($sql_brasao);


?>
<title>Listagem por &Aacute;rea de Atua&ccedil;&atilde;o</title>

<style type="text/css">

.tabela {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
</style>

<div id="DivImprimir">
<input type="button" onClick="print();this.style.display = 'none';" value="Imprimir" /></div>
<center>

<table width="700px" height="120" border="2" cellspacing="0" class="tabela">
  <tr>
    <td width="106"><center><img src="../../img/brasoes/<?php print $BRASAO; ?>" width="96" height="105"   />
    </center></td>
    <td width="584" height="33" colspan="2"><span class="style1">
      <center>
             <p>LISTA DE SERVI&Ccedil;OS POR CATEGORIA E SERVI&Ccedil;O</p>
             <p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
             <p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
      </center>
    
    
    </span></td>
  </tr>
  </table>
  
    <table width="700px" height="120" border="2" cellspacing="0" class="tabela">
  <?php  //comando sql que mostrar� as categorias e os servi�os 

$sql_descr = mysql_query("SELECT
						  servicos_categorias.codigo, servicos_categorias.nome, COUNT(servicos_categorias.nome),
						  servicos.descricao 
						  FROM 
						  servicos_categorias 
						INNER JOIN
						  servicos ON servicos.codcategoria = servicos_categorias.codigo
						GROUP BY
						  servicos_categorias.nome");
					
						
while(list($cod,$nome)=mysql_fetch_array($sql_descr)){
	echo"<tr><td bgcolor=\"grey\" > -> $nome</td></tr>";
							
	$sql_serv = mysql_query("SELECT
										  servicos.descricao
										 FROM
										  servicos_categorias 
										 INNER JOIN
										  servicos ON servicos.codcategoria = servicos_categorias.codigo
										  WHERE
										 servicos_categorias.codigo = '$cod'
										  
										
										  ");
										  
	
	while(list($serv)=mysql_fetch_array($sql_serv)){
		
		echo"<tr>
		
		<td align=\"center\"> - $serv</td></tr>";
	}
	echo '<table width="700px" border="2" cellspacing="0" class="tabela">';
	
}			

?>

  </table>