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
if(!$_POST['txtCNPJ']){
	include 'login.php';
} else {
	$tomador_CNPJ = $_POST['txtCNPJ'];		  
	
	$sql_tomador=mysql_query("
		SELECT codigo, 
			   nome,  
			   logradouro, 
			   numero,
			   complemento, 
			   municipio, 
			   uf, 
			   email
		FROM cadastro
		WHERE 
			cnpj='$tomador_CNPJ' OR
			cpf='$tomador_CNPJ'
	");		  
	if(!mysql_num_rows( $sql_tomador ))	{
		Mensagem("CNPJ/CPF inválido! Favor verificar");
		Redireciona("des.php");
	}else{
		list($cod_tomador,$nome_tomador,$logradouro_tomador,$numero_tomador,$complemento_tomador,$municipio_tomador,$uf_tomador,$email_tomador)=mysql_fetch_array($sql_tomador);
		$endereco_tomador = "$logradouro_tomador, $numero_tomador";
		if($complemento_tomador) 
			$endereco_tomador .= ", $complemento_tomador";
		?>
<form id="frmGuia" method="post" name="frmDesIssRetificar" target="_parent">
	<input type="hidden" name="hdCodGuia" id="hdCodGuia" value="" />
	<input type="hidden" name="c" value="<?php echo $cod_tomador; ?>" />
	<table width="580" border="0" cellpadding="0" cellspacing="1">
		<tr>
			<td width="5%" height="10" bgcolor="#FFFFFF"></td>
		    <td width="50%" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">DES - Cancelamento da DES ISS Retido</td>
	        <td width="45%" bgcolor="#FFFFFF"></td>
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
					<td width="26%" align="left" valign="middle">CNPJ:</td>
				    <td width="74%" align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $tomador_CNPJ; ?></td>
				</tr>
				<tr>
				  <td align="left" valign="middle">Raz&atilde;o Social:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo $nome_tomador;?></td>
			  	</tr>
				<tr>
				  <td align="left" valign="middle">Endere&ccedil;o:</td>
				  <td align="left" valign="middle" bgcolor="#FFFFFF"><?php echo "$endereco_tomador - $municipio_tomador - $uf_tomador";?></td>
			  	</tr>
			  	<tr>
			  		<td colspan="2" align="center" valign="top" id="Container">
						<script>acessoAjax("../include/des/tomador_cancelardes.ajax.php?c=<?php echo $cod_tomador?>&e=e","","Container");</script>
							
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
	<?php
	}//fim if orgao
}//fim if post de cnpj
?>