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
 $credito_total =0;
 
 $sql=mysql_query("SELECT credito FROM notas WHERE datahoraemissao >= '$txtAno-01-01' AND
 datahoraemissao <= '$txtAno-12-31' AND tomador_cnpjcpf='$txtTomadorCpfCnpj'  "); 
 while(list($creditos)=mysql_fetch_array($sql))
 {
   $credito_total += $creditos; 
 }
 
 $sql=mysql_query("SELECT tomador_nome, tomador_cnpjcpf FROM notas WHERE tomador_cnpjcpf='$txtTomadorCpfCnpj' LIMIT 1");
 
 $verifica =mysql_num_rows($sql);
 
 if($verifica > 0)
 {
 
 list($nome,$cnpfcpf)=mysql_fetch_array($sql); ?>

<table width="500" border="0" cellpadding="0" cellspacing="0" >
 <tr>
  <td colspan="3" align="center" bgcolor="#CCCCCC" style="color:#FFFFFF">
    Créditos do Tomador <b><?php print $nome;?></b>
  </td>
 </tr> 
 <tr bgcolor="#FFFFCC">
  <td>
    CPF/CNPF do tomador
  </td>
  <td>
    Nome do tomador
  </td>
  <td>
    Total de Créditos
  </td>
 </tr>
  
 <tr>
  <td>
    <?php print $cnpfcpf; ?>
  </td>
  <td>
    <?php print $nome;?>
  </td>
  <td>
    <?php print number_format($credito_total,2);?> R$
  </td>
 </tr>  
</table>
<?php
 }
 else
  print("<script language=JavaScript>alert('Cnpj/Cpf Inválido!! Favor Verificar novamente.');parent.location='tomadores.php';</script>"); 
 
 
 
 
 
 
 
 
 
 
 
 
 
  

?>