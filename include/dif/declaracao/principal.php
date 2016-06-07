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
<script>
  function VerificaArquivo(){
	if(document.getElementById('import').value){	
		var arquivo = document.getElementById('import').value;		
		var extensao = (arquivo.substring(arquivo.lastIndexOf("."))).toLowerCase();
		if(extensao !='.xml'){
			alert('O arquivo deverá estar no formato XML');
			return false;
		}
		else{return true;}
	}
	else{
		alert('Insira um arquivo para Realizar a declaração');
		return false; 
	}	
  }
</script>
<?php 
	if($_POST['btEnviar']){
	  include("include/dif/declaracao/verifica_xml.php");
	}
?>

<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="340" align="center" bgcolor="#FFFFFF" rowspan="3">Arquivo de declaração mensal</td>
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
		<td height="60" colspan="3" bgcolor="#CCCCCC" align="center">
			<form  method="post" name="frmPagamento"   enctype="multipart/form-data" onsubmit="return VerificaArquivo();">
				<input type="hidden" value="<?php echo $_POST['txtMenu'];?>" name="txtMenu">
				<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
					<tr>
					  <td align="left" valign="middle" style="text-indent:30px;">Per&iacute;odo</td>
					  <td align="left" valign="middle">
					  	<?php
						//array de meses comencando em 1 ate 12
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
						  <select name="cmbMes" id="cmbMes">
							  <option value=""></option>
				              <?php
							  for($ind=1;$ind<=12;$ind++){
							  echo "<option value='$ind'>{$meses[$ind]}</option>";
							  }
							  ?>
			              </select>
		                  <select name="cmbAno" id="cmbAno">
			                  <option value=""> </option>
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
						<td width="30%" align="left" style="text-indent:30px;"> XML </td>
						<td align="left" width="70%">
							<input type="file" name="import" id="import" class="botao" />
						</td>
					</tr>
					<td colspan="2" align="center">
							<input type="submit" value="Enviar" name="btEnviar" class="botao" onclick="return ValidaFormulario('cmbMes|cmbAno','Preencha a competencia!')">
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
	<tr>
		<td height="1" bgcolor="#CCCCCC" colspan="3"></td>
		<td bgcolor="#CCCCCC"></td>
	</tr>
</table>
