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
	session_name("emissores_iss");
	session_start();	 	
	include("../conect.php");
	include("../../funcoes/util.php");

	$cod_tomador = $_GET['c'];
	$stringSql = ("
		SELECT
			des_issretido.codigo, 
			des_issretido.data_gerado,
			des_issretido.iss, 
			des_issretido.estado,
			DATE_FORMAT(des_issretido.competencia,'%m/%Y'),
			COUNT(*)
		FROM
			des_issretido
		INNER JOIN
			cadastro ON cadastro.codigo = des_issretido.codcadastro
		INNER JOIN
			des_issretido_notas ON des_issretido_notas.coddes_issretido = des_issretido.codigo
		WHERE
			cadastro.codigo='$cod_tomador' AND
			(des_issretido.estado = 'B' OR des_issretido.estado = 'C')
		GROUP BY 
			des_issretido.codigo
	");
	$sql_guias = mysql_query($stringSql);
	// fim sql
	
	
	$cont = 0;  
	$sql_guias=Paginacao($stringSql,'frmGuia','Container',12);
	//cria a lista de campos para preenchimento da declaracao
	if(mysql_num_rows($sql_guias)){
		?>
			  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bordercolor="#CCCCCC" bgcolor="#FFFFFF">
                <tr>
                  <td align="center" bgcolor="#CCCCCC">Competência</td>
                  <td align="center" bgcolor="#CCCCCC">Data Emissão</td>
                  <td align="center" bgcolor="#CCCCCC">Total (R$)</td>
                  <td align="center" bgcolor="#CCCCCC">Qtde Notas</td>
                  <td align="center" bgcolor="#CCCCCC">Cancelar</td>
                </tr>
				<?php	
				while(list($codigo, $dataemissao, $total,$estado,$competencia,$notas) = mysql_fetch_array($sql_guias)){
					$style = $estado=='C'? 'background-color:#FFAC84;':'';
				?>                
	 				<tr id="trDes<?php echo $cont;?>" style="<?php echo $style;?>">
						<input name="txtCodigoGuia<?php echo $cont;?>" type="hidden" id="txtCodigoGuia<?php echo $cont;?>" value="<?php echo $codigo; ?>" />
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
					  <?php if($estado=='C')echo 'Canc'; else{?>
	                  	<input name="imgCancelar<?php echo $cont;?>" id="imgCancelar<?php echo $cont;?>" type="image" src="../img/botoes/botao_cancelar.jpg" onClick="return des_issretido.cancelarDeclaracao('<?php echo $cont;?>');">
	                  <?php }?>
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
			 
		  </table>		  