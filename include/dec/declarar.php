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
$cnpj = $_SESSION['login'];
$sqlcnpj=mysql_query("SELECT codigo, nome, razaosocial, cnpj, logradouro, municipio, uf, email FROM cadastro WHERE cnpj='$cnpj' AND estado = 'A'");
	list($codigo,$nome,$razaosocial,$cnpj_cartorio,$endereco,$municipio,$uf,$email)=mysql_fetch_array($sqlcnpj);
	?>

<form method="post" name="frmDec" id="frmDec" action="include/dec/declarar_sql.php" onsubmit="return confirm('Confira seus dados antes de continuar');">
	<input type="hidden" name="hdCnpjDec" value="<?php echo $cnpj; ?>" />
	<input type="hidden" name="hdCodCartorio" value="<?php echo $codigo; ?>" />
	<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="5" bgcolor="#FFFFFF"></td>
			<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Declaração DEC</td>
			<td width="65%" bgcolor="#FFFFFF"></td>
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
				<table width="100%" height="100%" bgcolor="#CCCCCC" border="0" align="center" cellpadding="5" cellspacing="0">
					<tr>
						<td colspan="2" align="center"><strong>C&aacute;lculo de Receita Bruta com Discrimina&ccedil;&atilde;o de Tomadores<br>
							Guia destinada SOMENTE para tributa&ccedil;&atilde;o de receitas PR&Oacute;PRIAS. </strong></td>
					</tr>
					<tr>
						<td width="27%" align="left" valign="middle">CNPJ:</td>
						<td width="73%" align="left" valign="middle"><?php echo $cnpj_cartorio; ?></td>
					</tr>
					<tr>
						<td align="left" valign="middle">Raz&atilde;o Social:</td>
						<td align="left" valign="middle"><?php echo $razaosocial;?></td>
					</tr>
					<tr>
						<td align="left" valign="middle">Endere&ccedil;o:</td>
						<td align="left" valign="middle"><?php echo "$endereco - $municipio - $uf";?></td>
					</tr>
					<tr height="10">&nbsp;</tr>
					<tr>
						<td colspan="2" align="center" valign="top">
							<table border="0" align="left" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF" width="100%">
								<tr>
								  <td align="left" valign="middle">Per&iacute;odo</td>
								  <td align="left" valign="middle">
								  	<?php
									//array de meses comencando em 1 ate 12
									$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
									$mes=date("n");
									$ano=date("Y");						
									if($DEC_ATRAZADAS == 'n'){//var que vem do conect.php
										echo "<b>{$meses[$mes]}/{$ano}</b>";
									?><br />
									Declarações atrasadas entre em contato com a prefeitura
									<input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
									<input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
								  	<?php 
									}else{
									?>
									  <select name="cmbMes" id="cmbMes" onchange="SomaImpostosDes();CalculaMultaDes();">
										  <option value=""></option>
							              <?php
										  for($ind=1;$ind<=12;$ind++){
										  echo "<option value='$ind'>{$meses[$ind]}</option>";
										  }
										  ?>
						              </select>
					                  <select name="cmbAno" id="cmbAno" onchange="SomaImpostosDes();CalculaMultaDes();" >
						                  <option value=""> </option>
											<?php
												$year=date("Y");
												for($h=0; $h<5; $h++){
													$y=$year-$h;
													echo "<option value=\"$y\">$y</option>";
												}
											?>
					                  </select>
									 <?php
									 }//else se é permitudo declaracões atrazadas
									 ?>
					              </td>
							    </tr>
								<?php
                        
									listaRegrasMultaDes();//cria os campos hidden com as regras pra multa da declaracao
									
									//pega o numero de servicos do emissor
									
									
									$num_servicos = 1;//quantos linhas vão aparecer pra preencher
									$num_serv_max = 20;// numero maximo de linhas que podem ser adicionadas
									
									campoHidden("hdServicos",$num_servicos);
									
									campoHidden("hdServMax",$num_serv_max-1);
									//cria a lista de campos para preenchimento da declaracao
									
									for($c=1;$c<$num_serv_max;$c++){
								?>
								<!--TR QUE VAI CONTER ID-->
								<tr id="trServ<?php echo $c;?>" style="<?php echo $trServStyle;?>" bgcolor="#999999">
									<td colspan="7">
										<table border="0" align="center" cellspacing="0" bordercolor="#FFFFFF" width="100%">
											<tr>
												<td align="left" colspan="2" >
													<select style="width:285px;" id="cmbEstabelecimento<?php echo $c;?>"  name="cmbEstabelecimento<?php echo $c;?>" onchange="buscaServicosCartorioTipo(this, 'tdListarServ<?php echo $c;?>',<?php echo $c;?>);">
														<option value="">Tipo de Estabelecimento</option>
														<?php
															$estabelecimento = mysql_query("SELECT cartorios_tipo.codigo, cartorios_tipo.tipocartorio FROM cartorios_tipo");
															while(list($codcart, $tipo) = mysql_fetch_array($estabelecimento))
															{
																echo "<option value=\"$codcart\" id=\"$tipo\">$tipo</option>";
															}
														?>
													</select>
												</td>
												<td align="left" id="tdListarServ<?php echo $c;?>" colspan="3">
													<select style="width:275px;" id="cmbCodCart<?php echo $c;?>"  name="cmbCodCart<?php echo $c;?>" >
														<option >Selecione o tipo de Estabelecimento</option>
													</select>
												</td>
											<tr height="1"></tr>
											<tr bgcolor="#FFFFFF" align="center">
												<td width="144" align="center">Base de C&aacute;lculo (R$)</td>
												<td align="center" width="156">Valor do Emolumento</td>
												<td align="center" width="69">ISS (R$)</td>
												<td width="57" align="center">Al&iacute;q (%)</td>
												<td align="center" width="119">N&ordm;. Documento</td>
											</tr>
											<tr bgcolor="#FFFFFF">
												<td align="center"><?php echo "<input name=\"txtBaseCalculo$c\" id=\"txtBaseCalculo$c\" name=\"txtBaseCalculo$c\" type=\"text\" onkeyup=\"MaskMoeda(this)\" value=\"0,00\" onkeydown=\"return NumbersOnly(event);\" onblur=\"CalculaImpostoDes(txtBaseCalculo$c, txtAliquota$c, txtImposto$c);\" maxlength=\"12\" size=\"12\" class=\"texto\" style=\"text-align:right\" />"; ?></td>
												<td align="center">
													<input name="txtEmo<?php echo $c;?>" id="txtEmo<?php echo $c;?>" onkeydown="return NumbersOnly(event);" style="text-align:right;" onkeyup="MaskMoeda(this)" value="0,00" onblur="CalculaImpostoDes(<?php echo "txtBaseCalculo$c, txtAliquota$c, txtImposto$c"; ?>);" type="text" size="10" class="texto" />
												</td>
												<td align="center">
													<input name="txtImposto<?php echo $c;?>" id="txtImposto<?php echo $c;?>" style="text-align:right;" type="text" value="0,00" readonly="readonly" size="10" class="texto" />
												</td>
												<td align="center">
													<input name="txtAliquota<?php echo $c;?>" id="txtAliquota<?php echo $c;?>" type="text" readonly="readonly" style="text-align:right;" size="4" class="texto" />
												</td>
												<td align="center">
													<input name="txtNroDoc<?php echo $c;?>" id="txtNroDoc<?php echo $c;?>" type="text" size="10" class="texto" />
												</td>
											</tr>
										</table>
									</td>
									<?php
											if ($c>=$num_servicos){
												$trServStyle = "display:none;";
											}
							
									}//fim while listagem dos campos pra declaracao
							
									?>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="2" align="right" valign="middle">
							<input name="btServRemover" id="btServRemover" type="button" value="Remover Serviço" class="botao" disabled="disabled" onclick="EmissorRemoverServ();">
							<input name="btServInserir" id="btServInserir" type="button" value="Inserir Serviço" class="botao" onclick="EmissorInserirServ();">
						</td>
					</tr>
					<tr>
						<td align="left" valign="middle">Imposto Total:</td>
						<td align="left" valign="middle">
							<input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" />
						</td>
					</tr>
					<tr style="display: none;">
						<td align="left" valign="middle">Multa e Juros de Mora:</td>
						<td align="left" valign="middle">
							<input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
						</td>
					</tr>
					<tr style="display: none;">
						<td align="left" valign="middle"><b>Total a Pagar:</b></td>
						<td align="left" valign="middle">
							<input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle"><em>* Confira seus dados antes de continuar<br>
							** Desabilite seu bloqueador de pop-up</em></td>
					</tr>
					<tr>
						<td align="left" valign="middle">&nbsp;</td>
						<td align="left" valign="middle">
							<input type="submit" value="Declarar" class="botao" onclick="return ValidaFormMsg('cmbMes|cmbAno|cmbCodCart1|txtBaseCalculo1|txtNroDoc1|cmbEstabelecimento<?php echo $c; ?>|cmbCodCart<?php echo $c; ?>','O Período e pelo menos um serviço devem ser preenchidos!');" />
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			</td>
	</table>
</form>
</tr>
<tr>
	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
</tr>
</table>
