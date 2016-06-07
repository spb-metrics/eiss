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
	if($_POST["btCadastrarFiscal"]=="Cadastrar")
		{
			$nome  =strip_tags(addslashes($_POST["txtNome"]));
			$login =strip_tags(addslashes($_POST["txtLogin"]));
			$senha =strip_tags(addslashes($_POST["txtSenha"]));
			
			// verifica nas tabelas fiscais e usuarios se já existe um fiscal com este nome e se já existe umum usuario com este nome e/ou login
			$sql_fiscal=mysql_query("SELECT codigo FROM fiscais WHERE nome='$nome'");
			$sql_usuario=mysql_query("SELECT codigo FROM usuarios WHERE nome='$nome'");
			$sql_login=mysql_query("SELECT codigo FROM usuarios WHERE login='$login'");
			
			if(mysql_num_rows($sql_fiscal)>0)
				{
					Mensagem("Já existe um fiscal cadastrado com este nome!");
				}
			elseif(mysql_num_rows($sql_usuario)>0)
				{
					Mensagem("Já existe um usuário cadastrado com este nome");
				}	
			elseif(mysql_num_rows($sql_login)>0)
				{
					Mensagem("Já existe um usuário cadastrado com este login");
				}
			else
				{
					// cadastra o fiscal no banco
					mysql_query("INSERT INTO fiscais SET nome='$nome', estado = 'A'");
					add_logs('Inseriu o estado de um Fiscal');
					
					// cadastra o usuario do fiscal no banco
					mysql_query("INSERT INTO usuarios SET nome='$nome', login='$login', senha='$senha', tipo='prefeitura', nivel='M'");
					add_logs('Inseriu um Fiscal');
					Mensagem("Fiscal cadastrado com sucesso!");
				}		
		}
?>
<fieldset><legend>Cadastro de fiscais</legend>
	<form method="post" onSubmit="return ValidaFormulario('txtNome|txtLogin|txtSenha')">
		<table align="center" width="100%">
			<tr>
				<td width="9%">Nome<font color="#FF0000">*</font></td>
				<td width="91%"><input type="text" class="texto" name="txtNome" id="txtNome" /></td>
			</tr>
			<tr>
				<td>Login<font color="#FF0000">*</font></td>
				<td><input type="text" class="texto" name="txtLogin" id="txtLogin" /></td>
			</tr>
			<tr>
				<td>Senha<font color="#FF0000">*</font></td>
				<td><input type="password" class="texto" name="txtSenha" id="txtSenha" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" class="botao" name="btCadastrarFiscal" value="Cadastrar" /></td>
			</tr>
			<tr>
				<td colspan="2"><font color="#FF0000">* Dados Obrigatórios</font></td>
			</tr>
		</table>
		<input type="hidden" name="btCadastrar" value="Cadastrar" />
		<input type="hidden" name="include" id="include" value="<?php echo $_POST["include"];?>" />
	</form>
</fieldset>