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
	$operadora_CNPJ = $_SESSION['login'];
	
	$sql_operadora = mysql_query("
		SELECT 
			codigo, 
			nome, 
			razaosocial, 
			logradouro,
			numero, 
			municipio, 
			uf, 
			email,
			estado
		FROM 
			cadastro 
		WHERE 
			cnpj = '$operadora_CNPJ'
	");
	$dados = mysql_fetch_array($sql_operadora);
					  
		
		?>
<form id="frmGuiaRetificarOpr" method="post" name="frmGuiaRetificarOpr" target="_parent">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
		
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td height="10" bgcolor="#FFFFFF"></td>
		    <td align="center" bgcolor="#FFFFFF" rowspan="3">DOC - Retificação de declaracão de Operadoras de Cr&eacute;dito</td>
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
					<td colspan="2" align="left"><strong>Operadora de Cr&eacute;dito: <font color="#FF0000"><?php echo $dados['nome'];?></font></strong></td>
			  </tr>
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle"><?php echo $operadora_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle"><?php echo $dados['razaosocial'];?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle"><?php echo $dados['logradouro'].", ".$dados['numero']." - ".$dados['municipio']." - ".$dados['uf'];?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top">

	<?php
	
	$sql_guias = mysql_query("
		SELECT
			doc_des.codigo, 
			DATE(doc_des.data),
			DATE_FORMAT(doc_des.competencia,'%m/%Y'),
			doc_des_contas.iss
		FROM
			doc_des 
		INNER JOIN
			cadastro ON cadastro.codigo = doc_des.codopr_credito
		INNER JOIN
			doc_des_contas ON doc_des.codigo = doc_des_contas.coddoc_des
		WHERE
			cadastro.cnpj = '$operadora_CNPJ' AND doc_des.estado = 'N'
		ORDER BY 
			codigo
		DESC
	"); 
	$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
        <tr bgcolor="#CCCCCC">
          <td width="140" align="center">Código da Declaração</td>
          <td width="90" align="center">Competência</td>
          <td width="110" align="center">Data Emissão</td>
          <td width="90" align="center">ISS (R$)</td>
          <td align="center">Cancelar</td>
         </tr>
       </table>
      <div>
      	<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
		<?php
		while(list($codigo, $dataemissao, $competencia, $total) = mysql_fetch_array($sql_guias)){
		?>                
            <tr id="trDes<?php echo $cont;?>">
                <td width="140" align="center">
                    <input name="txtCodigoGuia<?php echo $cont;?>" type="text" class="texto" id="txtCodigoGuia<?php echo $cont;?>" 
                    value="<?php echo $codigo; ?>" size="10" style="text-align:center" readonly="readonly" />
            	</td>
            	<td width="90" align="center">
            		<input name="txtDataCompetencia<?php echo $cont;?>" type="text" class="texto" id="txtDataCompetencia<?php echo $cont;?>" 
                    value="<?php echo ($competencia); ?>" size="7" readonly="readonly" style="text-align:center" />		              
            	</td>
            	<td width="110" align="center">
            		<input name="txtDataEmissao<?php echo $cont;?>" type="text" class="texto" id="txtDataEmissao<?php echo $cont;?>" 
                    value="<?php echo DataPt($dataemissao); ?>" size="10" readonly="readonly" style="text-align:center" />		              
            	</td>
            	<td width="90" align="center">
            		<input name="txtValorTotal<?php echo $cont;?>" type="text" class="texto" id="txtValorTotal<?php echo $cont;?>" 
                    value="<?php echo DecToMoeda($total); ?>" size="10" readonly="readonly" style="text-align:right" />                      
            	</td>
            <td align="center" id="tdCancelar<?php echo $cont;?>">
            <input name="imgCancelar<?php echo $cont;?>" id="imgCancelar<?php echo $cont;?>" type="image" src="img/botoes/botao_cancelar.jpg" onClick="return doc.cancelarDeclaracao('<?php echo $cont;?>');">
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
		echo("<center><b>Nenhuma declaração foi encontrada!</b></center>");
		
	}
	?>                  	              
			  <tr>
				  <td colspan="2" align="left" valign="middle"><em>* Confira seus dados antes de continuar</em></td>
			  </tr>
			  <tr>
			  	<td colspan="2"><input type="button" value="Voltar" class="botao" onclick="parent.location = 'doc.php'" ></td>
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
