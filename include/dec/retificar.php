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
	$cnpj = $_SESSION['login'];
	
	$sql_cartorios=mysql_query("
		SELECT codigo, 
			   nome, 
			   razaosocial, 
			   logradouro, 
			   municipio, 
			   uf, 
			   email,
			   estado
		FROM cadastro
		WHERE cnpj='$cnpj'
	");
					  
		list($cod_cart,$nome_cart,$razao_cart,$endereco_cart,$municipio_cart,$uf_cart,$email_cart,$estado_cart)=mysql_fetch_array($sql_cartorios);
		if($estado_cart=='NL')	{
			Mensagem("Cadastro não liberado pela prefeitura!");
			Redireciona("../../principal.php");
		}
		if($estado_cartorio=='I')	{
			Mensagem("Cartório Inativo, entre em contato com a prefeitura!");
			Redireciona("../../principal.php");
		}
		
		?>
<form id="frmGuia" method="post" name="frmDesSegundaVia" action="include/dec/retificar_sql.php" target="_parent">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Cancelamento de Declaração</td>
		<td width="65%" bgcolor="#FFFFFF"></td>
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
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
		  <td height="1"></td>
	      <td></td>
		</tr>
		<tr>
			<td colspan="3" height="1"></td>
		</tr>
		<tr>
			<td height="60" colspan="3">
	
			<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle"><?php echo $cnpj; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle"><?php echo $razao_cart;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle"><?php echo "$endereco_cart - $municipio_cart - $uf_cart";?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top">

	<?php
	
	$stringSql = ("
		SELECT
		  cartorios_des.codigo, 
		  cartorios_des.data_gerado,
		  cartorios_des.total, 
		  DATE_FORMAT(cartorios_des.competencia,'%m/%Y')
		FROM
		  cartorios_des 
		INNER JOIN
		  cadastro ON cadastro.codigo = cartorios_des.codcartorio
		WHERE
		  cadastro.cnpj = '$cnpj' AND
		  cartorios_des.estado = 'N'
	"); 
	
	$sql_guias = mysql_query($stringSql);
	// fim sql
	
  
	$cont = 0;  
  	if(mysql_num_rows($sql_guias)>0){
	$numero = mysql_num_rows($sql_guias);
	//cria a lista de campos para preenchimento da declaracao
	
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
                    <tr>
              			<td colspan="5" align="center" bgcolor="#999999">Número de Declarações Encontradas: <?php echo "$numero";?> </td>
              		</tr>  
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC">Código da Declaração</td>
	                  <td align="center" bgcolor="#CCCCCC">Competência</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td align="center" bgcolor="#CCCCCC">Total (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">Cancelar</td>
	                 </tr>
		<?php
		while(list($codigo, $dataemissao, $total,$competencia) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr id="trDes<?php echo $cont;?>" bgcolor="">
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
		                  <td align="center" id="tdCancelar<?php echo $cont;?>">
		                  	<input name="imgCancelar<?php echo $cont;?>" id="imgCancelar<?php echo $cont;?>" type="image" src="img/botoes/botao_cancelar.jpg" onClick="return dec.cancelarDeclaracao('<?php echo $cont;?>');">
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
			  	<td><input type="button" value="Voltar" class="botao" onClick="parent.location = 'principal.php'" ></td>
			  </tr>
		  </table>		
		  </td>
		</tr>
	</table>    
	</tr>
	<tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>	    

</form>
