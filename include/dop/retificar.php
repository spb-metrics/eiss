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
	$orgao_CNPJ = $_SESSION['login'];
	
	$sql_orgao=mysql_query("
		SELECT codigo, 
			   nome, 
			   razaosocial, 
			   logradouro,
			   numero, 
			   municipio, 
			   uf, 
			   email,
			   estado
		FROM cadastro 
		WHERE cnpj='$orgao_CNPJ'
	");
					  
		list($cod_orgao,$nome_orgao,$razao_orgao,$logradouro_orgao,$numero,$municipio_orgao,$uf_orgao,$email_orgao,$estado_orgao,$orgao_senha)=mysql_fetch_array($sql_orgao);
		if($estado_orgao=='NL')	{
			Mensagem("Cadastro não liberado pela prefeitura!");
			Redireciona("dop.php");
		}
		if($estado_orgao=='I')	{
			Mensagem("CNPJ inválido ou Orgão inativo, entrar em contato com a prefeitura.");
			Redireciona("dop.php");
		}
		
		?>
<form id="frmGuia" method="post" name="frmDesSegundaVia" action="inc/dop/retificar_sql.php" target="_parent">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
		
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
		    <td align="center" bgcolor="#FFFFFF" rowspan="3">DOP - Retificação de declaracão de Orgãos Públicos</td>
	      <td bgcolor="#FFFFFF"></td>
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
			<td height="60" colspan="3" bgcolor="#CCCCCC">
	
			<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
		  		<tr>
					<td colspan="2" align="left"><strong>Orgão Público: cancelamento da declaração.</strong></td>
				</tr>
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle"><?php echo $orgao_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle"><?php echo $razao_orgao;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle"><?php echo "$logradouro_orgao, $numero - $municipio_orgao - $uf_orgao";?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top">

	<?php
	
	$stringSql = ("
		SELECT
		  dop_des.codigo, 
		  dop_des.data_gerado,
		  dop_des.total, 
		  DATE_FORMAT(dop_des.competencia,'%m/%Y'),
		  COUNT(*)
		FROM
		  dop_des 
		INNER JOIN
		  cadastro ON cadastro.codigo = dop_des.codorgaopublico
		INNER JOIN
		  dop_des_notas ON dop_des_notas.coddop_des = dop_des.codigo
		WHERE
		  cadastro.cnpj = '$orgao_CNPJ' AND
		  dop_des.estado = 'N'
		GROUP BY
		  dop_des.codigo
		ORDER BY
		  dop_des.codigo
	"); 
	
	$sql_guias = mysql_query($stringSql);
	// fim sql
	
  
$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC">Código da Declaração</td>
	                  <td align="center" bgcolor="#CCCCCC">Competência</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td align="center" bgcolor="#CCCCCC">Total (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">Notas</td>
	                  <td align="center" bgcolor="#CCCCCC">Cancelar</td>
	                 </tr>
		<?php
		while(list($codigo, $dataemissao, $total,$competencia,$quant) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr id="trDes<?php echo $cont;?>">
		                  <td align="center">
		                  	<input name="txtCodigoGuia<?php echo $cont;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $cont;?>" value="<?php echo $codigo; ?>" size="10" style="text-align:center" readonly="readonly" />	                  
		                  </td>
		                  <td align="center">
	                      	<input name="txtDataCompetencia<?php echo $cont;?>" type="text" class="texto" id="txtDataCompetencia<?php echo $cont;?>" value="<?php echo($competencia); ?>" size="7" readonly="readonly" style="text-align:center" />		              
	                      </td>
		                  <td align="center">
	                      	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>" value="<?php echo DataPt($dataemissao); ?>" size="10" readonly="readonly" style="text-align:center" />		              
	                      </td>
	                      <td align="center">
	                      	<input name="txtValorTotal<?php echo $cont;?>" type="text" class="texto" id="txtValorTotal<?php echo $cont;?>" value="<?php echo DecToMoeda($total); ?>" size="10" readonly="readonly" style="text-align:right" />                      
	                      </td>
	                      <td align="center">
	                      	<input name="txtQuantNotas<?php echo $cont;?>" type="text" class="texto" id="txtQuantNotas<?php echo $cont;?>" value="<?php echo $quant; ?>" size="5" readonly="readonly" style="text-align:right" />                      
	                      </td>
		                  <td align="center" id="tdCancelar<?php echo $cont;?>">
		                  	<input name="imgCancelar<?php echo $cont;?>" id="imgCancelar<?php echo $cont;?>" type="image" src="img/botoes/botao_cancelar.jpg" onClick="return dop.cancelarDeclaracao('<?php echo $cont;?>');">
		                  </td>
		                </tr>
		<?php
			// incrementa contador
			$cont++;	
		}//fim while listagem dos campos pra declaracao
		echo "</table>";
	}else{
		echo("<center><b>Nenhuma declaração foi encontrada!</b></center>");
		
	}
	?>                  	              
			  <tr>
				  <td colspan="2" align="left" valign="middle"><em>* Confira seus dados antes de continuar</em></td>
			  </tr>
			  <tr>
			  	<td><input type="button" value="Voltar" class="botao" onclick="parent.location = 'principal.php'" ></td>
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
