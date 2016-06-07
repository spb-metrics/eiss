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
	$nroautuacao = $_POST["txtNroAutuacao"];
	$anoautuacao = $_POST["txtAnoAutuacao"];
	if($_POST["btCancelar"] == "Cancelar Autuação")
		{
			$anoautuacao = $_POST["txtAnoAutuacao"];
			$nroautuacao = $_POST["txtNroAutuacao"];
			mysql_query("UPDATE processosfiscais_autuacoes 
                         SET cancelado = 'C'
                         WHERE nroautuacao = '$nroautuacao'
                         AND anoautuacao = '$anoautuacao'");
			add_logs("Cancelou uma Atuação");
			Mensagem("Autuação Cancelada");
		}
	$sql = mysql_query	("SELECT processosfiscais.nroprocesso,
                          processosfiscais.anoprocesso,
                          cadastro.razaosocial,
                          processosfiscais_autuacoes.nroautuacao,
                          processosfiscais_autuacoes.anoautuacao,
                          processosfiscais_autuacoes.titulo,
                          processosfiscais_autuacoes.historico,
                          processosfiscais_infracoes.nroinfracao,
                          processosfiscais_infracoes.anoinfracao,
                          processosfiscais_infracoes.tituloinfracao,
                          processosfiscais_infracoes.descricao,
                          processosfiscais_infracoes.fundamentacaolegal,
                          processosfiscais_autuacoes.codigo,
                          processosfiscais_autuacoes.reincidencia,
                          processosfiscais_autuacoes.quantidade,
                          processosfiscais_autuacoes.multa,
						  processosfiscais_autuacoes.cancelado
                          FROM processosfiscais
                          INNER JOIN cadastro
                          ON processosfiscais.codemissor = cadastro.codigo
                          INNER JOIN processosfiscais_autuacoes
                          ON processosfiscais.nroprocesso = processosfiscais_autuacoes.nroprocesso
                          INNER JOIN processosfiscais_infracoes
                          ON processosfiscais_autuacoes.codinfracao = processosfiscais_infracoes.codigo
                          WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao'
                          AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						  ");

//seleciona os dados da autuacao: numero do processo, ano do processo, razao social, codigo da autuacao, descricao da autuacao, nomero e ano da infracao, descricao da infracao, fundamentacao legal (legislacao municipal, como leis e multas)
	list($nroprocesso, $anoprocesso, $razaosocial, $autuacao_nro, $autuacao_ano, $autuacao_descricao, $autuacao_historico, $infracoes_nro, $infracoes_ano, $infracoes_titulo, $infracoes_descricao, $fundamentacaolegal, $codautuacao, $reincidencia, $quantidade, $multa, $cancelado) = mysql_fetch_array($sql); 	
?>

<fieldset style="margin-left:7px; margin-right:7px;">
	<table>
		<tr>
			<td>Processo Fiscal:</td>
			<td><?php echo "$nroprocesso/$anoprocesso"; ?></td>
		</tr>
		<tr>
			<td>Nome/Razão:</td>
			<td><?php echo"$razaosocial"; ?></td>
		</tr>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;">
	<table>
		<tr>
			<td>Documento:</td>
			<td><?php echo"$autuacao_descricao $autuacao_nro/$autuacao_ano"; ?></td>
		</tr>
		<tr>
			<td>Infra&ccedil;&atilde;o:</td>
			<td><?php echo"$infracoes_nro/$infracoes_ano - $infracoes_titulo"; ?></td>
		</tr>
		<tr>
			<td>Histórico da Infracão:</td>
			<td><?php echo "$autuacao_historico"; ?></td>
		</tr>
		<tr>
			<td>Descri&ccedil;&atilde;o Infracão:</td>
			<td><?php echo "$infracoes_descricao"; ?></td>
		</tr>
		<tr>
			<td valign="top">Fundamenta&ccedil;&atilde;o Legal: </td>
			<td align="justify"><?php  echo nl2br($fundamentacaolegal); ?></td>
		</tr>
		<?php if($autuacao_descricao == "Notificação"){?>
			<tr>
				<td valign="top">Compet&ecirc;ncias:</td>
				<td>
					<table>
						<tr>
							<td>
								<p style="line-height: 200%">
									<?php
										$sqlcompetencias = mysql_query("SELECT competencia FROM processosfiscais_competencias WHERE codautuacao = '$codautuacao' ORDER BY competencia");
										while(list($competencia) = mysql_fetch_array($sqlcompetencias)){
											$competencia = implode("/", array_reverse(explode("-", $competencia)));
											echo "$competencia&nbsp;&nbsp;\t";
											$string.="$competencia|";
									}
								?>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		<?php }else{?>
			<tr>
				<td>Há reicidência?</td>
				<td>
				<?php 
					if($reincidencia == "N"){
					echo "Não";
					}else{
					echo "Sim";
				?>
				</td>
			</tr>
			<tr>
				<td>Quantidade de Reincidência:</td>
				<td><?php echo $quantidade; ?></td>
			</tr>
			<tr>
				<td>Multa por Reincidencia:</td>
				<td><?php echo "$multa%"; ?> </td>
			</tr>
		<?php }//fim if de reincidencia.
		}//fim if de tipo de documento ?>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;">
	<table>
		<tr>
			<form method="post" id="frmVoltar">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao2" value="documentosautuacao_alterar" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
				<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
				<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
				<td>
					<?php
						$sql_teste=mysql_query("SELECT situacao FROM processosfiscais WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
						list($situacaoprocesso)=mysql_fetch_array($sql_teste);
						if($situacaoprocesso=="A")		
							{?>
								<input type="submit" name="btnAlterar" value="Alterar" class="botao" onclick="document.getElementById('txtAcao_frmVoltar').value='documentosautuacao_alterar';" />
							<?php }
					?>
				</td>
				<td><input name="btnVoltar" value="Voltar" type="submit" class="botao" onclick="document.getElementById('txtAcao2').value='documentosautuacao';" /></td>
			</form>
        <form method="post">
                <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao" value="docsprevia" />
				<?php if($autuacao_descricao == "Notificação"){?>
<!--				<td><input name="btCompetencias" value="Competências" type="submit" class="botao" onclick="window.location='docs_autuacao_previa.php'"/></td>-->
				<?php }//fim if para competencia de notificacao. ?>
				<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />				
				<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
				<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
			</form>	
			<form method="post" id="frmImprime" action="inc/fiscalizacao/processos/docs_autuacao_imprimir.php" target="_blank">
                <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao" value="visualizarautuacao" />
				<td><input type="submit" class="botao" name="btImprimir" value="Imprimir" /></td>
                <td><input name="btCancelar" <?php if($cancelado=='C'){echo "style=\"display:none\"";} ?> value="Cancelar Autuação" type="submit" class="botao" 
                onclick="if(Confirma('Deseja Cancelar essa Autuacao?')){cancelaAction('frmImprime','','_parent');}else return false;"/></td>
				<input type="hidden" name="txtProcesso"  value="<?php echo "$nroprocesso/$anoprocesso"; ?>" />
				<input type="hidden" name="txtRazaoSocial" value="<?php echo $razaosocial; ?>" />
				<input type="hidden" name="txtDoc" value="<?php echo"$autuacao_descricao $autuacao_nro/$autuacao_ano"; ?>" />
				<input type="hidden" name="txtInfracao" value="<?php echo"$infracoes_nro/$infracoes_ano - $infracoes_titulo"; ?>" />
				<input type="hidden" name="txtHistorico" value="<?php echo $autuacao_historico; ?>" />
				<input type="hidden" name="txtDescricao" value="<?php echo $infracoes_descricao; ?>" />
				<input type="hidden" name="txtFundamentacao" value="<?php echo $fundamentacaolegal; ?>" />
				<input type="hidden" name="txtReincidencia" value="<?php echo $reincidencia; ?>" />
				<input type="hidden" name="txtQtd" value="<?php echo $quantidade; ?>" />
				<input type="hidden" name="txtMulta" value="<?php echo "$multa%"; ?>" />
				<input type="hidden" name="txtCompetencias" value="<?php echo $string; ?>" />
				<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
				<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
			</form>
		</tr>
	</table>
</fieldset>