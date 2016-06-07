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
	
	//seleciona todas as informacoes do processo fiscal, é muito relacionamento de tabelas, por isso é grande. -.-
	$sql = mysql_query("SELECT processosfiscais.codemissor, processosfiscais.nroprocesso, processosfiscais.anoprocesso,
 processosfiscais.abertura, processosfiscais.data_abertura, processosfiscais.data_inicial, processosfiscais.data_final, 
 processosfiscais.observacoes, cadastro.razaosocial, processosfiscais.codigo
FROM processosfiscais 
 INNER JOIN cadastro ON processosfiscais.codemissor = cadastro.codigo
WHERE processosfiscais.nroprocesso = '$nroprocesso' AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($codemissor, $nroproc, $anoproc, $abertura, $dataabertura, $datainicial, $datafinal, $observacoes, $razaosocial, $codprocesso) = mysql_fetch_array($sql);
	
	$dataabertura=DataPt($dataabertura);
	$datainicial=DataPt($datainicial);
	$datafinal=DataPt($datafinal);
	
	$sql = mysql_query("SELECT servicos_categorias.nome
                        FROM servicos_categorias
                        INNER JOIN servicos ON servicos.codcategoria=servicos_categorias.codigo
                        INNER JOIN cadastro_servicos ON cadastro_servicos.codservico=servicos.codigo
                        INNER JOIN cadastro ON cadastro.codigo=cadastro_servicos.codemissor
                        WHERE cadastro.codigo ='$codemissor'
                        GROUP BY servicos_categorias.nome
                        ORDER BY servicos_categorias.nome"); 
//<link href="../../css/padrao_prefeitura.css" rel="stylesheet" type="text/css">
 
?>

<fieldset style="margin-left:7px; margin-right:7px;">
<legend>Informa&ccedil;&atilde;o do Processo Fiscal</legend>
	<table align="left" width="100%">
		<tr>
			<td>Processo Fiscal:</td>
			<td><?php echo $nroproc."/".$anoproc; ?></td>
		</tr>
		<tr>
			<td>Atividade:</td>
			<td><?php 
				while(list($nomecategoria)=mysql_fetch_array($sql))
					{
						//junta todos os resultados numa string, separando por virgula
						$string.=$nomecategoria.", ";
					}
				//remove a ultima virgula
				$string=substr($string, 0, -2);
				echo $string;	
			?></td>
		</tr>
		<tr>
			<td>Nome/Razao Social:</td>
			<td><?php echo $razaosocial; ?></td>
		</tr>
		<tr>
			<td>Data de Abertura:</td>
			<td><?php echo $dataabertura; ?></td>
		</tr>
		<tr>
			<td>Situação:</td>
			<td><?php 
					switch($abertura){
						case "I": $abertura = "Iniciada"; break;
						case "G": $abertura = "Geral"; break;
					}
					echo $abertura; 
				?>
			</td>
		</tr>
		<tr>
			<td>Periodo Fiscalizado:</td>
			<td><?php echo $datainicial ." &Agrave; ". $datafinal ?></td>
		</tr>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Fiscais</legend>
	<?php 	
		$sql = mysql_query("SELECT processosfiscais_fiscais.codfiscal, fiscais.nome FROM processosfiscais_fiscais INNER JOIN fiscais ON processosfiscais_fiscais.codfiscal = fiscais.codigo WHERE processosfiscais_fiscais.codprocesso ='$codprocesso' AND fiscais.estado = 'A' ORDER BY fiscais.nome");
		if(mysql_num_rows($sql) > 0){
	?>
	<table width="100">
		<tr align="center">
			<td>Matr&iacute;cula</td>
			<td>Nome</td>
		</tr>
		<?php 
		while(list($codfiscal, $nomefiscal) = mysql_fetch_array($sql)){
			echo "
				<tr align=\"center\">
					<td>$codfiscal</td>
					<td>$nomefiscal</td>
				</tr>
				";
		}//fim while
		}//fim if
		else{echo "<table><tr><td colspan= \"2\">Nenhum Fiscal Cadastrado para esse Processo.</td><tr>";
		}//fim else
		?>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;">
<legend>Informa&ccedil;&otilde;es do Termo de In&iacute;cio</legend>
	<table align="left">
		<?php		
			$sql = mysql_query("SELECT nrotif, anotif, datainicial, datafinal FROM processosfiscais_tif WHERE nroprocesso = '$nroprocesso' AND anoprocesso = '$anoprocesso'");
			if(mysql_num_rows($sql) > 0){
		?>
		<tr>
			<td>Termo de In&iacute;cio:</td>
				<?php 
					list($tifnumero, $anotif, $tifdatainicial, $tifdatafinal) = mysql_fetch_array($sql);
						echo "<td>$tifnumero/$anotif</td>";
						 $tifdatafinal = DataPt($tifdatafinal);
						 $tifdatainicial = DataPt($tifdatainicial);
				?>
		</tr> 
		<tr>
			<td>Per&iacute;odo de fiscaliza&ccedil;&atilde;o: </td>
			<?php echo
				"<td>$tifdatainicial &Agrave; $tifdatafinal</td>"
			?>
		</tr>
		<tr>
			<td><form method="post" action="inc/fiscalizacao/processos/tif_imprimir.php" target="_blank">
					<input type="submit" class="botao" name="btImprimir" value="Imprimir"/>
					<input type="hidden" name="txtNro" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAno" value="<?php echo $anotif; ?>" />
				</form></td>
		</tr>
	</table>
	<?php 
					}//if
					else{echo "<table><tr><td>Termo de In&iacute;cio n&atilde;o Cadastrado para esse Processo.</tr></td></table>";
					}//fim if
	
	?>
</fieldset>
<form method="post">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao" value="intimacao_detalhes" />
	<fieldset style="margin-left:7px; margin-right:7px;"><legend>Informa&ccedil;&otilde;es das Intima&ccedil;&otilde;es </legend>
		<?php 
		$sqlintimacao = mysql_query("SELECT codigo, nrointimacao, anointimacao, dataemissao, prazo, situacao FROM processosfiscais_intimacoes WHERE nroprocesso = '$nroprocesso' AND anoprocesso = '$anoprocesso' AND cancelado = 'N' ORDER BY anointimacao, nrointimacao");
		if(mysql_num_rows($sqlintimacao) > 0){
		?>
		<table width="100%" align="left">
			<tr>
				<td>Intima&ccedil;&atilde;o</td>
				<td>Emiss&atilde;o</td>
				<td>Prazo</td>
				<td>Situa&ccedil;&atilde;o</td>
				<td>Documentos</td>
			</tr>
			<?php 
				while(list($codintimacao, $nrointimacao, $anointimacao, $dataemissaointimacao, $prazointimacao, $situacaointimacao) = mysql_fetch_array($sqlintimacao)){
				$dataemissaointimacao = implode("/", array_reverse(explode("-", $dataemissaointimacao)));
				switch($situacaointimacao){
					case "A": $situacaointimacao = "Aberta" ; break;
					case "C": $situacaointimacao = "Conclu&iacute;do"; break;
				}
	
				echo "
					<tr>
						<td>$nrointimacao/$anointimacao</td>
						<td>$dataemissaointimacao</td>
						<td>$prazointimacao</td>
						<td>$situacaointimacao</td>
						<td><input type=\"submit\" name=\"btnDetalhes\" value=\"detalhes\" class=\"botao\" onClick=\"txtIntimacao.value='$codintimacao';\"/></td>
					</tr>
				";}
			}//if
			else{echo "<table><tr><td>Nenhuma Intima&ccedil;&atilde;o Cadastrada para esse Processo.</tr></td>";
			}//fim if
			?>
			<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
			<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
			<input type="hidden" name="txtIntimacao"  value="<?php echo $codintimacao; ?>"/>
		</table>
	</fieldset>
	<fieldset style="margin-left:7px; margin-right:7px;"><legend>Infoma&ccedil;&otilde;es dos Documentos de Autua&ccedil;&atilde;o </legend>
		<?php 	
		$sql_autuacao = mysql_query("SELECT nroautuacao, anoautuacao, titulo, obrigacao, valor FROM processosfiscais_autuacoes WHERE nroprocesso ='$nroprocesso' AND anoprocesso = '$anoprocesso' ORDER BY anoautuacao, nroautuacao");
		if(mysql_num_rows($sql_autuacao) > 0){
		?>
		<table align="left" width="100%">
			<tr>
				<td>Documento</td>
				<td>Descri&ccedil;&atilde;o</td>
				<td>Tipo Obriga&ccedil;&atilde;o </td>
				<td>R$</td>
			</tr>
			<?php 
				while(list($autuacao_nro, $autuacao_ano, $autuacao_descricao, $autuacao_obrigacao, $autuacao_valor) = mysql_fetch_array($sql_autuacao))
				{
					switch($autuacao_obrigacao)
					{
						case "P": $autuacao_obrigacao = "Principal"; break;
						case "A"; $autuacao_obrigacao = "Acess&oacute;ria"; break;
					}
					
					switch($autuacao_valor)
					{
						case "": $autuacao_valor = "Não Emitida"; break;
						case $autuacao_valor = $autuacao_valor; break;
					}
					
					echo "
						<tr>
							<td>$autuacao_nro/$autuacao_ano</td>
							<td>$autuacao_descricao</td>
							<td>$autuacao_obrigacao</td>
							<td>$autuacao_valor</td>
						</tr>
				";}//fim while
			?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<?php
		}//if
		else{echo "<table><tr><td colspan= \"2\">Nenhum Documento de Autua&ccedil;&atilde;o Cadastrado para esse Processo.</td><tr></table>";
		}//fim if
		?>
	</fieldset>
</form>
<fieldset style="margin-left:7px; margin-right:7px;">
	<form method="post">
		<table>
			<tr>
				<td>
					<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
					<input type="hidden" name="txtAcao" id="txtAcao" value="detalhes" />
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso"; ?>" />				
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
					<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
				</td>
			</tr>
		</table>
	</form>
</fieldset>