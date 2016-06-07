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
	$emissor_CNPJ = $_SESSION['login'];
	$sql_emissor=mysql_query("
		SELECT codigo, 
			   nome, 
			   razaosocial, 
			   logradouro,
			   numero,
			   complemento,
			   bairro,
			   cep, 
			   municipio, 
			   uf, 
			   email,
			   estado
		FROM cadastro
		WHERE cnpj='$emissor_CNPJ' OR cpf='$emissor_CNPJ'
	");		  
	list($cod_emissor,$nome_emissor,$razao_emissor,$logradouro_emissor,$numero_emissor,
		$complemento_emissor,$bairro_emissor,$cep_emissor,$municipio_emissor,
		$uf_emissor,$email_emissor,$estado_emissor,$simplesnacional)=mysql_fetch_array($sql_emissor);


?>
<form id="frmGuia" method="post" name="frmDesRetificar" target="_parent">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
		
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
		    <td width="25%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Retificação de DES</td>
	        <td width="70%" bgcolor="#FFFFFF"></td>
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
	
			<table width="100%" height="100%" border="0" align="center" cellpadding="3" cellspacing="2">
				<tr>
					<td width="27%" align="left" valign="middle">CNPJ:</td>
				    <td width="73%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $emissor_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $razao_emissor;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$logradouro_emissor - $numero_emissor - $complemento_emissor - $municipio_emissor - $uf_emissor";?></td>
			  	</tr>
				<tr>
				  <td colspan="2" align="center" valign="top" id="Container">
						<script>acessoAjax("include/des/cancelardes.ajax.php","","Container");</script>
							
				  </td>
		</tr>
		<tr>
	    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
		</tr>
	</table>    
	    
    	  </td>
		</tr>  
	</table>
</form>

