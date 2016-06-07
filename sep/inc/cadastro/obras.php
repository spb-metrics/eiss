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
	if($_POST['btSalvar'] == "Salvar"){
		//Verifica se ja foi buscado alguma obra se sim atualiza se não inseri
		if($_POST['CODOBRA']){
			include("inc/cadastro/obras_atualizar.php");
		}else{
			include("inc/cadastro/obras_inserir.php");
		}
	}
?>
<style type="text/css">
<!--
#divBuscaObra {
	position:absolute;
	left:40%;
	top:20%;
	width:298px;
	height:276px;
	z-index:1;
	visibility:<?php if(isset($_POST['btBuscaObra'])) { echo "visible"; }else{ echo "hidden"; }?>
}

input[type*="text"]{
	text-transform:uppercase;
}
-->
</style>
<div id="divBuscaObra"  >
	<?php include("inc/cadastro/busca_obra.php"); ?>
</div>
<?php
	if(isset($_POST['CODOBRA'])){
		$codigo = $_POST['CODOBRA'];
		$sql_busca_obra = mysql_query("
			SELECT	
				codigo,
				codcadastro,
				obra,
				alvara,
				iptu,
				endereco,
				proprietario,
				proprietario_cnpjcpf,
				DATE_FORMAT(dataini,'%d/%m/%Y'),
				DATE_FORMAT(datafim,'%d/%m/%Y'),
				listamateriais,
				valormateriais,
				estado
			FROM
				obras
			WHERE
				codigo = '$codigo'
		");
		list($codigo,$codcadastro,$obra,$alvara,$iptu,$endereco,$proprietario,$proprietario_cnpjcpf,$dataini,$datafim,$listamateriais,$valormateriais,$estado) = mysql_fetch_array($sql_busca_obra);
		
		$sql_busca_empreiteira = mysql_query("SELECT IF(cnpj <> '',cnpj,cpf) AS cnpjcpf FROM cadastro WHERE codigo = '$codcadastro'");
		list($cnpj) = mysql_fetch_array($sql_busca_empreiteira);
	}
?>
<table border="0" cellspacing="0" cellpadding="0" class="form">
	<tr>
		<td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
		<td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Prestadores - Cadastro</td>
		<td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
	</tr>
	<tr>
		<td width="18" background="img/form/lateralesq.jpg"></td>
		<td align="center">
			<form method="post" name="formObras" id="formObras">
				<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
				<input type="hidden" name="CODOBRA" id="CODOBRA" value="<?php echo $_POST['CODOBRA']?>" />
				<fieldset>
					<table width="100%">
						<tr align="left">
							<td width="27%">CNPJ/CPF da empreiteira<font color="#FF0000">*</font></td>
							<td width="73%">
								<input type="text" class="texto" name="txtCNPJCPFEmpreiteira" id="txtCNPJCPFEmpreiteira" size="20" maxlength="18" value="<?php echo $cnpj;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>Obra<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtObra" id="txtObra" size="40" value="<?php echo $obra;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>Alvará Nº<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtAlvara" id="txtAlvara" size="20" value="<?php echo $alvara;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>IPTU<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtIptu" id="txtIptu" size="30" value="<?php echo $iptu;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>Endereço<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtEndereco" id="txtEndereco" size="40" value="<?php echo $endereco;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>Proprietário<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtProprietario" id="txtProprietario" size="30" value="<?php echo $proprietario;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>CNPJ/CPF Proprietário<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtCNPJCPF" id="txtCNPJCPF" size="20" maxlength="18" value="<?php echo $proprietario_cnpjcpf;?>" />
							</td>
						</tr>
						<tr align="left">
							<td>Lista de Materiais</td>
							<td>
								<textarea rows="5" cols="37" class="texto" name="txtListaMateriais"><?php echo $listamateriais;?></textarea>
							</td>
						</tr>
						<tr align="left">
							<td>Valor dos Materiais<font color="#FF0000">*</font></td>
							<td>
								<input type="text" class="texto" name="txtValorMateriais" id="txtValorMateriais" size="12" value="<?php echo DecToMoeda($valormateriais);?>" />
							</td>
						</tr>
						<?php
							if($_POST['CODOBRA']){
						?>
							<tr align="left">
								<td>Data de inicio</td>
								<td><input type="text" class="texto" name="txtDataInicio" size="12" maxlength="10" value="<?php echo $dataini;?>" disabled="disabled" /></td>
							</tr>
							<?php
								if($datafim != ""){
							?>
							<tr align="left">
								<td>Data de fim</td>
								<td><input type="text" class="texto" name="txtDataFim" size="12" maxlength="10" value="<?php echo $datafim;?>" disabled="disabled" /></td>
							</tr>
							<?php
								}
							?>
							<tr align="left">
								<td>Estado da obra</td>
								<td>
									<input type="radio" name="rdEstado" value="A" <?php if($estado == "A"){ echo "checked=\"checked\"";}?> />Aberta
									<input type="radio" name="rdEstado" value="C" <?php if($estado == "C"){ echo "checked=\"checked\"";}?> />Concluida
								</td>
							</tr>
						<?php
							}
						?>
						<tr align="left">
							<td colspan="2">
								<br />
								<input type="button" name="btNovo" class="botao" value="Novo" onclick="LimpaCampos('formObras')" />
								<input type="submit" class="botao" name="btSalvar" value="Salvar" 
								onclick="return ValidaFormulario('txtCNPJCPFEmpreiteira|txtObra|txtAlvara|txtIptu|txtEndereco|txtProprietario|txtCNPJCPF|txtValorMateriais')" />
								<input type="button" name="btPesquisar" value="Pesquisar" class="botao" onclick="document.getElementById('divBuscaObra').style.visibility='visible'" />
							</td>
						</tr>
					</table>
				</fieldset>
			</form>
		</td>
		<td width="19" background="img/form/lateraldir.jpg"></td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>
