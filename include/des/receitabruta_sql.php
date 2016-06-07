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
		
		$cnpj = $_POST['txtCNPJ'];
		$razao = $_POST['txtRazao'];	
		$mes = $_POST['cmbMes'];
		$ano = $_POST['cmbAno'];
		$base = MoedaToDec($_POST['txtBase']);
		$aliq = $_POST['cmbAliq'];
		$dataGerado = DataMysql($_POST['hdDataAtual']);
		
		$valor = $base * ($aliq/100);
		
		$sql_existe_cnpj = mysql_query("SELECT codigo,cnpj,razaosocial FROM emissores_temp WHERE cnpj='$cnpj';");
		
		if(mysql_num_rows($sql_existe_cnpj)==0){
						
			mysql_query("INSERT INTO emissores_temp 
						 SET cnpj='$cnpj', 
						 razaosocial='$razao'");							 
			$sql_existe_cnpj = mysql_query("SELECT codigo,cnpj,razaosocial FROM emissores_temp WHERE cnpj='$cnpj';"); 
			list($cod_emissor,$cnpj_emissor,$razao_emissor)=mysql_fetch_array($sql_existe_cnpj);			
			
  		}else{
		
			list($cod_emissor,$cnpj_emissor,$razao_emissor)=mysql_fetch_array($sql_existe_cnpj);
			if(($cnpj)&&($razao))
			{
				if(($cnpj_emissor != $cnpj)||($razao_emissor !=$razao)){
					mysql_query("UPDATE emissores_temp SET cnpj='$cnpj_emissor',razaosocial='$razao_emissor' WHERE codigo='$cod_emissor'");
				}			
			}	
		}			
			
		$codverificacao =gera_codverificacao();	
			mysql_query("INSERT INTO des_temp SET
						 codemissores_temp=	'$cod_emissor',
						 data_gerado='$dataGerado', 
						 competencia='$ano-$mes-01',
						 base='$base',
						 aliq='$aliq',
						 codverificacao='$codverificacao';");
		
		$sql_des_temp = mysql_query("SELECT MAX(codigo) FROM des_temp;");
		list($cod_des_temp)=mysql_fetch_array($sql_des_temp);
	
		$dias_prazo = 5;
		$data_venc = date("Y-m-d", time() + ($dias_prazo * 86400));
		$sql_dia = mysql_query("SELECT data_tributacao FROM configuracoes");
		list($dia)=mysql_fetch_array($sql_dia);
		if($mes<12){
			$mes++;
		}else{
			$mes = 1;
			$ano++;
		}
		$competencia = "$dia/$mes/$ano";
		$diasDec = diasDecorridos($competencia,date("d/m/Y"));
		
		$valormulta = calculaMultaDes($diasDec,$valor);
		//Mensagem("base: $base - dias: $diasDec - valor: $valor - valormulta: $valormulta");
		$valortotal = $valor + $valormulta;
		
		mysql_query("INSERT 
					 INTO 
						 guia_pagamento
					 SET 					 	 
						 dataemissao = '$dataGerado',
						 valor = '$valortotal',
						 valormulta= '$valormulta',
						 datavencimento = '$data_venc',
						 pago = 'N'");
		
		$sql_guia = mysql_query("SELECT MAX(codigo) 
					  		     FROM guia_pagamento;");
		list($cod_guia)=mysql_fetch_array($sql_guia);		
		
		$nossonumero = gerar_nossonumero($cod_guia);
		$chavecontroledoc = gerar_chavecontrole($cod_des_temp,$cod_guia);		
		
		mysql_query("UPDATE guia_pagamento SET nossonumero ='$nossonumero', chavecontroledoc='$chavecontroledoc' WHERE codigo='$cod_guia'");
		mysql_query("INSERT INTO guias_declaracoes SET codguia='$cod_guia',codrelacionamento='$cod_des_temp',relacionamento='des_temp'");

		$cod_guia =base64_encode($cod_guia);
		$cod_des_temp = base64_encode($cod_des_temp);
		
		echo"<script>window.open('../../reports/des_prestadores_comprovante.php?CODT=$cod_des_temp');</script>"; 
		Redireciona("../../../boleto/recebimento/index.php?COD=$cod_guia");

?>

