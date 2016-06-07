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
<div id="imprimir">
	<input type="button" value="Imprimir" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" />
</div>
<?php
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$tipoh=$_POST["txtTipo"];
	
	include("../../conect.php");
	include("../../../funcoes/util.php");
	
	if($tipoh=="prestados")
		{
			$string="AND tipo='P'";
		}
	elseif($tipoh=="tomados")
		{
			$string="AND tipo='T'";
		}
		
	if($tipoh)
		{
			$sql=mysql_query("SELECT homologado, nrodoc, competencia, cpfcnpjtomador, cpfcnpjprestador, valortotal, iss, issretido, deducao, tipo FROM processosfiscais_homologacao WHERE nroprocesso='$nroprocesso' AND anoprocesso='$anoprocesso' $string ORDER BY competencia");
			if(mysql_num_rows($sql)>0){
			?>	
			<fieldset><legend>Documentos de Homologação</legend>
				<table width="100%">
					<tr bgcolor="#999999">
						<td align="center" width="10%">Nro. Doc</td>
						<td align="center" width="26%">CPF/CNPJ Tomador</td>
						<td align="center" width="12%">Valor R$</td>
						<td align="center" width="9%">ISS R$</td>
						<td align="center" width="14%">ISS Retido R$</td>
						<td align="center" width="10%">Deduções R$</td>
						<td align="center" width="5%">Data</td>
						<td align="center" width="14%">Homologado</td>
						<?php if($tipoh=="todos"){echo "<td align=\"center\" width=\"5%\">Tipo</td>";} ?>
					</tr>
					<?php
						while(list($homologado,$nrodoc,$competencia,$cpfcnpjtomador,$cpfcnpjprestador,$vtotal,$iss,$issretido,$deducao,$tipo)=mysql_fetch_array($sql))
							{
								if($tipo=="P"){$tipo="Prestado";}
								else{$tipo="Tomado";}
								if($homologado=="S"){$homologado="Sim";}
								else{$homologado="Não";}
								$competencia=DataPt($competencia);
								$vtotal  = DecToMoeda($vtotal);
								$iss     = DecToMoeda($iss);
								$deducao = DecToMoeda($deducao);
								echo "
									<tr bgcolor=\"#FFFFFF\">
										<td>$nrodoc</td>
										<td>
											$cpfcnpjtomador
											$cpfcnpjprestador
										</td>
										<td align=\"center\">$vtotal</td>
										<td align=\"center\">$iss</td>
										<td align=\"center\">$issretido</td>
										<td align=\"center\">$deducao</td>
										<td align=\"center\">$competencia</td>
										<td align=\"center\">$homologado</td>
								";
								if($tipoh=="todos")
									{		
										echo "		
												<td>$tipo</td>
											</tr>
										";
									}//fim if
							}//fim while
					?>
				</table>
			</fieldset>
		<?php
	}}
?>			