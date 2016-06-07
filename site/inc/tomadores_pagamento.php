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
  if($_POST['btConfirmar']=="Confirmar Dados")
  {    
    mysql_query("UPDATE tomadores_pagamento SET estado='C',dadosconfirmacao='$txtDadosConfirma' WHERE nropagamento='$NroPagamento'");
	$sqlConfirmado=mysql_query("SELECT dadosconfirmacao FROM tomadores_pagamento WHERE nropagamento='$NroPagamento' GROUP BY cpfcnpj");					  
	list($CONFIRMACAO)=mysql_fetch_array($sqlConfirmado);
  }

						  

 if($_POST['btPagamento'] =="Pagamento")
 { 
  
  
  
   $sql=mysql_query("SELECT tomador_nome, SUM(issretido) FROM notas WHERE tomador_cnpjcpf='$txtCpfCnpj' AND issretido<>0 GROUP BY tomador_cnpjcpf");
       $linhas=mysql_num_rows($sql);
	   if($linhas==0)
	   {	   
	    $btPagamento="";
		echo"<script>alert('Não existem notas com este CNPJ ou CPF!');parent.location='tomadores.php';</script>";
	   }
	   else
 	   {
	     list($tomadornome,$totalissretido)=mysql_fetch_array($sql);
	     if($totalissretido==0)
		 {
		  $btPagamento="";
		  echo"<script>alert('Sem ISS para ser pago!');parent.location='tomadores.php';</script>";
		  
		 }
		 else
		 {
		   	  if($cmbMes =='total')
			  {
			    $string=("AND SUBSTRING(datahoraemissao,1,4)='$cmbAno'");									  									  
			  }	
			  else
			  { 
			     $string=("AND SUBSTRING(datahoraemissao,6,2)='$cmbMes' AND SUBSTRING(datahoraemissao,1,4)='$cmbAno'");				 
			  }					 
			     
			     $sql01=mysql_query("SELECT SUM(issretido) FROM notas WHERE tomador_cnpjcpf='$txtCpfCnpj'".$string." AND issretido<>0 GROUP BY tomador_cnpjcpf");											 
				 list($issretido)=mysql_fetch_array($sql01);
				 
				 $sql_codnota=mysql_query("SELECT codigo FROM notas WHERE tomador_cnpjcpf='$txtCpfCnpj'".$string."AND issretido<>0");								 
				 
				 if((mysql_num_rows($sql01)==0)||($issretido==0))
				 {	
				  $btPagamento="";			  
				  echo"<script>alert('Sem ISS para pagar nesta data');parent.location='tomadores.php';</script>"; 		   
				 }
				 
				 else
				 {				 
					  
					  if($cmbMes =='total')
					    {
						$string01=("'$cmbAno-00-00'");	
						$string02=("SUBSTRING(data,1,4)='$cmbAno'");								  									  
					    }	
					  else
					    { 
						 $string01=("'$cmbAno-$cmbMes-00'");				 
						 $string02=("AND SUBSTRING(data,6,2)='$cmbMes' AND SUBSTRING(data,1,4)='$cmbAno'");
					    }						
						
					  $sqlVerifica=mysql_query("SELECT estado,dadosconfirmacao FROM tomadores_pagamento WHERE cpfcnpj='$txtCpfCnpj'".$string02." GROUP BY cpfcnpj");	
					  list($estadoPagamento,$CONFIRMACAO)=mysql_fetch_array($sqlVerifica);					  
					  
                      if($estadoPagamento=='')					  
					  {   
					      $cont=0;
						  while(list($codNota)=mysql_fetch_array($sql_codnota))
						  {
							mysql_query("INSERT INTO tomadores_pagamento SET estado='D', cpfcnpj='$txtCpfCnpj',nropagamento='1',codnota='$codNota',data=".$string01."");			
							$cont++;	  
						  }
						  $NROpagamento = $cont.rand(000000,999999);
						  mysql_query("UPDATE tomadores_pagamento SET nropagamento='$NROpagamento' WHERE cpfcnpj='$txtCpfCnpj' AND nropagamento='1'");
						  
					  }  
			
						  
						 
					  $sqlprefdadosbanco=mysql_query("SELECT agencia,contacorrente,banco FROM boleto");
					  list($Agencia,$Conta,$BancoM)=mysql_fetch_array($sqlprefdadosbanco);
					  
					  $sqlprefdadosconf=mysql_query("SELECT cnpj FROM configuracoes");
					  list($CnpjPref)=mysql_fetch_array($sqlprefdadosconf);
		
					
		              $sqlnropagamento=mysql_query("SELECT nropagamento FROM tomadores_pagamento WHERE cpfcnpj='$txtCpfCnpj'".$string02." GROUP BY cpfcnpj");	
				      list($nropagamento)=mysql_fetch_array($sqlnropagamento);?>
				    <form method="post" name="frmGuia" id="frmGuia" >
					 <input type="hidden" name="btPagamento"value="Pagamento" />
					 <input type="hidden" name="NroPagamento" value="<?php echo $nropagamento ?>" />
					 <input type="hidden" name="cmbAno" value="<?php echo $cmbAno ?>" />
					 <input type="hidden" name="cmbMes" value="<?php echo $cmbMes ?>" />
					 <input type="hidden" name="txtCpfCnpj" value="<?php echo $txtCpfCnpj ?>" />
				     <fieldset style="width:520px;"><legend>Pagamento de ISS</legend>
					 <table width="520" border="0" align="center">
					   <tr>	
					    <td align="left">
						  <b>Para pagar o seu Iss do <?php if($cmbMes!='total'){echo"período de ".$cmbMes."/".$cmbAno;}else{echo"ano de ".$cmbAno;}?> deverá efetuar o depósito na conta 
						  da prefeitura.</b>
						</td>
					   </tr>
					   <tr>
					    <td align="left">						
						  Dados para Depósito, Transferência, DOC ou TED:<br />
						  <b>Titular:</b> <?php echo"$PREFEITURA" ;?><br />
						  <b>CNPJ:</b> <?php echo"$CnpjPref" ;?><br />						  
						  <b>Banco:</b> <?php echo"$BancoM" ;?><br />
						  <b>Agência:</b> <?php echo"$Agencia" ;?><br />
						  <b>Conta Corrente:</b> <?php echo"$Conta" ;?><br /><br />
						  
						  <b>Como faço para Depositar?</b><br />
						  1. Com os dados bancários em mãos, dirija-se até uma agencia <?php echo"$BancoM" ;?> mais próxima.<br />
 						  2. Efetue o Depósito, caso não saiba como, basta pedir auxilio a um funcionário do banco (ele estará de crachá).<br />
						  3. Você receberá um comprovante, que contem um número único, necessário para a confirmação.<br />
						    Se você depositou usando o Caixa Eletronico, esse número se chama "Número do Envelope"<br />
							Se você depositou usando o Caixa Manual, esse número se chama "Número do Documento"<br />
						  4. Faça a confirmação.<br /><br />
						  
						  Como faço para Confirmar o Pagamento?<br />						  
						  - Coloque na caixa de Confirmação  o Número do Documento, Envelope ou Nome Completo do titular em caso de Trasnferência/DOC/TED.<br /><br />
						  
						  <?php if($cmbMes!='total'){echo"ISS retido do período de ".$cmbMes."/".$cmbAno;}
						  else{echo"ano de ".$cmbAno;}?> Valor: <font color="#FF0000"><?php echo $issretido;?></font>
						  
						  <?php
						  if($estadoPagamento=='N')
						  {
						   echo"<center><font color=\"#FF0000\">Depósito Não foi encontrado,verifique os dados de confirmação ou consulte o banco.</font></center>";
						  }
						  elseif($estadoPagamento=='C')
						  {
						   echo"<center><font color=\"#FF0000\">Aguardando confirmação da prefeitura.</font></center>";
						  }
						  
						  
						  ?>
						  <br /><br />						
						  
						  <b>exemplo:</b><br />
						    &nbsp;Data: 00/00/0000<br/>
							&nbsp;Número do Documento: 0.000.000.000<br />
							&nbsp;valor: 00,00 R$<br />      
						  
						  
						 
						  <center>
						  <textarea cols="40" rows="10" name="txtDadosConfirma" class="texto"><?php if(isset($CONFIRMACAO)){echo $CONFIRMACAO;}?></textarea><br />
						  <input type="submit" name="btConfirmar" value="<?php if(isset($CONFIRMACAO)){echo"Atualizar Dados";}else{echo"Confirmar Dados";}?>" class="botao" />
						  </center>
						   
						
						</td>
					   </tr>					   
					 </table> 
					 </fieldset>
				    <form>
				   
		         <?php 
			     }	 	       
		 }		
       }  
 }
 else
 {



?>

<form method="post"> 
<table width="500" border="0" align="center" style="margin-left:9px;" >
 <tr>  
  <td colspan="2" align="center" bgcolor="#FFFFCC" 
  style="font-family:Verdana, Arial, Helvetica, sans-serif;">
   <b>Guia de Pagamento</b>
  </td> 
 </tr>
 <tr>
  <td  align="left">
   Cpf/Cnpj<font color="#FF0000">*</font>
  </td>
  <td  align="left">
   <input type="text" name="txtCpfCnpj" size="20" class="texto" onkeydown="stopMsk( event );" onkeypress="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );"  maxlength="18" />
  </td> 
 </tr>
 <tr>  
  <td align="left">
   Período 
  </td>
  <td align="left">    
    <select name="cmbMes" id="cmbMes" class="combo">
	  <option value=""> selecione o mês </option>
	  <option value="total" style="color:#FF0000;">Total</option>
	  <option value="01">janeiro</option>
	  <option value="02">fevereiro</option>
	  <option value="03">março</option>
	  <option value="04">abril</option>
	  <option value="05">maio</option>
	  <option value="06">junho</option>
	  <option value="07">julho</option>
	  <option value="08">agosto</option>
	  <option value="09">setembro</option>
	  <option value="10">outubro</option>
	  <option value="11">novembro</option>
	  <option value="12">dezembro</option>
	</select>	
	
	<select name="cmbAno" id="cmbAno" class="combo">
        <option selected="selected"> selecione ano </option>        
        <option value="2009">2009</option>
		<option value="2008">2008</option>
    </select>	
  </td> 
 </tr>
 <tr>  
  <td  colspan="2" align="center"><br />
   <input type="submit" name="btPagamento" size="20" class="botao" value="Pagamento"/>
  </td> 
 </tr>
</table>
</form>
<? }?>