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
<?php if($btCadastrar !="")
{
  if(($txtCpfCnpjTomador !="")&& ($txtRpsNumero !="") && ($txtRpsData !="") && ($txtRpsValor !="") && ($txtCpfCnpjPrestador !="")
  && ($txtEmailtomador !=""))
  {
    $sql=mysql_query("SELECT cnpjcpf FROM emissores WHERE cnpjcpf='$txtCpfCnpjPrestador'");
	if(mysql_num_rows($sql)>0)
		{
			$data= implode("-",array_reverse(explode("/", $txtRpsData)));
			
			$sql=mysql_query("INSERT INTO reclamacoes SET assunto ='Nota Fiscal Eletrônica de Serviços', especificacao='$cmbEspecificacao', tomador_cnpj='$txtCpfCnpjTomador', rps_numero='$txtRpsNumero', rps_data='$data', rps_valor='$txtRpsValor',
			emissor_cnpjcpf='$txtCpfCnpjPrestador', estado='pendente', datareclamacao = NOW(),tomador_email='$txtEmailtomador' ");
			
			print "<script language=JavaScript> alert('Reclamação cadastrada com sucesso!!');</script>";
		}
	else
		{
			echo "<script>alert('Prestador de serviços inexistente! Certifique-se de que o CPF/CNPJ do prestador de serviços está correto');</script>";
		}		
  }
  else
  {
   print "<script language=JavaScript> alert('Favor preencher campos obrigatórios');</script>";  
  }	

}?>


<form action="reclamacoes.php?btCadastro=T" method="post">

<table width="500" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td colspan="2" bgcolor="#FF6600" height="1">	</td>
   </tr>  
  
  <tr>
    <td align="center" background="../../img/index/index_oquee_fundo.jpg" colspan="2">
	 <b> Cadastro de reclamações </b><br><br><br>	</td>    
  </tr>  
  
  <tr>
    <td align="left" background="../../img/index/index_oquee_fundo.jpg" >
	 Assunto	</td>   
	<td align="left" background="../../img/index/index_oquee_fundo.jpg">
	 Nota Fiscal Eletrônica de Serviços	</td> 
  </tr>  
  
  <tr>
    <td align="left" background="../../img/index/index_oquee_fundo.jpg" >
	 Especificação	</td>   
	<td align="left" background="../../img/index/index_oquee_fundo.jpg"><select name="cmbEspecificacao" class="combo">
	  <option value="Conversão de NFE">N&atilde;o convers&atilde;o de RPS</option>
	  <option value="Diferen&ccedil;a de valores RPS/NFE">Diferen&ccedil;a de valores RPS/NFE</option>
	  <option value="Nota Cancelada">Nota Cancelada</option>
	</select></td> 
  </tr>  
 
  <tr>
    <td width="222" align="left" background="../../img/index/index_oquee_fundo.jpg">
	  Cpf/Cnpj do Tomador de serviços<font color="#FF0000">*</font></b>	</td>	
    <td width="258" align="left" background="../../img/index/index_oquee_fundo.jpg">
    <input type="text" name="txtCpfCnpjTomador" id="txtCpfCnpjTomador" class="texto"  onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );">  </tr>
  
  <tr>
    <td background="../../img/index/index_oquee_fundo.jpg" align="left">
	  Tomador Email<b><font color="#FF0000">*</font></b>	 
	</td>
    <td  background="../../img/index/index_oquee_fundo.jpg" align="left">
	  <input type="text" class="email" name="txtEmailtomador">  
	</td>  
  </tr>
  <tr>
    <td background="../../img/index/index_oquee_fundo.jpg" align="left">
	 Número do RPS ou NFe<b><font color="#FF0000">*</font></b>	</td>
    <td  background="../../img/index/index_oquee_fundo.jpg" align="left">
    <input type="text" class="texto" name="txtRpsNumero">  </tr>
  <tr>
    <td background="../../img/index/index_oquee_fundo.jpg" align="left">
	 Data de Emissão do RPS ou NFe<font color="#FF0000">*</font></b>	</td>
    <td  background="../../img/index/index_oquee_fundo.jpg" align="left">
    <input type="text" class="texto" name="txtRpsData" onKeyPress="formatar(this,'00/00/0000')" maxlength="10">  </tr>
  <tr>
    <td background="../../img/index/index_oquee_fundo.jpg" align="left">
	 Valor do RPS ou NFe<font color="#FF0000">*</font></b>	</td>
    <td  background="../../img/index/index_oquee_fundo.jpg" align="left">
    <input type="text" class="texto" name="txtRpsValor">  </tr>
  <tr>
    <td background="../../img/index/index_oquee_fundo.jpg" align="left">
	 CPF/CNPJ do Prestador de serviços<font color="#FF0000">*</font></b>	</td>
    <td  background="../../img/index/index_oquee_fundo.jpg" align="left">
    <input type="text" class="texto" name="txtCpfCnpjPrestador" id="txtCpfCnpjPrestador" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );">  </tr>
  <tr>
    <td align="center" background="../../img/index/index_oquee_fundo.jpg">
	  <input type="submit" name="btCadastrar" value="Cadastrar" class="botao">	</td>
	<td align="right" background="../../img/index/index_oquee_fundo.jpg">
	  <font color="#FF0000">*</font></b> Campos com preenchimento obrigátorio.	</td>
  </tr>  
  <tr>
    <td colspan="2" bgcolor="#FF6600" height="1">	</td>
  </tr>
</table>
</form>
