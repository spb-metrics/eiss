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
include("../../inc/conect.php");
include("../../funcoes/util.php");
// variaveis globais vindas do conect.php
// $CODPREF,$PREFEITURA,$USUARIO,$SENHA,$BANCO,$TOPO,$FUNDO,$SECRETARIA,$LEI,$DECRETO,$CREDITO,$UF	

// descriptografa o codigo
$CODIGO = base64_decode($_POST["CODIGO"]);


// sql feito na nota
$sql = mysql_query("
SELECT
  `notas`.`codigo`, 
  `notas`.`numero`, 
  `notas`.`codverificacao`,
  `notas`.`datahoraemissao`, 
  `notas`.`rps_numero`,
  `notas`.`rps_data`, 
  `notas`.`tomador_nome`, 
  `notas`.`tomador_cnpjcpf`,
  `notas`.`tomador_inscrmunicipal`, 
  `notas`.`tomador_endereco`,
  `notas`.`tomador_logradouro`,
  `notas`.`tomador_numero`,
  `notas`.`tomador_complemento`,
  `notas`.`tomador_cep`, 
  `notas`.`tomador_municipio`, 
  `notas`.`tomador_uf`,
  `notas`.`tomador_email`, 
  `notas`.`discriminacao`, 
  `notas`.`valortotal`,
  `notas`.`estado`, 
  `notas`.`credito`, 
  `notas`.`codservico`,
  `notas`.`valordeducoes`, 
  `notas`.`basecalculo`, 
  `notas`.`valoriss`,
  `notas`.`valorinss`,
  `notas`.`aliqinss`,
  `notas`.`valorirrf`,
  `notas`.`aliqirrf`,
  `notas`.`deducao_irrf`,
  `notas`.`total_retencao`,
  `cadastro`.`razaosocial`, 
  `cadastro`.`nome`, 
  IF(cadastro.cnpj <> '',cnpj,cpf),
  `cadastro`.`inscrmunicipal`, 
  `cadastro`.`logradouro`, 
  `cadastro`.`numero`,
  `cadastro`.`complemento`,
  `cadastro`.`municipio`, 
  `cadastro`.`uf`, 
  `cadastro`.`logo`,
  `servicos`.`codservico`, 
  `servicos`.`descricao`, 
  `servicos`.`aliquota`, 
  `notas`.`issretido`, 
  cadastro.codtipo, 
  cadastro.codtipodeclaracao
FROM
  `notas` INNER JOIN
  `cadastro` ON `notas`.`codemissor` = `cadastro`.`codigo`
  INNER JOIN
  `servicos` ON `servicos`.`codigo` = `notas`.`codservico`
WHERE
  `notas`.`codigo` = '$CODIGO'
");
list($codigo, $numero, $codverificacao, $datahoraemissao, $rps_numero, $rps_data, $tomador_nome, $tomador_cnpjcpf, $tomador_inscrmunicipal, $tomador_endereco, $tomador_logradouro, $tomador_numero, $tomador_complemento, $tomador_cep, $tomador_municipio, $tomador_uf, $tomador_email, $discriminacao, $valortotal, $estado, $credito, $codservico, $valordeducoes, $basecalculo, $valoriss,$valorinss,$aliqinss,$valorirrf,$aliqirrf, $deducao_irrf, $total_retencao, $empresa_razaosocial, $empresa_nome, $empresa_cnpjcpf,  $empresa_inscrmunicipal, $empresa_endereco, $empresa_numero, $empresa_complemento, $empresa_municipio, $empresa_uf, $empresa_logo, $servico_codservico, $servico_descricao, $servico_aliquota,$issretido,$codtipo,$coddec) = mysql_fetch_array($sql);

//nao tem soh endereco agora tem logradouro e numero com complemento
$tomador_endereco="$tomador_logradouro, $tomador_numero";
//se tiver complemento, adiciona para a string de endereço
if($tomador_complemento){
	$tomador_endereco.=", $tomador_complemento";
}
//se tiver complemento, adiciona para a string de endereço
if($tomador_cep){
	$tomador_endereco.=", $tomador_cep";
}

$empresa_endereco.=", $empresa_numero";
if($empresa_complemento){
	$empresa_endereco.=", $empresa_complemento";
}

$sql_codtipo_simples = codtipo('simples');
$sql_coddec = mysql_query("SELECT codigo FROM declaracoes WHERE declaracao = 'Simples Nacional'");
list($coddec_sql) = mysql_fetch_array($sql_coddec);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NFeletrônica [Imprimir Nota]</title>
<link href="../css/imprimir_prefeitura.css" rel="stylesheet" type="text/css" />
</head>

<body onload="window.resizeTo(850,650)">
<script src="../../scripts/padrao.js" type="text/javascript"></script><title>Relatorios - Notas</title>
<div id="DivImprimir"><input type="button" onClick="EscondeDiv('DivImprimir'); print();" value="Imprimir" /></div>

<center>
<table width="800" border="1" cellspacing="0" cellpadding="2" style="border:#000000 solid">
  <tr>
    <td colspan="4" rowspan="3" width="75%" style="border:#000000 solid" align="center">
<!-- tabela prefeitura inicio -->	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td rowspan="4" width="20%" align="center" valign="top"><img src="../../img/brasoes/<?php print $CONF_BRASAO; ?>" width="100" height="100" /><br />
	</td>
    <td width="80%" class="cab01"><?php print strtoupper($PREFEITURA); ?></td>
  </tr>
  <tr>
    <td class="cab03"><?php print strtoupper($SECRETARIA); ?></td>
  </tr>
  <tr>
    <td class="cab02">NOTA FISCAL ELETRÔNICA DE SERVIÇOS - NF-e</td>
  </tr>
  <tr>
    <td>RPS N&ordm; <?php print $rps_numero; ?>, emitido em <?php print (substr($rps_data,8,2)."/".substr($rps_data,5,2)."/".substr($rps_data,0,4)); ?>.</td>
  </tr>
</table>

<!-- tabela prefeitura fim -->	</td>
    <td width="25%" align="left" style="border:#000000 solid">Número da Nota<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print $numero; ?></strong></font></div></td>
  </tr>
  <tr>
    <td align="left" style="border:#000000 solid">Data e Hora de Emissão<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print (substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,4)." ".substr($datahoraemissao,11,2).":".substr($datahoraemissao,14,2)); ?></strong></font></div></td>
  </tr>
  <tr>
    <td align="left" style="border:#000000 solid">Código de Verificação<br /><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><strong><?php print $codverificacao; ?></strong></font></div></td>
  </tr>
  <tr>
    <td colspan="5" align="center" style="border:#000000 solid">
	
<!-- tabela prestador -->	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="3" class="cab03">PRESTADOR DE SERVI&Ccedil;OS</td>
    </tr>
  <tr>
    <td rowspan="4">
	<?php
	// verifica o logo
	if ($empresa_logo != "") {
		echo "<img src=../../img/logos/$empresa_logo >";
	}	
	?>	</td>
    <td align="left">CNPJ/CPF: <strong><?php print $empresa_cnpjcpf; ?></strong></td>
    <td align="left">Inscri&ccedil;&atilde;o Municipal: <strong><?php print verificaCampo($empresa_inscrmunicipal); ?></strong></td>
  </tr>
  <tr>
    <td colspan="2" align="left">
		Nome: <strong><?php print verificaCampo($empresa_razaosocial); ?></strong><br />
		Raz&atilde;o Social: <strong><?php echo verificaCampo($empresa_nome); ?></strong>
	</td>
    </tr>
  <tr>
    <td colspan="2" align="left">Endere&ccedil;o: <strong><?php print verificaCampo($empresa_endereco); ?></strong></td>
    </tr>
  <tr>
    <td align="left">Munic&iacute;pio: <strong><?php print verificaCampo($empresa_municipio); ?></strong></td>
    <td align="left">UF: <strong><?php print verificaCampo($empresa_uf); ?></strong></td>
  </tr>
</table>
	
	
<!-- tabela prestador -->	</td>
    </tr>
  <tr>
    <td colspan="5" align="center" style="border:#000000 solid">
<!-- tabela tomador inicio -->	

<table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
  <tr>
    <td colspan="3" class="cab03" align="center">TOMADOR DE SERVIÇOS</td>
    </tr>
  <tr>
    <td colspan="3" align="left">Nome/Razão Social: <strong><?php print verificaCampo($tomador_nome); ?></strong></td>
    </tr>
  <tr>
    <td align="left">CPF/CNPJ: <strong><?php print verificaCampo($tomador_cnpjcpf); ?></strong></td>
    <td colspan="2" align="left">Inscri&ccedil;&atilde;o Municipal: <strong><?php print verificaCampo($tomador_inscrmunicipal); ?></strong></td>
    </tr>
  <tr>
    <td colspan="3" align="left">Endereço: <strong><?php print $tomador_endereco; ?></strong></td>
    </tr>
  <tr>
    <td align="left">Munic&iacute;pio: <strong><?php print verificaCampo($tomador_municipio); ?></strong></td>
    <td align="left">Uf: <strong><?php print verificaCampo($tomador_uf); ?></strong></td>
    <td align="left">E-mail: <strong><?php print verificaCampo($tomador_email); ?></strong></td>
  </tr>
</table>
		
<!-- tabela tomador fim -->	</td>
    </tr>
  <tr>
    <td colspan="5" align="center" style="border:#000000 solid">
	
<!-- tabela discrimacao dos servicos -->	
	
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td class="cab03">DISCRIMINAÇÃO DOS SERVIÇOS</td>
  </tr>
  <tr>
    <td height="400" align="left" valign="top"><br /><?php print nl2br(verificaCampo($discriminacao));/*mostra os servicos com uma nova linha se necessario*/ ?><br /><br />
	<?php
	
	// verifica o estado da nfe
	if($estado == "C") {
		echo "<div align=center><font size=7 color=#FF0000><b>ATENÇÃO!!<BR>NFE CANCELADA</B></font></div>";
	} // fim if
	
	?></td>
  </tr>
</table>
	
	
<!-- tabela discrimacao dos servicos -->	</td>
    </tr>
  <tr>
    <td colspan="5" class="cab03" align="center" style="border:#000000 solid">VALOR TOTAL DA NOTA = R$ <?php print DecToMoeda($valortotal); ?></td>
    </tr>
  <tr>
    <td colspan="5" align="left" style="border:#000000 solid">Código do Serviço<br /><strong><?php print $servico_codservico." - ". $servico_descricao; ?></strong></td>
    </tr>
  <tr>
    <td style="border:#000000 solid">Valor Total das Deduções (R$)<br /><br /><div align="right"><strong><?php print DecToMoeda($valordeducoes); ?></strong></div></td>
    <td style="border:#000000 solid">Base de Cálculo (R$)<br /><br /><div align="right"><strong><?php print DecToMoeda($basecalculo); ?></strong></div></td>
    <td style="border:#000000 solid">
	 Alíquota (%)
	 <br /><br />	
	 <div align="right">
	  <strong>
	   <?php
	   if (($codtipo == $sql_codtipo_simples) || ($coddec == $coddec_sql))
	   {
	    echo "----";
	   }
	   else
	   {
	    print (DecToMoeda($servico_aliquota)." %");
	   } ?>
	  </strong>
	 </div>
	</td>
    <td style="border:#000000 solid">
	 Valor do ISS (R$)
	 <br /><br />
	 <div align="right">
	  <strong>
	   <?php 
	    if (($codtipo == $sql_codtipo_simples) || ($coddec == $coddec_sql))
		{
	      echo "----";	  
		} 
		else
		{
		 print DecToMoeda($valoriss); 
		}  ?>
	  </strong>
	 </div>
	</td>
    <td style="border:#000000 solid">
	 Crédito p/ Abatimento do IPTU
	 <br />
	 <div align="right">
	 <strong>
	  <?php 
	   if (($codtipo == $sql_codtipo_simples) || ($coddec == $coddec_sql))
		{
	      echo "----";	  
		} 
		else
		{	  
	     print DecToMoeda($credito); 
		} ?>
	 </strong></div>
	</td>
  </tr>
  <tr>
    <td colspan="5" style="border:#000000 solid" class="cab03">OUTRAS INFORMAÇÕES</td>
  </tr>
  <tr>
    <td colspan="5" style="border:#000000 solid" align="left">
	- Esta NF-e foi emitida com respaldo na Lei n&ordm; <?php print $credito; ?> e no Decreto n&ordm; <?php print $credito; ?><br />
	<?php
	if (($codtipo == $sql_codtipo_simples) || ($coddec == $coddec_sql))
	{
	  echo "- Esta NF-e não gera créditos, pois a empresa prestadora de serviços é optante pelo Simples Nacional<br> ";
	}
	if($issretido != 0)
	{
	  echo "- Esta NF-e possuí retenção de ISS no valor de R$ $issretido<br> ";
	
	}
	// verifica o estado do tomador
	if(($MUNICIPIO !== $tomador_municipio) && (($codtipo != $sql_codtipo_simples) || ($coddec == $coddec_sql))) {
		echo "- Esta NF-e não gera crédito, pois o Tomador de Serviços está localizado fora do município de $MUNICIPIO<br>";
	} // fim if	
	if($rps_numero){
	?>
	- Esta NF-e substitui o RPS N&ordm; <?php print $rps_numero; ?>, emitido em <?php print (substr($rps_data,8,2)."/".substr($rps_data,5,2)."/".substr($rps_data,0,4)); ?><br />
	<?php
	}//fim if rps
	//$valorinss,$aliqinss,$valorirrf,$aliqinss
	if($valorinss > 0){//soh mostra se tiver valor
		echo "- Retenção de INSS ".DecToMoeda($aliqinss)."% com valor de R$ ".DecToMoeda($valorinss)." <br>";
	}
	if($valorirrf > 0){//soh mostra se tiver valor
		echo "- Retenção de IRRF ".DecToMoeda($aliqirrf)."% com valor de R$ ".DecToMoeda($valorirrf).""; if($deducao_irrf > 0){ echo ". Dedução de R$ ".DecToMoeda($deducao_irrf); } echo "<br>";
	}
	if($total_retencao > 0){
		echo "- Total de rentenções da nota R$ ".DecToMoeda($total_retencao)." <br>";
	}
	?>
	</td>
  </tr>  
</table>
</center>
</body>
