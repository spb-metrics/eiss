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
<form method="post" name="frmValidarOperadora" id="frmValidarOperadora">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
</form>	
<? 
	// recebe a variavel que contem o número de verificação e a variavel que contém o número que o usuário digitou.
	$autenticacao  = $_SESSION['autenticacao'];
	$cod_seguranca = $_POST['codseguranca'];
	if($cod_seguranca == $_SESSION['autenticacao'] && $cod_seguranca){
		$sql = mysql_query("SELECT * FROM operadoras_creditos WHERE cnpj = '".$_POST['txtCNPJ']."'");	
		if(mysql_num_rows($sql) > 0){ 
			$dados = mysql_fetch_array($sql);
			//verifica se a empresa esta ativa	
			$login = $dados['cnpj'];	
			$sql = mysql_query("SELECT estado FROM operadoras_creditos WHERE cnpj ='$login'");	
			list($estado)=mysql_fetch_array($sql);
			if($estado == "A"){	
				//verifica se a senha digitada confere com a que está armazenada no banco	
				if($txtSenha == $dados['senha']){	   
					$_SESSION['OPERADORA'] = $dados['cnpj'];
					?><script>document.getElementById('frmValidarOperadora').submit();</script><?php		
				}else{
					print("<script language=JavaScript>alert('Senha não confere com a cadastrada no sistema! Favor verificar a senha.');
					document.getElementById('frmValidarOperadora').submit();</script>");	
				}	
			}else{
				print("<script language=JavaScript>alert('Instituição  desativada! Contate a Prefeitura.');
				document.getElementById('frmValidarOperadora').submit();</script>");
			}
		}else{
			print("<script language=JavaScript>alert('CPF/CNPJ não cadastrado no sistema! Favor verificar CPF/CNPJ.');
			document.getElementById('frmValidarOperadora').submit();</script>");
		} 
	}else{
		print("<script language=JavaScript>alert('Favor verificar código de segurança!');
		document.getElementById('frmValidarOperadora').submit();</script>");
	} 
?> 