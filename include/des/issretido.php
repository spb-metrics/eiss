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
if ($_POST['txtInscMunicipal']){
	$tomador_IM = $_POST['txtInscMunicipal'];
	$sql_IM_tomador=mysql_query("
		SELECT cnpj,cpf
		FROM cadastro
		WHERE inscrmunicipal='$tomador_IM'
	");
	if(!mysql_num_rows($sql_IM_tomador))	{
		Mensagem("Inscrição Municipal não encontrada, verifique os dados ou tente pelo CNPJ/CPF");
		Redireciona("tomadores.php");
	}else{
		list($tomador_CNPJ,$tomador_CPF)=mysql_fetch_array($sql_IM_tomador);
		$tomador_CNPJ = $tomador_CNPJ.$tomador_CPF;
	}
}
if ($_POST['txtCNPJ']){
	$tomador_CNPJ = $_POST['txtCNPJ'];
}
$sql_emissor = mysql_query("SELECT codigo, cnpj,cpf, razaosocial, email, inscrmunicipal, logradouro,numero,complemento,bairro,cep FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
if (mysql_num_rows($sql_emissor)){
	list($cod_emissor,$cnpj_emissor,$cpf_emissor,$nome_emissor,$email_emissor,$inscrmunicipal_emissor,$logradouro_emissor,
		$numero_emissor,$complemento_emissor,$bairro_emissor,$cep_emissor)=mysql_fetch_array($sql_emissor);
}
$sql_tomador=mysql_query("SELECT codigo, cnpj,cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");

if(!mysql_num_rows($sql_tomador)){
	$tipopessoa = strlen($tomador_CNPJ)==18? 'cnpj':'cpf';
	$codtipo = codtipo('tomador');
	$codtipodec = coddeclaracao('DES Simplificada');
	mysql_query("
		INSERT INTO 
			cadastro 
		SET 
			$tipopessoa = '$tomador_CNPJ',
			codtipo = '$codtipo',
			codtipodeclaracao = '$codtipodec'
	");
	//echo mysql_error();
	$sql_tomador=mysql_query("SELECT codigo, cnpj, cpf, nome, email FROM cadastro WHERE cnpj='$tomador_CNPJ' OR cpf='$tomador_CNPJ'");
	//Mensagem("Tomador não cadastrado no sistema, preencha os campos obrigatórios");
}			  
	
list($cod_tomador,$cnpj,$cpf,$TomadorNome,$TomadorEmail)=mysql_fetch_array($sql_tomador);

listaRegrasMultaDes();
?>
<form method="post" name="frmDesSemTomador" action="../include/des/gerarguia.php" onsubmit="document.getElementById('hdTotalInputs').value=totalemissores_des;return confirm('Confira seus dados antes de continuar');">	
<input type="hidden" name="hdTotalInputs" id="hdTotalInputs" />
<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="165" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">DES - Serviços Tomados</td>
      <td width="405" bgcolor="#FFFFFF"></td>
  </tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">



	<table border="0" cellpadding="3" cellspacing="2" width="100%">
		<tr>
			<td width="30%" align="left" valign="middle">CNPJ/CPF:</td>
			<td width="70%" align="left" bgcolor="#FFFFFF">&nbsp;&nbsp;<b><?php echo $_POST['txtCNPJ'];?></b>
			 <input type="hidden" value="<?php echo $_POST['txtCNPJ'];?>" name="txtCNPJ" /></td>
		</tr>		
		<tr>
			<td align="left" valign="middle">Razão Social/Nome:</td>
			<td align="left"><font color="#FF0000">*</font> <input type="text" name="txtRazaoNome" value="<?php echo $TomadorNome;?>" id="txtRazaoNome" class="texto"  size="62"/></td>
		</tr>			
		
		<tr>
			<td align="left" valign="middle">
				Compet&ecirc;ncia/Período:
			</td>
			<td align="left">&nbsp;&nbsp;  
				<?php
				$meses=array("1"=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
				$mes=date("n");
				$ano=date("Y");						
				if($DEC_ATRAZADAS == 'n'){//var que vem do conect.php
					echo "<b>{$meses[$mes]}/{$ano}</b>";
				?><br />
				Declarações atrasadas entre em contato com a prefeitura
				<input type="hidden" name="cmbMes" id="cmbMes" value="<?php echo $mes; ?>" />
				<input type="hidden" name="cmbAno" id="cmbAno" value="<?php echo $ano; ?>" />
				<?php 
				}else{
				?>
				  <select name="cmbMes" id="cmbMes" onchange="CalculaMultaDes();">
					  <?php
					  for($ind=1;$ind<=12;$ind++){
					  echo "<option value='$ind'>{$meses[$ind]}</option>";
					  }
					  ?>
				  </select>
				  <select name="cmbAno" id="cmbAno" onchange="CalculaMultaDes();" >
						<?php
							$year=date("Y");
							for($h=0; $h<5; $h++){
								$y=$year-$h;
								echo "<option value=\"$y\">$y</option>";
							}
						?>
				  </select>
				<?php
				}//else se é permitudo declaracões atrazadas
				?>
			</td>
		</tr>		
		<tr>
			<td colspan="2" align="center" valign="middle">
			 <br/>
			 <table width="100%" border="0" cellspacing="1">
			 	<tr>
				  <td colspan="4" align="center" bgcolor="#999999">
				    Dados dos Emissores:
				  </td>
				</tr> 				
				<tr>
				  <td width="24%" align="center" bgcolor="#999999">	
				    Cnpj/Cpf				  
				  </td>		
				  <td width="22%" align="center" bgcolor="#999999">		
   				    Número Nota				  
				  </td>									
				  <td width="29%" align="center" bgcolor="#999999">		
	
					Valor Nota			  
				  </td>											  
				  <td width="25%" align="center" bgcolor="#999999">					    
				    ISS Retido				  
				  </td>											  
				</tr>
			  </table>
				<div id="divEmissores" style="width:100%"> </div>
				
				<table align="right">	
				<tr>
				  <td align="right">
				    <input type="button" value="Remover" onclick="DesTomadores('deletar');" class="botao" id="btRemover" disabled="disabled"/>
					<input type="button" value="Nova Nota" onclick="DesTomadores('inserir');" class="botao"/>
				  </td>
				</tr>
				</table> 		
					
				
			 <br /><br />			
			 <table>
					<tr>
						<td align="left">Imposto Total:</td>
						<td>R$ <input type="text" name="txtImpostoTotal" id="txtImpostoTotal" value="0,00"style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>
					<tr>
						<td align="left">Multa e Juros de Mora:</td>
						<td>R$ <input type="text" name="txtMultaJuros" id="txtMultaJuros" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>
					<tr>
						<td align="left"><b>Total a Pagar:</b></td>
						<td>R$ <input type="text" name="txtTotalPagar" id="txtTotalPagar" value="0,00" style="text-align:right;" readonly="readonly" size="16" class="texto" /></td>
					</tr>	
			</table>
			</br>
			</br>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><br /><input type="submit" value="Declarar" onclick="document.getElementById('hdTotalInputs').value=totalemissores_des;return ValidarDesIssRetido();" class="botao" /><br />*Confira seus dados antes de continuar</td>
		</tr>
	</table>

		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
	</form>
<script type="text/javascript">
	DesTomadores('inserir');
</script>

