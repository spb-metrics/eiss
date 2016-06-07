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
<title>Relat&oacute;rio DIF</title>

<style type="text/css" media="print">
div.pagina {
writing-mode: tb-rl;
height: 80%;
margin: 10% 0%;
}

</style>
</head>
<body>
<div class="pagina">
<?php
	include("../../conect.php");
	include("../../../funcoes/util.php");
	$mes    = $_POST["cmbMes"];
	$ano    = $_POST["cmbAno"];
	$cnpj   = $_POST["txtCNPJ"];
	$nome   = $_POST["hdNome"];
	$estado = $_POST["cmbEstado"];
	switch($estado){
		case "B" : $str_estado = "Boleto";      break;
		case "C" : $str_estado = "Cancelada";   break;
		case "E" : $str_estado = "Escriturada"; break;
		case "N" : $str_estado = "Normal";      break;
	}
	if(($mes == "") && ($ano)){
		$stringdata = "AND YEAR(dif_des.competencia) = '$ano'";
	}elseif(($mes) && ($ano == "")){
		$stringdata = "AND MONTH(dif_des.competencia) = '$mes'";
	}elseif(($mes) && ($ano)){
		$stringdata = "AND YEAR(dif_des.competencia) = '$ano' AND MONTH(dif_des.competencia) = '$mes'";
	}
	if($estado){
		$stringestado = "AND dif_des.estado = '$estado'";
	}
	$sql_des = mysql_query("
		SELECT 
			dif_des_contas.codigo, 
			dif_des_contas.contaoficial, 
			dif_des_contas.contacontabil, 
			dif_des_contas.titulo, 
			dif_des_contas.item, 
			dif_des_contas.saldo_mesanterior, 
			dif_des_contas.debito, 
			dif_des_contas.credito, 
			dif_des_contas.saldo_mesatual, 
			dif_des_contas.receita, 
			dif_des_contas.aliquota, 
			dif_des_contas.iss, 
			dif_des.data, 
			dif_des.competencia 
		FROM 
			dif_des_contas 
		INNER JOIN 
			dif_des ON dif_des_contas.coddif_des = dif_des.codigo
		INNER JOIN
			cadastro ON dif_des.codinst_financeira = cadastro.codigo
		WHERE 
			cadastro.cnpj = '$cnpj' $stringdata $stringestado
			");
?>
<table width="1000" bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
	<tr>
    	<td colspan="12">Operadora de cr&eacute;dito: <?php echo $nome;?></td>
    </tr>
    <tr>
        <td colspan="12">N&uacute;mero de declara&ccedil;&otilde;es encontradas: <?php echo mysql_num_rows($sql_des);?></td>
    </tr>
    <?php
	if($estado){
	?>
    <tr>
    	<td colspan="12">Estado: <?php echo $str_estado;?></td>
    </tr>
    <?php
	}
	if(($mes) || ($ano)){
	?>
    <tr>
    	<td colspan="12">
			<?php 
				if(($mes) && (!$ano)){
					$meses = array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
					$mes = $meses[$mes];
					echo "Mês da competencia: $mes";
				}elseif((!$mes) && ($ano)){
					echo "Ano da competencia: $ano";
				}else{
					echo "Competencia: $mes/$ano";
				}
			?>
        </td>
    </tr>
    <?php
	}
	?>
    <tr>
        <td colspan="12"><hr color="#000000" size="2"></td>
    </tr>
    <?php
if(mysql_num_rows($sql_des)){
	?>
    <tr>
        <td width="89" align="center">Conta oficial</td>
        <td width="113" align="center">Conta Contabil</td>
        <td width="179" align="center">Titulo</td>
        <td width="33" align="center">Item</td>
        <td width="121" align="center">Saldo m&ecirc;s anterior</td>
        <td width="38" align="center">d&eacute;bito</td>
        <td width="42" align="center">cr&eacute;dito</td>
        <td width="101" align="center">saldo m&ecirc;s atual</td>
        <td width="60" align="center">Receita</td>
        <td width="74" align="center">Aliquota</td>
        <td width="39" align="center">ISS</td>
        <td width="83" align="center">Data</td>
    </tr>
    <tr>
    	<td colspan="12"><hr color="#000000" size="2"></td>
    </tr>
    <?php
	while(list($codigo,$contaoficial,$contacontabil,$titulo,$item,$saldo_mesanterior,$debito,$credito,$saldo_mesatual,$receita,$aliquota,$iss,$data) = mysql_fetch_array($sql_des)){
		$datahora = explode(" ",$data);
		$data = DataPt($datahora[0]);
		$hora = $datahora[1];
	?>
    <tr>
    	<td align="center"><?php echo $contaoficial;?></td>
        <td align="center"><?php echo $contacontabil;?></td>
        <td align="center"><?php echo $titulo;?></td>
        <td align="center"><?php echo $item;?></td>
        <td align="center"><?php echo DecToMoeda($saldo_mesanterior);?></td>
        <td align="center"><?php echo DecToMoeda($debito);?></td>
        <td align="center"><?php echo DecToMoeda($credito);?></td>
        <td align="center"><?php echo DecToMoeda($saldo_mesatual);?></td>
        <td align="center"><?php echo DecToMoeda($receita);?></td>
        <td align="center"><?php echo $aliquota."%";?></td>
        <td align="center"><?php echo DecToMoeda($iss);?></td>
        <td align="center"><?php echo $data." ".$hora;?></td>
    </tr>
    <?php
	}//fim while
}else{
	echo "
		<tr>
			<td align=\"center\"><b>N&atilde;o possui declara&ccedil;&otilde;es</b></td>
		</tr>
	";
}
	?>
</table>
</div>
</body>
</html>

