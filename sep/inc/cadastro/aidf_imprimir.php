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
require_once("../conect.php");
require_once("../../funcoes/util.php"); 


/*if(isset($_POST['btLiberar'])){
	include("../../../../sepiss/inc/prestadores/aidf_liberar.php");
}*/


if(isset($_POST)){
	$codaidf = $_REQUEST['hdCodAidf'];
	
	//Verifica se a variavel tem valor se nao tiver recebe o valor de otro hidden
	if($codaidf == ""){ 
		$codaidf = /*base64_decode*/($_REQUEST["txtCodAidf"]);
	}
	
	//dados do emissor e da grafica
	$sql_aidf = mysql_query("
						SELECT cadastro.razaosocial as emissor_razao,
							   cadastro.nome as emissor_nome,
							   cadastro.cnpj as emissor_cnpj,
							   cadastro.cpf as emissor_cpf,
							   cadastro.inscrmunicipal as emissor_im,
							   cadastro.logradouro as emissor_logradouro,
							   cadastro.numero as emissor_numero,
							   cadastro.complemento as emissor_complemento,
							   cadastro.bairro as emissor_bairro,
							   cadastro.cep emissor_cep,	
							   cadastro.municipio as emissor_municipio,
							   cadastro.uf as emissor_uf,
							   grafica.razaosocial as grafica_razao,
							   grafica.cnpj as grafica_cnpj,
							   grafica.cpf as grafica_cpf,
							   grafica.inscrmunicipal as grafica_im,
							   grafica.logradouro as grafica_logradouro,
							   grafica.numero as grafica_numero,
							   grafica.complemento as grafica_complemento,
							   grafica.bairro as grafica_bairro,
							   grafica.cep grafica_cep,	
							   grafica.municipio as grafica_municipio,
							   grafica.uf as grafica_uf,
							   DATE_FORMAT(aidf.data,'%m/%d/%Y'),
							   aidf.observacoes
						FROM aidf_solicitacoes as aidf
						INNER JOIN cadastro as cadastro ON aidf.codemissor=cadastro.codigo
						INNER JOIN cadastro as grafica ON aidf.codgrafica=grafica.codigo
						WHERE aidf.codigo='$codaidf'
						");
	list($emissor_razao,$emissor_nome,$emissor_cnpj,$emissor_cpf,$emissor_im,$emissor_logradouro,$emissor_numero,$emissor_complemento,$emissor_bairro,$emissor_cep,$emissor_municipio,$emissor_uf,
		 $grafica_razao,$grafica_cnpj,$grafica_cpf,$grafica_im,$grafica_logradouro,$grafica_numero,$grafica_complemento,$grafica_bairro,$grafica_cep,$grafica_municipio,$grafica_uf,
		 $data,$observacoes)=mysql_fetch_array($sql_aidf);
	if(!$emissor_cnpj){
		$emissor_cnpj=$emissor_cpf;
	}
	if(!$grafica_cnpj){
		$grafica_cnpj=$grafica_cpf;
	}
		
	//documentos solicitados dentro da aidf	 
	$sql_docs = mysql_query("
						SELECT 
							   serie,
							   subserie,
							   especie,
							   nroinicial,
							   nrofinal,
							   quantidade,
							   tipo
						FROM aidf_docs

						WHERE codsolicitacao='$codaidf'
					");
				/*while(list($serie,$especie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo)=mysql_fetch_array($sql_docs)) {
					echo "DOC:  $serie,$especie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo<br>";
				 }
				}*/
				
	mysql_query("UPDATE aidf_solicitacoes SET confirmar = 's' WHERE codigo = '$codaidf'");
	//mysql_query("DELETE FROM aidf_docs WHERE codsolicitacao = '$codaidf'");

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>AIDF : Imprimir</title>
<link href="../../css/imprimir_aidf.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {font-size: 8px;}
-->
</style>
</head>
<body>
<div id="div">
	<input name="btImprimir" id="btImprimir" type="button" value="Imprimir" onClick="document.getElementById('div').style.display='none';print()" />
</div>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="5">
	<tr>
		<td align="center">
			<table border="0" cellspacing="5" cellpadding="0">
				<tr>
					<td width="120" align="left" valign="top">
					
					<img src="../../img/brasoes/<?php echo $CONF_BRASAO; ?>"></td>
					<td width="550" align="left" valign="top"> 
						<span class="txtEstado">
						Estado 
						<?php 
						$estado = $CONF_ESTADO;
						echo estadoExtenso($estado);
						?>
						</span><br>
						<span class="txtPrefeitura">PREFEITURA MUNICIPAL DE 
						<?php echo strtoupper($CONF_CIDADE);
						
						?>
						</span><br>
						<span class="txtSecretaria">
						<?php $sql_sec = mysql_query("SELECT secretaria FROM configuracoes"); 
									list($sec)= mysql_fetch_array($sql_sec);
									echo $sec;?>
						</span><br>
						<span class="txtTitulo01">AUTORIZAÇÃO PARA IMPRESSÃO DE DOCUMENTOS FISCAIS<br>
						PRESTAÇÃO DE SERVIÇOS</span> </td>
					<td width="130" align="right" valign="top">Página: 1/1<br>
						Data: <?php echo date("d/m/Y"); ?></td>
				</tr>
			</table>		</td>
	</tr>
	<tr>
		<td align="right" class="txtAidf">AIDF N&ordm;
			<?php echo $codaidf; ?>		</td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
				<tr>
					<td width="800" height="25" colspan="4" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">ESTABELECIMENTO GR&Aacute;FICO</td>
				</tr>
				<tr>
					<td colspan="4" align="left"><span class="tblLabel">Gr&aacute;fica:</span><br>
						<span class="tblCampo"><?php echo $grafica_razao; ?> </span></td>
				</tr>
				<tr>
					<td colspan="3" align="left"><span class="tblLabel">CNPJ/CPF:</span><br>
						<span class="tblCampo"><?php echo $grafica_cnpj; ?> </span></td>
					<td align="right"><span class="tblLabel">Inscri&ccedil;&atilde;o Municipal:</span><br>
						<span class="tblCampo"><?php echo verificaCampo($grafica_im); ?> </span></td>
				</tr>
				<tr>
					<td colspan="2" align="left"><span class="tblLabel">Endere&ccedil;o:</span><br>
						<span class="tblCampo"><?php echo $grafica_logradouro; ?> </span></td>
					<td align="right"><span class="tblLabel">N&uacute;mero:</span><br>
						<span class="tblCampo"><?php echo $grafica_numero; ?> </span></td>
					<td align="right"><span class="tblLabel">Complemento:</span><br>
						<span class="tblCampo"><?php echo verificaCampo($grafica_complemento); ?> </span></td>
				</tr>
				<tr>
					<td align="left"><span class="tblLabel">Bairro:</span><br>
						<span class="tblCampo"><?php echo $grafica_bairro; ?> </span></td>
					<td align="right"><span class="tblLabel">Cidade:</span><br>
						<span class="tblCampo"><?php echo $grafica_municipio; ?> </span></td>
					<td align="right"><span class="tblLabel">UF:</span><br>
						<span class="tblCampo"><?php echo $grafica_uf; ?> </span></td>
					<td align="right"><span class="tblLabel">CEP:</span><br>
						<span class="tblCampo"><?php echo $grafica_cep; ?> </span></td>
				</tr>
			</table>		</td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
				<tr>
					<td width="800" height="25" colspan="4" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">ESTABELECIMENTO USU&Aacute;RIO</td>
				</tr>
				<tr>
					<td colspan="4" align="left"><span class="tblLabel">Nome/Raz&atilde;o Social:</span><br>
						<span class="tblCampo"><?php echo $emissor_razao; ?> </span></td>
				</tr>
				<tr>
					<td colspan="4" align="left"><span class="tblLabel">Nome Fantasia:</span><br>
						<span class="tblCampo"><?php echo $emissor_nome ?> </span></td>
				</tr>		
				<tr>
					<td colspan="3" align="left"><span class="tblLabel">CNPJ/CPF:</span><br>
				  <span class="tblCampo"><?php echo $emissor_cnpj; ?> </span></td>
					<td align="right"><span class="tblLabel">Inscri&ccedil;&atilde;o Municipal:</span><br>
						<span class="tblCampo"><?php echo verificaCampo($emissor_im); ?> </span></td>
				</tr>
				<tr>
					<td colspan="2" align="left"><span class="tblLabel">Endere&ccedil;o:</span><br>
						<span class="tblCampo"><?php echo $emissor_logradouro; ?> </span></td>
					<td align="right"><span class="tblLabel">N&uacute;mero:</span><br>
						<span class="tblCampo"><?php echo $emissor_numero; ?> </span></td>
					<td align="right"><span class="tblLabel">Complemento:</span><br>
						<span class="tblCampo"><?php echo verificaCampo($emissor_complemento); ?> </span></td>
				</tr>
				<tr>
					<td align="left"><span class="tblLabel">Bairro:</span><br>
						<span class="tblCampo"><?php echo $emissor_bairro; ?> </span></td>
					<td align="right"><span class="tblLabel">Cidade:</span><br>
						<span class="tblCampo"><?php echo $emissor_municipio; ?> </span></td>
					<td align="right"><span class="tblLabel">UF:</span><br>
						<span class="tblCampo"><?php echo $emissor_uf; ?> </span></td>
					<td align="right"><span class="tblLabel">CEP:</span><br>
						<span class="tblCampo"><?php echo $emissor_cep; ?> </span></td>
				</tr>
			</table>		</td>
	</tr>
	<tr>
		<td align="center"></td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
				<tr>
					<td width="800" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">AUTORIZA&Ccedil;&Atilde;O</td>
				</tr>
				<tr>
					<td align="left">Ao(s)<?php echo date("d"); ?> dia(s) do m&ecirc;s de <?php echo mesExtenso (date("m")) ; ?> do ano de <?php echo date("Y");?>, nesta <?php echo $sec;?>, com sede em 
					<?php echo $CONF_CIDADE; ?> , recebi a solicita&ccedil;&atilde;o de libera&ccedil;&atilde;o dos documentos fiscais abaixo relacionados.
					</td>
				</tr>
			</table>		</td>
	</tr>
	<tr>
		<td align="center"></td>
	</tr>
	<tr>
		<td align="center">
		<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
          <tr>
            <td width="100" rowspan="2" align="center" valign="top"><span class="tblTitulo">S&Eacute;RIE<br>
            </span></td>
            <td height="26" colspan="7" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">NUMERA&Ccedil;&Atilde;O</td>
            <br>
		  </tr>
          <tr>
            <td width="175" height="32" align="center" valign="top"><span class="tblLabel">Sub-s&eacute;rie</span><br></td>
            <td width="175" align="center" valign="top"><span class="tblLabel">Esp&eacute;cie</span><br></td>
            <td width="175" align="center" valign="top"><span class="tblLabel">N&deg; Inical </span><br></td>
            <td width="175" align="center" valign="top"><span class="tblLabel">N&deg; Final </span></td>
            <td width="175" align="center" valign="top"><span class="tblLabel">Quantidade</span><br></td>
          	<td width="175" align="center" valign="top"><span class="tblLabel">Tipo</span><br></td>
		  </tr>
          <?php
			while(list($serie,$especie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo)=mysql_fetch_array($sql_docs)) {?>
			 	<tr>
				  <td width="175" height="32" align="center" valign="top"><span class="tblLabel"><b><?php echo $serie; ?></b></span><br></td>				  				  				  
				  <td width="175" height="32" align="center" valign="top"><span class="tblLabel"><?php echo $subserie; ?></span><br></td>				  				  
				  <td width="175" align="center" valign="top"><span class="tblLabel"><?php echo $especie; ?></span><br></td>
				  <td width="175" align="center" valign="top"><span class="tblLabel"><?php echo $nroinicial; ?></span><br></td>
				  <td width="175" align="center" valign="top"><span class="tblLabel"><?php echo $nrofinal; ?></span><br></td>
			      <td width="175" align="center" valign="top"><span class="tblLabel"><?php echo $quantidade; ?></span><br></td>
				  <td width="175" align="center" valign="top"><span class="tblLabel"><?php echo $tipo; ?></span><br></td>
			    </tr>
			<?php
			  }
		     ?>	
          <!-- fim while -->
        </table></td>
	</tr>
	<tr>
		<td align="center">
		<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
				<tr>
					<td width="800" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">DESCRI&Ccedil;&Atilde;O DO PEDIDO
					</td>
				</tr>
				<tr>
					<td align="left">
						<?php  
						$sql_desc = mysql_query("SELECT observacoes FROM aidf_solicitacoes WHERE codigo = '$codaidf'");
						list($descricao)= mysql_fetch_array($sql_desc);
						echo $descricao;
						?>
					</td>
				</tr>
			</table>		
	   </td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellspacing="2" cellpadding="2" style="border:dotted thin">
				<tr>
					<td width="800" height="25" align="center" valign="middle" bgcolor="#CCCCCC" class="tblTitulo">PARECER</td>
				</tr>
				<tr>
					<td align="left" class="tblLabel">Situa&ccedil;&atilde;o: 
					<?php 
					$sql_sit = mysql_query("SELECT confirmar FROM aidf_solicitacoes WHERE  codigo= '$codaidf' "); 												
					list($sit)= mysql_fetch_array($sql_sit);
					echo $sit == 's'? 'Confirmado' : 'Aguardando';
					 
					?>
					</td>
				</tr>
			</table>		
		 </td>
	</tr>
	<tr>
			
		<td align="center"><?php 
		$sql_link = mysql_query("SELECT site FROM configuracoes");
			list($site)= mysql_fetch_array($sql_link);
		echo $site;?>
		</td>
	</tr>	
</table>
</body>
<?php
}
?>
</html>