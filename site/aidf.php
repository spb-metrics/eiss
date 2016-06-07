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
  
  // arquivo de conex�o com o banco
  require_once("inc/conect.php");
  //require_once("inc/conecta.pg.php"); 
  
  // arquivo com funcoes uteis
  require_once("../funcoes/util.php");
  //print("<a href=index.php target=_parent><img src=../img/topos/$TOPO></a>");
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>E-ISS</title>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>
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
    <td width="590" height="100" align="center" valign="top"><img src="../img/cabecalhos/aidf.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">
	<?php 
	//Conecta o banco de dados do postgress
	//require_once("../../midware/conecta.pg.php");
	
	
	if($_POST["txtMenu"]=="solicitacao"){
	include("inc/aidf/solicitacao.php");
	}elseif($_POST["txtMenu"]=="consulta"){
	include("inc/aidf/consulta.php");
	}elseif($_POST["txtMenu"]=="grafica_cadastro"){
	include("inc/aidf/grafica_cadastro.php");
	}elseif($_POST["txtMenu"]=="grafica_consulta"){
	include("inc/aidf/grafica_consulta.php");
	}elseif($_POST["txtMenu"]=="grafica_atualizar"){
	include("inc/aidf/grafica_atualizar.php");
	}elseif($_POST["txtMenu"]){
	include("inc/aidf/index.php");
	}else{
	include("inc/aidf/links.php"); //listar os menus do aidf
	} ?>
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
