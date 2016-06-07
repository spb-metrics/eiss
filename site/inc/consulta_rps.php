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
<?php if($btConsultarRps !="")
 {
   if(($txtNumeroRps !="")&&($txtDataRps !="") &&($txtPrestCpfCnpj !="")&&($txtTomCpfCnpj !=""))
   {  
    $datarps = implode("-",array_reverse(explode("/", $txtDataRps)));
    $sql=mysql_query("SELECT notas.codigo FROM notas INNER JOIN emissores ON
    `notas`.`codemissor` = `emissores`.`codigo` WHERE notas.rps_numero='$txtNumeroRps' AND notas.rps_data='$datarps' AND 
    notas.tomador_cnpjcpf='$txtTomCpfCnpj' AND emissores.cnpjcpf ='$txtPrestCpfCnpj' "); 
   
    $registros=mysql_num_rows($sql);
    if($registros >0)
    {
     list($cod_nota)=mysql_fetch_array($sql);
     $codigo = base64_encode($cod_nota); 
     print("<script language=\"javascript\">window.open('imprimir.php?CODIGO=$codigo');</script>");
    }
	
    else
    print("<script language=JavaScript>alert('Não existe nota cadastrada com estes dados!');parent.location='tomadores.php';</script>");

 }
 else
 {
   print("<script language=JavaScript>alert('Todos os campos devem ser preenchidos para realizar a consulta.      ');parent.location='tomadores.php';</script>"); 
 }

 }?>



<form method="post" action="tomadores.php"  >
<table width="500" border="0" align="center" style="margin-left:9px;" >
 <tr>  
  <td colspan="2" align="center" bgcolor="#FFFFCC" 
  style="font-family:Verdana, Arial, Helvetica, sans-serif;">
   <b>Consulta RPS</b>
  </td> 
 </tr>
 <tr>
  <td align="left">
   Número do RPS<font color="#FF0000">*</font>
  </td>
  <td align="left">
   <input type="text" name="txtNumeroRps" size="20" class="texto" />
  </td> 
 </tr>
 <tr> 
  <td align="left">
   Data do RPS<font color="#FF0000">*</font>
  </td>
  <td align="left">
   <input type="text" name="txtDataRps" size="10" class="texto" onkeypress="formatar(this,'00/00/0000');" maxlength="10" />(dd/mm/aaaa)
  </td> 
 </tr>  
 <tr>
  <td align="left">
   Prestador CPF/CNPJ<font color="#FF0000">*</font>
  </td>
  <td align="left">
   <input type="text" name="txtPrestCpfCnpj" id="txtPrestCpfCnpj" size="20" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" />
  </td> 
 </tr>
 <tr>
  <td align="left">
   Tomador CPF/CNPJ<font color="#FF0000">*</font>
  </td>
  <td  align="left">
   <input type="text" name="txtTomCpfCnpj" id="txtTomCpfCnpj" size="20" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"/>
  </td> 
 </tr>
  <tr> 
  <td colspan="2" align="center"><br /><br /> 
   <input type="submit" name="btConsultarRps" value="Consultar" class="botao" />
  </td> 
 </tr>
</table>
</form>