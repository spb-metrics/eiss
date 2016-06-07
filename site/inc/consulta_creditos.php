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
<form action="tomadores.php" method="post">
<table width="500" border="0" align="center" style="margin-left:9px;" >
 <tr>  
  <td colspan="2" align="center" bgcolor="#FFFFCC" 
  style="font-family:Verdana, Arial, Helvetica, sans-serif;">
   <b>Consulta Créditos</b>  </td> 
 </tr>
 <tr>
   <td align="left">Tomador CPF/CNPJ<font color="#FF0000">*</font> </td>
   <td  align="left"><input type="text" name="txtTomadorCpfCnpj" size="20" class="texto" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" /></td>
 </tr>
 <tr>
  <td align="left">Selecione o per&iacute;odo<font color="#FF0000">*</font> </td>
  <td  align="left">
   <select name="txtAno" class="texto">    
	 <option ="2009">2009</option>
   </select>
  &nbsp;</td> 
 </tr>
  <tr> 
  <td colspan="2" align="center"><br /><br /> 
   <input type="submit" name="txtConsultaCredito" value="Consultar" class="botao" />  </td> 
 </tr>
</table>
</form>