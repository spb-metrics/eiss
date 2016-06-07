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
    // busca o codigo do tipo operadora_credito
    $sql_codtipo=mysql_query("SELECT codigo FROM tipo WHERE tipo='operadora_credito'");
    list($codtipo)=mysql_fetch_array($sql_codtipo);
?>
<!-- box de conteúdos -->
<form name="frmDocBox" method="post" id="frmDocBox">
	<input type="hidden" name="txtTipo" id="txtTipo" />
	<input type="hidden" name="txtMenu" id="txtMenu" />
    <input type="hidden" name="txtCodTipo" id="txtCodTipo" value="<?php echo $codtipo; ?>" >
    
<table border="0" cellspacing="5" cellpadding="0" align="left">
  <tr>
    <td width="190" align="center" valign="top">
    
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="135" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Acessar Sistema</font><br />
                      <br />
                      Acesso ao sistema de operadoras de crédito.<br /></td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onClick="document.getElementById('txtTipo').value='doc';document.getElementById('frmDocBox').action='../login.php';frmDocBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="135" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Cadastro de Operadoras de cr&eacute;dito</font><br />
            <br />
          Cadastro de Operadoras de cr&eacute;dito.</td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onClick="document.getElementById('txtMenu').value='../include/doc/cadastro';frmDocBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="135" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta de Operadoras de cr&eacute;dito</font><br />
            <br />
          Consulta de Operadoras de cr&eacute;dito.</td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onClick="document.getElementById('txtMenu').value='include/doc/consulta.php';frmDocBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</form>    
