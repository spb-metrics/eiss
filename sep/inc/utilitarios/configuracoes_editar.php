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
//recebimento de variaveis por post
$endereco        = $_POST["txtEndereco"];
$cidade          = $_POST["txtCidade"];
$uf              = $_POST["txtUF"];
$chefetributos   = $_POST["txtChefe"];
$cnpj            = $_POST["txtCNPJ"];
$email           = $_POST["txtEmail"];
$lei             = $_POST["txtLei"];
$decreto         = $_POST["txtDecreto"];
$secretaria      = $_POST["txtSecretaria"];
$secretario      = $_POST["txtSecretario"];
$taxamulta       = $_POST["txtMulta"];
$taxajuros       = $_POST["txtJuros"];	
$taxacorrecao    = $_POST["txtTaxaCorrecao"];
$data_tributacao = $_POST["txtData"];
$layout          = $_POST["txtLayout"];
$dec_atrazadas   = $_POST["rbDec"];//dec_atrazadas serve para definir se a prefeitura aceita declaracoes atrazadas pelo site, se nao aceita, somente com a prefeitura pelo sepiss
$gerar_guia_site = $_POST["rbGuias"];
				


// testa quais campos tem valor e faz o upload da imagem
if($flBrasao !=""){

	$brasao = Uploadimagem('flBrasao','img/brasoes/');
	
	if(!is_dir("../img/brasoes/")){
		mkdir("../img/brasoes/");
	}
	
	$file = "img/brasoes/$brasao";
	$newfile = "../img/brasoes/$brasao";
	
	if(file_exists($file)){
		copy($file, $newfile);
	}

}//fim if
if($flLogo != ""){
	$logo = Uploadimagem('flLogo','img/logos/');
	
	if(!is_dir("../img/logos/")){
		mkdir("../img/logos/");
	}
	
	$file = "img/logos/$logo";
	$newfile = "../img/logos/$logo";
	
	if(file_exists($file)){
		copy($file, $newfile);
	}
	
}//fim if
if($flTopo != ""){
	$topo = Uploadimagem('flTopo','img/topos/');
	
	if(!is_dir("../img/topos/")){
		mkdir("../img/topos/");
	}
	
	$file = "img/topos/$topo";
	$newfile = "../img/topos/$topo";
	
	if(file_exists($file)){
		copy($file, $newfile);
	}
	
} //fim if 
//--------------------Update------------------------------  
//testa quais arquivos foram upados e tem retorno para atualizar no banco, para nao subescrever arquivos anteriores
if(($brasao != "") && ($logo == "") && ($topo == "")){
	$string = ",brasao = '$brasao'";
}elseif(($brasao == "") && ($logo != "") && ($topo == "")){
	$string = ",logo = '$logo'";
}elseif(($brasao == "") && ($logo == "") && ($topo != "")){
	$string = ",topo = '$topo'";
}elseif(($brasao != "") && ($logo != "") && ($topo == "")){
	$string = ",brasao = '$brasao', logo = '$logo'";
}elseif(($brasao != "") && ($logo == "") && ($topo != "")){
	$string = ",brasao = '$brasao', topo = '$topo'";
}elseif(($brasao == "") && ($logo != "") && ($topo != "")){
	$string = ",logo = '$logo', topo = '$topo'";
}elseif(($brasao != "") && ($logo != "") && ($topo != "")){
	$string = ",brasao = '$brasao', logo = '$logo', topo = '$topo'";
}//fim elseif

mysql_query("
	UPDATE configuracoes SET 
		endereco = '$endereco', 
		cidade = '$cidade', 
		estado = '$uf', 
		cnpj = '$cnpj', 
		email = '$email', 
		secretaria = '$secretaria', 
		secretario = '$secretario', 
		chefetributos = '$chefetributos', 
		lei = '$lei', 
		decreto = '$decreto'". $string .", 
		codlayout = '$layout', 
		taxacorrecao = '$taxacorrecao', 
		taxamulta = '$taxamulta', 
		taxajuros = '$taxajuros', 
		data_tributacao = '$data_tributacao', 
		declaracoes_atrazadas='$dec_atrazadas' , 
		gerar_guia_site='$gerar_guia_site'
");
add_logs('Atualizou uma Configuração');
Mensagem_onload("Dados atualizados");
?>