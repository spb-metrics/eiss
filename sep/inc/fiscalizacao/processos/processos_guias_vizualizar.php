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
$nroprocesso     = $_POST["txtNroProcesso"];
$anoprocesso     = $_POST["txtAnoProcesso"];
$codautuacao     = $_POST["hdParcela"];
$valor_total     = $_POST["hdValorTotal"];

//Pega o codigo quantidad de parcelas e o valor total
$sql = mysql_query("SELECT codigo, 
                    nroparcelas,
                    valor,
					quantidade,
					multa
                    FROM processosfiscais_autuacoes
                    WHERE nroprocesso = '$nroprocesso'
                    AND anoprocesso = '$anoprocesso'
                    AND codigo = '$codautuacao'");
list($codigo,$nroparcelas,$valor,$quantidade,$multa) = mysql_fetch_array($sql);
$valorreincidencia	 = $valor + $quantidade*($valor*$multa);

//botao ira gerar automaticamente as datas de vencimento a partir da data da primeira parcela
if($_POST["btnDatas"] == "Gerar Datas Automaticamente"){
	$sql_datas=mysql_query("SELECT SUBSTRING(vencimento,1,4), SUBSTRING(vencimento,6,2), SUBSTRING(vencimento,9,2), vencimento FROM processosfiscais_guias WHERE codautuacao = '$codautuacao' AND situacao='P' ORDER BY codigo DESC LIMIT 1");
	list($ano, $mes, $dia, $data)=mysql_fetch_array($sql_datas);
	if($data==""){
		Mensagem('É necessário que a data de vencimento da primeira parcela seja feita');
	}
	else{
		$sql=mysql_query("SELECT numero FROM processosfiscais_guias WHERE codautuacao = '$codautuacao' AND situacao ='A' ORDER BY numero");
		while(list($parcela)=mysql_fetch_array($sql)){
			$vencimento = $ano."-".$mes."-".$dia;
			$parcela++;
			$mes++;
			if($mes<10){
				$mes ="0".$mes;
			}
			if($mes>12){
				$mes ="1";
				$ano++;
			}
			mysql_query("UPDATE processosfiscais_guias SET vencimento='$vencimento' WHERE numero = '$parcela'");
			add_logs('Atualizou uma Guia de um Processo Fiscal');
		}
	}
}

if($_POST["btAlterarVencimento"] == "Alterar Vencimento"){
		//Recebe as informacoes que serao atualizadas
		$parcela               = $_POST["hdParcAtualizar"];
		$parcela_vencimento    = $_POST["txtVencimento"];
		$situacao				   = $_POST["hdSituacao"];
		$codigo 			   = $parcela;

		$sql_codigo = mysql_query("SELECT codautuacao FROM processosfiscais_guias WHERE codigo='$codigo'");
		list($codatual) = mysql_fetch_array($sql_codigo);
		
		$codigo--;
		
		$sql_vencimento = mysql_query("SELECT vencimento,  FROM processosfiscais_guias WHERE codigo='$codigo' AND codautuacao ='$codatual'");
		list($vencimento)=mysql_fetch_array($sql_vencimento);
		
		if(mysql_num_rows($sql_vencimento)==0){
			$codigo++;
			$sql_vencimento = mysql_query("SELECT vencimento FROM processosfiscais_guias WHERE codigo='$codigo' AND codautuacao ='$codatual'");
			list($vencimento)=mysql_fetch_array($sql_vencimento);
		}
		if($situacao!="P"){
		$parcela_vencimento    = DataMysql($parcela_vencimento);    //Muda a data de 00/00/0000 para 0000-00-00
			if($parcela_vencimento<=$vencimento){
				Mensagem("A data não pode ser menor que o vencimento da parcela anterior.");
			}
			else{
			mysql_query("UPDATE processosfiscais_guias
					 SET vencimento = '$parcela_vencimento'
					 WHERE codigo = '$parcela'");
			add_logs('Processo Fiscal - Atualizou Vencimento de parcela');
			Mensagem("Data de vencimento alterada com sucesso!");
			}
		}else{
		Mensagem("Parcelas pagas não podem ter sua data de vencimento alterada!");
		}
}

//botao que gera a quantidade de guias que o usuario solitou
if($_POST["btGerar"] == "Gerar")
	{
		$dataatual = date('Y-m-d');
		$sql_teste=mysql_query("SELECT situacao FROM processosfiscais_guias WHERE codautuacao='$codautuacao' AND situacao='P' ORDER BY codigo DESC LIMIT 1");
		if(mysql_num_rows($sql_teste)>0){
			Mensagem("Não é possível alterar o número de parcelas devido ao primeiro pagamento já ter sido realizado!");
			}
		else{
			$numero_parcelas = $_POST["txtNroParcelas"];
			mysql_query("UPDATE processosfiscais_autuacoes SET nroparcelas = '$numero_parcelas' WHERE codigo = $codautuacao"); // Atualiza o numero de parcelas da tabela de autuacoes 
			add_logs('Processo Fiscal - Atualização de parcelas');
			
			mysql_query("DELETE FROM processosfiscais_guias WHERE codautuacao = '$codautuacao'"); //Deleta todos os registros anteriores da tabela guias
			//inseri o numero de registros de acordo com o numero de parcelas que foi solicitado
			$x = 1;
			$valor_parcela = $valorreincidencia/$numero_parcelas; //divide o valor entre as parcelas
			while($x <= $numero_parcelas)
				{
					mysql_query("INSERT INTO processosfiscais_guias SET codautuacao= '$codautuacao', numero='$x', valor='$valor_parcela', situacao='A', datacientificacao='$dataatual'"); 
					$x++;
				}
			$x -= 1;
			add_logs('Processo Fiscal - Inserção de parcelas');
			Mensagem("Estipulado numero de $x parcelas");// funcao pra alert
		}	
	}

//botao que exerce a atualizacao do banco de dados
if($_POST["btAtualizar"] == "Atualizar"){
	
	//Recebe as informacoes que serao atualizadas
	$parcela               = $_POST["hdParcAtualizar"];
	$parcela_cientificacao = $_POST["txtCientificacao"];
	$parcela_valorpago     = $_POST["txtValorpago"];
	$parcela_vencimento    = $_POST["txtVencimento"];
	
	$sql_valor = mysql_query("SELECT codigo, codautuacao, valor, situacao FROM processosfiscais_guias WHERE codautuacao = '$codautuacao' AND codigo = '$parcela'");
	list($codigo, $codautuacao, $valor_parcela, $situacao_parcela)=mysql_fetch_array($sql_valor);
	
	$parcela_valorpago     = MoedaToDec($parcela_valorpago); // Retira as virgulas e coloca pontos para que o banco aceite
	$parcela_cientificacao = DataMysql($parcela_cientificacao);
	$valor_parcela     	   = MoedaToDec($valor_parcela);
	if($parcela_vencimento==""){
		Mensagem("Parcela sem data de vencimento!");
	}
	else{
		if($situacao_parcela=="P"){
			Mensagem("Parcela já paga! Alteração na data de vencimento não pode ser feita");
		}
		else{
			if($parcela_valorpago<$valor_parcela){
				Mensagem("Valor de pagamento menor que o valor da parcela.");
			}
			else{
				if($parcela_valorpago>$valor_parcela){
					Mensagem('Valor acima do valor da parcela.');
				}
				else{
					$codigo--;
					$sql_sit = mysql_query("SELECT situacao FROM processosfiscais_guias WHERE codigo='$codigo'");
					list($situacao_anterior)=mysql_fetch_array($sql_sit);
					if($situacao_anterior=="A"){
						Mensagem("Parcela anterior não paga!");
					}
					else{
						mysql_query("UPDATE processosfiscais_guias
								 SET datacientificacao = '$parcela_cientificacao',
								 valorpago = '$parcela_valorpago',
								 situacao = 'P'
								 WHERE codigo = '$parcela'");
						add_logs('Atualizou o Valor da Parcela');
						Mensagem("Dados da parcela atualizados!");
					}
				}
			}
		}
	}
}

	//Verifica se o valorpago ja houve algum pagamento se ja houver nao pode alterar
	$sql_valorpago = mysql_query("SELECT valorpago FROM processosfiscais_guias WHERE codautuacao = '$codautuacao'");
	list($valorpago) = mysql_fetch_array($sql_valorpago);
	

?>
<table width="100%" align="center">
	<tr>
		<td>
			<form method="post" name="frmParcelaVizualizar" id="frmParcelaVizualizar">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao_parcelas" />
				<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso;?>" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso;?>" />
				<input type="hidden" name="hdParcela" value="<?php echo $codautuacao;?>" />
				<input type="hidden" name="hdValorTotal" value="<?php echo $valor_total;?>" />
				<input type="hidden" name="hdNumeroParc" value="<?php echo $nroparcelas;?>" />
				<?php
					if($_POST["btEdit"] == "Editar"){

						$codparc = $_POST["hdCodParc"];
						$sql_atualizar = mysql_query("SELECT vencimento, datacientificacao, situacao, valorpago, numero, valor FROM processosfiscais_guias WHERE codigo = '$codparc'");
						list($vencimento,$datacientificacao,$situacao,$valorpago,$numero,$valorparcela) = mysql_fetch_array($sql_atualizar);
						$valorpago         = DecToMoeda($valorpago);// converte o valor de decimal para reais
						$valorparcela      = DecToMoeda($valorparcela);
						$vencimento        = DataPt($vencimento);   //converte a data de 0000-00-00 para 00/00/0000
						$datacientificacao = DataPt($datacientificacao);
						
						?>
						<fieldset style=" width:657px; margin-left:4px; margin-right:4px"><legend>Editar Parcela</legend>
							<table width="100%">
                            	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
								<input name="hdNumeroParc" type="hidden" value="<?php echo $numero; ?>" />
								<input name="hdParcAtualizar" type="hidden" value="<?php echo $codparc;?>" />
                                <input name="hdSituacao" type="hidden" value="<?php echo $situacao;?>" />
								<tr>
									<td width="150" align="left">Vencimento</td>
									<td align="left" colspan="2">
										<input name="txtVencimento" id="txtVencimento" onkeyup="return txtBoxFormat(document.frmParcelaVizualizar, 'txtVencimento', '99/99/9999', event);" maxlength="10"  size="12" value="<?php echo $vencimento;?>"  type="text" class="texto" />
									</td>
								</tr>
								<tr>
									<td align="left">Data de cientificação</td>
									<td align="left" colspan="2">
										<input name="txtCientificacao" id="txtCientificacao" onkeyup="return txtBoxFormat(document.frmParcelaVizualizar, 'txtCientificacao', '99/99/9999', event);" 
										maxlength="10"  size="12" value="<?php echo $datacientificacao;?>" type="text" class="texto" />								
									</td>
								</tr>
								<tr <?php if($valorpago==$valorparcela){echo "style=\"display:none\"";} ?>>
									<td align="left">Valor Pago</td>
									<td align="left" colspan="2">
										<input name="txtValorpago" onkeyup="MaskMoeda(this);" onkeypress="return NumbersOnly(event);" value="<?php echo MoedaToDec($valorpago); ?>" size="10"  type="text" class="texto" />
									</td>
								</tr>
								<tr>
									<td align="left" colspan="2"><input name="btAtualizar" type="submit" class="botao" value="Atualizar" onclick="document.getElementById('txtAcao_parcelas').value='parcelas'"/>&nbsp;<input name="btAlterarVencimento" type="submit" class="botao" value="Alterar Vencimento" onclick="document.getElementById('txtAcao_parcelas').value='parcelas'"/>&nbsp;<input name="btCancel" type="submit" class="botao" value="Cancelar" onclick="document.getElementById('txtAcao_parcelas').value='parcelas'"/></td>
								</tr>
							</table>
						</fieldset>
					<?php
					}else{
					$sql_teste=mysql_query("SELECT situacao FROM processosfiscais_guias WHERE codautuacao='$codautuacao' AND situacao='P'");
					?>
					<fieldset style="margin-left:4px;margin-right:4px; <?php if(mysql_num_rows($sql_teste)>0){echo "display:none;";} ?>">
						<table width="100%">
							<tr bgcolor="#FFFFFF">
								<td align="left" width="50%">Informe o numero de parcelas que desejas: </td>
								<td align="left" width="50%"><input name="txtNroParcelas" type="text" class="texto" size="6" value="<?php echo $nroparcelas;?>" /></td>
							</tr>
								<td align="left" colspan="2"><input name="btGerar" type="submit" class="botao" value="Gerar" onclick="document.getElementById('txtAcao_parcelas').value='parcelas'" /></td>
						</table>
					</fieldset>
					<?php
						$sql_lista = mysql_query("SELECT codigo, codautuacao, numero, valor, vencimento, datacientificacao, valorpago, situacao FROM processosfiscais_guias WHERE codautuacao = '$codautuacao' ORDER BY numero ASC");
						$sql_valores= mysql_query("SELECT codigo,  nroparcelas, valor, quantidade, multa FROM processosfiscais_autuacoes WHERE nroprocesso = '$nroprocesso' AND anoprocesso = '$anoprocesso' AND codigo = '$codautuacao'");
						list($codigo,$nroparcelas,$valortotal,$quantidade,$multa)=mysql_fetch_array($sql_valores);
						$result = mysql_num_rows($sql_lista);
						if($result > 0){
					?>
					<fieldset id="fieldset" style="margin-left:4px; margin-right:4px">
						<table width="100%">
							<tr bgcolor="#999999">
								<td width="10%" align="center">Parcela</td>
								<td width="16%" align="center">Vencimento</td>
								<td width="8%" align="center">Valor</td>
								<td width="12%" align="center">Situação</td>
								<td width="15%" align="center">Valor Pago</td>
								<td width="32%" align="center">Data de cientificação</td>
								<td width="7%" align="center">Ações</td>
							</tr>
							<?php
								$valorreincidencia	 = $valortotal + $quantidade*($valortotal*$multa);
								$valor_pendente    = valorreincidencia;
								while(list($codigo,$codautuacao,$numero,$valor,$vencimento,$datacientificacao,$valorpago,$situacao) = mysql_fetch_array($sql_lista)){
								$valor             = DecToMoeda($valor);
								$valorpago         = DecToMoeda($valorpago);
								$vencimento        = DataPt($vencimento);
								$datacientificacao = DataPt($datacientificacao);
								switch($situacao){
									case "A":
										$situacao = "Aberto"; break;
									case "P":
										$situacao = "Pago"; break;
								}//fim switch
								if($situacao=="Paga" && $valorpago<$valor){
									$situacao = "Aberto";
								}
								$valor_pendente=$valor_pendente + $valorpago;
							?>
							<tr bgcolor="#FFFFFF">
								<td align="center"><?php echo $numero;?></td>
								<td align="center"><?php echo $vencimento;?></td>
								<td align="center"><?php echo DecToMoeda($valor);?><input name="hdValor" type="hidden" id="hdValor" value="<?php echo $valor; ?>"/></td>
								<td align="center"><?php echo $situacao;?><input name="hdEstado" type="hidden" id="hdEstado" value="<?php echo $situacao; ?>"/></td>
								<td align="center"><?php echo DecToMoeda($valorpago);?></td>
								<td align="center"><?php echo $datacientificacao;?></td>
								<td align="center"><input name="btEdit" type="submit" class="botao" value="Editar" onclick="document.getElementById('hdCodParc').value='<?php echo $codigo;?>';document.getElementById('txtAcao_parcelas').value='parcelas'" /></td>
							</tr>
							<?php
								}//fim while
							$valor_pendente = $valorreincidencia-$valor_pendente;
							?>
						<input name="hdCodParc" type="hidden" id="hdCodParc" />
						<tr>
                        	<td align="right" colspan="7" bgcolor="#999999">Valor Total: <?php echo "R$ ".DecToMoeda($valorreincidencia).""?>&nbsp;&nbsp;&nbsp;
Valor Pendente: <?php echo "R$ ".DecToMoeda($valor_pendente).""?>
</td>
                        </tr>
                        </table>
						<table>
							<tr>
								<td>
									<input name="btVoltar" id="btVoltar" type="submit" class="botao" value="Voltar" 
										onclick="document.getElementById('txtAcao_parcelas').value='guiasparcelamento'" />
                                    <input name="btnDatas" id="btnDatas" type="submit" class="botao" value="Gerar Datas Automaticamente" onclick="document.getElementById('txtAcao_parcelas').value='parcelas';Confirma('Deseja atualizar as datas de vencimento de acordo com a primeira parcela?');"/>
								</td>
							</tr>
						</table>
					</fieldset>
					<?php
						}else{?>
							<table width="100%">
								<tr>
									<td align="center"><b>Ainda não foi parcelado</b></td>
								</tr>
								<tr>
									<td align="left">
										<input name="btVoltar" id="btVoltar" type="submit" class="botao" value="Voltar" 
										onclick="document.getElementById('txtAcao_parcelas').value='guiasparcelamento'" />
									</td>
								</tr>
							</table>
				<?php	}//fim else
					}//fim else	
				?>
			</form>
		</td>
	</tr>
</table>