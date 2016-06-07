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
	
	var url='inc/fiscalizacao/processos/descricao_infracao_ajax.php?valor='+campo.value;
	
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

</script>

<?php
$nroprocesso  		= $_POST["txtNroProcesso"];
$anoprocesso  		= $_POST["txtAnoProcesso"];
$tipoautuacao 		= $_POST["cmbTipodoc"];
$tipo_autuacao 		= $_POST["cmbTipodoc"];
$historicoautuacao 	= $_POST["txtHistorico"];
$descricaoinfracao 	= $_POST["txtDescricaoinfracao"];
$funtamentacao 		= $_POST["txtFundamentacao"];
$reincidencia		= $_POST["cmbReincidencia"];
$qtdautuacao		= $_POST["txtQTD"];
$multaautuacao		= $_POST["txtMulta"];
$codinfracao		= $_POST["cmbCodinfracao"];
$valor				= $_POST["txtValor"];
$ano = Date("Y");
switch($tipoautuacao){
	case "A": $tipoautuacao = "Auto de Infração"; break;
	case "N": $tipoautuacao = "Notificação"; break;
}
if($_POST["btnConfirmar"] == "Confirmar") {
	if($codinfracao == 0){
		Mensagem("Selecione uma infração");
	}else{
	if($_POST["txtValor"]==""){
		Mensagem("Digite um valor para a autuação");
	}else{
	$anoautuacao 		= date("Y");
	$nroautuacao 		= mysql_query("SELECT MAX(processosfiscais_autuacoes.nroautuacao) FROM processosfiscais_autuacoes WHERE processosfiscais_autuacoes.anoautuacao = '$anoautuacao'");
	list($nroautuacao) = mysql_fetch_array($nroautuacao);
	$nroautuacao++;
	
	$valor   = MoedaToDec($valor);
	$multaautuacao   = MoedaToDec($multaautuacao);
	mysql_query("
	INSERT INTO processosfiscais_autuacoes 
	SET processosfiscais_autuacoes.nroautuacao = '$nroautuacao', 
	processosfiscais_autuacoes.anoautuacao = '$anoautuacao', 
	processosfiscais_autuacoes.nroprocesso = '$nroprocesso', 
	processosfiscais_autuacoes.anoprocesso = '$anoprocesso', 
	processosfiscais_autuacoes.codinfracao = '$codinfracao', 
	processosfiscais_autuacoes.titulo = '$tipoautuacao', 
	processosfiscais_autuacoes.historico = '$historicoautuacao', 
	processosfiscais_autuacoes.reincidencia = '$reincidencia', 
	processosfiscais_autuacoes.quantidade = '$qtdautuacao', 
	processosfiscais_autuacoes.multa = '$multaautuacao',
	processosfiscais_autuacoes.valor = '$valor'");
	add_logs('Inseriu um documento com Autuação');
	
	$codautuacao		= mysql_query("SELECT MAX(codigo) FROM processosfiscais_autuacoes");
	list($codautuacao)	= mysql_fetch_array($codautuacao);
	$contcomp=0; //usado para contar quantas competencias foram adicionadas
	if($tipo_autuacao == "A"){
		Mensagem("Documento de autuação cadastrada com o Código: $nroautuacao/$anoautuacao");
	}
	else{
		mysql_query("UPDATE processosfiscais_autuacoes SET reincidencia = NULL, quantidade = NULL, multa = NULL WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
		for($m=1;$m<=12;$m++){
			for($a=$ano;$a>=($ano-5);$a--){
						if(strlen($m) == 1) {$m="0".$m;}
						$competencia = $_POST["ckb".$m."/".$a];
						$codcompetencia = "$a-$m";
						if($competencia){
							mysql_query("INSERT INTO processosfiscais_competencias SET codautuacao = '$codautuacao', competencia = '$codcompetencia'");
							$contcomp++;
						}
			}//fim for, para Anos
		}//fim for, que grava no banco o mes e o ano das competencias selecionadas.
		add_logs('Atualizou uma Autuação com respectivo código e ano');
		Mensagem("Documento de autuação cadastrada com o Código: $nroautuacao/$anoautuacao, e foram selecionadas $contcomp competencias");
	}
	?>
	<form method="post" id="form">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="visualizarautuacao" />
		<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
		<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
	</form>
	<script>document.getElementById('form').submit();</script>
<?php }//fim else
	}//fim if de submit
}
$sql = mysql_query("SELECT cadastro.razaosocial
                    FROM cadastro
                    INNER JOIN processosfiscais
                    ON cadastro.codigo = processosfiscais.codemissor
                    WHERE processosfiscais.nroprocesso = '$nroprocesso'
                    AND processosfiscais.anoprocesso = '$anoprocesso'");
list($razaosocial) = mysql_fetch_array($sql);
?>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Documentos de Autuação</legend>
	<table>
		<tr>
			<td>Processo Fiscal:</td>
			<td><?php echo"$nroprocesso/$anoprocesso - $razaosocial" ?></td>
		</tr>
	</table>
</fieldset>
<form method="post" id="frmInserirDoc">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_autoinfracao" />
	<fieldset style="margin-left:7px; margin-right:7px;">
			<table width="100%">
				<tr>
					<td>Tipo doc:</td>
					<td><?php echo "$tipoautuacao"; ?></td>
				</tr>
				<tr>
					<td>Número/Ano da Infração:</td>
					<td>
						<select name="cmbCodinfracao" id="cmbCodinfracao" class="combo" onchange="ConsultaInfracao(this);">
							<option value="0">==SELECIONE==</option>
							<?php
								$sql=mysql_query("SELECT codigo, nroinfracao, anoinfracao, tituloinfracao FROM processosfiscais_infracoes");
								while(list($codinfracao, $nroinfracao, $anoinfracao, $descricaoinfracao) = mysql_fetch_array($sql))
									{
										echo "<option value=\"$codinfracao\">$nroinfracao/$anoinfracao - $descricaoinfracao</option>";
									}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td valign="top">Histórico da infração:</td>
					<td><textarea class="texto" name="txtHistorico" rows="5" cols="50"></textarea></td>
				</tr>
				<tr>
					<td valign="top">Descrição da infração:</td>
					<td><textarea class="texto" name="txtDescricaoinfracao" id="txtDescricaoinfracao" rows="5" cols="50" readonly="readonly"></textarea></td>
				</tr>
				<tr>
					<td valign="top">Fundamentação Legal:</td>
					<td><textarea class="texto" name="txtFundamentacao" id="txtFundamentacao" rows="5" cols="50" readonly="readonly"></textarea></td>
				</tr>
                <tr>
                	<td>Valor da Autuação:</td>
                    <td><input type="text" class="texto" name="txtValor" id="txtValor" onkeypress="MaskMoeda();" maxlength="15"/></td>
                </tr>
				<?php 
				if($tipo_autuacao == "A"){
				?>
				<tr>
					<td>Reincidência?</td>
					<td>
						<select name="cmbReincidencia" class="combo">
							<option value="N">Não</option>
							<option value="S">Sim</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Quantidade de Reincidências:</td>
					<td><input type="text" class="texto" name="txtQTD" value="0" onkeypress="return SomenteNumeros(this)" />* Se houver Reincidência</td>
				</tr>
				<tr>
					<td>% de Multa de Reincidência:</td>
					<td><input type="text" class="texto" name="txtMulta" maxlength="5" />* Se houver Reincidência</td>
				</tr>
				<?php 
				}//fim if, serve para o auto de infracao com reincidencia
				elseif($tipo_autuacao == "N"){
				?>
					<tr>
						<td valign="top">Compet&ecirc;ncias:</td>
					</tr>
					<tr>
						<td colspan="2" align="right">
							<table>
								<?php
								for($m=1;$m<=12;$m++){ // a $m serve para dizer o mes
									echo "<tr>";
									for($a=$ano;$a>=($ano-5);$a--){ //a $a serve para dizer o ano
										?>
											<td>
												<input type="checkbox" name="ckb<?php if(strlen($m) == 1) {$m="0".$m;} echo $m."/".$a; ?>" value="<?php echo $m."/".$a; ?>" /><?php echo $m."/".$a; ?>
											</td>
										<?php
									}//fim for, para Anos
									echo "</tr>";
								}//fim for, que calcula o mes e o ano da competencia.
								?>
							</table>
						</td>
				<?php 
				}//fim else if, serve se for notificação.
				?>
			</table>
	</fieldset>
	<fieldset style="margin-left:7px; margin-right:7px;">
		<input type="submit" name="btnConfirmar" value="Confirmar" class="botao" onclick="document.getElementById('txtAcao_autoinfracao').value='documentosautuacao_inserir_autoinfracao'" />
		<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_autoinfracao').value='documentosautuacao_inserir'" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
		<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
		<input type="hidden" name="cmbTipodoc" value="<?php echo $tipo_autuacao; ?>" />
	</fieldset>
</form>
