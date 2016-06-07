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
<style type="text/css">
<!--
.style2 {color: #999999}
-->
</style>
<table width="150" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td><img src="../img/topicos/topicos_indicativos.jpg"></td>
  </tr>
  <tr>
    <td><font color="#999999">------------------------------</font></td>
  </tr>
  <tr>
    <td>Contribuintes autorizados à emissão de NFe<br>
	<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM emissores WHERE estado = 'A'");
list($empresas_ativas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$empresas_ativas</strong></font>";
	
	?>
	</td>
  </tr>
  <tr>
    <td><font color="#999999">------------------------------</font></td>
  </tr>
  <tr>
    <td>NFe já emitidas<br>
	<?php
$sql = mysql_query("SELECT COUNT(codigo) FROM notas");
list($notas_emitidas) = mysql_fetch_array($sql);
echo "<font color=#FF0000 size=4><strong>$notas_emitidas</strong></font>";
	
	?>
	</td>
  </tr>
  <tr>
    <td><font color="#999999">------------------------------</font></td>
  </tr>  
</table>

