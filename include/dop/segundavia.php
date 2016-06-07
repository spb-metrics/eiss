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
//verifica se tem o emissor cadastrado
$sql_orgao = mysql_query("
	SELECT 
		codigo, 
		nome,
		razaosocial, 
		logradouro, 
		numero,
		municipio, 
		uf, 
		email 
	FROM 
		cadastro 
	WHERE 
		cnpj = '$orgao_CNPJ'
");
$dados_orgaos = mysql_fetch_array($sql_orgao);

	?>

	<form id="frmGuia" method="post" name="frmDesSegundaVia" action="include/dop/gerasegundavia_guia.php" target="_blank">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
		
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
		    <td align="center" bgcolor="#FFFFFF" rowspan="3">DOP - Segunda Via da Guia de Pagamento</td>
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
					<td colspan="2" align="left"><strong>Em caso de extravio da primeira via imprima sua segunda via.</strong></td>
				</tr>
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle"><?php echo $orgao_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle"><?php echo $dados_orgaos['razaosocial'];?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle"><?php echo $dados_orgaos['logradouro'].", ".$dados_orgaos['numero']." - ".$dados_orgaos['municipio']." - ".$dados_orgaos['uf'];?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top">

	<?php
	
	
	//lista todas as guias te tabelas diferentes unindo-as com UNION do sql: des, des_temp e des_issretido
		$sql_guias = mysql_query("
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
				dop_des ON dop_des.codigo = guias_declaracoes.codrelacionamento
			INNER JOIN
				cadastro ON cadastro.codigo = dop_des.codorgaopublico 
			WHERE
				guia_pagamento.pago = 'N' AND cadastro.cnpj = '$orgao_CNPJ' AND guias_declaracoes.relacionamento = 'dop_des'
			GROUP BY 
				codigo 
			ORDER BY 
				codigo DESC") or die(mysql_error()); 
	
		
$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td width="95" align="center" bgcolor="#CCCCCC">Código da Guia</td>
	                  <td width="105" align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td width="90" align="center" bgcolor="#CCCCCC">Valor (R$)</td>
	                  <td width="100" align="center" bgcolor="#CCCCCC">Data Venc</td>
	                  <td width="70" align="center" bgcolor="#CCCCCC">Pendente</td>
	                  <td align="center" bgcolor="#CCCCCC">Imprimir</td>
	                 </tr>
                   </table>
                 <div <?php if(mysql_num_rows($sql_guias)>13){ echo "style=\"overflow:auto; height:300px\"";}?>>
                  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
		<?php
		while(list($codigo, $dataemissao, $valor, $datavencimento, $pago) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr>
		                  <td align="center" width="95">
		                  	<input name="txtCodigoGuia<?php echo $cont;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $cont;?>" 
                            value="<?php echo $codigo; ?>" size="10" style="text-align:center" readonly />	                  
		                  </td>
		                  <td align="center" width="105">
	                      	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>" 
                            value="<?php echo DataPt($dataemissao); ?>" size="10" readonly />		              
	                      </td>
		                  <td align="center" width="90">
	                      	<input name="txtValor<?php echo $cont;?>" type="text" class="texto" id="txtValor<?php echo $cont;?>" 
                            value="<?php echo DecToMoeda($valor); ?>" size="10" readonly style="text-align:right" />                      
	                      </td>
		                  <td align="center" width="100">
		                  	<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>2" 
                            value="<?php echo DataPt($dataemissao); ?>" size="10" readonly />
		                  </td>
		                  <td align="center" width="70">
		                  	<input name="txtSituacao<?php echo $cont;?>" type="text" class="texto" id="txtSituacao<?php echo $cont;?>2" 
                            value="<?php if($pago == 'N') { echo "Sim";} else { echo "Não"; }; ?>" size="3" style="text-align:center" readonly />
		                  </td>
		                  <td align="center">
		                  	<input name="imgImprimir<?php echo $cont;?>" id="imgImprimir<?php echo $cont;?>" type="image" 
                            src="img/botoes/botao_imprimir.jpg" onClick="return SubmitSegundaViaGuia('<?php echo $cont;?>');" title="Imprimir">
		                  </td>
		                </tr>
		<?php
			// incrementa contador
			$cont++;
		}//fim while listagem dos campos pra declaracao?>
		</table>
       </div>
     <?php
	}else{
		echo("<center><b>Nenhuma guia gerada</b></center>");	
	}
	?>                  	              
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
	    
	    	</form>



