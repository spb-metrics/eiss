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
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$sql=mysql_query("SELECT processosfiscais.data_final,
					  processosfiscais.situacao, 
                      cadastro.razaosocial
                      FROM processosfiscais
                      INNER JOIN cadastro
                      ON processosfiscais.codemissor=cadastro.codigo
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($datafim,$situacao,$emissor)=mysql_fetch_array($sql);
	$datafim=DataPt($datafim);
	if($_POST["btnConfirmar"]=="Confirmar")
		{
			$prorrogacao=strip_tags(addslashes($_POST["txtDiasProrrogacao"]));
			$observacoes=strip_tags(addslashes($_POST["txtObs"]));
			$dataemissao=date("Y-m-d");
			$datafinal=explode("/",$datafim);
			$Y=$datafinal[2]; $m=$datafinal[1]; $d=$datafinal[0];
			$dataprorrogada=date("Y-m-d",mktime(0,0,0,$m,$d+$prorrogacao,$Y));
			
			// define o numero do termo de prorrogacao
			$ano=date("Y");
			$sql=mysql_query("SELECT MAX(nroprorrogacao) FROM processosfiscais_prorrogacao WHERE anoprorrogacao='$ano'");
			list($nroprorrogacao)=mysql_fetch_array($sql);
			$nroprorrogacao++;
			
			// inseri os dados no banco
			mysql_query("INSERT INTO processosfiscais_prorrogacao SET nroprocesso='$nroprocesso', anoprocesso='$anoprocesso', nroprorrogacao='$nroprorrogacao', anoprorrogacao='$ano', dataemissao='$dataemissao', diasprorrogacao='$prorrogacao', observacoes='$observacoes'"); 
			add_logs('Inseriu uma Prorrogação de Um Processo Fiscal');
			
			// atualiza o prazo do processo
			mysql_query("UPDATE processosfiscais SET data_final='$dataprorrogada' WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
			add_logs('Atualizou uma Prorrogação de Um Processo Fiscal');
			Mensagem("Inserido termo de prorrogação");
			?>	
				<form method="post" action="inc/fiscalizacao/processos/prorrogacao_imprimir.php" target="_blank" id="frmImprimir">
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
					<input type="hidden" name="txtDiasProrrogacao" value="<?php echo $prorrogacao; ?>" />
					<input type="hidden" name="txtObservacoes" value="<?php echo $observacoes; ?>"  />
				</form>
				<script>document.getElementById('frmImprimir').submit();</script>
			<?php
		}	
?>
<form method="post" id="form">	
	<table width="100%">
		<tr>
			<td>
				<fieldset>
					<table>
						<tr>
							<td align="left">Processo Fiscal:</td>
							<td align="left"><?php echo $nroprocesso."/".$anoprocesso." - ".$emissor; ?></td>
						</tr>
						<tr>
						  <td align="left">Data Pr&eacute;via de T&eacute;rmino:</td>
						  <td align="left"><?php echo $datafim; ?></td>
					  </tr>
					</table>
				</fieldset>
				<?php					
					$sql=mysql_query("SELECT nroprorrogacao, anoprorrogacao, dataemissao, diasprorrogacao, dataprorrogada, observacoes FROM processosfiscais_prorrogacao WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
					if(mysql_num_rows($sql)>0){
				?>
				<fieldset><legend>Termos de prorrogação deste processo</legend>
					<table width="100%">
						<tr bgcolor="#999999">
							<td>Termo de prorrogação:</td>
							<td>Data de emissão:</td>
							<td>Dias de prorrogação:</td>
							<td>Observações:</td>
							<td width="1"></td>
						</tr>
						<?php
							while(list($nroprorrogacao,$anoprorrogacao,$dataemissao,$diasprorrogacao,$datafinal,$observacoes)=mysql_fetch_array($sql))
								{
									$datafinal=DataPt($datafinal);
									$dataemissao=DataPt($dataemissao);
									echo "
										<tr bgcolor=\"#FFFFFF\">
											<td align=\"center\">$nroprorrogacao/$anoprorrogacao</td>
											<td align=\"center\">$dataemissao</td>
											<td align=\"center\">$diasprorrogacao</td>
											<td align=\"justify\">$observacoes</td>
											<td>
												<input type=\"button\" class=\"botao\" value=\"Imprimir\" onclick=\"document.getElementById('printDiasProrrogacao').value='$diasprorrogacao'; document.getElementById('printDataProrrogada').value='$datafinal'; document.getElementById('printObservacoes').value='$observacoes'; document.getElementById('frmPrint').submit();\" />											
											</td>
										</tr>
									";
								}
						?>
					</table>
				</fieldset> <?php }//fim if se tem prorrogacao
				if($situacao!="C"){
				?>
				<fieldset>
					<table>
						<tr>
							<td>Dias de Prorroga&ccedil;&atilde;o:</td>
							<td><input name="txtDiasProrrogacao" type="text" class="texto" /></td>
						</tr>
						<tr>
							<td valign="top">Observa&ccedil;&atilde;o:</td>
							<td><textarea name="txtObs" rows="5" cols="40" class="texto"></textarea></td>
						</tr>
					</table>
					<table align="center">
						<tr>
							<td><input name="btnLimpar" value="Limpar Campos" type="reset" class="botao"></td>
						</tr>
					</table>
				</fieldset>
				<?php
				}//fim if se cancelado
				?>
				<fieldset>
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
					<?php
					if($situacao != "C"){
					?>
					<input name="btnConfirmar" value="Confirmar" type="submit" class="botao" onclick="document.getElementById('txtAcao_prorrogacao').value='termoprorrogacao'">
					<?php
					}//fim if se cancelado
					?>
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_prorrogacao').value='detalhes'" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
					<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
					<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
					<input type="hidden" name="txtAcao" id="txtAcao_prorrogacao" />
				</fieldset>
			</td>
		</tr>
	</table>
</form>	
<form method="post" action="inc/fiscalizacao/processos/prorrogacao_imprimir.php" target="_blank" id="frmPrint">
	<input type="hidden" name="txtNroProcesso" id="printNroProcesso" value="<?php echo $nroprocesso; ?>" />
	<input type="hidden" name="txtAnoProcesso" id="printAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	<input type="hidden" name="txtDiasProrrogacao" id="printDiasProrrogacao" />
	<input type="hidden" name="txtDataProrrogada" id="printDataProrrogada" />
	<input type="hidden" name="txtObservacoes" id="printObservacoes" />
</form>