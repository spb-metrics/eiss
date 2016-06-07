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
<?php $sql=mysql_query("SELECT notas.numero,notas.valortotal,notas.tomador_nome,notas.estado,notas.estado,emissores.nome FROM notas INNER JOIN emissores ON
`notas`.`codemissor` = `emissores`.`codigo` WHERE notas.rps_numero='$txtNumeroRps' AND notas.rps_data='$txtDataRps' AND 
notas.tomadorcnpjcpf='$txtTomCpfCnpj' AND emissores. ")?>



<table width="490" border="0" cellpadding="0" cellspacing="0" >
 <tr>
  <td align="center" colspan="5" bgcolor="#CCCCCC" style="color:#FFFFFF;" >
    <b><i>Resultado da Consulta</i></b>
  </td>
 </tr>
 <tr bgcolor="#FFFFCC">
  <td>
   <b>Número da Nota</b>
  </td>
  <td>
   <b>Valor da Nota</b>
  </td>
  <td>
   <b>Nome do tomador</b>
  </td>
  <td>
   <b>Estado da Nota</b>
  </td>
  <td> 
   XX 
  </td>
 </tr>
 
 
 

 <tr>
  <td>
   Número da Nota
  </td>
  <td>
   Valor da Nota
  </td>
  <td>
   Nome do tomador
  </td>
  <td>
   Estado da Nota
  </td>
  <td> 
   XX 
  </td>
 </tr>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
</table>