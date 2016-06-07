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
//recebe os dados
$cnpj = $_SESSION["login"];

//configuracao da prefeitura para gerar todas as guias de declaracao de uma vez, ou individualmente
if($GERAR_GUIA_SITE == 't'){;//var vinda do conect.php
	$guia_checked = "this.checked = true";//faz o check box ficar sempre marcado para nao poder ser desmarcado
	$todas_guias = true;
}else{
	$guia_checked = "";//se nao, nao faz nada no onclick
	$todas_guias = false;
}

//determina o emissor
$sql_login = mysql_query("SELECT codigo FROM cadastro WHERE cnpj = '$cnpj'");
list($codemissor) = mysql_fetch_array($sql_login);

// carrega as regras de multa por ataso
listaRegrasMultaDes();
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="340" align="center" bgcolor="#FFFFFF" rowspan="3">Emiss&atilde;o da guia de pagamento</td>
	    <td width="405" bgcolor="#FFFFFF"></td>
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
		<td height="60" colspan="3" bgcolor="#CCCCCC" align="center">
			<p align="center">Escolha o período</p>
			<form method="post">
				<input type="hidden" name="txtMenu" value="<?php echo $_POST['txtMenu'];?>" />
				<table>
					<tr>
						<td>
				  	<?php
					//array de meses comencando em 1 ate 12
					$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
					$mes = date("n");
					$ano = date("Y");						
					?>
					  <select name="cmbMes" id="_mes">
						  <option value=""></option>
			              <?php
						  for($ind=1;$ind<=12;$ind++){
						  	echo "<option value='$ind'";if($ind == $mes){ echo "selected=\"selected\"";}echo ">{$meses[$ind]}</option>";
						  }
						  ?>
		              </select>
                      </td>
                      <td>
	                  <select name="cmbAno" id="_ano">
		                  <option value=""> </option>
							<?php
								$year=date("Y");
								for($h=0; $h<5; $h++){
									$y=$year-$h;
									echo "<option value=\"$y\"";if($y == $ano){ echo "selected=\"selected\"";}echo ">$y</option>";
								}
							?>
	                  </select>
						</td>
						<td><input type="submit" class="botao" name="btBuscar" value="Buscar" onclick="return ValidaFormulario('_mes|_ano','Por favor selecione um mês e um ano!')"/></td>
					</tr>
				</table>
			</form>
<?php
	if($_POST["btBuscar"] == "Buscar")
		{
			$ano = $_POST["cmbAno"];
			$mes = $_POST["cmbMes"];
			$sql = mysql_query("
                SELECT 
	                dif_des.codigo,
	                dif_des.data,
	                dif_des.codverificacao,
	                SUM(dif_des_contas.iss),
	                DATE_FORMAT(dif_des.competencia,'%m/%Y')
                FROM 
                	dif_des
                INNER JOIN 
                	dif_des_contas ON dif_des.codigo = dif_des_contas.coddif_des
                WHERE 
                	MONTH(dif_des.competencia) = '$mes' AND 
                	YEAR(dif_des.competencia) = '$ano' AND 
                	dif_des.codinst_financeira = '$codemissor' AND 
                	dif_des.estado = 'N'
                GROUP BY 
                	dif_des.codigo
            ");
			if(mysql_num_rows($sql) > 0)
				{
					?>
						<form method="post">	
							<input type="hidden" name="txtMenu" value="guia_pagamento/index.php" />
							<input type="hidden" name="btBuscar" value="Buscar" />
							<input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
							<input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
							<input type="hidden" name="txtEmissor" value="<?php echo $codemissor;?>" />
							<table width="70%">
								<tr bgcolor="#999999" style=" <?php if($todas_guias){echo "display: none;";} ?>">
									<td colspan="4" align="right">Selecionar tudo</td>
									<td align="center">
										<input type="checkbox" name="ckTodos" id="ckTodos" onclick="
										<?php
										if($todas_guias){
											echo "this.checked = true; GuiaPagamento_TotalISS()";
										}else{
											echo "GuiaPagamento_TotalISS();";
										}
										?>
										">
									</td>
								</tr>
                                <tr bgcolor="#FFFFFF">
                                    <td width="100" align="center">Data Gerado</td>
                                    <td width="90" align="center">Competência</td>
                                	<td width="110" align="center">Cod. Verificação</td>
                                    <td width="60" align="center">Valor</td>
                                    <td align="center"></td>
                                </tr>
                            </table>
                           <div style=" width:70%; <?php if(mysql_num_rows($sql)>13){ echo "height:300px; overflow:auto";}?>">
                            <table width="100%">
								<?php
									$cont = 0;
									while(list($codigo,$data,$codverificacao,$total,$data_comp) = mysql_fetch_array($sql)){
										$datahora = explode(" ",$data);
										$data = DataPt($datahora[0]);
										$hora = $datahora[1];
										?>										
											<tr bgcolor="#FFFFEA">
												<td width="100" align="center"><?php echo $data;?></td>
												<td width="90" align="center"><?php echo $data_comp;?></td>
												<td width="110" align="center"><?php echo $codverificacao;?></td>
												<td width="60" align="right"><?php echo DecToMoeda($total);?></td>
												<td align="center">
													<input type="checkbox" name="ckISS<?php echo $cont;?>" id="ckISS<?php echo $cont;?>" value="<?php echo $total."|".$codigo;?>" onclick="
													<?php
													if($todas_guias){
														//serve para ja comecar com checked, e se tentar tirar a marcacao ele fica checked denovo
														echo "this.checked = true;\" checked=\"checked\"";
													}else{
														echo "GuiaPagamento_SomaISS(this);";
													}
													?>
													">
													<input type="hidden" name="txtCodNota<?php echo $cont;?>" id="txtCodNota<?php echo $cont;?>" />													
												</td>
											</tr>
										<?php
										$cont++;
									}
								?>
							</table>
                          </div>
						 	<input type="hidden" value="<?php echo $total_iss."|".($cont-1); ?>" name="txtTotalIssHidden" id="txtTotalIssHidden"/>
						 	<table>
								<tr>
									<td>Imposto</td>
									<td>
										<input type="text" class="texto" style="text-align: right" name="txtTotalIss" id="txtTotalIss" value="0,00" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td>Multa</td>
									<td>
										<input type="text" class="texto" style="text-align: right" name="txtMultaJuros" id="txtMultaJuros" value="0,00" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td>Total</td>
									<td>
										<input type="text" class="texto" style="text-align: right" name="txtTotalPagar" id="txtTotalPagar" value="0,00" readonly="readonly" >
									</td>
								</tr>
								<tr>
									<td>
									</td>
									<td>
										<input type="hidden" class="texto" name="txtMultaJuros" id="txtMultaJuros" value="0" readonly="yes" >
									</td>
								</tr>
							</table>	
							<input type="submit" class="botao" value="Gerar Boleto" name="btBoleto" id="btBoleto" onclick="document.getElementById('btBoleto').disabled; return (ValidaCkbDec('txtTotalIss')) && (Confirma('Deseja gerar esta guia?'))"/>
							<input type="hidden" name="txtCont" value="<?php echo $cont; ?>" />
						 	
						</form>	
                        
				</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#CCCCCC" colspan="3"></td>
				<td bgcolor="#CCCCCC"></td>
			</tr>
        </table>
					<?php
			}else{
				echo "<center>Nenhum Resultado Encontrado!</center>";
			}
			if($_POST["btBoleto"] == "Gerar Boleto"){
				//recebe os dados
				$totaliss = MoedaToDec($_POST['txtTotalIss']);
					
				$codemissor     = $_POST["txtEmissor"];
				$multa          = MoedaToDec($_POST["txtMultaJuros"]);
				$total          = MoedaToDec($_POST["txtTotalPagar"]);
				$cont           = $_POST["txtCont"];
				$dataemissao    = date("Y-m-d");
				$data           = explode("-",$dataemissao);
				/*$datavencimento = mktime(24*5,0,0,$data[1],$data[2],$data[0]);
				$datavencimento = date("Y-m-d",$datavencimento);*/
				$datavencimento = UltDiaUtil($data[1],$data[0]);
				
				// busca o codigo do banco e o arquivo q gera o boleto
				$sql = mysql_query("SELECT bancos.boleto, boleto.tipo FROM boleto INNER JOIN bancos ON bancos.codigo = boleto.codbanco");
				list($boleto,$tipoboleto) = mysql_fetch_array($sql);
				
					// inseri a guia de pagamento no db
					//require_once("../midware/conecta.pg.php");
					//$pg_sql_cod = pg_query("SELECT MAX(numero_conhecimto) FROM smafinan");
					//list($pg_last_id) = pg_fetch_array($pg_sql_cod);
					//$pg_codigo = $pg_last_id + 1;
					mysql_query("
						INSERT INTO 
							guia_pagamento 
						SET 
							valor='$total', 
							valormulta='$multa', 
							dataemissao='$dataemissao',
							datavencimento='$datavencimento', 
							pago='N', 
							estado='N'
					");
					
					// busca o codigo da guia de pagamento recem inserida
					$sql=mysql_query("SELECT MAX(codigo) FROM guia_pagamento");
					list($codguia)=mysql_fetch_array($sql);
					//include_once('include/guia_pg/postgre_sql.php');
					
					
					//Mensagem($cont);
					// relaciona a guia de pagamento com as delcaracoes
					for($i=0; $i<$cont; $i++){
						if($_POST["ckISS".$i]){
							//Mensagem($cont);
							$coddeclaracao=explode("|", $_POST["ckISS".$i]);
							
							mysql_query("INSERT INTO guias_declaracoes SET codguia='$codguia', codrelacionamento='$coddeclaracao[1]', relacionamento='dif_des'");
							mysql_query("UPDATE dif_des SET estado='B' WHERE codigo='$coddeclaracao[1]'");
						}
					}
					
					// retorna o codigo do ultimo relacionamento
					$sql=mysql_query("SELECT MAX(codigo) FROM guias_declaracoes");
					list($codrelacionamento)=mysql_fetch_array($sql);
					
					// gera o nossonumero e chavecontroledoc
					$nossonumero = gerar_nossonumero($codguia);
					$chavecontroledoc = gerar_chavecontrole($codrelacionamento,$codguia);
					
					// seta o nossonumero e a chavecontroledoc no banco
					mysql_query("UPDATE guia_pagamento SET nossonumero='$nossonumero', chavecontroledoc='$chavecontroledoc' WHERE codigo='$codguia'");
					
					// gera o boleto
					Mensagem("Boleto gerado com sucesso");
					imprimirGuia($codguia);
					
					Redireciona("principal.php");
			}		
		}
		
?>
<script type="text/javascript">
	<?php
	if($_POST['btBuscar']){
	?>
	document.getElementById('_mes').value = '<?php echo $_POST['cmbMes']; ?>';
	document.getElementById('_ano').value = '<?php echo $_POST['cmbAno']; ?>';
	if(document.getElementById('cmbMes'))
		CalculaMultaDes();
	<?php
	}
	?>
		
	var check_guia = function(){
		document.getElementById('ckTodos').onclick();
	};
	<?php
	if($todas_guias){
		echo "loadEvent(check_guia);";
	}
	?>
</script>