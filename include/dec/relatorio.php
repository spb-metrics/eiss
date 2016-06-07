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
<html>
<head>
<title>Relat&oacute;rio DEC</title>
<div class="pagina">
<style type="text/css" media="print">
div.pagina {
writing-mode: tb-rl;
height: 80%;
margin: 10% 0%;
}

</style>
</head>
<body>

<?php
	include("../conect.php");
	include("../../funcoes/util.php");
	$mes  = $_POST["cmbMes"];
	$ano  = $_POST["cmbAno"];
	$cnpj = $_POST["txtCNPJ"];
	$nome = $_POST["hdNome"];
	if(($mes == "") && ($ano)){
		$string = "AND SUBSTRING(cartorios_des.competencia,1,4) = '$ano'";
	}elseif(($mes) && ($ano == "")){
		$string = "AND SUBSTRING(cartorios_des.competencia,6,2) = '$mes'";
	}elseif(($mes) && ($ano)){
		$string = "AND SUBSTRING(cartorios_des.competencia,1,7) = '$ano-$mes'";
	}
	$sql_des = mysql_query("
		SELECT 
			cartorios_des_notas.codigo, 
			cartorios_des_notas.valornota, 
			cartorios_des_notas.nota_nro, 
			cartorios_des_notas.emolumento, 
			cartorios_des.competencia, 
			cartorios_des.data_gerado, 
            cartorios_servicos.servicos,
			cartorios_servicos.aliquota,
			cartorios_servicos.codigo
		FROM 
			cartorios_des_notas 
		INNER JOIN 
			cartorios_des ON cartorios_des_notas.coddec_des = cartorios_des.codigo
		INNER JOIN
			cadastro ON cartorios_des.codcartorio = cadastro.codigo
		INNER JOIN
			cartorios_servicos ON cartorios_des_notas.codservico = cartorios_servicos.codigo
		WHERE cadastro.cnpj = '$cnpj' $string
			");
	if(mysql_num_rows($sql_des)){
?>
<table bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
	<tr>
    	<td colspan="12">Cartório: <?php echo $nome;?></td>
    </tr>
    <tr>
        <td colspan="12">Número de declarações feitas: <?php echo mysql_num_rows($sql_des);?></td>
    </tr>
    <tr>
        <td colspan="12"><hr color="#000000" size="2"></td>
    </tr>
    <tr>
        <td align="center">Número da Nota</td>    
        <td align="center">Tipo de Serviço</td>
        <td align="center">Cód. Serviço</td>
        <td align="center">Aliquota</td>
        <td align="center">Valor da Nota</td>
        <td align="center">Valor de Emolumentos</td>
        <td align="center">Data Competência</td>
        <td align="center">Data Gerado</td>
    </tr>
    <tr>
    	<td colspan="12"><hr color="#000000" size="2"></td>
    </tr>
    <?php
	while(list($codigo,$valornota,$nronota,$emolumento,$competencia,$datagerada,$servico,$aliquota,$codservico) = mysql_fetch_array($sql_des)){
	?>
    <tr>
        <td align="center"><?php echo $nronota;?></td>
        <td align="center"><?php echo $servico;?></td>
        <td align="center"><?php echo $codservico;?></td>
        <td align="center"><?php echo DecToMoeda($aliquota)."%";?></td>
        <td align="center"><?php echo DecToMoeda($valornota);?></td>
        <td align="center"><?php echo DecToMoeda($emolumento);?></td>
        <td align="center"><?php echo DataPt($competencia);?></td>
        <td align="center"><?php echo DataPt($datagerada);?></td>
    </tr>
    <?php
	}//fim while
	?>
</table>
<?php
}else{
	echo "
		<table width=\"700\">
			<tr>
				<td align=\"center\"><b>N&atilde;o possui declara&ccedil;&otilde;es</b></td>
			</tr>
		<table>
	";
}
?>
</div>
</body>
</html>