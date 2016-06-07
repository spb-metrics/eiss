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
	$sql=mysql_query("SELECT cidade, estado FROM configuracoes");
	list($CIDADE,$UF)=mysql_fetch_array($sql);
?>
 <!-- Formulário de inserção de empresa -->
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="340" align="center" bgcolor="#FFFFFF" rowspan="3">Cadastro de Empreiteiras</td>
	    <td width="405" bgcolor="#FFFFFF"></td>
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
		<td height="60" colspan="3" bgcolor="#CCCCCC" align="center">


          <form action="../include/decc/cadastro/inserir.php" method="post" name="frmCadastroEmpreiteira" id="frmCadastroEmpreiteira" onsubmit="">
          <table width="480" border="0" align="center" id="tblEmpresa">
            <tr>
                <td width="135" align="left">Nome<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtEmpresa" id="txtEmpresa" class="texto" ></td>
            </tr>
            <tr>
                <td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtRazao" id="txtRazao" class="texto"></td>
            </tr>

           <!-- alterna input cpf/cnpj-->
            <tr>
            <td align="left">CNPJ<font color="#FF0000">*</font></td>
            <td align="left"><input type="text" size="18"  name="txtCNPJ" id="txtCNPJ" class="texto"  onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" onblur="ValidaCNPJ(this,'spamempreiteiras')" /><span id="spamempreiteiras"></span></td>
            </tr>
           <!-- alterna input cpf/cnpj FIM-->
            <tr>
                <td align="left">Logradouro:<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Número:<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="10" maxlength="10" name="txtNumero" id="txtNumero" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Complemento:</td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtComplemento" id="txtComplemento" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Bairro:<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="60" maxlength="100" name="txtBairro" id="txtBairro" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">CEP:<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="10" maxlength="9" name="txtCEP" id="txtCEP" class="texto" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Comercial<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" id="txtFoneComercial" /></td>
            </tr>
            <tr>
                <td align="left">Telefone Celular</td>
                <td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneCelular" /></td>
            </tr>
            <tr>
                <td align="left">UF<font color="#FF0000">*</font></td>
                <td align="left">
                    <!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                    <select name="txtUf"  id="txtUf" onchange="buscaCidades(this,'tdCidades');">
                        <?php
                            $sql=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
                            while(list($uf)=mysql_fetch_array($sql))
                                {
                                    echo "<option value=\"$uf\"";if($uf == $UF){ echo "selected=selected"; }echo ">$uf</option>";
                                }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="left">Município<font color="#FF0000">*</font></td>
                <td align="left" id="tdCidades">
					<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
                    <select style="width:150px;" name="txtInsMunicipioEmpresa" id="txtInsMunicipioEmpresa">
                       <?php
                       		$sql_municipio = mysql_query("SELECT nome FROM municipios WHERE uf = '$UF'");
                        	while(list($nome) = mysql_fetch_array($sql_municipio)){
                        		echo "<option value=\"$nome\"";if(strtolower($nome) == strtolower($CIDADE)){ echo "selected=selected";} echo ">$nome</option>";
                        	}//fim while 
                        ?>
                    </select>
                    <!--O SELECT ESTA DENTRO DO ARQUIVO LISTAMUNICIPIO.PHP-->
                </td>
            </tr>
            <tr>
                <td align="left">Insc. Municipal</td>
                <td align="left"><input type="text" size="20" maxlength="20" name="txtInscrMunicipal" id="txtInscrMunicipal" class="texto" /></td>
            </tr>
			<tr>
				<td align="left">PIS/PASEP</td>
				<td align="left"><input type="text" size="20" maxlength="20" name="txtPispasep" id="txtPispasep" class="texto" /></td>
			</tr>
            <tr>
                <td align="left">Email<font color="#FF0000">*</font></td>
                <td align="left"><input type="text" size="30" maxlength="100" name="txtEmail" id="txtEmail" class="email" /></td>
            </tr>
            <tr>
                <td align="left">Senha<font color="#FF0000">*</font></td>
                <td align="left"><input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto" onkeyup="verificaForca(this)" /></td>
            </tr>
            <tr>
                <td align="left">Confirma Senha<font color="#FF0000">*</font></td>
                <td align="left"><input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" /></td>
            </tr>
           <tr>
             <td colspan="2" align="left">&nbsp;</td>
             </tr>
           <tr>
             <td colspan="2" align="left">
              <input type="button" value="Adicionar Responsável/Sócio" name="btAddSocio" class="botao" onclick="incluirSocio()" />
              </td>
           </tr>
           <tr>
             <td colspan="2" align="center">
    <table width="480" border="0" cellspacing="1" cellpadding="2">

         <?php include("../include/decc/cadastro/cadastro_socios.php");?>
    </table>

         </td>
           </tr>
           <tr>
             <td colspan="2" align="left">&nbsp;</td>
             </tr>
           <tr>
             <td colspan="2" align="left">
              <input type="button" value="Adicionar Serviços" name="btAddServicos" class="botao" onclick="incluirServico()" />
              </td>
           </tr>
           <tr>
             <td colspan="2" align="center">


    <table width="480" border="0" cellspacing="1" cellpadding="2">

         <?php include("../include/decc/cadastro/cadastro_servicos.php")?>
    </table>

            </td>
           </tr>
           <tr>
             <td align="left" height="15"></td>
             <td align="right"></td>
             </tr>
			 <tr>
             <td align="right" colspan="2"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
             </tr>
           	 <tr>
             <td align="left" colspan="2">
             	<input type="submit" value="Cadastrar" name="btCadastrar" class="botao"
                onclick="return (ValidaFormulario('txtEmpresa|txtRazao|txtCNPJ|txtLogradouro|txtNumero|txtFoneComercial|txtUf|txtInsMunicipioEmpresa|txtEmail|txtBairro|txtCEP|txtNomeSocio1|txtCpfSocio1|cmbCategoria1')) && (ConfereCNPJ(this)) && (ValidaSenha('txtSenha','txtSenhaConf'))" />
				<input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='decc.php'">
			 </td>
			 </tr>
          </table>
          </form>
          </td>
    </table>




				</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#CCCCCC" colspan="3"></td>
				<td bgcolor="#CCCCCC"></td>
			</tr>
        </table>
