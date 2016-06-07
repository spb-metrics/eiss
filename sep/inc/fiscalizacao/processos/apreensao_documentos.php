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
	// recebe os dados do processo e busca a razão social do emissor de NFe
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$sql=mysql_query("SELECT cadastro.razaosocial,processosfiscais.situacao
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($emissor,$situacao)=mysql_fetch_array($sql);
	
	// caso a apreensao seja confirmada, faz o registro em banco
	if($_POST["btConfirmar"]=="Confirmar")
		{
			$x=$_POST["txtQTD"];
			$observacoes=strip_tags(addslashes($_POST["txtObs"]));
			
			// busca o numero da ultima intimacacao e aumenta em um
			$anoapreensao=date("Y");
			$sql=mysql_query("SELECT MAX(nroapreensao) FROM processosfiscais_apreensoes WHERE anoapreensao='$anoapreensao'");
			list($nroapreensao)=mysql_fetch_array($sql);
			$nroapreensao++;
			
			// cadastra a apreensao no banco
			$data=date("Y-m-d");
			mysql_query("INSERT INTO processosfiscais_apreensoes 
                         SET nroprocesso='$nroprocesso',
                         anoprocesso='$anoprocesso',
                         nroapreensao='$nroapreensao',
                         anoapreensao='$anoapreensao',
                         dataemissao='$data',
                         observacoes='$observacoes'");
			
			// cadastra os documentos apreendidos
			$sql=mysql_query("SELECT MAX(codigo) FROM processosfiscais_apreensoes");
			list($codapreensao)=mysql_fetch_array($sql);
			for($i=0; $i<$x; $i++)
				{
					$doc=$_POST["chbDoc".$i];
					if($doc)
						{
							mysql_query("INSERT INTO processosfiscais_apreensoes_docs 
                                         SET codapreensao='$codapreensao',
                                         coddoc='$doc'");
						}
				}
			Mensagem("Apreensão de documentos realizada com sucesso!");
			?>
				<form method="post" id="frmImprimir" action="inc/fiscalizacao/processos/apreensao_imprimir.php" target="_blank">
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
					<input type="hidden" name="txtNroApreensao" value="<?php echo $nroapreensao; ?>" />
					<input type="hidden" name="txtAnoApreensao" value="<?php echo $anoapreensao; ?>" />
					<input type="hidden" name="txtEmissao" value="<?php echo $data; ?>" />
					<input type="hidden" name="txtObservacoes" value="<?php echo $observacoes; ?>" />
				</form>
				<script>document.getElementById('frmImprimir').submit();</script>
			<?php 	
		}
?>
<form method="post" id="form">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_apreensaodocs" />
<fieldset><legend>Cadastro de Apreensão de Documentos</legend>
	<table width="80%">
		<tr>
			<td width="25%">Processo Fiscal: </td>
			<td><?php echo $nroprocesso."/".$anoprocesso; ?></td>
		</tr>
		<tr>
			<td width="25%">Nome/Razão: </td>
			<td><?php echo $emissor; ?></td>
		</tr>
	</table>
</fieldset>
<fieldset>
<?php
	$sql=mysql_query("SELECT codigo, 
                      nroapreensao,
                      anoapreensao,
                      dataemissao,
                      observacoes
                      FROM processosfiscais_apreensoes
                      WHERE nroprocesso='$nroprocesso'
                      AND anoprocesso='$anoprocesso'
                      ORDER BY anoapreensao, nroapreensao");
	if(mysql_num_rows($sql)>0)
		{
			?>
				<table align="center" width="100%">
					<tr>
						<td colspan="2" align="center">Apreensões</td>
					</tr>
					<tr align="center" bgcolor="#999999">
						<td width="70">Número/Ano</td>
						<td width="100">Dt.Emissão</td>
						<td>Observações</td>
						<td width="60">&nbsp;</td>
					</tr>
					<?php
						while(list($codapreensao, $nroapreensao,$anoapreensao,$dataemissao,$observacoes)=mysql_fetch_array($sql))
							{
								$dataemitido=DataPt($dataemissao);
								?>
									<tr align="center" bgcolor="#FFFFFF">
										<td><?php echo "$nroapreensao/$anoapreensao";?></td>
										<td><?php echo $dataemitido; ?></td>
										<td><?php echo $observacoes; ?></td>
										<td>
											<input type="button" class="botao" value="Imprimir" onclick="document.getElementById('printNroApreensao').value='<?php echo $nroapreensao; ?>'; document.getElementById('printAnoApreensao').value='<?php echo $anoapreensao; ?>'; document.getElementById('printEmissao').value='<?php echo $dataemissao; ?>'; document.getElementById('printObservacoes').value='<?php echo $observacoes; ?>'; document.getElementById('frmPrint').submit();" />
										</td>
									</tr>
								<?php
							}
					?>
				</table>
			<?php 
		}
	else
		{ 
			echo "Nenhuma apreenção de documentos foi realizada neste processo até o momento!";
		}				
?>	
	<br />
	<br />
<?php
if($situacao != "C"){
?>
</fieldset>
<fieldset>
	<table align="center">
		<tr>
			<td valign="top" align="right">Observações:	</td>
			<td><textarea name="txtObs" cols="30" rows="5" class="texto"></textarea></td>
		</tr>
		<tr>
			<td colspan="2"><input value="Limpar Dados" type="reset" class="botao" id="btnLimp"></td>
		</tr>
	</table>
	<table align="center" width="100%">
		<tr>
			<td colspan="3" align="center">Documentos</td>
		</tr>
		<tr align="center" bgcolor="#999999">
			<td></td>
			<td>Código</td>
			<td>Descrição</td>
		</tr>
			<?php 
				$sql=mysql_query("SELECT codigo, nrodoc, descricao FROM processosfiscais_docs");
				$x=0;
				while(list($coddoc,$nrodoc,$descricao)=mysql_fetch_array($sql))
					{
						echo "
							<tr align=\"center\" bgcolor=\"#FFFFFF\">	
								<td><input type=\"checkbox\" name=\"chbDoc$x\" value=\"$coddoc\" /></td>
								<td>$nrodoc</td>
								<td>$descricao</td>
							</tr>	
						";	
						$x++;	
					}
			?>
	</table>
			<?php
			}//fim if se processo cancelado
			?>
	<table>
		<tr>
			<td>
			<?php
			if($situacao !="C"){
			?>
			<input name="btConfirmar" value="Confirmar" type="submit" class="botao" onclick="document.getElementById('txtAcao_apreensaodocs').value='apreensaodocumentos'" >
			<?php
			}//fim if se processo cancelado
			?>
			</td>
			<td>
				<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_apreensaodocs').value='detalhes'" />
				<input type="hidden" name="txtQTD" value="<?php echo $x; ?>" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
				<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
				<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
				<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
			</td>
		</tr>
	</table>
</fieldset>
</form>
<form id="frmPrint" method="post" action="inc/fiscalizacao/processos/apreensao_imprimir.php" target="_blank">
	<input type="hidden" name="txtNroProcesso" id="printNroProcesso" value="<?php echo $nroprocesso; ?>" />
	<input type="hidden" name="txtAnoProcesso" id="printAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	<input type="hidden" name="txtNroApreensao" id="printNroApreensao" />
	<input type="hidden" name="txtAnoApreensao" id="printAnoApreensao" />
	<input type="hidden" name="txtEmissao" id="printEmissao" />
	<input type="hidden" name="txtObservacoes" id="printObservacoes" />
</form>