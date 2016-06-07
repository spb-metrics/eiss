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
//menu com uma array com os nomes e o links respectivos
$menus = array(
	"Cadastro Empresas" 	=> "cadempresas.php",
	"AIDF" 					=> "aidf.php",
	"Declara��o Eletr�nica" => "des.php",
	//"Certid�es Eletr�nicas" 	=> "certidoes.php", //menu certidoes eletronicas retiradas em novahartz
	"Simples Nacional" 		=> "simples.php",
	"MEI" 					=> "mei.php",
	//"Download" 			=> "download.php", //menu download retirado em novahartz
	"Institui��o Financeira"=> "dif.php",
	"Operadoras de Cr�dito" => "doc.php",
	"�rg�o P�blico" 		=> "dop.php",
	"Empreiteiras" 			=> "decc.php",
	"Cart�rio" 				=> "dec.php",
	"Legisla��o" 			=> "legislacao.php",
	"Not�cias" 				=> "noticias.php",
	"Perguntas e Respostas" => "faq.php",
	"Reclama��es" 			=> "ouvidoria.php",
	"Contato" 				=> "contato.php"
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
foreach($menus as $menu_nome => $menu_link){
	?>
	<tr>
		<td height="20" class="menu"><a class="menu" href="<?php echo $menu_link; ?>">&nbsp;<?php echo $menu_nome; ?></a></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<?php
}
?>
</table>
<br />

