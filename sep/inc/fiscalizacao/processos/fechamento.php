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
	$data = Date('Y-m-d');

		// ACIONA O BOTAO CONCLUIR, PEGA OS DADOS E ATUALIZA
			if($_POST["btFechar"] == "Concluir Processo")
				{
					$nroprocesso = $_POST["txtNroProcesso"];
					$anoprocesso = $_POST["txtAnoProcesso"];
					mysql_query("UPDATE processosfiscais 
                                 SET situacao='C',
                                 data_final='$data'
                                 WHERE anoprocesso='$anoprocesso'
                                 AND nroprocesso='$nroprocesso'");
					add_logs('Atualizou um Processo');
					Mensagem("Processo Atualizado");
				}
		// ACIONA O BOTAO ENVIAR, PEGA OS DADOS E ATUALIZA
		if($_POST["btObs"] == "Enviar")
				{
					$txtobs = $_POST["txtObs"];
					$anoprocesso = $_POST["txtAnoProcesso"];
					$nroprocesso = $_POST["txtNroProcesso"];
					mysql_query("UPDATE processosfiscais
                                 SET processosfiscais.observacoes = '$txtObs'
                                 WHERE processosfiscais.nroprocesso = '$nroprocesso'
                                 AND processosfiscais.anoprocesso = '$anoprocesso'");
					add_logs('Atualizou uma Observação de um Processo');
					Mensagem("Observações Alteradas com sucesso!");
				}
?>
<fieldset style="margin-left:10px; margin-right:10px;">
	<form method="post" id="frmFechamento">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<?php
			$sqlprocesso = mysql_query("SELECT cadastro.razaosocial,
                                        processosfiscais.observacoes
                                        FROM processosfiscais
                                        INNER JOIN cadastro
                                        ON processosfiscais.codemissor=cadastro.codigo
                                        WHERE processosfiscais.nroprocesso = '$nroprocesso'
                                        AND processosfiscais.anoprocesso='$anoprocesso'");
			while(list($razaosocial, $observacoes) = mysql_fetch_array($sqlprocesso)){ ?>
		<table>
			<tr>
				<td>Processo Fiscal:</td>
				<td><?php echo "$nroprocesso"; ?></td>
			</tr>
			<tr>
		   		<td>Nome/Raz&atilde;o:</td>
				<td><?php echo "$razaosocial"; ?></td>
		  	</tr>
			<tr>
				<td>Data de Abertura: </td>
				<td><?php echo "$anoprocesso"; ?></td>
		  	</tr>
		  	<tr>
				<td><input type="submit" name="btFechar" class="botao" value="Concluir Processo" onclick="document.getElementById('txtAcao_fechamento').value='fechamento'; return Confirma('Deseja Fechar esse Processo?')" /></td>
			</tr>
		  		
		</table>
	<br /><br />
	<table>
		<tr>
			<td valign="top">Observa&ccedil;&atilde;o:</td>
			<td align="left"><textarea name="txtObs" rows="5" cols="40" class="texto"><?php echo "$observacoes"; ?></textarea></td>
		</tr>
		<tr>
			<td align="left"><input name="btVoltar" type="submit" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_fechamento').value='detalhes'" /></td>
			<td align="left"><input type="submit" name="btObs" id="btObs" class="botao" value="Enviar" onclick="document.getElementById('txtAcao_fechamento').value='fechamento'" /></td>
		</tr>
	</table>
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_fechamento" />
	<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
	<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	<input type="hidden" name="txtNroProcesso0" value="<?php echo $nroprocesso; ?>" />
	<input type="hidden" name="txtAnoProcesso0" value="<?php echo $anoprocesso; ?>" />				
	<input type="hidden" name="contador" value="1" />				
	</form>
</fieldset>
<?php } // FIM DO WHILE ?>