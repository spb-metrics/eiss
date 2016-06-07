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

if(isset($_POST["COD"])){
	$cod_grafica=$_POST["COD"];
	mysql_query("UPDATE graficas SET estado='A' WHERE codigo='$cod_grafica'");
	Mensagem("Grafica Liberada");
}
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="600" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Gráficas - Liberar</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
   <fieldset>
   <legend>Liberar Acesso</legend>
<?php    
$sql_buscaempresa = mysql_query("SELECT codigo, nome, cnpjcpf FROM graficas WHERE estado = 'NL' ORDER BY nome ASC");
if(mysql_num_rows($sql_buscaempresa)){
?>
   <form action="" method="post" id="frmLiberar">
   		<input type="hidden" name="include" id="include" value="<?php echo $_POST['include'];?>" />
		<input type="hidden" name="COD" id="COD" />
		<input type="hidden" name="btLiberarEmpresa" id="btLiberarEmpresa"/>
   <table width="100%" align="center" cellpadding="0" cellspacing="1">    
    <tr> 
	 <td width="60%" align="center" bgcolor="#999999">Nome</td>
	 <td width="25%" align="center" bgcolor="#999999">CNPJ/CPF</td>
	 <td width="15%" align="center" bgcolor="#999999"></td>
    </tr>
	
	<?php 
while(list($codigo, $nome, $cnpjcpf)=mysql_fetch_array($sql_buscaempresa)) {
	
	?>	
     <tr> 
	  <td align="left" bgcolor="#FFFFFF" >&nbsp;<?php echo $nome; ?></td>
	  <td align="center" bgcolor="#FFFFFF"><?php echo $cnpjcpf; ?></td>
	  <td align="center"><a onclick="document.getElementById('COD').value='<?php echo $codigo; ?>';document.getElementById('btLiberarEmpresa').value='T';document.getElementById('frmLiberar').submit();"><img src="img/botoes/botao_ativar.jpg" /></a></td>
     </tr>  

	<?php
	} // im while
	 ?> 
   	 
   </table>  
   </form> 
<?php
}else{
?>
	<table width="100%">
    	<tr>
        	<td align="center">Nenhuma Gráfica aguardando liberação</td>
        </tr>
    </table>
<?php
}
?>
    
   </fieldset>
   
	</td>
	<td width="19" background="img/form/lateraldir.jpg"></td>
  </tr>
  <tr>
    <td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
    <td background="img/form/rodape_fundo.jpg"></td>
    <td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
  </tr>
</table>

