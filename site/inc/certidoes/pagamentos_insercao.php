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
session_start();  
$cnpjcpf_empresa=$_SESSION['SESSAO_cnpj_emissor']; 
include("../conect.php");
include("../../../funcoes/util.php");
if ($_POST){
	$codemissor = $_POST['txtCodEmissor'];
	$codverificacao = gera_codverificacao();
	$mes = date("m");
	$ano = date("Y");	
	$hoje = date("Y-m-d");
	
	if($mes ==12){
		$mes=1;
		$ano++;
	} else {
		$mes++;
	}
	
	$val=date("$ano-$mes-d");	
	
	//verifica se ja foi tirada certidao no dia
	$sql_negativa_hoje = mysql_query("
						SELECT codigo
	  					FROM certidoes_pagamento 
	  					WHERE codemissor = '$codemissor' AND
	  				  		  dataemissao = '$hoje'");
	
	//se ja foi tirada a certidao, redireciona pra existente 
	if (mysql_num_rows($sql_negativa_hoje)){
		Mensagem("Você ja tirou sua certidão de pagamento hoje!");
		list($codigo)=mysql_fetch_array($sql_negativa_hoje);
		$codv = base64_encode($codigo);
		Redireciona("../../../reports/certpagamento.php?CODV=$codv");
		
	}else{//insere no banco a certidao e redireciona
		mysql_query("
			INSERT INTO certidoes_pagamento 
			SET codemissor='".$_POST['txtCodEmissor']."',
				codverificacao='$codverificacao',
				dataemissao=NOW(),
				datavalidade='$val'");
		
		$sql_certicao_negativa = mysql_query("
							SELECT codigo
		  					FROM certidoes_pagamento
		  					WHERE codemissor = '$codemissor' AND
		  				  		  codverificacao = '$codverificacao'");
		
		list($codigo)=mysql_fetch_array($sql_certicao_negativa);
		$codv = base64_encode($codigo);
		Redireciona("../../../reports/certpagamento.php?CODV=$codv");
	}
} else {
	Mensagem("Inválido");
	Redireciona("../site/certidoes.php");
}
?>
	