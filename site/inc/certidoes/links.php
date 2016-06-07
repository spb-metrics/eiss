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
<form name="frmCertidoes" method="post" id="frmCertidoes">
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Emiss&atilde;o de Certid&atilde;o Negativa de D&eacute;bitos de  ISS</font><br />
            <br />
Com ela voc&ecirc; comprova a regularidade   do seu ISS.<br />        </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD">&nbsp;<a onclick="document.getElementById('txtMenu').value='debitos';frmCertidoes.submit()" href="#" class="box"><img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Emiss&atilde;o de Certid&atilde;o Negativa de Pagamentos de ISS</font><br /><br>
Confirme a autenticidade da Certid&atilde;o Negativa de Tributo.</td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='pagamentos';frmCertidoes.submit()" href="#" class="box"><img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Verificação de Autenticidade de Certid&atilde;o de ISS<br />
        </font> <br />
        Verifique a validade das Certidões Negativas / Pagamentos de ISS</td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='verifautenticidade';frmCertidoes.submit()" href="#" class="box"><img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
      </tr>
    </table>    
    
    </td>
  </tr>
</table>
</form>    
<!-- box de conteúdos -->