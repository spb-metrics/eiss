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
<!-- box de conteúdos -->
<form name="frmAidfBox" method="post" action="aidf.php" id="frmAidfBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
    
	<table border="0" cellspacing="5" cellpadding="0">
	  <tr>
		<td width="190" align="center" valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="3" bgcolor="#CCCCCC"></td>
		  </tr>
		  <tr>
			<td height="10" bgcolor="#999999"></td>
		  </tr>
		  <tr>
			<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Prestador: Solicita&ccedil;&atilde;o de AIDF junto a Prefeitura</font><br />
						  <br />
				Com ela voc&ecirc; comprova a regularidade   do seu ISS.<br />        </td>
		  </tr>
		  <tr>
			<td height="1"></td>
		  </tr>
		  <tr>
			<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='solicitacao';frmAidfBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
		  </tr>
		</table>    
		
		</td>
		<td width="190" align="center" valign="top">
	
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="3" bgcolor="#CCCCCC"></td>
		  </tr>
		  <tr>
			<td height="10" bgcolor="#999999"></td>
		  </tr>
		  <tr>
			<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Prestador: Verifique Libera&ccedil;&atilde;o de AIDF junto a Prefeitura</font><br />            <br />
				Verifique se j&aacute; foi emitido a AIDF pela Prefeitura.</td>
		  </tr>
		  <tr>
			<td height="1"></td>
		  </tr>
		  <tr>
			<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='consulta';frmAidfBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
		  </tr>
		</table>        
		
		</td>
		<td width="190" align="center" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="3" bgcolor="#CCCCCC"></td>
		  </tr>
		  <tr>
			<td height="10" bgcolor="#999999"></td>
		  </tr>
		  <tr>
			<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Prestador: Verifique se a gr&aacute;fica tem autoriza&ccedil;&atilde;o da prefeitura</font><br />
			  <br /> 
			  As gr&aacute;ficas somente podem confeccionar NF com autoriza&ccedil;&atilde;o da Prefeitura.</td>
		  </tr>
		  <tr>
			<td height="1"></td>
		  </tr>
		  <tr>
			<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='grafica_autorizacao';frmAidfBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
		  </tr>
		</table>    
		
		</td>
	  </tr>
	  <tr>
		<td width="190" align="center" valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="3" bgcolor="#CCCCCC"></td>
		  </tr>
		  <tr>
			<td height="10" bgcolor="#999999"></td>
		  </tr>
		  <tr>
			<td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Gr&aacute;fica: Consulta da situa&ccedil;&atilde;o e libera&ccedil;&atilde;o da prefeitura</font><br />
			  <br /> 
			  Consultar a situa&ccedil;&atilde;o da gr&aacute;fica com a prefeitura.</td>
		  </tr>
		  <tr>
			<td height="1"></td>
		  </tr>
		  <tr>
			<td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='grafica_consulta';frmAidfBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
		  </tr>
		</table>    
		
		</td>
	  </tr>
	</table>
</form>    