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
	// recebe os dados do processo
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$acao=$_POST["txtAcao"];
	$sql=mysql_query("SELECT situacao FROM processosfiscais WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
	list($situacaoprocesso)=mysql_fetch_array($sql);
	
	// recebe os dados do formulario
	if($_POST["btInserir"]=="Inserir")
		{
			if($situacaoprocesso=="C")
				{
					Mensagem("Não é possível registrar novas dividas ativas pois o processo já foi concluído!");
				}
			else
				{	
					$codautuacao=$_POST["cmbDocumento"];
					$datainscricao = implode("-",array_reverse(explode("/",$_POST["txtDataInscricao"])));
					$datalimite = implode("-",array_reverse(explode("/",$_POST["txtDataLimite"])));
					$anodivida=$_POST["txtAno"];
					$observacoes=strip_tags(addslashes($_POST["txtObs"]));
					
					// busca o numero do ultimo registro e incrementa em 1
					$sql=mysql_query("SELECT MAX(nrodivida) FROM processosfiscais_dividaativa");
					list($nrodivida)=mysql_fetch_array($sql);
					$nrodivida++;
					
					//inseri os dados no banco
					mysql_query("INSERT INTO processosfiscais_dividaativa SET codautuacao='$codautuacao', nrodivida='$nrodivida', anodivida='$anodivida', datainscricao='$datainscricao', datalimite='$datalimite', observacoes='$observacoes'");
					add_logs('Inseriu uma Divida Pública');
					echo "<script>alert('Divida pública ativada com sucesso!')</script>";
				}
		}
	
	// busca o emissor
	$sql=mysql_query("SELECT cadastro.razaosocial
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($emissor)=mysql_fetch_array($sql);
?>
<fieldset><legend>Dívida Ativa</legend>
	<table>
		<tr>
			<td>Processo Fiscal: </td><td><?php echo $nroprocesso."/".$anoprocesso; ?></td>
		</tr>
		<tr>
			<td>Nome/Razão: </td><td><?php echo $emissor; ?></td>
		</tr>
	</table>
</fieldset>

<fieldset><legend>Inserir Dívida Ativa</legend>
	<?php
		$sql=mysql_query("SELECT codigo, nroautuacao, anoautuacao, titulo FROM processosfiscais_autuacoes WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso'");
		$result = mysql_num_rows($sql);
		if($result < 1)
			{
				echo "Nenhuma divida ativa pode ser cadastrada por que este processo fiscal não possuí nenhum documento de autuação cadastrado.";
			}
		else
			{	
	?>
	<form method="post">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao_divida" />
		<table width="100%">
			<tr>
				<td>Documento:</td>
				<td>
					<select name="cmbDocumento">
						<?php 
							while(list($codautuacao,$nroautuacao,$anoautuacao,$titulo)=mysql_fetch_array($sql))
								{
									echo "<option value=\"$codautuacao\">$nroautuacao/$anoautuacao $titulo</option>";
								}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Data da Inscrição:</td>
				<td><input type="text" class="texto" name="txtDataInscricao" value="<?php echo date("d/m/Y"); ?>" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>Data Limite:</td>
				<td><input type="text" class="texto" name="txtDataLimite" onkeypress="formatar(this, '00/00/0000')" maxlength="10" /></td>
			</tr>
			<tr>
				<td>Ano da Inscrição:</td>
				<td><input type="text" class="texto" name="txtAno" value="<?php echo date("Y"); ?>" readonly="readonly" /></td>
			</tr>
			<tr>
				<td>Observações:</td>
				<td><textarea rows="5" cols="25" class="texto" name="txtObs"></textarea></td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="botao" name="btInserir" value="Inserir" onclick="document.getElementById('txtAcao_divida').value='dividaativa'" />
					<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
				</td>
			</tr>
		</table>
</fieldset>
<fieldset><legend>Dívidas Ativas realizadas</legend>
	<?php
		$sql=mysql_query("SELECT processosfiscais_dividaativa.nrodivida, 
                          processosfiscais_dividaativa.anodivida,
                          processosfiscais_dividaativa.observacoes,
                          DATE_FORMAT(processosfiscais_dividaativa.datalimite, '%d/%m/%Y') AS datalimete,
                          processosfiscais_autuacoes.titulo
                          FROM processosfiscais_dividaativa
                          INNER JOIN processosfiscais_autuacoes
                          ON processosfiscais_dividaativa.codautuacao=processosfiscais_autuacoes.codigo
                          WHERE processosfiscais_autuacoes.nroprocesso='$nroprocesso'
                          AND processosfiscais_autuacoes.anoprocesso='$anoprocesso'");
		if(mysql_num_rows($sql)>0)
			{
				?>
				<table align="center" width="100%">
					<tr bgcolor="#999999">
						<td align="center">Número/Ano</td>
						<td align="center">Descrição</td>
                        <td align="center">Data Limite</td>
						<td align="center" width="50%">Observações</td>
					</tr>
					<?php
						while(list($nrodivida,$anodivida,$observacoes,$datalimite,$descricao)=mysql_fetch_array($sql))
							{
								echo "
									<tr bgcolor=\"#FFFFFF\">
										<td align=\"center\">$nrodivida/$anodivida</td>
										<td align=\"center\">$descricao</td>
                                        <td align=\"center\">$datalimite</td>
										<td align=\"center\">$observacoes</td>
									</tr>
								";
							}
					?>
				</table>
				<?php
			}	
		else{echo "Nenhuma divida ativa referente a este processo fiscal";}		
	?>
    </fieldset>
    <fieldset>
	<table align="center" width="100%">	
		<tr>
			<td align="left">
					<input type="submit" value="Voltar" name="btnVoltar" class="botao" onclick="document.getElementById('txtAcao_divida').value='detalhes';" />
					<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
					<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso"; ?>" />				
					<input type="hidden" name="contador" value="1" />
			</td>
		</tr>
	</table>
</form>    
	<?php } ?>
</fieldset>