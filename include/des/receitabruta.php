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
	require_once("../include/conect.php");
	require_once("../funcoes/util.php");
	
	$cnpj=$_POST['txtCNPJ'];
	
	$sql_existe_cnpj = mysql_query("SELECT cnpj , razaosocial FROM emissores_temp WHERE cnpj='$cnpj';");
	if(mysql_num_rows($sql_existe_cnpj)>0)
	{
		list($Cnpj,$RazaoSocial)=mysql_fetch_array($sql_existe_cnpj);
	}
	
?>
<script src="../scripts/padrao.js" language="javascript" type="text/javascript"></script>
<script src="../scripts/java_site.js" language="javascript" type="text/javascript"></script>

Guia de Recolhimento
<br>
<form name="frmGuiaArrecadacao" method="post" action="../include/des/receitabruta_sql.php" >
	<table>
		<tr>
			<td>
				<table>
					<tr>
						<td>CNPJ:</td>
					  <td><input type="text" title="CNPJ" name="txtCNPJ" id="txtCNPJ" maxlength="18" class="texto" 
							onkeydown="return NumbersOnly( event );" onkeyup="CNPJCPFMsk( this );" <?php if($Cnpj){echo "value=\"$Cnpj\"";}else{echo "value=\"$cnpj\"";}?>>
						</td>
					</tr>
					<tr>
						<td>Razão Social</td>
						<td><input type="text" title="Razão Social" name="txtRazao" id="txtRazao" class="texto"  <?php if($RazaoSocial){echo "value=\"$RazaoSocial\"";}?>></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				Período:
				<select name="cmbMes" id="cmbMes">
					<option value=""> </option>
					<option value="1">Janeiro</option>
					<option value="2">Fevereiro</option>
					<option value="3">Março</option>
					<option value="4">Abril</option>
					<option value="5">Maio</option>
					<option value="6">Junho</option>
					<option value="7">Julho</option>
					<option value="8">Agosto</option>
					<option value="9">Setembro</option>
					<option value="10">Outubro</option>
					<option value="11">Novembro</option>
					<option value="12">Dezembro</option>
				</select>
				<select name="cmbAno" id="cmbAno">
					<option value=""> </option>
					<option value="2009">2009</option>
					<option value="2008">2008</option>
					<option value="2007">2007</option>
					<option value="2006">2006</option>
					<option value="2005">2005</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td align="center"><strong>Base de Cálculo</strong></td>
						<td align="center"><strong>Alíquota</strong></td>
					</tr>
					<tr>
						<td align="center" width="160">
							R$ <input name="txtBase" id="txtBase1" size="12" maxlength="12" type="text" style="text-align:right;" class="texto" 
								onkeyup="MaskMoeda(this)" value="0,00" onkeydown="return NumbersOnly(event);">
						</td>
						<td align="center">
							<select name="cmbAliq" id="cmbAliq1">
								<option value="0.5">0,5</option>
								<option value="1">1,0</option>
								<option value="2">2,0</option>
								<option value="3">3,0</option>
								<option value="4">4,0</option>
								<option value="5" selected="selected">5,0</option>
								<option value="5.5">5,5</option>
							</select>%				
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="hidden" name="hdDataAtual" id="hdDataAtual" value="<?php echo date("d/m/Y");?>" />
				<input type="submit" value="Gerar" />
			</td>
		</tr>
	</table>
</form>