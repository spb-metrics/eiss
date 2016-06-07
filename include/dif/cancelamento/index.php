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
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="form">
  <tr>
    <td>
		<fieldset><legend>Cancelamento CIF</legend>
		<?php
			//testa se o usuario fez login, se tiver feito verifica as informacoes digitadas com as ja existentes no banco
				if(!$_POST['txtCNPJ']){
					if($_POST["hdLogin"]){ include('dif_login_atualizar.php');}
				} else {
					if($_SESSION['autenticacao'] != $_POST['codseguranca']){
						if($_POST['autenticacao'] != $_POST['codseguranca']){
							Mensagem("Favor verificar código de segurança!");
							Redireciona("dif.php");
						}//fim if
					}//fim if
					if($_POST['txtCNPJ']){
						$sql_senha = mysql_query("SELECT senha FROM inst_financeiras WHERE cnpj = '".$_POST["txtCNPJ"]."' AND estado = 'A'");
						list($senha) = mysql_fetch_array($sql_senha);
						if(mysql_num_rows($sql_senha)>0){
							if($_POST["txtSenha"]){
								if($_POST["txtSenha"] != $senha){
									Mensagem("A senha não confere com a cadastrada");
									Redireciona("dif.php");
								}//fim if
							}else{
								Mensagem("Digite a senha");
								Redireciona("Dif.php");
							}//fim else senha existe
						}else{
						  Mensagem("Este CNPJ ainda não foi ativado!");
						  Redireciona("dif.php");
						}//fim else cnpj teste
					}else{
						Mensagem("Digite o CNPJ!");
						Redireciona("dif.php");
					}//fim else cnpj existe
				}//fim else
				
				include("inc/dif/cancelamento/cancelar.php");	
		?>
		</fieldset>
	</td>
</table>
