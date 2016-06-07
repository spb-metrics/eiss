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
	// RECEBE OS DADOS
	$dataini=strip_tags(addslashes($_POST["txtDataInicio"]));
	$nrodias=strip_tags(addslashes($_POST["txtNroDias"]));
	$datafim=strip_tags(addslashes($_POST["txtDataFim"]));
	$obs=strip_tags(addslashes($_POST["txtObs"]));
	$intimacao=$_POST["cmbIntimacao"];
	$prazo=strip_tags(addslashes($_POST["txtPrazo"]));
	$obsprazo=strip_tags(addslashes($_POST["txtObsPrazo"]));
	$codprocesso=$_POST["txtCodigo"];
	$codemissor=$_POST["txtCodEmissor"];
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$sqllegislacao = mysql_query("SELECT codigo, titulo FROM legislacao"); //listar as leis para a intimacao
	$legislacao = $_POST["cmbLegislacao"];

	
	//INSERI OS DADOS NO BANCO CASO AS INFOS TENHAM SIDO PREENCHIDAS
	if($_POST["btConfirmar"]=="Confirmar")
		{
			if(($dataini)&&($nrodias)&&($datafim)&&($intimacao))
				{			
					$sql = mysql_query("SELECT nrotif, 
                                        anotif,
                                        datainicial,
                                        datafinal
                                        FROM processosfiscais_tif
                                        WHERE nroprocesso = '$nroprocesso'
                                        AND anoprocesso = '$anoprocesso'");
					if(mysql_num_rows($sql) > 0)
						{
							Mensagem('Termo de Início já realizado!');
						}
					else
						{
						$dataini=DataMysql($dataini);
						$datafim=DataMysql($datafim);
						mysql_query("INSERT INTO processosfiscais_tif
                                     SET codlegislacao = '$legislacao',
                                     nroprocesso='$nroprocesso',
                                     anoprocesso='$anoprocesso',
                                     codemissor='$codemissor',
                                     datainicial='$dataini',
                                     datafinal='$datafim',
                                     dias='$nrodias',
                                     observacoes='$obs',
                                     intimacao='$intimacao'");
						
						$sql=mysql_query("SELECT MAX(codigo) FROM processosfiscais_tif");
						list($codtif)=mysql_fetch_array($sql);
						
						$ano = date("Y");
						$datahoje = date('Y-m-d');
						$sqlnumero = mysql_query("SELECT MAX(nrotif) FROM processosfiscais_tif WHERE anotif = '$ano'");
						list($nrotif) = mysql_fetch_array($sqlnumero);
						$nrotif++;
						
						mysql_query("UPDATE processosfiscais_tif SET nrotif='$nrotif', anotif='$ano' WHERE codigo='$codtif'");
						
						for($x=0; $x<=10; $x++)
							{
								if($_POST["chbDocumentos".$x])
									{
										mysql_query("INSERT INTO processosfiscais_tif_docs 
                                                     SET codtif='$codtif',
                                                     coddoc='".$_POST["chbDocumentos".$x]."',
													 estado='P'");
									}
							}
			
						if($intimacao=="S")
							{
								// CASO NECESSÁRIO, INSERI UMA INTIMACAO NO BANCO
								$sql_intimacao=mysql_query("SELECT  MAX(nrointimacao) 
                                                            FROM processosfiscais_intimacoes
                                                            WHERE anointimacao = '$ano'");
								list($nrointimacao)=mysql_fetch_array($sql_intimacao);
								$nrointimacao++;
								mysql_query("INSERT INTO processosfiscais_intimacoes SET 
											 prazo='$prazo',
                                             observacoes='$obsprazo',
                                             dataemissao='$datahoje',
                                             nroprocesso='$nroprocesso',
											 anoprocesso='$anoprocesso',
                                             anointimacao='$ano',
                                             nrointimacao='$nrointimacao',
                                             codlegislacao = '$legislacao'");
								
								//pega o codigo da intimação recem cadastrada para levar para a pagina de impressão da intimação
								list($codintimacao)=mysql_fetch_array(mysql_query("SELECT MAX(codigo) FROM processosfiscais_intimacoes"));
								$sql_intimacao=mysql_query("SELECT MAX(codigo) FROM processosfiscais_intimacoes");
								list($codintimacao)=mysql_fetch_array($sql_intimacao);
								for($x=1; $x<=10; $x++)
									{
										if($_POST["cmbDocs".$x])
											{
												mysql_query("INSERT INTO processosfiscais_intimacoes_docs 
                                                             SET codintimacao='$codintimacao',
                                                             coddoc='".$_POST["cmbDocs".$x]."'");
											}//fim if para inserir documentos de intimacao marcados
									}//fim for para loop de quantos documentos marcados
							}//fim if se tem intimacao para inserir no banco
						
						Mensagem("Dados inseridos com sucesso");
						?>
						<form method="post" action="inc/fiscalizacao/processos/imprimir_termo_inicio.php" target="_blank" id="formimp">
							<input type="hidden" name="txtNroTif" value="<?php echo "$nrotif"; ?>" />
							<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
							<input type="hidden" name="txtCodEmissor" value="<?php echo "$codemissor"; ?>" />
							<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
							<input type="hidden" name="txtCodigo" value="<?php echo "$codigo"; ?>" />
							<input type="hidden" name="txtRazao" value="<?php echo "$razaosocial"; ?>" />
							<input type="hidden" name="txtNroDias" value="<?php echo "$nrodias"; ?>" />
							<input type="hidden" name="txtDataFim" value="<?php echo "$datafim"; ?>" />
							<input type="hidden" name="txtObs" value="<?php echo "$obs"; ?>" />
							<input type="hidden" name="txtObsPrazo" value="<?php echo "$obsprazo"; ?>" />
							<input type="hidden" name="txtDataInicio" value="<?php echo "$dataini"; ?>" />
							<input type="hidden" name="txtPrazo" value="<?php echo "$prazo"; ?>" />
							<input type="hidden" name="txtCmbIntimacao" value="<?php echo "$intimacao"; ?>" />
							<input type="hidden" name="txtLegislacao" value="<?php echo "$legislacao"; ?>" />
						</form>
						<form method="post" action="inc/fiscalizacao/processos/intimacao_imprimir.php" target="_blank" id="formIntimacao">
							<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
							<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
							<input type="hidden" name="txtIntimacao" value="<?php echo "$codintimacao"; ?>" />
						</form>
						<?php
						echo "<script>document.getElementById('formimp').submit();</script>";
						if($_POST["cmbIntimacao"]=="S"){
							echo "<script>document.getElementById('formIntimacao').submit();</script>";
						}
					}
				}
			else{ Mensagem("Informe todos os dados"); }
		}
			
	//SELECIONA O PROCESSO AO QUAL SERÁ CRIADO O TIF
	$sql=mysql_query("SELECT processosfiscais.nroprocesso,
                      processosfiscais.anoprocesso,
                      cadastro.razaosocial,
                      cadastro.codigo
                      FROM processosfiscais
                      INNER JOIN cadastro
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($nroprocesso,$anoprocesso,$razaosocial,$codemissor)=mysql_fetch_array($sql);
?>
<form method="post" id="frmTif">	
	
	<fieldset style="margin-left:10; margin-right:10">
		<table width="44%">
			<tr>
				<td align="left">Processo Fiscal:</td>
				<td align="left"><?php echo $nroprocesso." / ".$anoprocesso; ?></td>
			</tr>
			<tr>
				<td align="left">Nome/Razão Social:</td>
				<td align="left"><?php echo $razaosocial; ?></td>
			</tr>
		</table>
	</fieldset>
	<fieldset style="margin-left:10; margin-right:10">
		<table width="100%">
			<tr>
				<td align="left" width="160">Inicio da Fiscalização:<font color="#FF0000">*</font></td>
				<td align="left"><input type="text" class="texto" name="txtDataInicio" id="txtDataInicio" maxlength="10" /> </td>
			</tr>
			<tr>
				<td align="left">Número de Dias:<font color="#FF0000">*</font></td>
				<td align="left"><input type="text" class="texto" name="txtNroDias" /> </td>
			</tr>
			<tr>
				<td align="left">Previsão para Finalização:<font color="#FF0000">*</font></td>
				<td align="left"><input type="text" class="texto" name="txtDataFim" id="txtDataFim" maxlength="10" /> </td>
			</tr>
			<tr>
				<td align="left">Observações:</td>
				<td align="left"><textarea rows="5" cols="40" name="txtObs" class="texto"></textarea></td>
			</tr>
			<tr><td align="left" colspan="2"><font color="#FF0000">*Dados Obrigatórios</font></td></tr>
		</table>
	</fieldset>
	<fieldset style="margin-left:10; margin-right:10"><legend>Intimação</legend>
		<table width="63%">
			<tr>
				<td align="left">Intimação:</td>
				<td align="left">
				<select name="cmbIntimacao">
					<option value="S">Sim</option>
					<option value="N">Não</option>
				</select>
				</td>
			</tr>
				<div id="divint" style="display:none;">
			<tr>
				<td align="left">Dias de Prazo:</td>
				<td align="left"><input type="text" class="texto" name="txtPrazo" /></td>
			</tr>	
			<tr>
				<td>Legislação:</td>
				<td>
					<select name="cmbLegislacao" class="combo">
						<option value="0">==Selecione==</option>
						<?php
						while(list($codlei, $titulolei) = mysql_fetch_array($sqllegislacao)){
						?>
						<option value="<?php echo $codlei;?>"><?php echo $titulolei;?></option>
						<?php
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td align="left">Observações:</td>
				<td align="left"><textarea rows="5" cols="40" name="txtObsPrazo" class="texto"></textarea></td>
			</tr>
			</div>	
		</table>
	</fieldset>
	<fieldset style="margin-left:10; margin-right:10"><legend>Documentos</legend>
		<table align="left" width="100%">
					<?php
						$sql_docs = mysql_query("SELECT codigo, nrodoc, descricao FROM processosfiscais_docs");
						$contdoc = 0;
						while(list($coddoc,$nrodoc,$descricao) = mysql_fetch_array($sql_docs)){
						?>
						<tr>
							<td width="5%"><input name="<?php echo "chbDocumentos".$contdoc; ?>" id="<?php echo "chbDocumentos".$contdoc; ?>" type="checkbox" value="<?php echo $coddoc; ?>" /></td>
							<td width="10%" bgcolor="#FFFFFF"><?php echo $nrodoc; ?></td>
							<td bgcolor="#FFFFFF"><?php echo $descricao; ?></td>
						</tr>
						<?php
						$contdoc++;
						}//fim while

//				for($x=1; $x<=10; $x++)
//					{		
//						echo "<tr><td>Código | Documento</td><td><select name=\"cmbDocs$x\"><option value=\"\"></option>";
//						$sql=mysql_query("SELECT codigo, nrodoc, descricao FROM processosfiscais_docs");
//						while(list($coddoc,$nrodoc,$descricao)=mysql_fetch_array($sql))
//								{
//									echo "<option value=\"$coddoc\">$nrodoc | $descricao</option>";
//								}
//						echo "</select></td></tr>";
//					}
						?>
                        <tr>
                        	<td colspan="3"><input name="btnSeltudo" value="Selecionar Tudo" type="button" class="botao" <?php echo "onclick=\"Selecionar('$contdoc')\""; ?>>&nbsp;<input name="btnLimpar" value="Limpar Campos" type="reset" class="botao"></td>
                        </tr>	
		</table>
	</fieldset>
	<fieldset style="margin-left:10; margin-right:10">
		<table align="left">
			<tr>
				<td><input type="submit" class="botao" name="btConfirmar" value="Confirmar" onclick="document.getElementById('txtAcao_tif').value='emitirtermoinicio'" /></td>
				<td><input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_tif').value='detalhes'" /></td>
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso"; ?>" />
					<input type="hidden" name="contador" value="1" />				
			</tr>
		</table>
	</fieldset>
	<table>
		<tr>
			<td>
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao_tif" />
				<input type="hidden" name="txtCodigo" value="<?php echo $codigo; ?>" />
				<input type="hidden" name="txtCodEmissor" value="<?php  echo $codemissor; ?>" />
				<input type="hidden" name="txtNroProcesso" value="<?php  echo $nroprocesso; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php  echo $anoprocesso; ?>" />
			</td>
		</tr>
	</table>
</form>
<?php //} //FIM DO IF ?>