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
	if($_POST["btSalvar"] == "Salvar"){
		include("inc/utilitarios/boleto_editar.php");
	}//fim if
	$sql_boleto = mysql_query("SELECT codigo, tipo,  codbanco, agencia, contacorrente, convenio, contrato, carteira, codfebraban FROM boleto");
	list($codigo, $tipo, $codbanco, $agencia, $contacorrente, $convenio, $contrato, $carteira, $codfebraban)= mysql_fetch_array($sql_boleto);
	//echo "$codigo, $tipo, $codbanco, $agencia, $contacorrente, $convenio, $contrato, $carteira, $cofebraban";
?>
<table border="0" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
    <td width="18" align="left" background="img/form/cabecalho_fundo.jpg"><img src="img/form/cabecalho_icone.jpg" /></td>
    <td width="700" background="img/form/cabecalho_fundo.jpg" align="left" class="formCabecalho">&nbsp;Utilit&aacute;rios - Configura��es</td>  
    <td width="19" align="right" valign="top" background="img/form/cabecalho_fundo.jpg"><a href=""><img src="img/form/cabecalho_btfechar.jpg" width="19" height="21" border="0" /></a></td>
  </tr>
  <tr>
    <td width="18" background="img/form/lateralesq.jpg"></td>
    <td align="center">
    
		<fieldset>
		<legend>Boleto</legend>
		<form method="post" id="frmBoleto" >
		<input name="include" id="include" type="hidden" value="<?php echo $_POST["include"];?>" />
		<input name="btBoleto" id="btBoleto" type="hidden" value="Boleto" />
		<table width="100%">
			<tr align="left">
				<td align="left">Tipo:</td>
				<td>
				<?php 
				$sql_banco = mysql_query("SELECT codigo, banco FROM bancos");
					
					
				
				?>
				<select name="cmbTipo" class="combo">
									<option value="P" <?php if ($tipo == 'P') echo 'selected="selected"'; ?>>Pagamento</option>
									<option value="R" <?php if ($tipo == 'R') echo 'selected="selected"'; ?>> Recebimento</option>
								
					</select></td>
				<td>C�digo do Banco: </td>
				<td><select name="cmbCodBanco" class="combo">
										<?php 
										while(list($codigob, $banco)= mysql_fetch_array($sql_banco)){
											echo "<option value=\"$codigob\"";if($codigob==$codbanco){echo 'selected="selected"';}echo">$banco</option>";
											
											}	
									?>
					</select></td>
			</tr>
			<tr align="left">
				<td align="left">Ag�ncia:</td>
				<td><input name="txtAgencia" type="text" class="texto" value="<?php echo $agencia;?>" ></td>
				<td>Conta Corrente</td>
				<td><input name="txtContaCorrente" type="text" class="texto" value="<?php echo $contacorrente;?>" ></td>
			</tr>
			<tr align="left">
				<td align="left">Conv�nio:</td>
				<td><input name="txtConvenio" type="text" class="texto" value="<?php echo $convenio;?>" ></td>
				<td>Contrato:</td>
				<td><input name="txtContrato" type="text" class="texto" value="<?php echo $contrato; ?>" ></td>
			</tr>
			<tr align="left">
				<td align="left">Carteira:</td>
				<td><input name="txtCarteira" type="text" class="texto" value="<?php echo $carteira;?>" ></td>
				<td align="left">C�digo Febraban:</td>
				<td><input name="txtCodfebraban" type="text" class="texto" value="<?php echo $codfebraban;?>" ></td>
			</tr>
		    <tr align="left">
				<td colspan="4">
				<input type="submit" name="btSalvar" value="Salvar" class="botao">
				<input type="button" value="Voltar" class="botao" onclick="document.getElementById('btBoleto').value='';this.form.submit();">
				</td>
		    </tr>
			</table>
			</form>
			</fieldset>
			<br />
		<td width="19" background="img/form/lateraldir.jpg"> </td>
	</tr>
	<tr>
		<td align="left" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantoesq.jpg" /></td>
		<td background="img/form/rodape_fundo.jpg"></td>
		<td align="right" background="img/form/rodape_fundo.jpg"><img src="img/form/rodape_cantodir.jpg" /></td>
	</tr>
</table>