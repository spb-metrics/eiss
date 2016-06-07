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
	//Recebe as variaveis passadas por post que mantem o processo escolido
	$nroprocesso = $_POST["txtNroProcesso"];
	$anoprocesso = $_POST["txtAnoProcesso"];
	$sql=mysql_query("SELECT situacao FROM processosfiscais WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
	list($situacaoprocesso)=mysql_fetch_array($sql);
	
	if($_POST["btAlterar"]=="Alterar")
		{
			if($situacaoprocesso=="C")
				{
					Mensagem("As datas de vencimento e cientificação não podem ser alteradas pois o processo já foi concluído!");
				}
			else
				{	
					//recebe os dados enviados pela propria pagina
					$codciente=$_POST["txtCodciente"];
					$codautuacao=$_POST["txtCodautuacao"];
					$x=$_POST["txtContador"];
					$vencimento=DataMysql($_POST["txtVencimento".$x]);
					$ciente=DataMysql($_POST["txtCiente".$x]);
					
					//verifica se já existe registro de cientificacao e vencimento no banco
					$sql_teste=mysql_query("SELECT codigo FROM processosfiscais_ciente_vencimento WHERE codigo='$codciente'");
					if(mysql_num_rows($sql_teste)>0)
						{
							// atualiza os dados no banco
							mysql_query("UPDATE processosfiscais_ciente_vencimento 
                                         SET dataciente='$ciente',
                                         datavencimento='$vencimento'
                                         WHERE codigo='$codciente'");
							Mensagem("Dados alterados com sucesso!");
						}
					else
						{
							// inseri os dados no banco
							mysql_query("INSERT INTO processosfiscais_ciente_vencimento
                                          SET dataciente='$ciente',
                                          datavencimento='$vencimento',
                                          codautuacao='$codautuacao'");
							Mensagem("Dados inseridos com sucesso!");
						}	
				}		
		}
	
	// busca a razao social da empresa processada
	$sql=mysql_query("SELECT cadastro.razaosocial
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($razaosocial)=mysql_fetch_array($sql);
?>
<table align="center" width="100%">
	<tr>
		<td>
			<form method="post" id="form">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao_vencimento" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso;?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso;?>" />
				<input type="hidden" name="txtCodciente" id="txtCodciente" />
				<input type="hidden" name="txtCodautuacao" id="txtCodautuacao" />
				<input type="hidden" name="txtContador" id="txtContador" />
				<fieldset>
					<table>
						<tr>
							<td align="left">Processo Fiscal:</td>
							<td align="left"><?php echo $nroprocesso."/".$anoprocesso;?></td>
						</tr>
						<tr>
							<td align="left">Empresa:</td>
							<td align="left"><?php echo $razaosocial; ?></td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
				<?php
					
					// busca os documentos de autuacao referentes a este processo fiscal
					$sql_lista = mysql_query("SELECT codigo, nroautuacao, anoautuacao, situacao FROM processosfiscais_autuacoes WHERE anoprocesso='$anoprocesso' AND nroprocesso='$nroprocesso'");
					$result = mysql_num_rows($sql_lista);
					if($result > 0)
						{					
							?>
								<table width="100%" align="left">
									<tr bgcolor="#999999" align="center">
										<td>Documento</td>
										<td>Ciente</td>
										<td>Vencimento</td>
										<td>Situacao</td>
										<td width="1"></td>
									</tr>
									<?php
									$x=0;
									while(list($codautuacao,$nroautuacao,$anoautuacao,$situacao) = mysql_fetch_array($sql_lista))
										{
											// busca as datas ciente e vencimneto deste documento de autuacao, caso já existam
											$sql=mysql_query("SELECT codigo, dataciente, datavencimento FROM processosfiscais_ciente_vencimento WHERE codautuacao='$codautuacao'");
											list($codigo,$ciente,$vencimento)=mysql_fetch_array($sql);
											$ciente=DataPt($ciente);
											$vencimento=DataPt($vencimento);
											
											if($situacao=="N"){$situacao="Não Emitido";}
											else{$situacao="Emitido";}
											
									?>
											<tr bgcolor="#FFFFFF" align="center">
												<td><?php echo $nroautuacao."/".$anoautuacao;?></td>
												<td>
													<input type="text" class="texto" name="<?php echo "txtCiente".$x; ?>" value="<?php echo $ciente;?>" size="10" maxlength="10" onkeydown="MaskData(this)" />
												</td>
												<td>
													<input type="text" class="texto" name="<?php echo "txtVencimento".$x; ?>" value="<?php echo $vencimento;?>" size="10" maxlength="10" onkeypress="MaskData(this)" />
												</td>
												<td><?php echo $situacao; ?></td>
												<td>
													<input type="submit" class="botao" name="btAlterar" value="Alterar" onclick="document.getElementById('txtCodciente').value='<?php echo $codigo; ?>';document.getElementById('txtCodautuacao').value='<?php echo $codautuacao; ?>'; document.getElementById('txtContador').value='<?php echo $x; ?>'; document.getElementById('txtAcao_vencimento').value='datacientevencimento';" />
												</td>
											</tr>
							<?php
										$x++;
									}//fim while
						
				?>
					</table>	
				<?php	}else{ echo "Não há parcelas"; }//fim else?>
				</fieldset>
				<fieldset>
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_vencimento').value='detalhes'" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
					<input type="hidden" name="contador" value="1" /> <!-- precisa do contador se voltar para detalhes -->
				</fieldset>
			</form>
		</td>
	</tr>
</table>