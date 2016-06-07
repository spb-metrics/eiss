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
	if(!$_POST['txtCNPJ']){?>
<form method="post">
	<input name="txtMenu" type="hidden" value="<?php echo $_POST['txtMenu'];?>" />
    <fieldset>
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
        	<tr>
            	<td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td width="19%" align="left">Digite seu CNPJ:</td>
                <td width="81%" align="left">
                	<input name="txtCNPJ" id="txtCNPJ" type="text" onKeyUp="CNPJCPFMsk( this );" size="20" maxlength="18" class="texto" />
                </td>
            </tr>
            <tr>
                <td height="30" valign="middle" colspan="2" align="left">
                	<input name="btAvancar" value="Avan&ccedil;ar" type="submit" class="botao" onClick="ValidaFormulario('txtCNPJ','Preencha o CNPJ!')" />
                </td>
            </tr>
        </table>
    </fieldset>
</form>
    <?php	
	}else{
	$cnpjcpf = $_POST["txtCNPJ"];
	
	$sql_consulta = mysql_query("SELECT emissores.nome, emissores.razaosocial, emissores.cnpjcpf, emissores.inscrmunicipal, emissores.logo, emissores.simplesnacional, emissores.nfe, emissores.municipio, emissores.uf, emissores.endereco, emissores.email, emissores.fonecomercial, emissores.fonecelular, emissores.estado FROM emissores_servicos INNER JOIN emissores ON emissores.codigo = emissores_servicos.codemissor INNER JOIN servicos ON emissores_servicos.codservico = servicos.codigo INNER JOIN servicos_categorias ON servicos.codcategoria = servicos_categorias.codigo WHERE cnpjcpf = '$cnpjcpf' AND servicos_categorias.nome = 'Construção Civil'");
	
	if(mysql_num_rows($sql_consulta)>0){
	
	list($nome, $razaosocial, $cnpjcpf, $inscrmunicipal, $logo, $simplesnacional, $nfe, $municipio, $uf, $endereco,$email,$fone,$fonecel, $estado)=mysql_fetch_array($sql_consulta);
	switch($estado){
	case "A": $estado="Ativo" ; break;
	case "I": $estado="Inativo" ; break;
	case "NL": $estado="Não Liberado" ; break;
	}
	switch($nfe){
	case "s": $nfe="Sim" ; break;
	case "n": $nfe="Não" ; break;
	}
	switch($simplesnacional){
	case "S": $simplesnacional="Sim" ; break;
	case "N": $simplesnacional="Não" ; break;
	}

?>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
        <td bgcolor="#FF6600" height="1"></td>
    </tr>
    <tr>
        <td align="left" background="../../img/index/index_oquee_fundo.jpg">
<table class="form" width="500">
	<tr>
		<td>
			<form method="post" id="frmCadastroInst" action="inc/dec/inserir.php">
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<table align="left" width="100%">
					<tr align="left">
						<td width="120">Nome:</td>
						<td colspan="2"><input type="text" size="50" value="<?php echo "$nome"; ?>" readonly="true" maxlength="40" class="texto" name="txtNome" id="txtNome" /></td>
                        <td rowspan="5" colspan="2"><img src="../img/logos/<?php echo "$logo"; ?>"></td>
					</tr>
					<tr align="left">
						<td>Raz&atilde;o Social:</td>
						<td colspan="2"><input type="text" size="50" maxlength="40" value="<?php echo "$razaosocial"; ?>" readonly="true"class="texto" name="txtRazao" id="txtRazao" /></td>
					</tr>
					<tr align="left">
						<td>CNPJ:</td>
						<td colspan="2"><input type="text" class="texto" value="<?php echo "$cnpjcpf"; ?>" readonly="true" name="txtCnpj" onKeyDown="return NumbersOnly( event );" onKeyUp="CNPJCPFMsk( this );" maxlength="18" id="txtCnpj" /></td>
					</tr>
                    <tr align="left">
						<td>Endere&ccedil;o:</td>
						<td><input type="text" class="texto" value="<?php echo "$endereco"; ?>" readonly="true" size="50" maxlength="40" name="txtEndereco" id="txtEndereco" /></td>
					</tr>
					<tr align="left">
						<td>Munic&iacute;pio:</td>
						<td colspan="2"><input type="text" size="50" value="<?php echo "$municipio"; ?>" maxlength="40" class="texto" name="txtMunicipio" readonly="readonly" /></td>
					</tr>
					<tr align="left">
						<td>UF:</td>
						<td colspan="2"><input type="text" value="<?php echo "$uf"; ?>" size="50" maxlength="40" class="texto" name="txtUf" readonly="readonly" /></td>
					</tr>
					<tr align="left">
						<td>Email:</td>
						<td colspan="2"><input type="text" value="<?php echo "$email"; ?>" readonly="true" size="50" maxlength="30" class="texto" name="txtEmail" id="txtEmail" /></td>
					</tr>
					<tr align="left">
						<td>Telefone 01:</td>
						<td colspan="2"><input type="text" class="texto" value="<?php echo "$fone"; ?>" readonly="true" name="txtFone1" id="txtFone1" /></td>
					</tr>
					<tr align="left">
						<td>Telefone 02:</td>
						<td colspan="2"><input type="text" value="<?php echo "$fonecel"; ?>" readonly="true" class="texto" name="txtFone2" /></td>
					</tr>
					<tr align="left">
						<td>Incri&ccedil;&atilde;o Municipal:</td>
						<td colspan="2">
							<input type="text" name="cmbInscrMunicipal" value="<?php echo "$inscrmunicipal"; ?>" readonly="true" style="width:150px" id="cmbInscrMunicipal" class="texto">
						</td>
					</tr>
					<tr align="left">
						<td>Simples Nacional</td>
						<td colspan="2">
							<input type="text" class="texto" name="cmbSN" value="<?php echo "$simplesnacional"; ?>" readonly="true" style="width:150px" id="cmbSN">
						</td>
					</tr>
					<tr align="left">
						<td>Estado</td>
						<td colspan="2">
							<input type="text" class="texto" name="cmbEstado" style="color:#FF0000" value="<?php echo "$estado"; ?>" readonly="true" id="cmbEstado">
						</td>
					</tr>
					<tr align="left">
						<td>NFE:</td>
						<td colspan="2"><input type="text" size="50" value="<?php echo "$nfe"; ?>" readonly="true" maxlength="40" class="texto" name="txtNFE" id="txtNFE" /></td>
                    <input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='decc.php'">
				</table>		
			</form>
            <?php }
			else{
			Mensagem("CNPJ não cadastrado ou inexistente");
			Redireciona('decc.php');
			
			} ?>
		</td>
	</tr>
</table>			
        </td>
    <tr>
        <td colspan="2" bgcolor="#FF6600" height="1"></td>
    </tr>
</table>
<?php } ?>