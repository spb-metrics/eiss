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

$sql=mysql_query("SELECT codigo, nome,cnpj, cpf FROM cadastro WHERE cnpj='".$_SESSION['SESSAO_cnpj_emissor']."' OR cpf='".$_SESSION['SESSAO_cnpj_emissor']."'");
list($codigo,$nome,$cnpj,$cpf)=mysql_fetch_array($sql);  

/*$sql_verifica=mysql_query("
SELECT guia_pagamento.codigo,guia_pagamento.dataemissao, guia_pagamento.valor
FROM guia_pagamento 
INNER JOIN des ON guia_pagamento.codrelacionamento=des.codigo 
WHERE des.codemissor='$codigo' AND guia_pagamento.pago='N' AND guia_pagamento.relacionamento='des' ORDER BY guia_pagamento.dataemissao ASC"); 

$resultado=mysql_num_rows($sql_verifica); 
*/

$tomador_CNPJ = $_SESSION['SESSAO_cnpj_emissor'];

//verifica se tem o emissor cadastrado
$sql_emissor=mysql_query("SELECT 
							codigo,
							nome,
							razaosocial,
							inscrmunicipal,
							logradouro,
							numero,
							complemento,
							bairro,
							cep,							
							municipio,
							uf,
							email 
				  FROM cadastro 
				  WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
if(mysql_num_rows($sql_emissor)) {
	$resultado = "s";
	$existe_emissor = "s";
}

$sql_tomador = mysql_query ("SELECT codigo, 
									nome, 
									inscrmunicipal, 
									logradouro,
									numero,
									complemento,
									bairro,
									cep,			
									municipio, 
									uf, 
									email 
							FROM cadastro 
							WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
if (mysql_num_rows($sql_tomador)){
	$resultado = "s";
	$existe_tomador = "s";
}

if ($resultado){
	
	if ($existe_emissor){
		$stringSql[0] = ("(
			SELECT
				guia_pagamento.codigo, 
				guia_pagamento.dataemissao,
				guia_pagamento.valor, 
				guia_pagamento.datavencimento,
				guia_pagamento.pago
			FROM
				guia_pagamento 
			INNER JOIN
				guias_declaracoes ON guia_pagamento.codigo = guias_declaracoes.codguia
			INNER JOIN
				des ON des.codigo = guias_declaracoes.codrelacionamento 
			INNER JOIN
				cadastro ON cadastro.codigo = des.codcadastro
			WHERE
				(cadastro.cnpj = '$tomador_CNPJ' OR
				cadastro.cpf = '$tomador_CNPJ') AND
				guia_pagamento.pago = 'N'  AND				
				guias_declaracoes.relacionamento = 'des'
		)"); 
	}
	if ($existe_tomador) {
		$stringSql[2] = ("
			(SELECT
			  guia_pagamento.codigo, 
			  guia_pagamento.dataemissao,
			  guia_pagamento.valor, 
			  guia_pagamento.datavencimento,
			  guia_pagamento.pago
			FROM
			  guia_pagamento 
			INNER JOIN
			  guias_declaracoes ON guias_declaracoes.codguia = guia_pagamento.codigo
			INNER JOIN
			  des_issretido ON des_issretido.codigo = guias_declaracoes.codrelacionamento 
			INNER JOIN
			  cadastro ON cadastro.codigo = des_issretido.codcadastro
			WHERE
			  (cadastro.cnpj = '$tomador_CNPJ' OR
			  cadastro.cpf = '$tomador_CNPJ') AND
			  guia_pagamento.pago = 'N'  AND			  
			  guias_declaracoes.relacionamento = 'des_issretido')"); 
	}
	$string_Sql = implode(" UNION ",$stringSql)." ORDER BY datavencimento";
	//echo $string_Sql;
	$sql_guias = mysql_query($string_Sql);
	//echo $string_Sql;	
	$tem_guias = mysql_num_rows($sql_guias);
}
  
?>
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="130" align="center" bgcolor="#FFFFFF" rowspan="3">Prestador Cadastrado</td>
	    <td width="440" bgcolor="#FFFFFF"></td>
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

	<table width="98%" border="0" align="center" cellpadding="2" cellspacing="5">
	  <tr>
		<td width="19%" align="left">&nbsp;</td>
		<td width="81%" align="right" ><a href="inc/logout.php" style="color:#FF0000;">Sair</a></td>
	    </tr>
			<tr>
				<td align="left">Nome</td>
			    <td align="left" bgcolor="#FFFFFF"><?php echo"$nome"; ?>&nbsp;</td>
			</tr>
			<tr>
			  <td align="left">CNPJ / CPF</td>
	          <td align="left" bgcolor="#FFFFFF"><?php echo"$cnpjcpf"; ?></td>
		</tr>
			<tr>
			  <td align="center">&nbsp;</td>
			  <td align="left" valign="middle" bgcolor="#FFFFFF">
              
<?php 
if(!$tem_guias) { 
?>
<form action="inc/certidoes/debitos_insercao.php" method="post" target="blank">
<table  width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
     <td align="left" height="50">Até a presente data não constam débitos para o contribuinte identificado acima.     </td>
  </tr>
  <tr>
     <td align="right" height="30" bgcolor="#CCCCCC">
        <input type="hidden" name="txtCodEmissor" value="<?php echo $codigo; ?>">
        <input type="submit" value="Imprimir certidão negativa" class="botao">

     </td>
  </tr>
</table>
</form>
<?php				  			   
} 
else {	 
?>
<table align="center" border="0">
	  <tr>
		 <td align="center">Existem débitos em aberto com a Prefeitura Municipal.<br><br>Para imprimir sua Certidão Negativa, o prestador deverá quitar suas guias que foram geradas na Declaração Eletrônica de Serviços (DES).         </td>
	  </tr>
	  <tr>
		 <td align="center">Pagamentos pendentes:</td>  
	  </tr>
	  <tr>
		 <td align="center">
         
<table width="70%">         
<?php
while(list($codigo_guia, $dataemissao_guia, $valor_guia, $datavencimento_guia, $pago_guia) = mysql_fetch_array($sql_guias)) {

?>			 	   
	   <tr>	 
		 <td align="left" bgcolor="#CCCCCC">Data da emissão da guia:</td>
		 <td align="center" bgcolor="#CCCCCC"><?php echo DataPt($dataemissao_guia); ?></td>		 				 	    
	   </tr>
	   <tr>	 
		 <td align="left" bgcolor="#CCCCCC">Valor da Guia:</td>
		 <td align="right" bgcolor="#CCCCCC">R$ <?php echo DecToMoeda($valor_guia); ?></td>
	   </tr>
	   <tr>	 
		 <td height="2"></td>
	   </tr>
<?php	  
}
?>        
</table>         
		</td>
	  </tr>
      <tr>	 
		 <td colspan="2" align="center"><b>Contate a prefeitura para realizar o pagamento das guias pendentes</b></td>				 
	  </tr>
	</table>
<?php
}
?>              </td>
	    </tr>
			<tr>
			  <td align="center">&nbsp;</td>
			  <td align="left" valign="middle">&nbsp;</td>
	    </tr>
	  </table>
      
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
