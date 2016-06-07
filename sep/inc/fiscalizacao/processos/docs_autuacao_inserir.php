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
if($_POST["btnConfirmar"] == "Confirmar") {
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
<form method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao" value="documentosautuacao_inserir_autoinfracao" />
	<fieldset style="margin-left:7px; margin-right:7px;">
			<table>
				<tr>
					<td>Tipo doc:</td>
					<td>
						<select name="cmbTipodoc" class="combo" onchange="submit()">
							<option>==Selecione==</option>
							<option value="A">Auto de Infração</option>
							<option value="N">Notificação</option>
						</select>					
					</td>
				</tr>
			</table>
	</fieldset>
	<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
</form>
<fieldset style="margin-left:7px; margin-right:7px;">
	<form method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="documentosautuacao" />
		<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
		<input name="btnVoltar" value="Voltar" type="submit" class="botao" />
	</form>
</fieldset>
