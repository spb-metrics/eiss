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
// Acentuação
header("Content-Type: text/html; charset=ISO-8859-1",true);	
?><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><?php	
require_once("conect.php");//Conecta ao banco de dados

$prefeitura_cnpj = $CONF_CNPJ;//cnpj e nome da prefeitura vem do conetct.php
$prefeitura_nome = $CONF_CIDADE;

$cnpj = $_GET['valor'];	

/*
if($prefeitura_cnpj == $cnpj){
	echo "Prefeitura de $prefeitura_nome";
	exit;
}
*/
$sql_buscatomador = mysql_query("SELECT razaosocial FROM cadastro WHERE cnpj = '$cnpj' OR cpf = '$cnpj'");
list($razao) = mysql_fetch_array($sql_buscatomador);

if(mysql_num_rows($sql_buscatomador)>0){
	if($razao){
		echo $razao;
	}else{
		echo '&nbsp;';
	}
}else{
	if($_GET['cad']!='n'){
		echo "Tomador n&atilde;o cadastrado!";
	}else{
		echo '&nbsp;';
	}
	
}
	

?>