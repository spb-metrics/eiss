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
	if($_POST['btAlterar'] == "Alterar"){
		include('include/simples/alterar.php');
	}
	$cnpjcpf = $_SESSION['login'];
	$sql=mysql_query("
		SELECT 
			logradouro,
			numero,
			complemento, 
			email,
			bairro,
			cep, 
			fonecomercial, 
			fonecelular, 
			senha 
		FROM 
			cadastro 
		WHERE 
			cnpj= '$cnpjcpf' OR
			cpf= '$cnpjcpf'
	");
	list($logradouro,$numero,$complemento,$email,$bairro,$cep,$fonecomercial,$fonecelular,$senha)=mysql_fetch_array($sql);
	$endereco = "$logradouro, $numero";
	if($complemento)
		$endereco .= ", $complemento";
?>
	<table width="580" border="0" cellpadding="0" cellspacing="1">
        <tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
	        <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Atualizar Cadastro</td>
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
    <form method="post">
    	<input name="txtCNPJ" type="hidden" value="<?php echo $cnpjcpf;?>" />
        <table>
            <tr align="left">
                <td>Logradouro<font color="red">*</font></td>
                <td><input type="text" size="60" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto" value="<?php echo $logradouro; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Número<font color="red">*</font></td>
                <td><input type="text" size="20" maxlength="100" name="txtNumero" id="txtNumero" class="texto" value="<?php echo $numero; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Complemento</td>
                <td><input type="text" size="20" maxlength="100" name="txtComplemento" id="txtComplemento" class="texto" value="<?php echo $complemento	; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Bairro<font color="red">*</font></td>
                <td><input type="text" size="20" maxlength="100" name="txtBairro" id="txtBairro" class="texto" value="<?php echo $bairro; ?>" /></td>
            </tr>
            <tr align="left">
                <td>CEP<font color="red">*</font></td>
                <td><input type="text" size="20" maxlength="100" name="txtCEP" id="txtCEP" class="texto" value="<?php echo $cep; ?>" /></td>
            </tr>            
            <tr align="left">
                <td>Email<font color="red">*</font></td>
                <td><input type="text" size="30" maxlength="100" name="txtEmail" class="email" value="<?php echo $email; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Telefone Comercial<font color="red">*</font></td>
                <td><input type="text" class="texto" size="20" maxlength="14" name="txtFoneComercial" id="txtFoneComercial" value="<?php echo $fonecomercial; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Telefone Celular</td>
                <td><input type="text" class="texto" size="20" maxlength="14" name="txtFoneCelular" id="txtFoneCelular" value="<?php echo $fonecelular; ?>" /></td>
            </tr>
            <tr align="left">
                <td>Senha<font color="red">*</font></td>
                <td>
                	<input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto" value="<?php echo $senha; ?>" 
                    onkeyup="verificaForca(this)" />
                </td>
            </tr>
            <tr align="left">
            	<td>Confirmar senha</td>
                <td><input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" value="<?php echo $senha;?>" /></td>
            </tr>
            <tr align="left">
                <td colspan="2">
                    <input type="submit" class="botao" name="btAlterar" value="Alterar" onclick="return (ValidaSenha('txtSenha','txtSenhaConf') && ValidaFormulario('txtLogradouro|txtBairro|txtCEP|txtNumero|txtFoneComercial|txtSenha'))" />
                    &nbsp;&nbsp;
                    <input type="button" class="botao" name="btSair" value="Sair" onclick="window.location='principal.php'" />
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
