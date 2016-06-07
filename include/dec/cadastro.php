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
	$sql_info = mysql_query("SELECT estado, cidade FROM configuracoes");
	list($UF,$CIDADE) = mysql_fetch_array($sql_info);
	
	if($_POST["btCadastrar"] == "Cadastrar"){
			include("inserir.php");
	}
?>
<table width="580" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Cartórios</td>
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
<table bgcolor="#CCCCCC" class="form" width="500">
	<tr>
		<td>
			<form method="post" id="frmCadastroInst" name="frmCadastroInst">
				<input type="hidden" name="txtMenu" value="<?php echo $_POST["txtMenu"]; ?>" />
				<table align="left" width="100%">
					<tr align="left">
						<td width="130"> Nome:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" size="50" maxlength="40" class="texto" name="txtNome" id="txtNome" /></td>
					</tr>
					<tr align="left">
						<td> Razão Social:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" size="50" maxlength="40" class="texto" name="txtRazao" id="txtRazao" /></td>
					</tr>
					<tr align="left">
						<td> CNPJ:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" class="texto" name="txtCNPJ" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="18" id="txtCNPJ" onblur="ValidaCNPJ(this, 'spamdec')" /><span id="spamdec"></span></td>
					</tr>
                    <tr align="left">
						<td>Inscrição Municipal:</td>
						<td colspan="2"><input type="text" class="texto" name="txtInscrMunicipal" onkeydown="return NumbersOnly( event );" maxlength="20" id="txtInscrMunicipal"/><span id="spamdec"></span></td>
					</tr>
					<tr align="left">
						<td> CEP:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" maxlength="9" class="texto" onkeydown="return NumbersOnly( event );" onkeyup="CEPMsk( this );" name="txtCEP" id="txtCEP" /></td>
					</tr>
                    <tr align="left">
						<td> Logradouro:<font color="#FF0000">*</font></td>
						<td><input type="text" class="texto" size="50" maxlength="40" name="txtLogradouro" id="txtLogradouro" /></td>
					</tr>                    
                    <tr align="left">
						<td> Número:<font color="#FF0000">*</font></td>
						<td><input type="text" class="texto" size="9" maxlength="9" name="txtLogradouroNro" id="txtLogradouroNro" /></td>
					</tr>
                    <tr align="left">
						<td>Complemento:</td>
						<td><input type="text" class="texto" size="9" maxlength="9" name="txtComplemento" id="txtComplemento" /></td>
					</tr>
                    <tr align="left">
						<td> Bairro:<font color="#FF0000">*</font></td>
						<td><input type="text" class="texto" size="40" maxlength="40" name="txtBairro" id="txtBairro" /></td>
					</tr>
					<tr align="left">
						<td> UF:<font color="#FF0000">*</font></td>
						<td align="left" colspan="2">
                            <select name="txtUfEmpresa" id="txtUfEmpresa" onchange="buscaCidades(this,'dvMunicipioEmpresa')">
                                <option value=""></option>
                                <?php
                                    $sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                                    while(list($uf_busca)=mysql_fetch_array($sql)){
                                        echo "<option value=\"$uf_busca\"";if($uf_busca == $UF){ echo "selected=selected"; }echo ">$uf_busca</option>";
                                    }
                                ?>
                            </select>
                        </td>
					</tr>
                    <tr>
                        <td align="left">Município<font color="#FF0000">*</font></td>
                        <td align="left" colspan="2">
                            <div  id="dvMunicipioEmpresa">
                                <select name="txtMunicipioEmpresa" id="txtInsMunicipioEmpresa" class="combo">
                                    <?php
                                        $sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UF'");
                                        while(list($nome) = mysql_fetch_array($sql_municipio)){
                                            echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADE)){ echo "selected=selected";} echo ">$nome</option>";
                                        }//fim while 
                                    ?>
                                </select>
                            </div>
                        </td>
                    </tr>
					<tr align="left">
						<td> Telefone 01:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" class="texto" name="txtFone1" id="txtFone1" /></td>
					</tr>
					<tr align="left">
						<td>Telefone 02:</td>
						<td colspan="2"><input type="text" class="texto" name="txtFone2" /></td>
					</tr>
					<tr align="left">
						<td>Adm. Pública</td>
						<td colspan="2">
							<select name="cmbAdmPublica" style="width:150px" id="cmbAdmPublica">
								<option value="D">Direta</option>
								<option value="I">Indireta</option>
							</select>
						</td>
					</tr>
					<tr align="left">
						<td>Nível</td>
						<td colspan="2">
							<select name="cmbNivel" style="width:150px" id="cmbNivel">
								<option value="M">Municipal</option>
								<option value="E">Estadual</option>
								<option value="F">Federal</option>
							</select>
						</td>
					</tr>
					<tr>
	                    <td colspan="2"><hr align="left" width="438" size="2" color="#CCCCCC" /></td>
                    </tr>
					<tr align="left">
						<td> Diretor:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" size="50" maxlength="40" class="texto" name="txtDiretor" id="txtDiretor" /></td>
					</tr>
					<tr align="left">
						<td> CPF Diretor:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" class="texto" name="txtCpfDiretor" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfDiretor" /></td>
					</tr>
                    <tr>
	                    <td colspan="2"><hr align="left" width="438" size="2" color="#CCCCCC" /></td>
                    </tr>
					<tr align="left">
						<td> Responsável:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" size="50" maxlength="40" class="texto" name="txtResponsavel" id="txtResponsavel" /></td>
					</tr>
					<tr align="left">
						<td> CPF Responsável:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" class="texto" name="txtCpfResponsavel" onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" maxlength="14" id="txtCpfResponsavel" /></td>
					</tr>
                    <tr>
	                    <td colspan="2"><hr align="left" width="438" size="2" color="#CCCCCC" /></td>
                    </tr>
					<tr align="left">
						<td> Email:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="text" size="50" maxlength="30" class="texto" name="txtEmail" id="txtEmail" /></td>
					</tr>
					<tr align="left">
						<td> Senha:<font color="#FF0000">*</font></td>
						<td colspan="2"><input type="password" size="18" maxlength="18" class="texto" name="txtSenha" id="txtSenha" onkeyup="verificaForca(this)" /></td>
					</tr>
					<tr>
						<td align="left"> Confirma Senha:<font color="#FF0000">*</font></td>
						<td align="left">
							<input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" />
						</td>
					</tr>
                    <tr align="right"><td colspan="2"><font color="#FF0000">* Campos Obrigatórios</font></td></tr>
					<tr align="left">
						<td colspan="2">
							<input type="submit" value="Cadastrar" name="btCadastrar" class="botao" onClick="return (ValidaFormulario('txtNome|txtRazao|txtCNPJ|txtCEP|txtSenha|txtDiretor|txtCpfDiretor|txtLogradouro|txtLogradouroNro|txtBairro|txtResponsavel|txtCpfResponsavel|txtInsMunicipioEmpresa|txtUfEmpresa|txtEmail|txtFone1', 'Preencha todos os campos obrigatórios.')) && (ConfereCNPJ(this)) && (ValidaSenha('txtSenha','txtSenhaConf'));"/>
							<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='dec.php'">
						</td>
					</tr>
				</table>		
			</form>
		</td>
	</tr>
</table>			
        </td>
    <tr>
        <td colspan="2" height="1"></td>
    </tr>
</table>
