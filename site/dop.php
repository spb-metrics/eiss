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
  session_start();
  
  // arquivo de conexão com o banco
  require_once("inc/conect.php"); 
  
  // arquivo com funcoes uteis
  require_once("../funcoes/util.php");
  //print("<a href=index.php target=_parent><img src=../img/topos/$TOPO></a>");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>E-ISS</title>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<link href="../css/padrao_site.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="760" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include("inc/topo.php"); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" height="400" valign="top" align="center">
	
<table height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170" rowspan="2" align="left" valign="top" background="../img/menus/menu_fundo.jpg"><?php include("inc/menu.php"); ?></td>
    <td width="590" height="100" align="center" valign="top"><img src="../img/cabecalhos/orgaos.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">
	<?php
	if($_POST["txtMenu"]){
		
		include($_POST["txtMenu"]);
	}else{ 
	?>
    
    
<?php
    // busca o codigo do tipo operadora_credito
    $sql_codtipo=mysql_query("SELECT codigo FROM tipo WHERE tipo='orgao_publico'");
    list($codtipo)=mysql_fetch_array($sql_codtipo);
?>
<!-- box de conteúdos -->
<form name="frmDecBox" method="post" id="frmDecBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
	<input type="hidden" name="txtTipo" id="txtTipo" />
    <input type="hidden" name="txtCodTipo" id="txtCodTipo" value="<?php echo $codtipo; ?>" >
    
<table border="0" cellspacing="5" cellpadding="0" align="left">
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Acessar Sistema</font><br />
                      <br />
                      Acesso ao sistema de declara&ccedil;&atilde;o de org&atilde;os p&uacute;blicos.<br />
        </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtTipo').value='dop';document.getElementById('frmDecBox').action='../login.php';frmDecBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Cadastro de &Oacute;rg&atilde;os P&uacute;blicos (DOP)</font><br />
                      <br />
                      Cadastro do Org&atilde;o P&uacute;blico. </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='../include/dop/cadastro.php';frmDecBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
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
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Consulta de cadastro para &Oacute;rg&atilde;os P&uacute;blicos (DOP)</font><br />
                      <br />
                      Consulta da situa&ccedil;&atilde;o do Org&atilde;o P&uacute;blico.<br />
        </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="20" align="left" bgcolor="#859CAD"><a onclick="document.getElementById('txtMenu').value='../include/dop/consulta_situacao.php';frmDecBox.submit();" href="#" class="box">&nbsp;<img src="../img/box/web.png" width="14" height="14" /> Servi&ccedil;o on-line</a></td>
      </tr>
    </table>    
    
    </td>
  </tr>

</table>


    
    
    
    
    
    
    
</form>    
    <?php }//fim else de menus. ?>
    </td>
  </tr>
</table>



	</td>
  </tr>
</table>
<?php include("inc/rodape.php"); ?>
<?php include("inc/teclado.php");?>

</body>
</html>
