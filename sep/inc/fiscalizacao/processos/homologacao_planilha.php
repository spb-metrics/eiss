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
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$tipo=$_POST["txtTipo"];
	?>
	<fieldset>
	<form method="post" id="frmTipo">
		<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
		<input type="hidden" name="txtAcao" id="txtAcao" value="planilhahomolagacao" />
		<table align="center">
			<tr>
				<td><input type="submit" class="botao" value="Serviços Prestados" onClick="txtTipo.value='prestados'" /></td>
				<td><input type="submit" class="botao" value="Serviços Tomados" onClick="txtTipo.value='tomados'" /></td>
				<td><input type="submit" class="botao" value="Todos Serviços" onClick="txtTipo.value='todos'" /></td>
			</tr>
		</table>
		<input type="hidden" name="txtTipo" />
		<input type="hidden" name="txtNroProcesso" value="<?php echo $nroprocesso; ?>" />
		<input type="hidden" name="txtAnoProcesso" value="<?php echo $anoprocesso; ?>" />
	</form>
	<?php
	if($tipo=="prestados")
		{
			$string="AND tipo='P'";
		}
	elseif($tipo=="tomados")
		{
			$string="AND tipo='T'";
		}
	include("homologacao_planilha_detalhes.php");		
?>
	</fieldset>
<table width="100%">
	<tr>
		<td align="left">
			<form method="post" id="form">
				<input type="submit" name="btnVoltar" value="Voltar" class="botao" />
				<input type="hidden" name="include" id="include" value="<?php echo  $_POST['include'];?>" />
				<input type="hidden" name="txtAcao" id="txtAcao2" value="detalhes" />
				<input type="hidden" name="txtNroProcesso0" value="<?php echo "$nroprocesso";//precisa de txtNroProcesso0 se voltar para detalhes. ?>" />
				<input type="hidden" name="txtAnoProcesso0" value="<?php echo "$anoprocesso";//precisa de txtAnoProcesso0 se voltar para detalhes. ?>" />				
				<input type="hidden" name="contador" value="1" /> <!--precisa do contador se voltar para detalhes -->
			</form>
		</td>
	</tr>
</table>