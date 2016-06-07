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
	//conexao ao banco  e as funcoes
	include("../../site/inc/conect.php");
	include("../../funcoes/util.php");
	
	//recebe as variaveis por post
	$mes     = $_POST["cmbMes"];
	$ano     = $_POST["cmbAno"];
	$cnpj    = $_POST["txtCNPJ"];
	$nome    = $_POST["hdNome"];
	$estado  = $_POST["cmbEstado"];
	$tomador = $_POST["rdTomador"];
	
	//testa se foi preenchido o mes ou o ano
	if(($mes == "") && ($ano)){
		$string = "AND SUBSTRING(simples_des.competencia,1,4) = '$ano'";
	}elseif(($mes) && ($ano == "")){
		$string = "AND SUBSTRING(simples_des.competencia,6,2) = '$mes'";
	}elseif(($mes) && ($ano)){
		$string = "AND SUBSTRING(simples_des.competencia,1,7) = '$ano-$mes'";
	}
	
	//executa o sql
	$sql_des = mysql_query("
				SELECT 
					simples_des.codigo, 
					simples_des.codemissor, 
					simples_des.competencia, 
					simples_des.data_gerado, 
					simples_des.total, 
					simples_des.tomador, 
					simples_des.codverificacao, 
					simples_des.estado 
				FROM 
					simples_des 
				INNER JOIN 
					cadastro
				ON
					cadastro.codigo = simples_des.codemissor
				WHERE
					(cadastro.cnpj = '$cnpj' OR cadastro.cpf = '$cnpj') AND simples_des.tomador LIKE '$tomador%' AND simples_des.estado LIKE '$estado%' $string
				");
	if(mysql_num_rows($sql_des)){
?>
<table width="700" bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; border-width:thin;">
	<tr>
    	<td colspan="6">Institui&ccedil;&atilde;o Financeira: <?php echo $nome;?></td>
    </tr>
    <tr>
        <td colspan="6">N&uacute;mero de declara&ccedil;&otilde;es feitas: <?php echo mysql_num_rows($sql_des);?></td>
    </tr>
    <tr>
        <td colspan="6"><hr color="#000000" size="2"></td>
    </tr>
    <tr>
        <td width="89"  align="center">Cod. verifica&ccedil;&atilde;o</td>
        <td width="120" align="center">Compet&ecirc;ncia</td>
        <td width="172" align="center">Data emiss&atilde;o</td>
        <td width="50"  align="center">Tomador</td>
        <td width="121" align="center">Total</td>
        <td width="39"  align="center">Estado</td>
    </tr>
    <tr>
    	<td colspan="6"><hr color="#000000" size="2"></td>
    </tr>
    <?php
	while(list($codigo,$codemissor,$competencia,$data_gerado,$total,$tomador,$codverificacao,$estado) = mysql_fetch_array($sql_des)){
		$data        = DataPt($data_gerado);
		$competencia = DataPt($competencia);
		switch($tomador){
			case "s": $tomador = "Sim";        break;
			case "n": $tomador = "N&atilde;o"; break;
		}
		switch($estado){
			case "B": $estado = "Boleto";      break;
			case "C": $estado = "Cancelada";   break;
			case "E": $estado = "Escriturada"; break;
			case "N": $estado = "Normal";      break;
		}
	?>
    <tr>
    	<td align="center"><?php echo $codverificacao;?></td>
        <td align="center"><?php echo $competencia;?></td>
        <td align="center"><?php echo $data;?></td>
        <td align="center"><?php echo $tomador;?></td>
        <td align="center"><?php echo DecToMoeda($total);?></td>
        <td align="center"><?php echo $estado;?></td>
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