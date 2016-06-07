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
	if(!($_SESSION['SESSAO_cnpj_emissor']))
	{
?>
		<form action="inc/certidoes/verifica.php" method="post" onSubmit="return ValidaFormulario('txtCNPJCPF')">
		<input type="hidden" name="txtMenu" value="<?php echo $_POST['txtMenu']; ?>" />
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="250" align="center" bgcolor="#FFFFFF" rowspan="3">Certid&otilde;es Negativas - Informe seus dados</td>
      <td width="320" bgcolor="#FFFFFF"></td>
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
				<td width="19%" align="left">CNJP/CPF</td>
		<td width="81%" align="left">
		    <input type="text" name="txtCNPJCPF" id="txtCNPJCPF" class="texto" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"  maxlength="18"> 
		    <em>Somente n&uacute;meros</em> </td>
		  </tr>
			<tr>
				<td align="center">&nbsp;</td>
			    <td align="left" valign="middle"><input type="submit" name="btVerificarCertidao" id="btVerificarCertidao" value="Consultar" class="botao" /></td>
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
	 else
	 {	 	  
   	  include($_SESSION['SESSAO_menu_certidoes'].".php");
	 }
	 
	 ?>