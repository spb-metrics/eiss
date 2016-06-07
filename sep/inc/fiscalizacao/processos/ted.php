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
$nroprocesso = $_POST["txtNroProcesso"];
$anoprocesso = $_POST["txtAnoProcesso"];
$sql = mysql_query("SELECT cadastro.razaosocial,processosfiscais.situacao
                    FROM cadastro
                    INNER JOIN processosfiscais
                    ON processosfiscais.codemissor = cadastro.codigo
                    WHERE processosfiscais.nroprocesso = '$nroprocesso'
                    AND processosfiscais.anoprocesso = '$anoprocesso'");
list($razaosocial,$situacao) = mysql_fetch_array($sql);

if($_POST["btReenviar"] == "Reeviar Docs."){
		//recebe a quantidade maxima de documentos
		$contdoc = $_POST["txtContdoc"];
		//testando quais documentos selecionados e registrando eles no banco
		for($x = 0; $x <= $contdoc; $x++){
			if($_POST["chDocumentos".$x]){
				$coddoc = $_POST["chDocumentos".$x];
				$codted = $_POST["hdDocs".$x];
				mysql_query("UPDATE processosfiscais_ted_docs SET estado='P' WHERE codted = '$codted' AND coddoc = '$coddoc'");
			}//fim if
		}//fim for
		Mensagem("Documento(s) pronto(s) para ser(em) reenviado(s)!");
}

if($_POST["btnConfirmar"] == "Confirmar")
	{
		//buscando as observacoes, o ano do ted e a data de emissao
		$observacoes_ted = $_POST["txtObs"];
		$ano_ted = date("Y");
		$data_ted = date("Y-m-d");
		
		//recebe a quantidade maxima de documentos
		$contdoc = $_POST["txtContdoc"];
		
		$sql = mysql_query("SELECT codigo FROM processosfiscais_ted WHERE anoprocesso='$anoprocesso' AND nroprocesso='$nroprocesso'");
		while(list($codted) = mysql_fetch_array($sql)){
		for($x = 0; $x <= $contdoc; $x++){
			$codted = $_POST["hdDocumentos".$x];
			$coddoc = $_POST["chbDocumentos".$x];
			mysql_query("UPDATE processosfiscais_ted_docs SET estado='T' WHERE codted = '$codted' AND coddoc = '$coddoc'");
		}//fim for
		$sql_ted = mysql_query("SELECT anoprocesso, nroprocesso FROM processosfiscais_ted WHERE anoprocesso='$anoprocesso' AND nroprocesso = '$nroprocesso'");
		list($anoted, $nroted)=mysql_fetch_array($sql_ted);
		}
		Mensagem("Documentos enviados");
		?>
			<form method="post" target="_blank" id="frmimprimir" action="inc/fiscalizacao/processos/termo_entrega_imprimir.php">
				<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
				<input type="hidden" name="txtNroTed" value="<?php echo $nroted; ?>" />
				<input type="hidden" name="txtAnoTed" value="<?php echo $anoted; ?>" />
			</form>
			<script>document.getElementById('frmimprimir').submit();</script>
		<?php
	}//fim if do submit
?>
<form method="post" id="form">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
    <input type="hidden" name="txtAcao" id="txtAcao_ted" />
	<table width="100%">
		<tr>
			<td>
				<fieldset style="margin-left:4px; margin-right:4px;">
					<table>
						<tr>
							<td align="left">Processo Fiscal:</td>
							<td align="left"><?php echo "[ $nroprocesso/$anoprocesso ] $razaosocial"; ?></td>
						</tr>
					</table>
				</fieldset>
				<fieldset style="margin-left:4px; margin-right:4px;">
					<table width="100%">
						<tr>
							<td>
								<table>
									<?php 
										//mostra outros ted do mesmo processo
										$sql_resultados = mysql_query("SELECT nroted, anoted, dataemissao, observacoes FROM processosfiscais_ted WHERE nroprocesso = '$nroprocesso' AND anoprocesso = '$anoprocesso' ORDER BY anoted, nroted");
										if(mysql_num_rows($sql) > 0){
									?>
										<tr bgcolor="#999999">
											<td align="center" width="100">N°/Ano</td>
											<td align="center" width="110">Data de Emiss&atilde;o:</td>
											<td align="center" width="400">Observações</td>
											<td align="center" width="50">Ações</td>
										</tr>
										<?php
											while(list($nroted, $anoted, $dataemissao, $observacoes) = mysql_fetch_array($sql_resultados)){
											$dataemissao = DataPt($dataemissao);
										?>
										<tr bgcolor="#FFFFFF">
											<td align="center"><?php echo $nroted."/".$anoted; ?></td>
											<td align="center"><?php echo $dataemissao; ?></td>
											<td align="center"><?php echo $observacoes; ?></td>
											<td align="center">
												<input type="button" class="botao" value="Imprimir" onclick="document.getElementById('nroprocesso').value='<?php echo $nroprocesso; ?>'; document.getElementById('anoprocesso').value='<?php echo $anoprocesso; ?>'; document.getElementById('nroted').value='<?php echo $nroted; ?>'; document.getElementById('anoted').value='<?php echo $anoted; ?>'; document.getElementById('frmPrint').submit();" />
											</td>
										</tr>
											<?php 
											}//fim while
										}//fim if
										else{ 
											echo "<tr><td>Nenhum Termo de Entrega de Documentos cadastrado para esse processo.</td></tr>";
										}//fim else
										?>
								</table>	
							</td>
						</tr>
                    </table>
					<?php
					if($situacao!="C"){
                	$sql = mysql_query("
					SELECT processosfiscais_ted.anoted, processosfiscais_ted.nroted, processosfiscais_docs.codigo, processosfiscais_docs.nrodoc, processosfiscais_docs.descricao, processosfiscais_ted_docs.codted 
					FROM processosfiscais_docs
					INNER JOIN processosfiscais_ted_docs 
					ON processosfiscais_docs.codigo = processosfiscais_ted_docs.coddoc
					INNER JOIN processosfiscais_ted
					ON processosfiscais_ted.codigo = processosfiscais_ted_docs.codted
					WHERE processosfiscais_ted.anoprocesso='$anoprocesso' AND processosfiscais_ted.nroprocesso='$nroprocesso' AND processosfiscais_ted_docs.estado='P' ORDER BY nroted, anoted");
					if(mysql_num_rows($sql)>0){
					?>
				</fieldset>
				<fieldset style="margin-left:4px; margin-right:4px;"><legend>Documentos Recebidos</legend>
					<table width="100%">
						<tr bgcolor="#999999">
							<td width="5%">&nbsp;</td>
                            <td width="10%" align="center">C&oacute;digo:</td>
							<td width="20%">N°/Ano</td>
							<td align="center">Descri&ccedil;&atilde;o:</td>
						</tr>
					</table>
					<table width="100%">
					<?php
						$contdoc = 0;
						while(list($anoted, $nroted, $coddoc, $nrodoc, $descricaodoc, $codted) = mysql_fetch_array($sql)){
						?>
						<tr bgcolor="#FFFFFF">
							<td width="5%"><input name="<?php echo "chbDocumentos".$contdoc; ?>" id="<?php echo "chbDocumentos".$contdoc; ?>" type="checkbox" value="<?php echo $coddoc; ?>" /><input type="hidden" name="<?php echo "hdDocumentos".$contdoc; ?>" id="<?php echo "hdDocumentos".$contdoc; ?>" value="<?php echo $codted; ?>"/></td>
							<td width="10%"><?php echo $nrodoc; ?></td>
                            <td width="20%"><?php echo $nroted."/".$anoted; ?></td>
							<td><?php echo $descricaodoc; ?></td>
						</tr>
						<?php
						$contdoc++;
						}//fim while
						?>
                        <tr>
                        	<td align="center" colspan="5" height="50"><input name="btnSeltudo" value="Selecionar Tudo" type="button" class="botao" <?php echo "onclick=\"Selecionar('$contdoc')\""; ?>>&nbsp;<input name="btnLimpar" value="Limpar Campos" type="reset" class="botao">&nbsp;<input name="btnConfirmar" value="Confirmar" type="submit" class="botao" onclick="document.getElementById('txtAcao_ted').value='termoentregadocumentos'"></td>
                        </tr>
					</table>
					<table width="100%">
                        <tr>
                            <td valign="top">Observa&ccedil;&otilde;es:</td>
                            <td><textarea name="txtObs" rows="5" cols="75" class="texto"></textarea></td>
                        </tr>
                    </table> 
					<?php
					}//fim if se cancelado
					?>
				</fieldset>
				<fieldset style="margin-left:4px; margin-right:4px;"><legend>Documentos Devolvidos</legend>
                <?php 
					$sql_enviados = mysql_query("
					SELECT processosfiscais_ted.anoted, processosfiscais_ted.nroted, processosfiscais_docs.codigo, processosfiscais_docs.nrodoc, processosfiscais_docs.descricao, processosfiscais_ted_docs.codted
					FROM processosfiscais_docs
					INNER JOIN processosfiscais_ted_docs 
					ON processosfiscais_docs.codigo = processosfiscais_ted_docs.coddoc
					INNER JOIN processosfiscais_ted
					ON processosfiscais_ted.codigo = processosfiscais_ted_docs.codted
					WHERE processosfiscais_ted.anoprocesso='$anoprocesso' AND processosfiscais_ted.nroprocesso='$nroprocesso' AND processosfiscais_ted_docs.estado='E' ORDER BY anoted, nroted");
				
                if(mysql_num_rows($sql_enviados)>0){
				?>
                	<table width="100%">
						<tr bgcolor="#999999">
                        	<td width="5%"></td>
							<td width="15%">Código</td>
                            <td width="13%">N°/Ano</td>
							<td width="52%" align="center">Descri&ccedil;&atilde;o:</td>
						</tr>
					</table>
					<table width="100%">
					<?php
						$contdoc = 0;
						while(list($anoted, $nroted, $coddoc, $nrodoc, $descricaodoc, $codted) = mysql_fetch_array($sql_enviados)){
						?>
						<tr bgcolor="#FFFFFF">
                        	<td width="5%"><input name="<?php echo "chDocumentos".$contdoc; ?>" id="<?php echo "chDocumentos".$contdoc; ?>" type="checkbox" value="<?php echo $coddoc; ?>" /></td>
							<td width="15%"><?php echo $nrodoc; ?><input type="hidden" name="<?php echo "hdDocs".$contdoc; ?>" id="<?php echo "hdDocs".$contdoc; ?>" value="<?php echo $codted; ?>"/></td>
                            <td width="13%"><?php echo $nroted."/".$anoted; ?></td>
							<td width="52%"><?php echo $descricaodoc; ?></td>
						</tr>
						<?php
						$contdoc++;
						}//fim while
						?>
                        <tr height="30" align="center">
                        	<td colspan="4"><input type="submit" name="btReenviar" id="btReenviar" class="botao" value="Reeviar Docs." onclick="document.getElementById('txtAcao_ted').value='termoentregadocumentos'" /></td>
                        </tr>
                	</table>
                <?php
				}else{
				echo "Nenhum documento devolvido!";
				}
				?>
                </fieldset>
				<?php }?>
				<fieldset style="margin-left:4px; margin-right:4px;">
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtContdoc" value="<?php echo $contdoc; ?>" />
					<?php
					if($situacao!="C"){
					?>
					<input name="btnConfirmar" value="Confirmar" type="submit" class="botao" onclick="document.getElementById('txtAcao_ted').value='termoentregadocumentos'">
					<?php
					}//fim if se cancelado
					?>
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_ted').value='detalhes'" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
					<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
				</fieldset>
			</td>
		</tr>
	</table>
</form>
<form id="frmPrint" method="post" target="_blank" action="inc/fiscalizacao/processos/ted_imprimir.php">
	<input type="hidden" name="txtNroProcesso" id="nroprocesso" />
	<input type="hidden" name="txtAnoProcesso" id="anoprocesso" />
	<input type="hidden" name="txtNroTed" id="nroted" />
	<input type="hidden" name="txtAnoTed" id="anoted" />
</form>