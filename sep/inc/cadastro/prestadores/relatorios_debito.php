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
<title>Relat&oacute;rios - Prestadores</title>
<?php 
include("../conect.php"); 
include("../../funcoes/util.php");
?>
<script src="../../scripts/padrao.js" type="text/javascript"></script>
<div id="DivImprimir"><input type="button" onClick="EscondeDiv('DivImprimir');print();" value="Imprimir" /></div>
<table width="700">
	<tr>
		<td>
			<table width="100%" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px">
				<tr>
					<td align="left"><b>Nomes</b></td>
					<td align="left"><b>Endereço</b></td>
					<td align="center"><b>Municipio</b></td>
					<td align="center"><b>UF</b></td>
					<td align="center"><b>Ultima Nota </b></td>
					<td align="center"><b>AIDF</b></td>
					<td align="center"><b>Estado</b></td>
					<td align="center"><b>Valor</b></td>
				</tr>
				<tr>
					<td colspan="8"><hr size="2px"></td>
				</tr>
				<?php
					//VERIFICA SE O USUARIO DIGITOU ALGUMA DATA CASO TENHA DIGITADO VERIFICA EM QUAL DOS IF'S ESSA DATA SE ENCAIXA
					$txtDataIni = DataMysql($txtDataIni);
					$txtDataFim = DataMysql($txtDataFim);
					
					if(($txtDataIni != "") && ($txtDataFim == ""))
						{
							$querysql = "AND SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni'";
						}
					elseif(($txtDataIni == "") && ($txtDataFim != ""))
						{
							$querysql = "AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'";
						}
					elseif(($txtDataIni != "") && ($txtDataFim != ""))
						{
							$querysql = "AND SUBSTRING(datahoraemissao,1,10) >= '$txtDataIni' AND SUBSTRING(datahoraemissao,1,10) <= '$txtDataFim'";
						}
					elseif(($txtDataIni == "") && ($txtDataFim == ""))
						{
							$querysql = "";
						}
						
					//SQL CONCATENADO COM A VARIAVEL STRING $querysql nome, razaosocial, endereco, municipio, uf, estado, ultimanota, notalimite
						
					$sql = mysql_query("
						SELECT 
						emissores.nome, 
						emissores.endereco, 
						emissores.municipio, 
						emissores.uf, 
						emissores.estado, 
						emissores.ultimanota, 
						emissores.notalimite, 
						notas.valortotal
						FROM emissores 
						INNER JOIN notas ON notas.codemissor = emissores.codigo 
						WHERE notas.estado = 'B' ".$querysql);
					while(list($nome,$endereco,$municipio,$uf,$estado,$ultima,$notalimite,$valor) = mysql_fetch_array($sql))
						{
							switch($notalimite){
								case 0:	 $aidf = "Liberado";   break;
								default: $aidf = $notalimite; break;
							}
							switch($estado){
								case "A": $estado = "Ativo";   break;
								case "I": $estado = "Inativo"; break;
							}
				?>
				<tr>
					<td align="left"><?php echo $nome;?></td>
					<td align="left"><?php echo $endereco;?></td>
					<td align="center"><?php echo $municipio;?></td>
					<td align="center"><?php echo $uf;?></td>
					<td align="center"><?php echo $ultima;?></td>
					<td align="center"><?php echo $aidf;?></td>
					<td align="center"><?php echo $estado;?></td>
					<td align="center"><?php echo "R$ ".DecToMoeda($valor);?></td>
				</tr>
				<tr>
					<td colspan="8"><hr color="#000000" size="1px" /></td>
				</tr>
				<?php
						}
				?>
			</table>
		</td>
	</tr>
</table>