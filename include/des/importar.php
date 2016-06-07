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
<form method="post" enctype="multipart/form-data" action="include/des/verifica_xml.php">

<table width="580" border="0" cellpadding="0" cellspacing="1">
    <tr>
		<td width="5%" height="10" bgcolor="#FFFFFF"></td>
        <td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Enviar Declara&ccedil;&otilde;es</td>
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
	  <td colspan="3" bgcolor="#CCCCCC">
		
			  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="2">
				  <tr>
					  <td width="33%" align="left">
						  Arquivo de Remessa (xml)</td>
					  <td width="67%" align="left" >
				    <input type="file" name="arquivoxml" class="texto">						</td>
				  </tr>
				  <tr>
					  <td align="left">&nbsp;</td>
				      <td align="left"><input type="submit" name="btImportar" class="botao" value="Importar"></td>
				  </tr>
				  <tr>
					  <td  colspan="2">
					    <em>Importação do arquivo no formato xml com os dados compatíveis com<br>o sistema para realizar a declaração.</em>                      </td>
				  </tr>
					<tr>
					  <td  colspan="2" align="right"><img src="img/xml.jpg" width="112" height="38" border="0" usemap="#Map"></td>
			    </tr>
			  </table>		 
	  </td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
			
<map name="Map">
	<area shape="rect" coords="34,23,72,32" href="modelosxml/modelodes.xml" target="_blank" alt="Modelo de XML" title="Modelo de XML">
    <area shape="rect" coords="89,23,97,31" href="http://pt.wikipedia.org/wiki/XML" target="_blank" alt="Wikipedia" title="Wikipedia">
</map>