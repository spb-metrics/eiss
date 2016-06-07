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
	$nroprocesso 	= $_POST["txtNroProcesso"];
	$anoprocesso 	= $_POST["txtAnoProcesso"];
	$codintimacao 	= $_POST["txtIntimacao"];

	if($_POST["btConcluirIntimacao"]=="Concluir")
		{
			mysql_query("UPDATE processosfiscais_intimacoes SET situacao='C' WHERE codigo='$codintimacao'");
			add_logs('Atualizou uma Intimação: Concluída');		
			Mensagem("Intimação concluída!");
		}
	elseif($_POST["btnCancelar"])
		{
			mysql_query("UPDATE processosfiscais_intimacoes SET cancelado = 'S' WHERE codigo = '$codintimacao'");
			add_logs('Atualizou uma Intimação: Cancelada');		
			Mensagem("Intimação Cancelada!");
		}
	
	//pega a razao social da empresa
	$sqlproc = mysql_query("
	SELECT cadastro.razaosocial
	FROM cadastro
	INNER JOIN processosfiscais ON processosfiscais.codemissor = cadastro.codigo
	WHERE processosfiscais.nroprocesso = '$nroprocesso' AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($razaosocial) = mysql_fetch_array($sqlproc);
	
	$sql = mysql_query("SELECT nrointimacao, anointimacao, dataemissao, prazo, situacao, observacoes, codlegislacao, cancelado FROM processosfiscais_intimacoes WHERE codigo = '$codintimacao'");
	list($nrointimacao, $anointimacao, $dataemissao, $prazointimacao, $situacao, $observacoes, $codlei, $intimacaocancelada) = mysql_fetch_array($sql);
	$sql_lei = mysql_query("SELECT titulo FROM legislacao WHERE codigo = '$codlei'");
	list($legislacao) = mysql_fetch_array($sql_lei);
	$dataemissao = dataPt("$dataemissao");
	switch($situacao){
		case 'A': $situacao = "Aberto"; break;
		case 'C': $situacao = "Concluído"; break;
	}
?>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Intimação</legend>
	<table>
		 <tr>
			  <td>Processo Fiscal:</td>
			  <td align="left"><?php echo "[ $nroprocesso/$anoprocesso ] $razaosocial"; //PUXA O NOME E EXIBE NA PAGINA A INFORMACAO ?></td>
		 </tr>
		<tr>
			<td>Número da intimação:</td>
			<td><?php echo "$nrointimacao/$anointimacao"; if($intimacaocancelada == "S"){echo " - Intimação Cancelada";}?></td>
		</tr>
		<tr>
			<td>Data de Emissão:</td>
			<td><?php echo $dataemissao; ?></td>
		</tr>
		<tr>
			<td>Observações:</td>
			<td><?php echo $observacoes; ?></td>
		</tr>
		<tr>
			<td>Dias de Prazo:</td>
			<td><?php echo $prazointimacao; ?></td>
		</tr>
		<tr>
			<td>Legislação:</td>
			<td><?php echo $legislacao; ?></td>
		</tr>
		<tr>
			<td>Situação:</td>
			<td><?php echo $situacao; ?></td>
		</tr>
		<tr>
			<td valign="top">Documentos Solicitados:</td>
			<td>
				<?php  
				//seleciona os documentos solicitados na intimação.
				$sqldocs = mysql_query("
										SELECT processosfiscais_docs.nrodoc, processosfiscais_docs.descricao 
										FROM processosfiscais_docs 
										INNER JOIN processosfiscais_intimacoes_docs ON processosfiscais_intimacoes_docs.coddoc = processosfiscais_docs.codigo
										INNER JOIN processosfiscais_intimacoes ON processosfiscais_intimacoes.codigo = processosfiscais_intimacoes_docs.codintimacao
										WHERE processosfiscais_intimacoes.codigo = '$codintimacao'
										ORDER BY processosfiscais_docs.nrodoc
										");
				while(list($doc_nro,$doc_descricao) = mysql_fetch_array($sqldocs)){
					echo "$doc_nro - $doc_descricao<br>";
				}
				?>
			</td>
		</tr>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;">
	<table>
    	<tr>
			<td>
                <form method="post" id="form" target="_blank" action="inc/fiscalizacao/processos/intimacao_imprimir.php">
                    <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                    <input type="hidden" name="txtAcao" id="txtAcao" value="intimacao" />
                    <input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="cancelaAction('form','','_parent')" />
                    <input type="submit" name="btnImprimir" value="Imprimir" class="botao" />
                    <input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
                    <input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
                    <input type="hidden" name="txtIntimacao" value="<?php echo "$codintimacao"; ?>" />
                </form>
            </td>
            <td>
                <form method="post" onsubmit="return Confirma('Deseja Cancelar essa Intimação?')">
                    <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                    <input type="hidden" name="txtAcao" id="txtAcao" value="intimacao_detalhes" />
                    <input type="submit" name="btnCancelar" value="Cancelar Intimação" class="botao" />
                    <input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
                    <input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
                    <input type="hidden" name="txtIntimacao" value="<?php echo "$codintimacao"; ?>" />
                </form>
            </td>
            <td>
                <form method="post" onsubmit="return Confirma('Deseja Concluir essa Intimação?')">
                    <input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
                    <input type="hidden" name="txtAcao" id="txtAcao" value="intimacao_detalhes" />
                    <input type="submit" class="botao" name="btConcluirIntimacao" value="Concluir" />
                    <input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
                    <input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
                    <input type="hidden" name="txtIntimacao" value="<?php echo $codintimacao; ?>" />
                </form>
			</td>
		</tr>
	</table>
</fieldset>