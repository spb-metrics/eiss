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
$cod_emissor = $_POST['hdCodEmissor'];
$dataCompetencia = DataMysql("01/".$_POST['cmbMes']."/".$_POST['cmbAno']);
$dataGerado = DataMysql($_POST['hdDataAtual']);
$num_servicos = $_POST['hdServicos'];
$total = 0;
$valor_iss_retido_soma = 0;

for($c=1;$c<=$num_servicos;$c++){
	$tomadorCnpjCpf[$c] = $_POST['txtTomadorCnpjCpf'.$c];
	
	//verificar cnpj da prefeitura aki (falta fazer)
	
	//Verifica se todos os tomadores que foram passados pelo usuario existem no banco
	$sql_tomador = mysql_query("
		SELECT 
			codigo 
		FROM 
			cadastro 
		WHERE 
			cnpj = '{$tomadorCnpjCpf[$c]}' OR 
			cpf = '{$tomadorCnpjCpf[$c]}'
	");
	if(!mysql_num_rows($sql_tomador)>0){
		if(strlen($tomadorCnpjCpf[$c])==18){
			$tipo_tomador_inserir = 'cnpj';
		}else{
			$tipo_tomador_inserir = 'cpf';
		}
		mysql_query("
			INSERT INTO cadastro (
				$tipo_tomador_inserir,
				codtipo
			) VALUES (
				'".$tomadorCnpjCpf[$c]."',
				'".codtipo('tomador')."'
			)
		");
		
		//Mensagem("O tomador referente ao cnpj/cpf: ".$tomadorCnpjCpf[$c]." n�o est� cadastrado no sistema");
		//Redireciona("../../principal.php");
		//exit();
	}
	$baseCalculo[$c] = MoedaToDec($_POST['txtBaseCalculo'.$c]);
	$total = $total + $baseCalculo[$c];
	$impostoServico[$c] = MoedaToDec($_POST['txtImposto'.$c]);
	$valor_iss_retido[$c] = MoedaToDec($_POST['txtIssRetido'.$c]);
	
	//soma o total de iss retido
	$valor_iss_retido_soma += MoedaToDec($_POST['txtIssRetido'.$c]);
	
	$temp = explode('|',$_POST['cmbCodServico'.$c]);
	$codigoServico[$c] = $temp[1];
	$nroNota[$c] = $_POST['txtNroDoc'.$c];
}
$multaJuros = MoedaToDec($_POST['txtMultaJuros']);
$totalPagar = MoedaToDec($_POST['txtImpostoTotal']);	

$query_des = ("
	INSERT INTO des SET 
		codcadastro		='$cod_emissor', 
		competencia		='$dataCompetencia', 
		data_gerado		='$dataGerado', 
		total			='$total', 
		iss_retido 		='$valor_iss_retido_soma',
		iss				='$totalPagar',
		tomador			='s',
		codverificacao	='$codverificacao'
");

//teste se eh um contador que esta declarando pelo prestador	
//se for grava no campo codcontador o codigo cadastro do contador se nao deixa null
//mas se o session contador for igual a cod_emissor eh pq o proprio contador esta declarando, entao nao precisa
if($_SESSION['contador'] && $_SESSION['contador']!=$cod_emissor){
	$query_des.=", codcontador='{$_SESSION['contador']}'";
}

mysql_query($query_des);

$sql_des = mysql_query("SELECT MAX(codigo) FROM des");
								 
list($cod_des)=mysql_fetch_array($sql_des);

for($c=1;$c<=$num_servicos;$c++){
	if($baseCalculo[$c]!=""&&$codigoServico[$c]!=""){
		mysql_query("
			INSERT INTO des_servicos SET 
				coddes			='{$cod_des}',
				codservico		='{$codigoServico[$c]}',
				basedecalculo	='{$baseCalculo[$c]}',
				iss_retido 		='{$valor_iss_retido[$c]}',
				iss				='{$impostoServico[$c]}',
				tomador_cnpjcpf	='{$tomadorCnpjCpf[$c]}',
				nota_nro		='{$nroNota[$c]}'
		");
	}
}

require("inconsistencias/sequenciamento_des.php");
require("inconsistencias/duplicacoes_des.php");		

//funcao de teste de autos de infracao
function registraAutoInfracao($codcadastro,$origem,$assunto){
	mysql_query("INSERT INTO autos_infracao SET codcadastro='$codcadastro',origem='$origem', assunto='$assunto',data_hora=NOW()");
}

registraAutoInfracao($cod_emissor,"DES Consolidada","Declara��o com tomador emitida");
	
$sql_guia = mysql_query("SELECT MAX(codigo) 
						 FROM guia_pagamento;");

list($cod_guia)=mysql_fetch_array($sql_guia);


$nossonumero = gerar_nossonumero($cod_guia);
$chavecontroledoc = gerar_chavecontrole($cod_des,$cod_guia);

$cod_guia = base64_encode($cod_guia);
$cod_des  = base64_encode($cod_des); 

echo "<script>window.open('../../reports/des_prestadores_comprovante.php?COD=$cod_des');</script>"; 
//Redireciona("../../boleto/boleto_bb.php?COD=$cod_guia");   

?>

