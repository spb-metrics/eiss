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
<title>Termo de Início de Fiscalização</title>
<?php
	include("../../conect.php");
	
	$sql=mysql_query("SELECT endereco, cidade, estado, secretaria, logo FROM configuracoes");
	list($end,$cidade,$estado,$sec,$logo) = mysql_fetch_array($sql);
		
	$dataini=$_POST["txtDataInicio"];
	$nrodias=$_POST["txtNroDias"];
	$datafim=$_POST["txtDataFim"];
	$obs=$_POST["txtObs"];
	$prazo=$_POST["txtPrazo"];
	$codprocesso=$_POST["txtCodigo"];
	$codemissor=$_POST["txtCodEmissor"];
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];

	$ano = date("Y");
	$sqlnumero = mysql_query("SELECT nrotif, anotif FROM processosfiscais_tif WHERE nroprocesso = '$nroprocesso' AND anoprocesso = '$anoprocesso'");
	list($nrotif, $anotif) = mysql_fetch_array($sqlnumero);
	
	$sql=mysql_query("SELECT cadastro.razaosocial
                      FROM processosfiscais
                      INNER JOIN cadastro
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso = '$anoprocesso'");
	list($razaosocial)=mysql_fetch_array($sql);
	
	?>
<div id='imp'>
	<input type="button" name="btnImprimir" value="Imprimir" onclick="document.getElementById('imp').style.display='none';print();document.getElementById('imp').style.display='block';"/>
</div>
<form>
	<table align="center" width="60%">
		<tr align="center">
			<td><img src="../../../img/logos/<?php echo $logo; ?>" /></td>
		</tr>
		<tr align="center">
			<td>Prefeitura Municipal de <?php echo $cidade; ?></td>
		</tr>
		<tr align="center">
			<td><?php echo $sec; ?></td>
		</tr>
		<tr align="center">
			<td colspan="3"><?php echo $end.", ".$cidade.", ".$estado; ?></td>
		</tr>		
	</table>
<br /><br />
<center><h2>TERMO DE INÍCIO</h2></center>
<br /><br />
<?php
	$dataini = implode("/", array_reverse(explode("-", $dataini)));
	$datafim = implode("/", array_reverse(explode("-", $datafim)));
	?>
		<table width="700" align="center">
			<tr> 
				<td align="justify">	
					Viemos através deste comunicar a V.S.ª que, o processo fiscal <?php echo "$nroprocesso/$anoprocesso"; ?>, foi iniciado em <?php echo $dataini; ?> contra a empresa <?php echo "$razaosocial"; ?>. O Processo de Fiscalização tem um prazo de duração de <?php echo "$nrodias"; ?> dias, podendo ser prorrogado, tendo uma conclusão prevista para o dia <?php echo "$datafim"; ?> , sob as seguintes observações: <br><?php echo "$obs"; ?>
				</td>
			</tr>
			<tr>
				<td align="justify">
					<br>A averiguação será procedida em base nos seguintes documentos:
					<?php 
					$sqldocs = mysql_query("
					SELECT processosfiscais_docs.nrodoc, processosfiscais_docs.descricao 
					FROM processosfiscais_docs 
					INNER JOIN processosfiscais_tif_docs ON processosfiscais_tif_docs.coddoc = processosfiscais_docs.codigo 
					INNER JOIN processosfiscais_tif ON processosfiscais_tif.codigo = processosfiscais_tif_docs.codtif 
					WHERE processosfiscais_tif.nrotif = '$nrotif' AND processosfiscais_tif.anotif = '$anotif' ORDER BY processosfiscais_docs.nrodoc");
					while(list($doc_nro,$doc_descricao) = mysql_fetch_array($sqldocs)){
				
				print ("<br>$doc_nro - $doc_descricao");
					}
					?>
				</td>
			</tr>		
		</table>
		</form>