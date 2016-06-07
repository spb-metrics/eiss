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
	include("../funcoes/util.php");

	if(!$_SESSION["issempresa"])
		{
			?>
				<fieldset>	
					<form method="post" action="inc/cadempresas/alterar_logar.php">	
						<table class="form">
							<tr align="left">
								<td>CPF/CNPJ</td>
								<td>
									<input  id="txtCPFCNPJ" type="text" size="20"  name="txtCPFCNPJ" class="texto"  onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
								</td>
							</tr>
							<tr align="left">
								<td>Senha</td>
								<td><input type="password" size="12" maxlength="10" name="txtSenha" class="texto" /></td>
							</tr>
							<tr><td colspan="2"><input type="submit" class="botao" value="Logar" /></td></tr>
						</table>
					</form>	
				</fieldset>	
			<?php
		}
	else
		{
			$campo=tipoPessoa($_SESSION['issempresa']);

            $sql=mysql_query("SELECT logradouro,
                              numero,
                              complemento,
                              bairro,
                              cep,
                              email,
                              fonecomercial,
                              fonecelular,
                              senha FROM cadastro
                              WHERE $campo='".$_SESSION["issempresa"]."'");
			list($logradouro,$numero,$complemento,$bairro,$cep,$email,$fonecomercial,$fonecelular,$senha)=mysql_fetch_array($sql);
			?>
				<fieldset>
					<form method="post" action="inc/cadempresas/alterar.php">	
						<table>
							<tr align="left">
								<td>Logradouro</td>
								<td><input type="text" size="60" maxlength="100" name="txtLogradouro" class="texto" value="<?php echo $logradouro; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Número</td>
								<td><input type="text" size="10" maxlength="10" name="txtNumero" class="texto" value="<?php echo $Numero; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Complemento</td>
								<td><input type="text" size="60" maxlength="100" name="txtComplemento" class="texto" value="<?php echo $complemento; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Bairro</td>
								<td><input type="text" size="60" maxlength="100" name="txtBairro" class="texto" value="<?php echo $bairro; ?>" /></td>
							</tr>
							<tr align="left">
								<td>CEP</td>
								<td><input type="text" size="10" maxlength="9" name="txtCEP" class="texto" value="<?php echo $cep; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Email</td>
								<td><input type="text" size="30" maxlength="100" name="txtEmail" class="email" value="<?php echo $email; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Telefone Comercial</td>
								<td><input type="text" class="texto" size="20" maxlength="15" name="txtFoneComercial" value="<?php echo $fonecomercial; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Telefone Celular</td>
								<td><input type="text" class="texto" size="20" maxlength="15" name="txtFoneCelular" value="<?php echo $fonecelular; ?>" /></td>
							</tr>
							<tr align="left">
								<td>Senha</td>
								<td><input type="password" size="12" maxlength="10" name="txtSenha" class="texto" value="<?php echo $senha; ?>" /></td>
							</tr>
							<tr align="left">
								<td colspan="2">
									<input type="submit" class="botao" name="btAlterar" value="Alterar" />
									&nbsp;&nbsp;
									<input type="submit" class="botao" name="btSair" value="Sair" />
								</td>
							</tr>
						</table>
					</form>	
				</fieldset>
			<?php
		}	
?>