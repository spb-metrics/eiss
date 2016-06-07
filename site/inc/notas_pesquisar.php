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
<fieldset style="width:500px"><legend>Pesquisar Nota</legend>
<br>
<form name="frmPesquisar" action="notas.php" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="left" width="30%">Número da Nota</td>
    <td align="left" width="70%"><input name="txtNumeroNota" type="text" size="10" class="botao" /></td>
  </tr>
  <tr>
    <td align="left">Código de Verificação</td>
    <td align="left"><input name="txtCodigoVerificacao" type="text" size="10" class="botao" /></td>
  </tr>
  <tr>
    <td align="left">Tomador - CNPJ/CPF</td>
    <td align="left"><input name="txtTomadorCPF" type="text" size="20" class="botao" /></td>
  </tr>
  <tr>
    <td align="left" colspan="2"><input name="btPesquisar" type="submit" value="Pesquisar" class="botao"></td>
  </tr>
</table>
</form>
</fieldset>
<?php
if($btPesquisar == 'Pesquisar') {


?>
<fieldset style="width:500px"><legend>Resultado da Pesquisa</legend>
<br>
<form name="frmPesquisar" action="notas.php" method="post">
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>N&ordm;</td>
    <td>Cód Verif</td>
    <td>D/H Emissão</td>
    <td>Tomador Nome</td>
	<td>Estado</td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="7" height="1" bgcolor="#999999"></td>
  </tr>
<?php

	$numero = $_POST['txtNumeroNota'];
	$codverificacao = $_POST['txtCodigoVerificacao'];
	$tomador_cnpjcpf = $_POST['txtTomadorCPF'];

	
	$sql = mysql_query("
SELECT
  `notas`.`codigo`, `notas`.`numero`, `notas`.`codverificacao`,
  `notas`.`datahoraemissao`, `notas`.`codemissor`, `notas`.`tomador_nome`,
  `notas`.`tomador_cnpjcpf`, `notas`.`estado`
FROM
  `notas`
WHERE
  `notas`.`codemissor` = '$CODIGO_DA_EMPRESA' AND
  `notas`.`numero` like '$numero%' AND
  `notas`.`codverificacao` like '$codverificacao%' AND  
  `notas`.`tomador_cnpjcpf` like '$tomador_cnpjcpf%'
  
	
	"); // fim sql
	
	while(list($codigo, $numero, $codverificacao, $datahoraemissao, $codempresa, $tomador_nome, $tomador_cnpjcpf, $estado) = mysql_fetch_array($sql)) {
	
	// mascara o codigo com cripto base64 
 	$crypto = base64_encode($codigo);
     

?>    
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $numero; ?></td>
    <td bgcolor="#FFFFFF"><?php echo $codverificacao;  ?></td>	
    <td bgcolor="#FFFFFF"><?php echo substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,2); ?></td>
    <td bgcolor="#FFFFFF"><?php echo $tomador_nome; ?></td>
    <td bgcolor="#FFFFFF"><?php if($estado == "C") { echo "<font color=red>".$estado."ANC</font>"; } else { echo $estado."ORM"; };?></td>	
    <td bgcolor="#FFFFFF" colspan="2"><a href="imprimir.php?CODIGO=<?php echo $crypto; ?>" target="_blank"><img alt="Imprimir nota" src="../../img/botoes/botao_imprimir.jpg" /></a>
	 <input type="hidden" name="txtCancelarNota" id="txtCancelarNota" value="<?php print $codigo;?>" />
	<?php
	if ($estado !== "C") {
	?>
	<a  onclick="CancelarNota(txtCancelarNota)"target="_parent"><img alt="Cancelar nota" src="../../img/botoes/botao_cancelar.jpg" /></a>
	<?php
	} // fecha if
	?>
	</td>
  </tr>
  <tr>
    <td colspan="7" height="1" bgcolor="#999999"></td>
  </tr> 
  <?php
	} // fim while  
  ?> 
</table>



<?php
} // fecha if
?>