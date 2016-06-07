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
if($_POST["btCadastrar"]){
	include("inserir.php"); 
}
$sql_info = mysql_query("SELECT cidade,estado FROM configuracoes");
list($CIDADEpref,$UFpref) = mysql_fetch_array($sql_info);
?>
<script>
function ValidaDop(){
	return ValidaFormulario('txtInsNomeOrgao|txtInsRazaoSocial|txtCNPJ|txtLogradouro|txtNumero|txtBairro|txtCEP|txtFone|txtInsUfOrgao|txtInsMunicipioEmpresa|txtInsDiretor|txtInsCPFDiretor|txtInsResponsavel|txtInsCPFResponsavel|txtInsEmailOrgao|txtSenha','Preencha os campos obrigatórios') && (ConfereCNPJ()) && (ValidaSenha('txtSenha','txtSenhaConf'));;
}
</script>
<table width="580" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="10" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de &Oacute;rg&atilde;o P&uacute;blico</td>
		<td width="65%" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#CCCCCC"></td>
		<td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="10" bgcolor="#FFFFFF"></td>
		<td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">
			<form method="post" name="frmCadastroOrgao" id="frmCadastroOrgao">
				<input type="hidden" name="txtMenu" value="<?php echo $_POST["txtMenu"]; ?>" />
				<table width="100%" border="0" align="center" id="tblOrgao">
					<tr>
						<td width="135" align="left">Nome<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="60" maxlength="100" name="txtInsNomeOrgao" id="txtInsNomeOrgao" class="texto" >
						</td>
					</tr>
					<tr>
						<td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="60" maxlength="100" name="txtInsRazaoSocial" id="txtInsRazaoSocial" class="texto">
						</td>
					</tr>
					<tr>
						<td align="left">CNPJ<font color="#FF0000">*</font></td>
						<td align="left">
							<input  id="txtCNPJ" type="text" size="20" maxlength="18"  name="txtCNPJ" class="texto"  
		onblur="ValidaCNPJ(this,'spamdop')" />
							<span id="spamdop"></span></td>
					</tr>
					<tr>
						<td align="left">Logradouro<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="60" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto" value="" />
						</td>
					</tr>
					<tr>
						<td align="left">Número<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="10" maxlength="10" class="texto" name="txtNumero" id="txtNumero" />
						</td>
					</tr>
					<tr>
						<td align="left">Bairro<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="30" maxlength="100" class="texto" name="txtBairro" id="txtBairro" />
						</td>
					</tr>
					<tr>
						<td align="left">Complemento</td>
						<td align="left">
							<input type="text" size="10" maxlength="10" class="texto" name="txtComplemento" id="txtComplemento" />
						</td>
					</tr>
					<tr>
						<td align="left">CEP<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="12" maxlength="11" class="texto" name="txtCEP" id="txtCEP" />
						</td>
					</tr>
					<tr>
						<td align="left">Telefone<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" class="texto" size="20" maxlength="15" name="txtFone" id="txtFone" />
						</td>
					</tr>
					<tr>
						<td align="left">Telefone adicional </td>
						<td align="left">
							<input type="text" class="texto" size="20" maxlength="15" name="txtFoneAdicional" id="txtFoneAdicional" />
						</td>
					</tr>
					<tr>
						<td align="left">UF<font color="#FF0000">*</font></td>
						<td align="left">
							<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
							<select name="txtInsUfOrgao" id="txtInsUfOrgao" onchange="buscaCidades(this,'tdCidades');">
								<option value=""></option>
								<?php
						$sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
						while(list($uf)=mysql_fetch_array($sql))
							{
								echo "<option value=\"$uf\"";if($uf == $UFpref){ echo "selected=selected"; }echo ">$uf</option>";
							}
					?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="left">Município<font color="#FF0000">*</font></td>
						<td align="left" id="tdCidades">
							<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
							<select name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
								<?php
									$sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UFpref'");
									while(list($nome) = mysql_fetch_array($sql_municipio)){
										echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADEpref)){ echo "selected=selected";} echo ">$nome</option>";
									}//fim while 
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Administração Pública<font color="#FF0000">*</font></td>
						<td>
							<select name="cmbAdmPublica" id="cmbAdmPublica">
								<option value="D">Direta</option>
								<option value="I">Indireta</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Nível<font color="#FF0000">*</font></td>
						<td>
							<select name="cmbNivel" id="cmbNivel">
								<option value="M">Municipal</option>
								<option value="E">Estadual</option>
								<option value="F">Federal</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr size="2" color="#CCCCCC" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Dados do Diretor de &Oacute;rgão:</td>
					</tr>
					<tr>
						<td width="135" align="left">Nome do Diretor<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="60" maxlength="100" name="txtInsDiretor" id="txtInsDiretor" class="texto">
						</td>
					</tr>
					<!-- alterna input cpf/cnpj-->
					<tr>
						<td align="left">CPF do Diretor<font color="#FF0000">*</font></td>
						<td align="left">
							<input  id="txtInsCPFDiretor" type="text" size="20" maxlength="14" name="txtInsCPFDiretor" class="texto"  onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr size="2" color="#CCCCCC" />
						</td>
					</tr>
					<tr>
						<td></td>
						<td>Dados do respons&aacute;vel:</td>
					</tr>
					<tr>
						<td width="135" align="left">Nome do respons&aacute;vel<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="60" maxlength="100" name="txtInsResponsavel" id="txtInsResponsavel" class="texto">
						</td>
					</tr>
					<!-- alterna input cpf/cnpj-->
					<tr>
						<td align="left">CPF do Respons&aacute;vel<font color="#FF0000">*</font></td>
						<td align="left">
							<input  id="txtInsCPFResponsavel" type="text" size="20" maxlength="14" name="txtInsCPFResponsavel" class="texto"  onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr size="2" color="#CCCCCC" />
						</td>
					</tr>
					<tr>
						<td align="left">Email<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="text" size="30" maxlength="100" name="txtInsEmailOrgao" id="txtInsEmailOrgao" class="email" />
						</td>
					</tr>
					<tr>
						<td align="left">Senha<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto" onkeyup="verificaForca(this)" />
						</td>
					</tr>
					<tr>
						<td align="left">Confirma Senha<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" />
						</td>
					</tr>
					<tr>
						<td align="left">
							<input type="submit" value="Cadastrar" name="btCadastrar" class="botao" 
							onclick="return ValidaDop();" />
							<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='dop.php'">
						</td>
						<td align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
