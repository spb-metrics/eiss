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
if(!$_POST['txtCNPJ']&&!$_POST['txtInscMunicipal']){
	$_SESSION['autenticacao'] = rand(10000,99999);
	
	if($_POST['txtMenu']=='semtomador'||
	 	$_POST['txtMenu']=='comtomador'||
	 	$_POST['txtMenu']=='segundavia_prestador'||
	 	$_POST['txtMenu']=='guia_pagamento'||
	 	$_POST['txtMenu']=='prestadores_cancelardes'||
	 	$_POST['txtMenu']=='guia_pagamento_issretido') {
	 	
	 	$login_seguro = true;
	 }
?>
	<form method="post" name="frmCNPJ">
	<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="165" align="center" bgcolor="#FFFFFF" rowspan="3">DES - Informe seu dados</td>
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
		<td height="60" colspan="3" bgcolor="#CCCCCC">

		<table width="98%" height="100%" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr>
				<td width="19%" align="left">CNPJ/CPF</td>
			    <td width="81%" align="left" valign="middle"><em>
			      <input class="texto" type="text" title="CNPJ" name="txtCNPJ"  id="txtCNPJ"  tabindex="1"/>
			    Somente n&uacute;meros</em></td>
			</tr>
		<?php if($login_seguro) {
		?>
			<tr>
				<td align="left">Senha</td>
				<td align="left">
					<input class="texto" type="password" title="Senha" name="txtSenha" id="txtSenha" tabindex="2" />
					<a href="recuperarsenha.php" tabindex="9">Recuperar Senha</a>
				</td>
			</tr>
			<tr>
				<td align="left">Cod Verificação</td>
				<td align="left">
					<input class="texto" type="text" title="IM" name="codseguranca" id="codseguranca" size="5" maxlength="5" tabindex="3" />
					<img style="cursor: pointer;" onclick="mostrar_teclado();" src="../img/botoes/num_key.jpg" title="Teclado Virtual" >&nbsp;
					<?php include("inc/cod_verificacao.php");?>
				</td>
			</tr>
			
		<?php } else {?>
			<tr>
			  <td align="left">ou</td>
			  <td align="left" valign="middle">&nbsp;</td>
		  	</tr>
			<tr>
			  <td align="left">Insc. Municipal</td>
			  <td align="left" valign="middle">
			    <input class="texto" type="text" title="IM" name="txtInscMunicipal" id="txtInscMunicipal" tabindex="4" />
			  </td>
		  	</tr>
		<?php } ?>
			<tr>
			  <td align="center">&nbsp;</td>
			  <td align="left" valign="middle">
				  <input type="submit" value="Avançar" class="botao" onclick="return verificaCnpjCpfIm();" tabindex="5" />
				  <input class="botao" value="Voltar" type="button" onclick="parent.location = 'des.php';" tabindex="6" />
			  </td>
		  </tr>
	  </table>		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
	
<?php 
}
else{
  $codverificacao=$_POST["codseguranca"];
  if($codverificacao==$_SESSION['autenticacao']||!$login_seguro )
  	{
  		include($_POST['txtMenu'].".php");
	}
  else
  	{
		Mensagem("Código de verificação inválido");
		Redireciona("des.php");
	}			
}

?>	