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
<title>Imprimir</title>

<body>

<div id="div"><input name="btImprimir" id="btImprimir" type="button" value="Imprimir" onClick="document.getElementById('div').style.display='none';print()" /></div>
<?php 
require_once("../conect.php");
require_once("../../funcoes/util.php"); 

//inclui o arquivo que atualiza as informações no banco
require_once("aidf_liberar.php");
echo "<script>window.close()</script>";
$codaidf = $_POST['hdCodAidf'];
if($codaidf == ""){ $codaidf = $_POST["txtCodAidf"];}

//dados do emissor e da grafica
$sql_aidf = mysql_query("
					SELECT 
						emissor.razaosocial as emissor_razao,
						emissor.cnpjcpf as emissor_cnpj,
						emissor.inscrmunicipal as emissor_im,
						emissor.endereco as emissor_endereco,
						emissor.municipio as emissor_municipio,
						emissor.uf as emissor_uf,
						grafica.razaosocial as grafica_razao,
						grafica.cnpjcpf as grafica_cnpj,
						grafica.inscrmunicipal as grafica_im,
						grafica.endereco as grafica_endereco,
						grafica.municipio as grafica_municipio,
						grafica.uf as grafica_uf,
						DATE_FORMAT(aidf.data,'%m/%d/%Y'),
						aidf.observacoes
					FROM 
						aidf_solicitacoes as aidf
					INNER JOIN 
						emissores as emissor ON aidf.codemissor=emissor.codigo
					INNER JOIN 
						graficas as grafica ON aidf.codgrafica=grafica.codigo
					WHERE 
						aidf.codigo = '$codaidf'
					");
list($emissor_razao,$emissor_cnpj,$emissor_im,$emissor_endereco,$emissor_municipio,$emissor_uf,
	 $grafica_razao,$grafica_cnpj,$grafica_im,$grafica_endereco,$grafica_municipio,$grafica_uf,
	 $data,$observacoes)=mysql_fetch_array($sql_aidf);

echo"SOLICITANTE: <br>$emissor_razao,$emissor_cnpj,$emissor_im,$emissor_endereco,$emissor_municipio,$emissor_uf,<br>
	 GRAFICA: <br>$grafica_razao,$grafica_cnpj,$grafica_im,$grafica_endereco,$grafica_municipio,$grafica_uf,<br>
	 $data,$observacoes<br><br>";
//documentos solicitados dentro da aidf	 
$sql_docs = mysql_query("
					SELECT 
						especie,
						serie,
						subserie,
						nroinicial,
						nrofinal,
						quantidade,
						tipo
					FROM 
						aidf_docs
					WHERE 
						codsolicitacao = '$codaidf'
				");
while(list($especie,$serie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo)=mysql_fetch_array($sql_docs)) {
	echo"DOC:  $especie,$serie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo<br>";
}//fim while
	



?>
</body>