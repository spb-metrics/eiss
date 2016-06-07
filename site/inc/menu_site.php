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
// itens de menu 
$menu = array("Cadastro Empresas","AIDF","Declaração Eletrônica","NFeletrônica","Certidões Eletrônicas","Simples Nacional","Instituição Financeira","Operadoras de Crédito","Órgão Público","Cartório","Download","Perguntas e Respostas","Contato","Notícias","Legislação");

$links = array("cadempresas.php","aidf.php","des.php","nfe.php target=_blank","certidoes.php","simples.php","dif.php","doc.php","dop.php","dec.php","download.php","faq.php","contato.php","noticias.php","legislacao.php");
// contador do vetor
$cont = count($menu);
// variavel auxiliar
$aux = 0;

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
// lista itens de menu
while($aux < $cont) {
	// imprime html
	
?>
  <tr>
    <td height="20" class="menu"><a class="menu" <?php echo "href=$links[$aux]"; ?>>&nbsp;<?php echo $menu[$aux]; ?></a></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#CCCCCC"></td>
  </tr>
<?php
	$aux++;
// fecha while
}
?>
</table><br>
<img src="../img/Logo_TI_verde.png"/>
