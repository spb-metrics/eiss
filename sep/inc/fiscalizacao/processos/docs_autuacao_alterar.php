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
<script language="JavaScript" type="text/javascript">
function ConsultaInfracao(campo){
	
	 // Verificar o Browser
	// Firefox, Google Chrome, Safari e outros
	if(window.XMLHttpRequest) {
	   req = new XMLHttpRequest();
	}
	// Internet Explorer
	else if(window.ActiveXObject) {
	   req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var url='inc/processofiscal/descricao_infracao_ajax.php?valor='+campo.value;
	
			req.open("Get", url, true);
		 
		// Quando o objeto recebe o retorno, chamamos a seguinte função;
		req.onreadystatechange = function() {
		 
			// Exibe a mensagem "Verificando" enquanto carrega
			if(req.readyState == 1) {				
				
			//document.getElementById('cmbCodinfracao').value = 'Verificando...';
			}
		 
			// Verifica se o Ajax realizou todas as operações corretamente (essencial)
			if(req.readyState == 4 && req.status == 200) {
			// Resposta retornada pelo validacao.php
			var resposta = req.responseText;
			/*if(resposta == 'Emissor não cadastrado')
			{
			 document.getElementById('hdvalidar'+cont).value='n';
			 resposta= '<font color=#ff0000>'+resposta+'</font>';
			}
			else{document.getElementById('hdvalidar'+cont).value='s';}
			// Abaixo colocamos a resposta na div do campo que fez a requisição
			document.getElementById('divtxtcnpjcpf'+cont).innerHTML = resposta;*/
		}
		    if(resposta)
			{
				resposta = resposta.split('---');			
				var descricao = resposta[0];
				var fundamentacao = resposta[1];
				document.getElementById('txtDescricaoinfracao').value = descricao;
				document.getElementById('txtFundamentacao').value = fundamentacao;		 
		    }		
		}		 
		req.send(null);
}
//esconder e mostrar div
function controlaCamada(nomeDiv) 
{ 
    if( document.getElementById('cmbTipodoc').value == "A" ) 
    { 
        document.getElementById('divAutoinfracao').style.display="block"; 
        document.getElementById('divNotificacao').style.display="none"; 
    } else 
    { 
        document.getElementById('divAutoinfracao').style.display="none"; 
        document.getElementById('divNotificacao').style.display="block"; 
    } 
}
</script>

<?php
$nroautuacao 		= $_POST["txtNroAutuacao"];
$anoautuacao 		= $_POST["txtAnoAutuacao"];
$nroprocesso		= $_POST["txtNroProcesso"];
$anoprocesso 		= $_POST["txtAnoProcesso"];
$tipoautuacao 		= $_POST["cmbTipodoc"];
$tipo_autuacao 		= $_POST["cmbTipodoc"];
$historicoautuacao 	= $_POST["txtHistorico"];
$reincidencia		= $_POST["cmbReincidencia"];
$qtdautuacao		= $_POST["txtQTD"];
$multaautuacao		= $_POST["txtMulta"];
$codinfracao		= $_POST["cmbCodinfracao"];
$ano = Date("Y");

//busca o codigo do documento de autuacao para usar no update
$sql = mysql_query("SELECT codigo FROM processosfiscais_autuacoes WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
list($codautuacao) = mysql_fetch_array($sql);
switch($tipoautuacao){
	case "A": $tipoautuacao = "Auto de Infração"; break;
	case "N": $tipoautuacao = "Notificação"; break;
}
if($_POST["btnConfirmar"] == "Confirmar") {
	mysql_query("UPDATE processosfiscais_autuacoes SET codinfracao = '$codinfracao',titulo = '$tipoautuacao',  historico = '$historicoautuacao' WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
	add_logs('Atualizou uma Autuação');
		
	//se for mudado de notificacao para auto de infracao, apaga as competencias do documento, pois auto de infracao nao tem competencias.
	if($tipo_autuacao == "A"){
		if($reincidencia == "S"){
		mysql_query("UPDATE processosfiscais_autuacoes SET reincidencia = '$reincidencia', quantidade = '$qtdautuacao', multa = '$multaautuacao' WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
		add_logs('Atualizou uma Reincidencia');
		
		}else{
		mysql_query("UPDATE processosfiscais_autuacoes SET reincidencia = '$reincidencia', quantidade = '0', multa =NULL WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
		add_logs('Atualizou uma Autuação com Reincidencia');
		}
		mysql_query("DELETE FROM processosfiscais_competencias WHERE codautuacao = '$codautuacao';");
		add_logs('Excluiu uma Competência');
		Mensagem("Documento de autuação: $nroautuacao/$anoautuacao - Auto de Infração atualizado!");
		
	}else{
		mysql_query("UPDATE processosfiscais_autuacoes SET reincidencia = NULL, quantidade = NULL, multa = NULL WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
		add_logs('Atualizou uma Autuação sem Reincidencia');
		mysql_query("DELETE FROM processosfiscais_competencias WHERE codautuacao = '$codautuacao';");
		for($m=1;$m<=12;$m++){
			for($a=$ano;$a>=($ano-5);$a--){
						if(strlen($m) == 1) {$m="0".$m;}
						$competencia = $_POST["ckb".$m."/".$a];
						$codcompetencia = "$a-$m";
						if($competencia){
							mysql_query("INSERT INTO processosfiscais_competencias SET codautuacao = '$codautuacao', competencia = '$codcompetencia'");
							add_logs('Inseriu uma Competência');
							$contcomp++;
							
						}
			}//fim for, para Anos
		}//fim for, que grava no banco o mes e o ano das competencias selecionadas.
		Mensagem("Documento de autuação: $nroautuacao/$anoautuacao - Notificação atualizado!");
	}//fim if tipo de documento
	
	?>
	<form method="post" id="form">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="visualizarautuacao" />
		<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
		<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
	</form>
	<script>document.getElementById('form').submit();</script><?php
}//fim do if de submit

//muito relacionamento de tabelas, por isso é muito grande.
$sql = mysql_query	("SELECT processosfiscais.nroprocesso,
                      processosfiscais.anoprocesso,
                      cadastro.razaosocial,
                      processosfiscais_autuacoes.nroautuacao,
                      processosfiscais_autuacoes.anoautuacao,
                      processosfiscais_autuacoes.titulo,
                      processosfiscais_autuacoes.historico,
                      processosfiscais_infracoes.codigo,
                      processosfiscais_infracoes.nroinfracao,
                      processosfiscais_infracoes.anoinfracao,
                      processosfiscais_infracoes.tituloinfracao,
                      processosfiscais_infracoes.descricao,
                      processosfiscais_infracoes.fundamentacaolegal,
                      processosfiscais_autuacoes.codigo,
                      processosfiscais_autuacoes.reincidencia,
                      processosfiscais_autuacoes.quantidade,
                      processosfiscais_autuacoes.multa
                      FROM processosfiscais INNER JOIN
                      cadastro ON processosfiscais.codemissor = cadastro.codigo
                      INNER JOIN processosfiscais_autuacoes 
                      ON processosfiscais.nroprocesso = processosfiscais_autuacoes.nroprocesso
                      INNER JOIN processosfiscais_infracoes
                      ON processosfiscais_autuacoes.codinfracao = processosfiscais_infracoes.codigo
                      WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao'
                      AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'");

//seleciona os dados da autuacao: numero do processo, ano do processo, razao social, codigo da autuacao, descricao da autuacao, nomero e ano da infracao, descricao da infracao, fundamentacao legal (legislacao municipal, como leis e multas)
	list($nroprocesso, $anoprocesso, $razaosocial, $autuacao_nro, $autuacao_ano, $autuacao_descricao, $autuacao_historico, $infracoes_codigo, $infracoes_nro, $infracoes_ano, $infracoes_titulo, $infracoes_descricao, $fundamentacaolegal, $codautuacao, $aut_reincidencia, $aut_quantidade, $aut_multa) = mysql_fetch_array($sql); 	
	if($autuacao_descricao == "Auto de Infração"){
	$div1 = "block"; 
	$div2 = "none";
	}else{
	$div1 = "none"; 
	$div2 = "block";
	}
?>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Documentos de Autuação</legend>
	<table>
		<tr>
			<td>Processo Fiscal:</td>
			<td><?php echo"$nroprocesso/$anoprocesso - $razaosocial" ?></td>
		</tr>
	</table>
</fieldset>
<form method="post" id="frmAlterarDoc">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_frmAlterarDoc" />
	<fieldset style="margin-left:7px; margin-right:7px;">
			<table width="100%">
				<tr>
					<td>Tipo doc:</td>
					<td>
						<select name="cmbTipodoc" class="combo" id="cmbTipodoc" onchange="controlaCamada(this);">
							<option value="A" <?php if($autuacao_descricao == "Auto de Infração"){echo "selected=selected";} ?>>Auto de Infração</option>
							<option value="N" <?php if($autuacao_descricao == "Notificação"){echo "selected=selected";} ?>>Notificação</option>
						</select>					
					</td>
				</tr>
				<tr>
					<td>Número/Ano da Infração:</td>
					<td>
						<select name="cmbCodinfracao" id="cmbCodinfracao" class="combo" onchange="ConsultaInfracao(this);">
							<?php
								$sql=mysql_query("SELECT codigo, nroinfracao, anoinfracao, tituloinfracao FROM processosfiscais_infracoes");
								while(list($codinfracao, $nroinfracao, $anoinfracao, $descricaoinfracao) = mysql_fetch_array($sql))
									{
										echo "<option value=\"$codinfracao\""; if($codinfracao == $infracoes_codigo){echo "selected=selected";} echo ">$nroinfracao/$anoinfracao - $descricaoinfracao</option>";
									}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td valign="top">Histórico da infração:</td>
					<td><textarea class="texto" name="txtHistorico" rows="5" cols="50"><?php echo $autuacao_historico; ?></textarea></td>
				</tr>
				<tr>
					<td valign="top">Descrição da infração:</td>
					<td><textarea class="texto" name="txtDescricaoinfracao" id="txtDescricaoinfracao" rows="5" cols="50" readonly="readonly"><?php echo $infracoes_descricao; ?></textarea></td>
				</tr>
				<tr>
					<td valign="top">Fundamentação Legal:</td>
					<td><textarea class="texto" name="txtFundamentacao" id="txtFundamentacao" rows="5" cols="50" readonly="readonly"><?php echo $fundamentacaolegal; ?></textarea></td>
				</tr>
				</table>
				<div id="divAutoinfracao" style="display:<?php echo $div1; ?>">
					<table>
					<tr>
						<td>Reincidência?</td>
						<td>
							<select name="cmbReincidencia" class="combo">
								<option value="N" <?php if($aut_reincidencia == "N"){echo "selected=selected";} ?>>Não</option>
								<option value="S" <?php if($aut_reincidencia == "S"){echo "selected=selected";} ?>>Sim</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Quantidade de Reincidências:</td>
						<td><input type="text" class="texto" name="txtQTD" value="<?php if($aut_reincidencia == "S"){echo $aut_quantidade;}else{echo "0";} ?>" onkeypress="return SomenteNumeros(this)" />* Se houver Reincidência</td>
					</tr>
					<tr>
						<td>% de Multa de Reincidência:</td>
						<td><input type="text" class="texto" name="txtMulta" maxlength="5" <?php if($aut_reincidencia == "S"){echo "value=\"$aut_multa\"";}?> />* Se houver Reincidência</td>
					</tr>
					</tr>
					</table>
				</div>
				<div id="divNotificacao" style="display:<?php echo $div2; ?>">
					<table width="100%">
						<tr>
							<td valign="top">Compet&ecirc;ncias:</td>
						</tr>
						<tr>
							<td colspan="2" align="center">
								<table>
									<?php
									for($m=1;$m<=12;$m++){ // a $m serve para dizer o mes
										echo "<tr>";
										for($a=$ano;$a>=($ano-5);$a--){ //a $a serve para dizer o ano
											if(strlen($m) == 1) {$m="0".$m;}
											$comp_cont = "$a-$m";
											$sql_competencias = mysql_query("SELECT competencia FROM processosfiscais_competencias WHERE codautuacao = '$codautuacao' AND competencia = '$comp_cont'");
											?>
												<td>
													<input type="checkbox" name="ckb<?php echo $m."/".$a; ?>" value="<?php echo $m."/".$a; ?>" <?php if(mysql_num_rows($sql_competencias) != 0){echo "checked";} ?> /><?php echo $m."/".$a; ?>
												</td>
											<?php
										}//fim for, para Anos
										echo "</tr>";
									}//fim for, que calcula o mes e o ano da competencia.
									?>
								</table>
							</td>
						</tr>
					</table>
				</div>
	</fieldset>
	<fieldset style="margin-left:7px; margin-right:7px;">
		<input type="submit" name="btnConfirmar" value="Confirmar" class="botao" onclick="document.getElementById('txtAcao_frmAlterarDoc').value='documentosautuacao_alterar'" />
		<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_frmAlterarDoc').value='documentosautuacao'" />
		<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />				
		<input type="hidden" name="txtNroAutuacao" value="<?php echo $nroautuacao; ?>" />
		<input type="hidden" name="txtAnoAutuacao" value="<?php echo $anoautuacao; ?>" />
	</fieldset>
</form>
