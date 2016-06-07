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
  include("inc/conect.php"); 
  
  // arquivo com funcoes uteis
  include("../funcoes/util.php");
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
    <td width="590" height="100" align="center" valign="top"><img src="../img/cabecalhos/contato.jpg" width="590" height="100" /></td>
  </tr>
  <tr>
    <td align="center" valign="top">


<!-- box de conteúdos -->
<form name="frmDesBox" method="post" id="frmDesBox">
	<input type="hidden" name="txtMenu" id="txtMenu" />
	<input type="hidden" name="txtCNPJ" id="txtCNPJ" />
    
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td align="center" valign="top">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Via Internet</font><br />
          <br />         
          <table width="374" border="0" cellspacing="4" cellpadding="0">
            <tr>
              <td width="110" align="left">Assunto:</td>
              <td width="258" align="left" colspan="3"><input type="text" name="txtAssunto" id="txtAssunto" class="texto" size="40" /></td>
            </tr>
            <tr>
              <td align="left">Nome:</td>
              <td align="left" colspan="3"><label title="Nome"><input type="text" name="txtNome" id="txtNome" class="texto" size="40" /></label></td>
            </tr>
            <tr>
              <td align="left">E-mail:</td>
              <td align="left" colspan="3"><input type="text" name="txtEmail" id="txtEmail" class="texto" size="40" /></td>
            </tr>
            <tr>
              <td align="left">Sexo:</td>
              <td colspan="2" align="left"><input type="radio" name="rdSexo" id="rdSexo" value="M" />Masculino</td>
			  <td align="left"><input type="radio" name="rdSexo" id="rdSexo" value="F" />Feminino</td>
            </tr>
            <tr>
              <td align="left">Idade:</td>
              <td align="left" colspan="3">
			  	<select name="cmbIdade" id="cmbIdade" class="combo">
					<option value=""></option>
					<option value="15 a 19">15 a 19</option>
					<option value="20 a 24">20 a 24</option>
					<option value="25 a 29">25 a 29</option>
					<option value="30 a 34">30 a 34</option>
					<option value="35 a 39">35 a 39</option>
					<option value="40 a 44">40 a 44</option>
					<option value="Acima de 45">Acima de 45</option>
				</select>			  </td>
            </tr>
            <tr>
              <td align="left">Escolaridade:</td>
              <td align="left" colspan="3">
			  	<select name="cmbEscolaridade" id="cmbEscolaridade" class="combo">
					<option value=""></option>
					<option value="Ensino Medio incompleto">Ensino Medio incompleto</option>
					<option value="Ensino Medio completo">Ensino Medio completo</option>
					<option value="Ensino Superior incompleto">Ensino Superior incompleto</option>
					<option value="Ensino Superior completo">Ensino Superior completo</option>
				</select>			  </td>
            </tr>
            <tr>
              <td align="left">Cidade:</td>
              <td align="left"><input type="text" name="txtCidade" id="txtCidade" class="texto" size="20" /></td>
              <td align="left">Estado:</td>
              <td align="left"><input name="txtEstado" type="text" class="texto" id="txtEstado" size="3" maxlength="2" /></td>
            </tr>
            <tr>
              <td align="left">Mensagem:</td>
              <td align="left" colspan="3"><textarea name="txtMensagem" id="txtMensagem" class="texto" rows="50" cols="40"></textarea></td>
            </tr>
            <tr>
              <td align="left">
			  	<label></label>			  </td>
              <td colspan="3" align="left"><input name="btEnviar" type="submit" class="botao" id="btEnviar" value="Enviar" 
				 	onclick="return ValidaFormulario('txtAssunto|txtNome|txtEmail|cmbIdade|rdSexo|txtCidade|txtEstado|txtMensagem')" /></td>
              </tr>
          </table>
          <br />        </td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>    </td>
    <td width="190" align="center" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
      </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
      </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo"> Via Telefone</font>
          <br />
          <br />          
          A  Central da Prefeitura Municipal fornece informa&ccedil;&otilde;es sobre os  servi&ccedil;os p&uacute;blicos municipais. Saiba que assuntos podem ser esclarecidos por meio da Central.</td>
      </tr>
      <tr>
        <td height="1"></td>
      </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
      </tr>
    </table>
    <br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="3" bgcolor="#CCCCCC"></td>
        </tr>
      <tr>
        <td height="10" bgcolor="#999999"></td>
        </tr>
      <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC" style="padding:5px;"><font class="boxTitulo">Via Presencial</font><br />
          <br />            
          A  Pra&ccedil;a de Atendimento da Secretaria Municipal de Finan&ccedil;as est&aacute;  localizada.  Saiba como &eacute; efetuado o atendimento ao contribuinte nesse local.</td>
        </tr>
      <tr>
        <td height="1"></td>
        </tr>
      <tr>
        <td height="5" align="left" bgcolor="#859CAD"></td>
        </tr>
    </table></td>
  </tr>
</table>
    
    
    
    
</form>    


	     
    </td>
  </tr>
</table>

	</td>
  </tr>
</table>
<?php include("inc/rodape.php"); 
include("inc/teclado.php");
?>

<?php
	if($_POST["btEnviar"] == "Enviar"){
		//recebe o formulário, monta corpo do email
		$corpo  = "Formulário enviado:\n";
		$corpo .= "Especificaçao: ISSdigital\n";
		$corpo .= "Assunto: ".$_POST["txtAssunto"] . "\n";
		$corpo .= "Nome: ".$_POST["txtNome"] . "\n";
		$corpo .= "Email: ".$_POST["txtEmail"] . "\n";
		$corpo .= "Sexo: ".$_POST["rdSexo"] . "\n";
		$corpo .= "Idade: ".$_POST["cmbIdade"] . "\n";
		$corpo .= "Escolaridade: ".$_POST["cmbEscolaridade"] . "\n";
		$corpo .= "Cidade: ".$_POST["txtCidade"] . "\n";
		$corpo .= "Estado: ".$_POST["txtEstado"] . "\n";
		$corpo .= "Texto: ".$_POST["txtMensagem"] . "\n";
		
		//Usa a funcao mail com os parametros, email do destinatario, Assunto e o corpo com as informacoes da mensagem
		mail($CONF_EMAIL,"ISSdigital",$corpo);
		Mensagem("Email enviado com sucesso!");
	}
?> 




</body>
</html>
