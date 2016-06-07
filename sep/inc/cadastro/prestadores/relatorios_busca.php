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
include("../conect.php"); 
include("../../funcoes/util.php");

//recebimento de variaveis por get
$txtDataIni = $_GET["txtDataIni"];
$txtDataFim = $_GET["txtDataFim"];
?>
<script src="../../scripts/padrao.js" type="text/javascript"></script>
<link href="../../css/padrao.css" rel="stylesheet" type="text/css">
<form method="post" id="frmPrestImp">
<?php
	//testa o valor do campo hidden se for debito mostra pesquisa com prestadores em debito se nao mostra todos os prestadores
	if($_GET["hdPrestadores"] == "Debito"){
	?>
		<table width="700">
			<tr>
				<td>
					<table width="100%">
						<tr bgcolor="#999999">
							<td align="center">Nomes</td>
							<td align="center">Endereço</td>
							<td align="center">Municipio</td>
							<td align="center">UF</td>
							<td align="center">Ultima Nota</td>
							<td align="center">AIDF</td>
							<td align="center">Estado</td>
							<td align="center">Valor</td>
						</tr>
					</table>
				<div style="overflow:auto; height:250px;">
					<table width="100%">
						<?php
							//VERIFICA SE O USUARIO DIGITOU ALGUMA DATA CASO TENHA DIGITADO VERIFICA EM QUAL DAS CONDICOES O VALOR SE ENCAIXA
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
									}//fim switch
									switch($estado){
										case "A": $estado = "Ativo";   break;
										case "I": $estado = "Inativo"; break;
									}//fim switch
						?>
						<tr bgcolor="#FFFFFF">
							<td width="12%" align="left"><?php echo $nome;?></td>
							<td width="16%" align="left"><?php echo $endereco;?></td>
							<td width="16%" align="center"><?php echo $municipio;?></td>
							<td width="6%" align="center"><?php echo $uf;?></td>
							<td width="20%" align="center"><?php echo $ultima;?></td>
							<td width="8%" align="center"><?php echo $aidf;?></td>
							<td width="12%" align="center"><?php echo $estado;?></td>
							<td width="10%" align="center"><?php echo "R$ ".DecToMoeda($valor);?></td>
						</tr>
						<?php
								}//fim while
						?>
					</table>
					</div>
				</td>
			</tr>
			<tr>
				<td><input name="btImprimir" value="Imprimir" type="submit" onclick="cancelaAction('frmPrestImp','inc/prestadores/relatorios_debito.php','_blank')" class="botao"></td>
			</tr>
		</table>
	<?php
	}elseif($_GET["hdPrestadores"] == "Todos"){
	?>	
		<table width="700">
			<tr>
				<td>
					<table width="100%">
						<tr bgcolor="#999999">
							<td width="17%" align="center">Nomes</td>
							<td width="22%" align="center">Endere&ccedil;o</td>
							<td width="14%" align="center">Município</td>
							<td width="6%" align="center">Uf</td>
							<td width="13%" align="center">Ultima Nota</td>
							<td width="13%" align="center">AIDF</td>
							<td width="15%" align="center">Estado</td>
						</tr>
					</table>
				<div style="overflow:auto; height:250px">
					<table width="100%">
						<?php
							$sql = mysql_query("SELECT nome, razaosocial, endereco, municipio, uf, estado, ultimanota, notalimite FROM emissores");
							while(list($nome,$rs,$endereco,$municipio,$uf,$estado,$ultima,$limite) = mysql_fetch_array($sql))
								{
									switch($limite){
										case 0:  $aidf = "Liberado"; break;
										default: $aidf = $limite;    break;
									}//fim switch
									switch($estado){
										case "A": $estado = "Ativo";   break;
										case "I": $estado = "Inativo"; break;
									}//fim switch
						?>
						<tr bgcolor="#FFFFFF" height="25">
							<td width="18%" align="left"><?php echo $nome;?></td>
							<td width="20%" align="left"><?php echo $endereco;?></td>
							<td width="14%" align="center"><?php echo $municipio;?></td>
							<td width="7%" align="center"><?php echo $uf;?></td>
							<td width="14%" align="center"><?php echo $ultima;?></td>
							<td width="14%" align="center"><?php echo $aidf;?></td>
							<td width="13%" align="center"><?php echo $estado;?></td>			
						</tr>
						<?php
								}//fim while
						?>
					</table>
				</div>
				</td>
			</tr>
			<tr>
				<td><input name="btImprimir" value="Imprimir" type="submit" onclick="cancelaAction('frmPrestImp','inc/prestadores/relatorios_lista.php','_blank')" class="botao"></td>
			</tr>
		</table>
	<?php
	}//fim elseif
?>
</form>