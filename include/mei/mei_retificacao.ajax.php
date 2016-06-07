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
<script src="../../scripts/padrao.js"></script>
<?php
	
	session_name("emissores_iss");
	session_start();
    $emissor_CNPJ = $_SESSION['login'];
    include("../conect.php");
	include("../../funcoes/util.php");
    
	$stringSql = ("
		SELECT
			mei_des.codigo, 
			mei_des.data_gerado,
			mei_des.total,
			mei_des.estado, 
			DATE_FORMAT(mei_des.competencia,'%m/%Y'),
			COUNT(*)
		FROM
			mei_des 
		INNER JOIN
			cadastro ON cadastro.codigo = mei_des.codemissor
		INNER JOIN
			mei_des_servicos ON mei_des_servicos.codmei_des = mei_des.codigo
		WHERE
			(cadastro.cnpj = '$emissor_CNPJ' OR cadastro.cpf = '$emissor_CNPJ') 			
		GROUP BY 
			mei_des.codigo
		ORDER BY
			mei_des.codigo
		DESC
	");
	$sql_guias=Paginacao($stringSql,'frmGuia','Container',12);
	// fim sql
	
  
	$cont = 0;  
  	
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
	                <tr>
	                  <td align="center" bgcolor="#CCCCCC">Código da declaração</td>
	                  <td align="center" bgcolor="#CCCCCC">Competência</td>
	                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
	                  <td align="center" bgcolor="#CCCCCC">Total (R$)</td>
	                  <td align="center" bgcolor="#CCCCCC">Notas</td>
	                  <td align="center" bgcolor="#CCCCCC">Cancelar</td>
	                 </tr>
		<?php
		while(list($codigo, $dataemissao, $total,$estado,$competencia, $notas) = mysql_fetch_array($sql_guias)){
		?>                
		                <tr id="trDes<?php echo $cont;?>"<?php if($estado =='C'){ echo"style=\"background-color:#FFAC84\"";}?> >
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
	                      	<input name="txtNotas<?php echo $cont;?>" type="text" class="texto" id="txtNotas<?php echo $cont;?>" value="<?php echo $notas; ?>" size="6" readonly="readonly" style="text-align:right" />                      
	                      </td>
		                  <td align="center" id="tdCancelar<?php echo $cont;?>">
		                  	<?php if($estado =='N'){?>
		                  		<input name="imgCancelar<?php echo $cont;?>" id="imgCancelar<?php echo $cont;?>" type="image" src="img/botoes/botao_cancelar.jpg" onClick="return mei.cancelarDeclaracao('<?php echo $cont;?>');">
		                  	<?php }else{echo "Canc";}?>
		                  	
		                  </td>
		                </tr>
		<?php
			// incrementa contador
			$cont++;
		}//fim while listagem dos campos pra declaracao
	}else{
		echo("<tr><td colspan=6 align=center><b>Nenhuma declaração foi encontrada!</b></td></tr>");
		
	}
	?>                  	              
	<tr>
		<td colspan="2" align="left" valign="middle"><em>* Confira seus dados antes de continuar</em></td>
	</tr>	
</table>	