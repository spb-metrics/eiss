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
if ($_POST['txtInscMunicipal']){
	$tomador_IM = $_POST['txtInscMunicipal'];
	$sql_IM_tomador=mysql_query("
		SELECT concat(cnpj,cpf)
		FROM cadastro 
		WHERE inscrmunicipal='$tomador_IM'
	");
	if(!mysql_num_rows($sql_IM_tomador))	{
		Mensagem("Inscrição Municipal não encontrada, verifique os dados ou tente pelo CNPJ/CPF");
		Redireciona("des.php");
	}else{
		list($tomador_CNPJ)=mysql_fetch_array($sql_IM_tomador);
	}
}
if ($_POST['txtCNPJ']){
	$tomador_CNPJ = $_POST['txtCNPJ'];
}

//verifica se tem o emissor cadastrado

$sql_tomador = mysql_query("
	SELECT 
		codigo, 
		nome, 
		inscrmunicipal, 
		logradouro,
		numero,
		complemento, 
		municipio, 
		uf, 
		email 
	FROM cadastro 
	WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'
");
if (mysql_num_rows($sql_tomador)){
	$resultado = "s";
	$existe_tomador = "s";
}

if (!$resultado) {
	Mensagem("Prestador não cadastrado no sistema, favor efetuar o cadastro de sua empresa e aguardar retorno da prefeitura no seu e-mail.");
	//Redireciona("des.php");
} else {
	if ($existe_tomador){
		list($cod_emissor,$razao_emissor,$im_emissor,$logradouro_emissor,$numero_emissor,$complemento_emissor,$municipio_emissor,$uf_emissor,$email_emissor) = mysql_fetch_array($sql_tomador);
		$endereco_emissor = "$logradouro_emissor, $numero_emissor";
		if($complemento_emissor) 
			$endereco_emissor .= ", $complemento_emissor";
		$nome_emissor = $razao_emissor;
	}
	?>

	<form id="frmGuia" method="post" name="frmDesSegundaVia" action="../include/des/segundavia_guia.php" target="_blank">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
		
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
		    <td width="50%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">DES - Segunda Via da Guia de Pagamento</td>
	        <td width="45%" bgcolor="#FFFFFF"></td>
	  	</tr>
		<tr>
		  <td height="1" bgcolor="#CCCCCC"></td>
	      <td bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
		  <td height="10" bgcolor="#FFFFFF"></td>
	      <td bgcolor="#FFFFFF"></td>
		</tr>
		<tr>
			<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
		</tr>
		<tr>
			<td colspan="3" bgcolor="#CCCCCC">
	
			<table width="100%" border="0" align="center" cellpadding="3" cellspacing="2">
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $tomador_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Inscri&ccedil;&atilde;o Municipal:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $im_emissor;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razao_emissor;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$endereco_emissor - $municipio_emissor - $uf_emissor";?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top">
	<?php
	//lista todas as guias te tabelas diferentes unindo-as com UNION do sql: des, des_temp e des_issretido
	if ($existe_tomador) {
		$string_Sql = ("
			SELECT
			  guia_pagamento.codigo, 
			  guia_pagamento.dataemissao,
			  guia_pagamento.valor, 
			  guia_pagamento.datavencimento,
			  guia_pagamento.pago
			FROM
			  guia_pagamento
			INNER JOIN
			  guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo  
			INNER JOIN
			  des_issretido ON des_issretido.codigo = guias_declaracoes.codrelacionamento 
			INNER JOIN
			  cadastro ON cadastro.codigo = des_issretido.codcadastro
			WHERE
			  guia_pagamento.pago = 'N'  AND
			  cadastro.codigo = '$cod_emissor' AND
			  guias_declaracoes.relacionamento = 'des_issretido' AND
			  des_issretido.estado = 'B'
	");
	$sql_guias = mysql_query($string_Sql);
	
	}
	$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC">Código da Guia</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td align="center" bgcolor="#CCCCCC">Valor (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Venc</td>
	                  <td align="center" bgcolor="#CCCCCC">Pendente</td>
	                  <td align="center" bgcolor="#CCCCCC">Imprimir</td>
	                 </tr>
		<?php
		while(list($codigo, $dataemissao, $valor, $datavencimento, $pago) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr>
		                  <td align="center">
		                  	<input name="txtCodigoGuia<?php echo $cont;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $cont;?>" value="<?php echo $codigo; ?>" size="10" style="text-align:center" readonly />	                  
		                  </td>
		                  <td align="center">
	                      	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>" value="<?php echo DataPt($dataemissao); ?>" size="10" readonly />		              
	                      </td>
		                  <td align="center">
	                      	<input name="txtValor<?php echo $cont;?>" type="text" class="texto" id="txtValor<?php echo $cont;?>" value="<?php echo DecToMoeda($valor); ?>" size="15" readonly style="text-align:right" />                      
	                      </td>
		                  <td align="center">
		                  	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>2" value="<?php echo DataPt($dataemissao); ?>" size="10" readonly />
		                  </td>
		                  <td align="center">
		                  	<input name="txtSituacao<?php echo $cont;?>" type="text" class="texto" id="txtSituacao<?php echo $cont;?>2" value="<?php if($pago == 'N') { echo "S";} else { echo "N"; }; ?>" size="3" style="text-align:center" readonly />
		                  </td>
		                  <td align="center">
		                  	<input name="imgImprimir<?php echo $cont;?>" id="imgImprimir<?php echo $cont;?>" type="image" src="../img/botoes/botao_imprimir.jpg" onClick="return SubmitSegundaViaGuia('<?php echo $cont;?>');">
		                  </td>
		                </tr>
		<?php
			// incrementa contador
			$cont++;
		}//fim while listagem dos campos pra declaracao
		echo "</table>";
	}else{
		echo("<center><b>Nenhuma guia gerada</b></center>");
		
	}
	?>                  	              
	              </td>
			  </tr>
			  <tr>
				  <td colspan="2" align="left" valign="middle"><em>* Confira seus dados antes de continuar<br>
	              ** Desabilite seu bloqueador de pop-up</em></td>
			  </tr>
		  </table>		
		  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>    
	</td>
	</tr>
	</table>	    
</form>
<?php
}

?>