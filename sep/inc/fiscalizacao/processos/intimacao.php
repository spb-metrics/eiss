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
	// RECEBE OS DADOS
	$nroprocesso = $_POST["txtNroProcesso"];
	$anoprocesso = $_POST["txtAnoProcesso"];
	
	//seleciona os dados das intimacaoes existentes
	$sql=mysql_query("SELECT 
					processosfiscais_intimacoes.codigo,
					processosfiscais_intimacoes.nrointimacao,
					processosfiscais_intimacoes.anointimacao, 
					processosfiscais_intimacoes.dataemissao, 
					processosfiscais_intimacoes.prazo, 
					processosfiscais_intimacoes.situacao, 
					processosfiscais_intimacoes.observacoes 
					FROM 
					processosfiscais_intimacoes
					WHERE 	processosfiscais_intimacoes.nroprocesso = '$nroprocesso' AND 
							processosfiscais_intimacoes.anoprocesso = '$anoprocesso' AND
							processosfiscais_intimacoes.cancelado = 'N'");
	
	// COLOCA EM UMA VARIAVEL AS LINHAS AFETADAS
	$totalint = mysql_num_rows($sql);
	
	//pega os dados do processo
	$sqlproc = mysql_query("
	SELECT cadastro.razaosocial, processosfiscais.situacao
	FROM cadastro
	INNER JOIN processosfiscais ON processosfiscais.codemissor = cadastro.codigo
	WHERE processosfiscais.nroprocesso = '$nroprocesso' AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($razaosocial, $situacaoprocesso) = mysql_fetch_array($sqlproc);
?>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Intimações</legend>
	<table width="100%">
		 <tr>
			  <td width="100">Processo Fiscal:</td>
			  <td align="left"><?php echo "[ $nroprocesso/$anoprocesso ] $razaosocial"; //PUXA O NOME E EXIBE NA PAGINA A INFORMACAO ?></td>
		 </tr>
	</table>
</fieldset>
<fieldset style="margin-left:7px; margin-right:7px;"><legend>Lista de Intimações</legend>
	<form id="frmDetalhes" method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="intimacao_detalhes" />
		<input type="hidden" name="txtIntimacao" id="txtIntimacao" />
		<input type="hidden" name="txtNroProcesso" id="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
		<input type="hidden" name="txtAnoProcesso" id="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
		<table width="100%">
		<?php
			if(mysql_num_rows($sql)!=0)
			{ ?>
		 <tr bgcolor="#FFFFFF">
		  <td colspan="6" align="center">Intimações encontradas: <?php print $totalint; //EXIBE O TOTAL DE INTIMACOES DO BANCO?></td>
		 </tr>
		 <tr bgcolor="#999999">
		  <td align="center" width="60">Intimação</td>
		  <td align="center" width="80">Dt. Emissão</td>
		  <td align="center" width="30">Prazo</td>
		  <td align="center" width="55">Situação</td>
		  <td align="center">Observações</td>
		  <td align="center" width="70">Ações</td>
		 </tr>
	<?php 
			while(list($codintimacao, $nrointimacao, $anointimacao, $dataemissao, $prazo, $situacao, $observacoes) = mysql_fetch_array($sql)){
				//RENOMEIA A VARIAVEL SITUACAO
				switch($situacao){
					case 'A': $situacao = "Aberto"; break;
					case 'C': $situacao = "Concluído"; break;
				}
				//TRANSFORMA A DATA PARA O PADRAO
				$dataemissao = DataPt($dataemissao);
				?>
				
					<tr bgcolor='#FFFFFF'>
						<td align="center"><?php echo "$nrointimacao/$anointimacao"?></td>
						<td align="center"><?php echo "$dataemissao"?></td>
						<td align="center"><?php echo "$prazo"?></td>
						<td align="center"><?php echo "$situacao"?></td>
						<td align="center"><?php echo "$observacoes"?></td>
						<td><input type="submit" name="btnDetalhes" value="Detalhes" class="botao" onclick="document.getElementById('txtIntimacao').value='<?php echo "$codintimacao";?>';" /></td>
					</tr>
					<?php
			} //FIM DO WHILE
			}else{ // fim if se tem resustados
	?>
		<tr>
		 <td>Nenhuma Intimação cadastrada para esse Processo. </td>
		</tr>
			<?php } //fim else se nao tem resustados ?>
		</table>
	</form>
	<form method="post" id="frmVoltar">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao_intimacao" />
		<table align="center" width="100%">
			<tr>
				<td align="left">
					<?php
					if($situacaoprocesso == "A"){//se o processo estiver fechado nao pode cadastrar mais intimação
					?>
						<input type="submit" name="btnCadastrar" value="Cadastrar Intimação" class="botao" onclick="document.getElementById('txtAcao_intimacao').value='inserir_intimacao'" />
					<?php
					}?>
					<input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_intimacao').value='detalhes'" />
					<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />				
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
					<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
				</td>
			</tr>
		</table>
	</form>
</fieldset>