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
require_once("../../../funcoes/util.php"); 
session_start();

if (!$_POST||!$_SESSION['SESSAO_cnpj_emissor']){
	Redireciona("../..");
}

$cod_verificacao = $_POST['txtCodVerificacao'];
$sql=mysql_query("SELECT codigo, nome,cnpj,cpf FROM cadastro WHERE cnpj='".$_SESSION['SESSAO_cnpj_emissor']."' OR cpf='".$_SESSION['SESSAO_cnpj_emissor']."'");
list($codigo,$nome,$cnpj,$cpf)=mysql_fetch_array($sql);

$sql_certicao_negativa = mysql_query("
					SELECT codigo
  					FROM certidoes_negativas 
  					WHERE codemissor = '$codigo' AND
  				  		  codverificacao = '$cod_verificacao'");

$sql_certicao_pagamento = mysql_query("
					SELECT codigo
  					FROM certidoes_pagamento 
  					WHERE codemissor = '$codigo' AND
  				  		  codverificacao = '$cod_verificacao'");


if (mysql_num_rows($sql_certicao_negativa)){
	list($codigo)=mysql_fetch_array($sql_certicao_negativa);
	$codv = base64_encode($codigo);
	Redireciona("../../../reports/certnegativa.php?CODV=$codv");
} else if (mysql_num_rows($sql_certicao_pagamento)){
	list($codigo)=mysql_fetch_array($sql_certicao_pagamento);
	$codv = base64_encode($codigo);
	Redireciona("../../../reports/certpagamento.php?CODV=$codv");

}else{
	Mensagem("Codigo Inválido!");
	FecharJanela();
	//Redireciona("../..");
}



?>