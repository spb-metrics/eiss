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
	$sql = mysql_query("SELECT cadastro.razaosocial
                        FROM cadastro
                        INNER JOIN processosfiscais
                        ON cadastro.codigo = processosfiscais.codemissor
                        WHERE processosfiscais.nroprocesso = '$nroprocesso'
                        AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($razaosocial) = mysql_fetch_array($sql);
	$sql = mysql_query("SELECT processosfiscais_autuacoes.nroautuacao, 
                        processosfiscais_autuacoes.anoautuacao,
                        processosfiscais_infracoes.nroinfracao,
                        processosfiscais_infracoes.anoinfracao,
                        processosfiscais_autuacoes.tiposervico,
                        processosfiscais_autuacoes.titulo,
                        processosfiscais_autuacoes.obrigacao,
                        processosfiscais_autuacoes.valor,
                        processosfiscais_autuacoes.situacao,
                        processosfiscais_autuacoes.cancelado
                        FROM processosfiscais_autuacoes
                        INNER JOIN processosfiscais_infracoes
                        ON processosfiscais_autuacoes.codinfracao = processosfiscais_infracoes.codigo
                        WHERE processosfiscais_autuacoes.nroprocesso = '$nroprocesso'
                        AND processosfiscais_autuacoes.anoprocesso = '$anoprocesso'
                        ORDER BY processosfiscais_autuacoes.anoautuacao, processosfiscais_autuacoes.nroautuacao");
?>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Documentos de Autuação</legend>
	<table>
		<tr>
			<td>Processo Fiscal:</td>
			<td><?php echo"$nroprocesso/$anoprocesso - $razaosocial" ?></td>
		</tr>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;">
	<form method="post">
		<table width="100%" align="center">
			<tr>
				<td>
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao" value="documentosautuacao_inserir" />
				<input type="submit" name="btnInclude" value="Incluir" class="botao" />
				<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
                <input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
				</td>
			</tr>
		</table>
	</form>
	<form method="post" id="frmDocs">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_frmDocs" />
	<?php 
	if(mysql_num_rows($sql) > 0) {		
		?>
		<table width="100%" align="center">
			<tr bgcolor="#999999">
				<td align="center">Documento</td>
				<td align="center">Infração</td>
				<td align="center">Tipo de Serviço</td>
				<td align="center">Descrição</td>
				<td align="center">Obrigação</td>
				<td align="center">Valor</td>
				<td align="center">Situação</td>
				<td align="center">Cancelado</td>
				<td align="center">Ações</td>
			</tr>
		<?php
		while(list($nroautuacao, $anoautuacao, $nroinfracao, $anoinfracao, $tiposervico, $tituloautuacao, $tipoobrigacao, $valorautuacao, $situacaoautuacao, $cancelado) = mysql_fetch_array($sql)) {
		
		switch($tiposervico){
		case "P": $tiposervico = "Prestado" ; break;
		case "T": $tiposervico = "Tomado" ; break;
		}
		switch($tipoobrigacao){
		case "P": $tipoobrigacao = "Principal" ; break;
		case "A": $tipoobrigacao = "Acessória" ; break;
		}
 		switch($situacaoautuacao){
		case "E": $situacaoautuacao = "Emitido" ; break;
		case "N": $situacaoautuacao = "Não Emitido" ; break;
		}
		switch($cancelado){
		case "A": $cancelado = "Aberto" ; break;
		case "C": $cancelado = "Cancelado" ; break;
		}
		if($valorautuacao > 0){
		$valorautuacao = number_format($valorautuacao,"2",",",".");  
		}


		print("<tr  height=\"25\" bgcolor='#FFFFFF'>
			<td align=\"center\">$nroautuacao/$anoautuacao</td>
			<td align=\"center\">$nroinfracao/$anoinfracao</td>
			<td align=\"center\">$tiposervico</td>
			<td align=\"center\">$tituloautuacao</td>
			<td align=\"center\">$tipoobrigacao</td>
			<td align=\"center\">$valorautuacao</td>
			<td align=\"center\">$situacaoautuacao</td>
			<td align=\"center\">$cancelado</td>
			<td><input type=\"submit\" name=\"btnDetalhes\" value=\"detalhes\" class=\"botao\" onClick=\"document.getElementById('txtNroAutuacao').value='$nroautuacao'; document.getElementById('txtAnoAutuacao').value='$anoautuacao'; document.getElementById('txtAcao_frmDocs').value='visualizarautuacao'\"/></td>
		</tr>
		");
		
		}//fim while
		echo "<input type=\"hidden\" name=\"txtNroAutuacao\" id=\"txtNroAutuacao\" value=\"echo $nroautuacao\" />";
		echo "<input type=\"hidden\" name=\"txtAnoAutuacao\" id=\"txtAnoAutuacao\" value=\"echo $anoautuacao\" />";
	}//fim if
	else{
	?>
    <table width="100%" align="center">
		<tr bgcolor="#FFFFFF">
			<td colspan="8">Nenhum Documento de Autuação cadastrado para esse Processo.</td>
		</tr>
	<?php 
	}//fim else
	?>
	</table>
		<table align="center" width="100%">
			<tr>
				<td align="left">
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_frmDocs').value='detalhes'" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso"; ?>" />				
					<input type="hidden" name="contador" value="1" />				
				</td>
			</tr>
		</table>
	</form>
</fieldset>