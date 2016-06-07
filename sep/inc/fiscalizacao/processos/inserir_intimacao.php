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

//pega os dados do emissor
$sqlproc = mysql_query	("
						SELECT cadastro.razaosocial
						FROM cadastro
						INNER JOIN processosfiscais ON processosfiscais.codemissor = cadastro.codigo
						WHERE processosfiscais.nroprocesso = '$nroprocesso' AND processosfiscais.anoprocesso = '$anoprocesso'
						");
list($razaosocial) = mysql_fetch_array($sqlproc);

$sqllegislacao = mysql_query("SELECT codigo, titulo FROM legislacao");



	
	//ACIONA O BOTAO AO CLICAR e entrar no if de submit
	if($_POST["btCadastrar"] == "Cadastrar"){	
		//RECEBE AS VARIÁVEIS POR POST
		$prazo = $_POST["txtPrazo"];
		$observacoes = $_POST["txtObservacoes"];
		$legislacao = $_POST["cmbLegislacao"];
		$ano = date('Y');
		$data = date('Y-m-d');
		$sqlmax = mysql_query("SELECT MAX(processosfiscais_intimacoes.nrointimacao) FROM processosfiscais_intimacoes WHERE processosfiscais_intimacoes.anointimacao = '$ano'");
		list($nrointimacao)=mysql_fetch_array($sqlmax);
		$nrointimacao++;
		
		//TESTA SE AS VARIAVEIS FORAM PREENCHIDAS CORRETAMENTE
		if(($prazo == "")||($legislacao == 0)){
		Mensagem("Necessário preencher todos os campos com *");
		}else{
		// INSERE NO BANCO
		mysql_query("INSERT INTO processosfiscais_intimacoes SET nroprocesso = '$nroprocesso', anoprocesso = '$anoprocesso', prazo = '$prazo', observacoes = '$observacoes', dataemissao = '$data', nrointimacao = '$nrointimacao', anointimacao = '$ano', codlegislacao = '$legislacao'");
		
		//pega o codigo recem cadastrado
		list($codintimacao) = mysql_fetch_array(mysql_query("SELECT MAX(codigo) FROM processosfiscais_intimacoes"));
		list($nrointimacao) = mysql_fetch_array(mysql_query("SELECT nrointimacao FROM processosfiscais_intimacoes WHERE codigo = '$codintimacao'"));
		$sqldocs = mysql_query("SELECT codigo FROM processosfiscais_docs");
		if(mysql_num_rows($sqldocs) > 0){
			while(list($cod_doc) = mysql_fetch_array($sqldocs)){
				$codigodoc = $_POST["chbDocumentos$cod_doc"];
				if($codigodoc){
					mysql_query("INSERT INTO processosfiscais_intimacoes_docs SET codintimacao = '$codintimacao', coddoc = '$cod_doc'");
				}//fim if se documento ta marcado
			}// fim while lista de documentos
		}// fim if se existe documentos
		add_logs('Inseriu uma Abertura de Processo Fiscal');		
		Mensagem("Intimação Cadastrada com codigo: $nrointimacao/$ano");
		?>
		<form id="frmDetalhes" method="post">
			<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
			<input type="hidden" name="txtAcao" id="txtAcao" value="intimacao_detalhes" />
			<input type="hidden" name="txtIntimacao" id="txtIntimacao" value="<?php echo "$codintimacao"; ?>" />
			<input type="hidden" name="txtNroProcesso" id="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
			<input type="hidden" name="txtAnoProcesso" id="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
		</form>
		<script>document.getElementById('frmDetalhes').submit();</script>
		<?php
		} //fim else se prazo nao ta vazio e insere no banco a intimacao.
	} //FIM DO IF DO BOTAO CADASTRAR
	
?>
<form method="post" id="frmInt">
	<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
	<input type="hidden" name="txtAcao" id="txtAcao_inserir_intimacao" />
	<fieldset style="margin-left:7px; margin-right:7px;"><legend>Inserir Intimação</legend>
			<table align="center">
				<tr>
					<td>Nome do Emissor:</td>
					<td><?php echo "$razaosocial"; ?></td>
				</tr>
				<tr> 
					<td>Código do Processo:</td><td>
					<?php echo "$nroprocesso/$anoprocesso"; ?></td>
				</tr>
				<tr>
					<td>Dias de Prazo:</td>
					<td><input type="text" name="txtPrazo" class="texto" size="3">*Não deixe em branco.</td>
				</tr>
				<tr>
					<td>Legislação:</td>
					<td>
						<select name="cmbLegislacao" class="combo">
							<option value="0">==Selecione==</option>
							<?php
							while(list($codlei, $titulolei) = mysql_fetch_array($sqllegislacao)){
							?>
							<option value="<?php echo $codlei;?>"><?php echo $titulolei;?></option>
							<?php
							}
							?>
						</select>*Não deixe em branco.			
					</td>
				</tr>
				<tr> 
					<td valign="top">Observações:</td><td><textarea name="txtObservacoes" rows="5" cols="47" class="texto"></textarea></td>
				</tr>
			</table>
	</fieldset>
		
	</fieldset>
	<fieldset style="margin-left:7px; margin-right:7px;">
	 	<?php
		$sqldocs = mysql_query("SELECT codigo, nrodoc, descricao FROM processosfiscais_docs");
		if(mysql_num_rows($sqldocs)>0){
		?>
		
		<table align="center" width="100%">
		 <tr bgcolor="#FFFFFF">
		  <td colspan="3" align="center">Selecione os Documentos da Itimação:</td>
		 </tr>
		 <tr bgcolor="#999999">
		  <td align="center"></td>
		  <td align="center" width="20">Código</td>
		  <td align="center">Descrição</td>
		 </tr>
		 <?php
		
		
		$contdoc = 0;
		while(list($cod_doc, $nrodoc, $descricao) = mysql_fetch_array($sqldocs))
			{
			print("
		<tr>
		 <td bgcolor='#FFFFFF' align=\"center\"><input type=\"checkbox\" name=\"chbDocumentos$contdoc\" value=\"t\" id=\"chbDocumentos$contdoc\"></td>
		 <td bgcolor='#FFFFFF' align=\"center\">$nrodoc</td>
		 <td bgcolor='#FFFFFF' align=\"left\">$descricao</td>
		</tr>
			");
			$contdoc++;
			}
		} //fim if se existe documentos
		
		?>
		 <tr>
		  <td align="center" colspan="5"><input name="btnSeltudo" value="Selecionar Tudo" type="button" class="botao" <?php echo "onclick=\"Selecionar('$contdoc')\""; ?>></td>
		 </tr>
		</table>
		<table>
			<tr>
				<td><input name="btCadastrar" type="submit" value="Cadastrar" class="botao" onclick="document.getElementById('txtAcao_inserir_intimacao').value='inserir_intimacao'" /></td>
				<td><input type="submit" name="btnVoltar" value="Voltar" class="botao" onclick="document.getElementById('txtAcao_inserir_intimacao').value='intimacao'" /></td>
					<input type="hidden" name="txtNroProcesso" value="<?php echo "$nroprocesso"; ?>" />
					<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />				
			</tr>
		</table>
	</fieldset>
</form>
