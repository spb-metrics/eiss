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
if($_POST["btAtualizar"]){
	$nome 			= trataString($_POST["txtNome"]);
	$razaosocial	= trataString($_POST["txtRazaoSocial"]);
	$cnpj			= $_POST["txtCNPJ"];
	$logradouro		= trataString($_POST["txtLogradouro"]);
	$numero			= $_POST["txtNumero"];
	$bairro			= trataString($_POST["txtBairro"]);
	$complemento	= trataString($_POST["txtComplemento"]);
	$cep			= $_POST["txtCEP"];
	$fone			= $_POST["txtFone"];
	$fonecelular	= $_POST["txtFoneCelular"];
	$uf				= $_POST["txtUf"];
	$municipio		= $_POST["txtinsMunicipioEmpresa"];
	$email			= $_POST["txtEmail"];
	$senha			= md5($_POST["txtSenha"]);
	$codigo			= $_POST["txtCod"];

	mysql_query("
				UPDATE cadastro SET
				nome='$nome', 
				razaosocial='$razaosocial', 
				senha='$senha', 
				logradouro='$logradouro',
				numero='$numero',
				complemento='$complemento',
				bairro='$bairro',
				cep='$cep',
				municipio='$municipio', 
				uf='$uf', 
				email='$email', 
				fonecomercial='$fone', 
				fonecelular='$fonecelular' 
				WHERE codigo='$codigo'
				");
	Mensagem("Gráfica Atualizada!");
	RedirecionaPost("aidf.php?txtMenu=grafica_autorizacao&txtCNPJGrafica=$cnpj");
	exit();
}//if para fazer o update no banco

//se NAO digitou cnpj e a senha mostra tela de login, se digitou cnpj mostra a atualizar
if(!$_POST['txtCNPJ']||!$_POST["txtSenha"]){ 
	include("login.php");

}else{//else se digitou cnpj e a senha mostra a tela de atualizar
	if( $_SESSION['autenticacao'] != $_POST['codseguranca']){
		Mensagem("Favor verificar código de segurança!");
		?>
		<form method="post" id="frmDOP">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmDOP').submit();</script>
		<?php
	}//fim if do codigo de verificação.
	$cnpj = $_POST["txtCNPJ"];
	$senha= md5($_POST["txtSenha"]);
	$sqltipo=mysql_query("SELECT codigo FROM tipo WHERE tipo='grafica'");
	list($codtipo)=mysql_fetch_array($sqltipo);
	$sql=mysql_query("
					  SELECT 
					  	codigo,
					  	nome, 
					  	razaosocial,
					    logradouro,
						numero,
						complemento,
						bairro,
						cep,
						municipio,
						uf, 
					    fonecomercial, fonecelular, email, estado 
					  FROM 
					  	cadastro 
					  WHERE 
					  	(cnpj='$cnpj' OR cpf='$cnpj') AND 
						senha='$senha' AND 
						codtipo='$codtipo'
					  ") or die(mysql_error());
						
	if(mysql_num_rows($sql) == 0){//se verifica se tem o cnpj no banco
		Mensagem("CNPJ ou Senha incorreta, verifique os dados digitados");
		?>
		<form method="post" id="frmDOP">
			<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
		</form>
		<script>document.getElementById('frmDOP').submit();</script>
		<?php //voltar para a tela de consulta
	}else{//fim if se existe o cnpj no banco
		list($codigo, $nome, $razaosocial, $logradouro, $numero, $complemento, $bairro, $cep, $municipio, $uf, $telefone, $telefone2, $email, $estado) = mysql_fetch_array($sql);
		?>

    
      <form method="post" name="frmCadastro" id="frmCadastro" onsubmit="return ValidaFormulario(
	  'txtNome|txtRazaoSocial|txtCnpj|txtLogradouro|txtNumero|txtBairro|txtCEP|txtFone|txtUf|txtinsMunicipioEmpresa|txtEmail|txtSenha|txtSenhaConf',
	  'Preencha os campos obrigatórios');">
	  <input type="hidden" name="txtCNPJ" value="<?php echo $_POST["txtCNPJ"]; ?>" />
	  <input type="hidden" name="txtCod" value="<?php echo $codigo; ?>" />
	  <input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
<table width="99%" border="0" cellpadding="0" cellspacing="1">
<tr>
	  <td width="5%" height="10" bgcolor="#FFFFFF"></td>
      <td width="30%" rowspan="3" align="center" bgcolor="#FFFFFF">Gr&aacute;fica: Atualizar Cadastro</td>
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
	    
      <table width="100%" border="0" align="center" id="tblOrgao">	   
		<tr>
			<td width="135" align="left">Nome<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtNome" id="txtNome" class="texto" value="<?php echo $nome; ?>" ></td>
		</tr>
		<tr>
			<td width="135" align="left">Razão Social<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="60" maxlength="100" name="txtRazaoSocial" id="txtRazaoSocial" class="texto" value="<?php echo $razaosocial; ?>"></td>
		</tr>	   	
      
		<tr>
			<td align="left">CNPJ<font color="#FF0000">*</font></td> 
			<td align="left"><input type="text" size="20" maxlength="18" name="txtCnpj" id="txtCnpj" class="texto" value="<?php echo $cnpj; ?>" readonly="readonly" /></td>
		</tr>
		<tr>
			<td align="left">Logradouro<font color="#FF0000">*</font></td>

			<td align="left">
				<input type="text" size="60" maxlength="100" name="txtLogradouro" id="txtLogradouro" class="texto" value="<?php echo $logradouro; ?>" />
			</td>
		</tr>
		<tr>
			<td align="left">Número<font color="#FF0000">*</font></td>
			<td align="left">
				<input type="text" size="10" maxlength="10" class="texto" name="txtNumero" id="txtNumero" value="<?php echo $numero; ?>" />

			</td>
		</tr>
		<tr>
			<td align="left">Bairro<font color="#FF0000">*</font></td>
			<td align="left">
				<input type="text" size="30" maxlength="100" class="texto" name="txtBairro" id="txtBairro" value="<?php echo $bairro; ?>" />
			</td>
		</tr>

		<tr>
			<td align="left">Complemento</td>
			<td align="left">
				<input type="text" size="10" maxlength="10" class="texto" name="txtComplemento" id="txtComplemento" value="<?php echo $complemento; ?>" />
			</td>
		</tr>
		<tr>
			<td align="left">CEP<font color="#FF0000">*</font></td>

			<td align="left">
				<input type="text" size="12" maxlength="11" class="texto" name="txtCEP" id="txtCEP" value="<?php echo $cep; ?>" />
			</td>
		</tr>
		<tr>
			<td align="left">Telefone<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFone" id="txtFone" value="<?php echo $telefone; ?>" /></td>
		</tr>
		<tr>
			<td align="left">Telefone celular </td>
			<td align="left"><input type="text" class="texto" size="20" maxlength="15" name="txtFoneCelular" id="txtFoneCelular" value="<?php echo $telefone2; ?>" /></td>
		</tr>
		<tr>
			<td align="left">UF<font color="#FF0000">*</font></td>
			<td align="left">
				<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
				<select name="txtUf" id="txtUf" onchange="buscaCidades(this,'tdCidades');">
					<option value=""></option>
					<?php
						$sql_ajax=mysql_query("SELECT uf FROM municipios GROUP BY uf ORDER BY uf");
						while(list($uf_ajax)=mysql_fetch_array($sql_ajax))
							{
								echo "<option value=\"$uf_ajax\" "; if($uf == $uf_ajax){echo "selected=selected";} echo ">$uf_ajax</option>";
							}
					?>
				</select>
			</td>
		</tr>		 
		<tr>
			<td align="left">Município<font color="#FF0000">*</font></td>
			<td align="left" id="tdCidades">
				<!--ESTE SELECT ESTA COM A NOMENCLATTURA DE UM TEXT PARA MANTER A COMPATIBILIDADE DO ARQUIVO INSERIR.PHP COM TODOS OS ARQUIVOS DE CADASTRO DE EMPRESAS-->
				<select name="txtinsMunicipioEmpresa" id="txtinsMunicipioEmpresa">
				<?php
					$sql_ajax=mysql_query("SELECT nome FROM municipios WHERE uf='$uf' ORDER BY nome");
					while(list($municipio_ajax)=mysql_fetch_array($sql_ajax)){
						echo "<option value=\"$municipio_ajax\" "; if($municipio == $municipio_ajax){echo "selected=selected";} echo ">$municipio_ajax</option>";
					}	
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td align="left">Email<font color="#FF0000">*</font></td>
			<td align="left"><input type="text" size="30" maxlength="100" name="txtEmail" id="txtEmail" class="email" value="<?php echo $email; ?>" /></td>
		</tr>
		<tr>
			<td align="left">Senha<font color="#FF0000">*</font></td>
			<td align="left">
            	<input type="password" size="18" maxlength="18" name="txtSenha" id="txtSenha" class="texto" value="<?php echo $senha; ?>" 
                onkeyup="verificaForca(this)" />
            </td>
		</tr>
		<tr>
			<td align="left">Confirma Senha<font color="#FF0000">*</font></td>
			<td align="left">
            	<input type="password" size="18" maxlength="18" name="txtSenhaConf" id="txtSenhaConf" class="texto" value="<?php echo $senha; ?>" />
            </td>
		</tr>	   
       <tr>
         <td align="left"><input type="submit" value="Atualizar" name="btAtualizar" class="botao" onclick="return ValidaSenha('txtSenha','txtSenhaConf');" /> <input type="button" name="btVoltar" value="Voltar" class="botao" onClick="window.location='aidf.php'"></td>
         <td align="right"><font color="#FF0000">*</font> Campos Obrigat&oacute;rios<br /> </td>
         </tr>   
      </table>   
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
</form>

<?php
  }//fim else se existe o cnpj
}//fim else se digitau corretamente cnpj senha
  ?>
