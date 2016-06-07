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
<fieldset style="width:800px"><legend>Resultado da Pesquisa</legend>
<?php
require_once("../conect.php");
require_once("../nocache.php");
require_once("../../funcoes/util.php");

//ve se alguma nota foi cancelada
if($_GET["txtCodigoCancela"]){ 
$codigo_nota = base64_decode($_GET["txtCodigoCancela"]);
mysql_query("UPDATE notas SET estado = 'C' WHERE codigo = '$codigo_nota'"); 
}//fim if se cancela uma nota.

$numero = $_GET['txtNumeroNota'];
$codverificacao = $_GET['txtCodigoVerificacao'];
$tomador_cnpjcpf = $_GET['txtCNPJ'];
if($numero){
	$numero= "='$numero'";
}else{
	$numero = "LIKE '%'"; }

$query=("
	SELECT
	`notas`.`codigo`, `notas`.`numero`, `notas`.`codverificacao`,
	`notas`.`datahoraemissao`, `notas`.`codemissor`, `notas`.`tomador_nome`,
	`notas`.`tomador_cnpjcpf`, `notas`.`estado`, cadastro.nome
	FROM
	`notas`
	INNER JOIN cadastro ON notas.codemissor = cadastro.codigo
	
	WHERE
	`notas`.`numero` $numero AND
	`notas`.`codverificacao` like '$codverificacao%' AND  
	`notas`.`tomador_cnpjcpf` like '$tomador_cnpjcpf%'
	ORDER BY 
	notas.datahoraemissao DESC
"); // fim sql

$sql=Paginacao($query,'frmNfe','divResultado');
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<?php 
	if(mysql_num_rows($sql)>0){ ?>
	  <tr>
		<td width="45" align="center">N&ordm;</td>
		<td width="80" align="center">Cód Verif</td>
		<td width="70" align="center">D/H Emissão</td>
		<td width="200" align="center">Nome Emissor</td>
		<td width="200" align="center">Nome Tomador</td>
		<td width="70" align="center">Estado</td>
		<td width="75">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="7" height="1" bgcolor="#999999"></td>
	  </tr>
	<?php
	while(list($codigo, $numero, $codverificacao, $datahoraemissao, $codempresa, $tomador_nome, $tomador_cnpjcpf, $estado, $emissor_nome) = mysql_fetch_array($sql)) {
	
	// mascara o codigo com cripto base64 
	$crypto = base64_encode($codigo);
	if($estado == "C"){$cor = "#FFAC84";}else{$cor = "#FFFFFF";}
	 
	
	?>    
	  <tr>
		<td bgcolor="<?php echo $cor;?>" width="45" align="right"><?php echo $numero; ?></td>
		<td width="80" align="center" bgcolor="<?php echo $cor;?>"><?php echo $codverificacao;  ?></td>	
		<td width="70" bgcolor="<?php echo $cor;?>" align="center"><?php echo substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,4)." ".substr($datahoraemissao,11,5); ?></td>
		<td width="200" align="left" bgcolor="<?php echo $cor;?>"><?php echo $emissor_nome; ?></td>
		<td width="200" align="left" bgcolor="<?php echo $cor;?>"><?php echo $tomador_nome; ?></td>
		<td width="75" align="center" bgcolor="<?php echo $cor;?>"><?php 
		switch ($estado) { 
		case "C": echo "Cancelado"; break;
		case "N": echo "Normal"; break;
		case "B": echo "Boleto Gerado"; break;
		case "E": echo "Escriturada"; break;
		} 
		
		?></td>	
		<td bgcolor="#FFFFFF" width="60"><img  style="cursor:pointer;" title="Imprimir Nota" src="img/botoes/botao_imprimir.jpg" onclick="document.getElementById('CODIGO').value='<?php echo $crypto;?>';cancelaAction('frmNfe','inc/nfe/imprimir.php','_blank')" />
		<?php
		if ($estado !== "C") {
		?>
		
		<img style="cursor:pointer;" title="Cancelar Nota" src="img/botoes/botao_cancelar.jpg" 
		onclick="CancelaNota('<?php echo $crypto;?>','Cancelar nota N° <?php echo "$numero de $emissor_nome"; ?>?');" />
		<?php
		} // fecha if
		?>
		</td>
	  </tr>
	  <?php
		} // fim while  
	}else{//fim if se tem resultados
	?>
	<tr>
		<td><strong><center>Nenhum resultado encontrado.</center></strong></td>
	</tr>
	<?php
	}//else se nao tem resultados da busca
  ?> 
</table>
<input type="hidden" name="CODIGO" id="CODIGO" />
<input type="hidden" name="txtCodigoCancela" id="txtCodigoCancela" />	
</fieldset>
