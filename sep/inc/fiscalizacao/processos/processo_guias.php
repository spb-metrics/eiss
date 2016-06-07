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
//Recebe as variaveis passadas por post que matem a empresa escolida
$nroprocesso = $_POST["txtNroProcesso"];
$anoprocesso = $_POST["txtAnoProcesso"];

//sql para obter o contribuinte desta autuacao
$sql_contribuinte = mysql_query("SELECT cadastro.razaosocial
                                 FROM cadastro
                                 INNER JOIN processosfiscais
                                 ON cadastro.codigo = processosfiscais.codemissor
                                 WHERE nroprocesso = '$nroprocesso'
                                 AND anoprocesso = '$anoprocesso'");
list($contribuinte) = mysql_fetch_array($sql_contribuinte);
?>
<table align="center" width="100%">
	<tr>
		<td>
			<form method="post" id="frmGuias">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao_parcelas" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />		
				<input type="hidden" name="contador" value="1" />
				<fieldset style="margin-left:4px; margin-right:4px">
					<table width="100%">
						<tr>
							<td align="left">Processofiscal: <?php echo "[ ".$nroprocesso."/".$anoprocesso." ] ".$contribuinte;?></td>
						</tr>
					</table>
				</fieldset>
				<?php
					$sql = mysql_query("SELECT codigo, nroautuacao, 
                                        anoprocesso,
                                        titulo,
                                        obrigacao,
                                        valor,
                                        nroparcelas,
										quantidade,
										multa
                                        FROM processosfiscais_autuacoes
                                        WHERE nroprocesso = '$nroprocesso' 
                                        AND anoprocesso = '$anoprocesso'");
					if(mysql_num_rows($sql)>0){
				?>
				<fieldset style="margin-left:4px; margin-right:4px">
					<table width="100%">
						<tr>
							<td align="center">Numero</td>
							<td align="center">Ano</td>
							<td align="center">Descrição</td>
							<td align="center">Tipo Obrigação</td>
							<td align="center">Nº Parc.</td>
							<td align="center">Valor</td>
                            <td align="center">Valor c/ Reincidência</td>
							<td align="center">Ações</td>
						</tr>
						<?php
							while(list($codigo,$nroatuacao,$anoprocesso,$titulo,$obrigacao,$valor,$nroparcelas,$qtdautuacao,$multaautuacao) = mysql_fetch_array($sql)){
								$valorreincidencia	 = $valor + $qtdautuacao*($valor*$multaautuacao);
								switch($obrigacao){
									case "P":
										$obrigacao = "Prestado";
									 break;
									case "T":
										$obrigacao = "Tomado";
									 break;
								}
						?>
						<tr>
							<td bgcolor="#FFFFFF" align="center"><?php echo $nroatuacao;?></td>
							<td bgcolor="#FFFFFF" align="center"><?php echo $anoprocesso;?></td>
							<td bgcolor="#FFFFFF" align="left"><?php echo $titulo;?></td>
							<td bgcolor="#FFFFFF" align="center"><?php echo $obrigacao;?></td>
							<td bgcolor="#FFFFFF" align="center"><?php echo $nroparcelas;?></td>
							<td bgcolor="#FFFFFF" align="center"><?php echo DecToMoeda($valor);?></td>
                            <td bgcolor="#FFFFFF" align="center"><?php echo DecToMoeda($valorreincidencia);?></td>
                            <td bgcolor="#FFFFFF" align="center"><input name="btEditar" type="submit" value="Editar" class="botao" onclick="document.getElementById('hdParcela').value='<?php echo $codigo?>';document.getElementById('hdValorTotal').value='<?php echo $valor?>'; document.getElementById('txtAcao_parcelas').value='parcelas'" />
							</td>
						</tr>
						<?php
								$x++;
							}//fim while?>
						<input name="hdValorTotal" type="hidden" id="hdValorTotal" />
						<input name="hdParcela" type="hidden" id="hdParcela" />
						<tr>
							<td>
							<input name="btVoltar" id="btVoltar" type="submit" class="botao" value="Voltar" 
										onclick="document.getElementById('txtAcao_parcelas').value='detalhes'" />
							<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
							<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
							<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
							</td>
						</tr>
					</table>
				</fieldset>
				</form>	
					<?php
						}else{
							//mensagem caso nao haja resultado
							echo 
								"<form method=\"post\">
									<input type=\"hidden\" name=\"txtNroProcesso0\" value=\"$nroprocesso\" />
									<input type=\"hidden\" name=\"txtAnoProcesso0\" value=\"$anoprocesso\" />				
									<input type=\"hidden\" name=\"contador\" value=\"1\"/>				
									<fieldset style=\"margin-left:4px; margin-right:4px\">
									<table width=\"100%\">
										<tr>
											<td align=\"center\">Nenhuma guia para esse processo fiscal!</td>
										</tr>
										<tr>
											<td align=\"left\">
												<input name=\"btVoltar\" value=\"Voltar\" type=\"submit\" class=\"botao\" onclick=\"document.getElementById('txtAcao_2').value='detalhes'\" />
												<input type=\"hidden\" name=\"txtNroProcesso0\" value=\"$nroprocesso\" />
												<input type=\"hidden\" name=\"txtAnoProcesso0\" value=\"$anoprocesso\" />				
												<input type=\"hidden\" name=\"contador\" value=\"1\" />
												<input type=\"hidden\" name=\"txtAcao\" id=\"txtAcao_2\" />
											</td>
										</tr>
									</table>
									</fieldset>
								</form>";
						}
				?>
		</td>
	</tr>
</table>