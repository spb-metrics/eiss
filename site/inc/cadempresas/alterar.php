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
<div style="display:none">
	<form method="post" action="../../cadempresas.php" id="frmVoltar" name="frmVoltar">
		<input type="text" name="txtMenu" id="txtMenu" value="alterar_form" />
	</form>
</div>	
<?php
	session_start();
	include("../conect.php");
    include("../../../funcoes/util.php");
	
	if($_POST["btAlterar"]=="Alterar")
		{
			$logradouro=trataString($_POST["txtLogradouro"]);
            $numero=trataString($_POST['txtNumero']);
            $complemento=trataString($_POST['txtComplemento']);
            $bairro=trataString($_POST['txtBairro']);
            $cep=trataString($_POST['txtCEP']);
			$email=trataString($_POST["txtEmail"]);
			$fonecomercial=trataString($_POST["txtFoneComercial"]);
			$fonecelular=trataString($_POST["txtFoneCelular"]);
			$senha=md5($_POST["txtSenha"]);
			
			mysql_query("UPDATE cadastro
                         SET logradouro='$logradouro',
                         numero='$numero',
                         complementto='$complemento',
                         bairro='$bairro',
                         cep='$cep',
                         email='$email',
                         fonecomercial='$fonecomercial',
                         fonecelular='$fonecelular',
                         senha='$senha'
                         WHERE cnpjcpf='".$_SESSION["issempresa"]."'");
		}		
	elseif($_POST["btSair"]=="Sair")
		{		
			session_destroy();
		}	
?>
<script>
	alert("Dados alterados com sucesso!");
	document.getElementById('frmVoltar').submit();
</script>