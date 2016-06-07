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
//header("Content-Type: text/xml"); //cabeçalho da página
//require_once '../../conect.php';
require_once 'xml.class.php';
//$codigo='57659';


$sql_cadastro = mysql_query("
	SELECT
		codigo,
		nome, 
		razaosocial,
		cnpj,
		cpf,
		inscrmunicipal,
		logradouro,
		numero,
		complemento,
		bairro,
		cep,
		municipio,
		uf,
		email,
		fonecomercial,
		fonecelular
	FROM
		cadastro
	WHERE
		codigo='$codigo'
");

$sql_servicos = mysql_query("
	SELECT 
		servicos.codigo,
		servicos.codcategoria,
		servicos_categorias.nome,
		servicos.codservico,
		servicos.descricao, 
		servicos.aliquota,
		servicos.aliquotair,
		servicos.basecalculo,
		servicos.incidencia,
		servicos.datavenc
	FROM 
		servicos 
	INNER JOIN 
		cadastro_servicos ON servicos.codigo=cadastro_servicos.codservico
	INNER JOIN 
		cadastro ON cadastro_servicos.codemissor=cadastro.codigo 
	INNER JOIN
		servicos_categorias ON servicos_categorias.codigo = servicos.codcategoria
	WHERE codemissor='$codigo'
");

$dom = new documentoXML('1.0', 'ISO-8859-1');//cria objeto instanciando a classe
$dados = $dom->createElement('dados','');//cria a tag raiz dados

$cadastro = $dom->createElement('cadastro','');//cria a tag cadastro
$result_cadastro = mysql_fetch_assoc($sql_cadastro);
foreach($result_cadastro as $key => $val) {//por cada campo do banco cria uma tag xml e joga pra dentro da tag cadastro
    $dado = $dom->createElement($key,$val); 
    $cadastro->appendChild($dado);
}
$dados->appendChild($cadastro);//joga a tag cadastro dentro da dados

if(mysql_num_rows($sql_servicos)){
	$servicos = $dom->createElement('servicos','');//cria a tag servicos
	while($result_servicos = mysql_fetch_assoc($sql_servicos)){
		$servico = $dom->createElement('servico','');
		foreach($result_servicos as $key => $val) {//cria uma tag servico com duas informacoes
		    $dado = $dom->createElement($key,$val);
		    $servico->appendChild($dado);
		}
		$servicos->appendChild($servico);
	}
	$dados->appendChild($servicos);//joga a tag servicos dentro da dados
}

$dom->appendChild($dados); //joga a tag dados pro xml
//echo $dom->saveXML();
@mkdir("xmls/offline/emp$codigo");
$dom->save("xmls/offline/emp$codigo/dados.xml");
?>