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
	include("../../conect.php");
	$sql=mysql_query("SELECT endereco, cidade, estado, secretaria, logo FROM configuracoes");
	list($ENDERECO,$CIDADE,$ESTADO,$SECRETARIA,$LOGO)=mysql_fetch_array($sql);
	
	$nroautuacao=$_POST["txtNroAutuacao"];
	$anoautuacao=$_POST["txtAnoAutuacao"];
	$processo=$_POST["txtProcesso"];
	$razaosocial=$_POST["txtRazaoSocial"];
	$doc=$_POST["txtDoc"];
	$infracao=$_POST["txtInfracao"];
	$historico=$_POST["txtHistorico"];
	$descricao=$_POST["txtDescricao"];
	$fundamentacao=$_POST["txtFundamentacao"];
	$reincidencia=$_POST["txtReincidencia"];
	$competencias=substr(str_replace("|",", ",$_POST["txtCompetencias"]),0,-2);
	$tipo=explode(" ",$doc);
	
	$sql=mysql_query("SELECT codigo FROM processosfiscais_autuacoes WHERE anoautuacao='$anoautuacao' AND nroautuacao='$nroautuacao'");
	list($codautuacao)=mysql_fetch_array($sql);
 ?>
<div id="imprimir">
	<input type="button" class="botao" name="btImprimir" value="Imprimir" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" />
</div>
<table align="center" width="700">
 <tr align="justify">
  <td>Prefeitura Municipal de <?php echo $CIDADE; ?></td>
  <td><?php echo $SECRETARIA; ?></td>
  <td><img src="../../../img/logos/<?php echo $LOGO; ?>" /></td>
 </tr>
 <tr align="center">
  <td colspan="3"><?php echo $ENDERECO.", ".$CIDADE.", ".$ESTADO; ?></td>
 </tr>
</table>
<br><br><br><br>
<table align="center" width="700">
 <tr align="justify">
  <td width="200">Processo Fiscal:</td><td width="500"><?php echo $processo;?></td>
 </tr>
 <tr align="justify">
  <td>Empresa:</td><td><?php echo $razaosocial;?></td>
 </tr>
 <tr align="justify">
  <td></td><td></td>
 </tr>
 <tr align="justify">
  <td>Documento:</td><td><?php echo $doc;?></td>
 </tr>
 <tr align="justify">
  <td>Infração:</td><td><?php echo $infracao;?></td>
 </tr>
 <tr>
  <td>Histórico:</td><td><?php echo $historico;?></td>
 </tr>
 <tr align="justify">
  <td>Descricao:</td><td><?php echo $descricao;?></td>
 </tr>
 <tr align="justify">
  <td valign="top">Fundamentação legal:</td><td><?php echo $fundamentacao;?></td>
 </tr>
<?php
if($tipo[0]=="Notificação"){
	echo "<tr align=\"justify\"><td>Competências:</td><td>$competencias</td></tr>";
}
else{
	if($reincidencia=="S"){$reincidencia="Sim";}
	else{$reincidencia="Não";}
	echo "<tr align=\"justify\"><td>Reincidente:</td><td>$reincidencia</td></tr>";
}
	
	$sqliss=mysql_query("SELECT processosfiscais_guias.valor FROM processosfiscais_autuacoes INNER JOIN processosfiscais_guias ON processosfiscais_autuacoes.codigo = processosfiscais_guias.codautuacao WHERE processosfiscais_guias.codautuacao='$codautuacao'");
	$sqlpagos=mysql_query("SELECT processosfiscais_guias.valor FROM processosfiscais_autuacoes INNER JOIN processosfiscais_guias ON processosfiscais_autuacoes.codigo = processosfiscais_guias.codautuacao WHERE processosfiscais_guias.codautuacao='$codautuacao' AND processosfiscais_guias.situacao='P'");
	$totalvalor=0;
	$parcelaspagas=0;
	while(list($valor)=mysql_fetch_array($sqlpagos)){
		$parcelaspagas	 = $parcelaspagas + $valor;
	}	
	while(list($valor)=mysql_fetch_array($sqliss)){
		$totalvalor	 = $valor + $totalvalor;
	}
	$totalvalor=$totalvalor-$parcelaspagas;
	echo "
			<tr align=\"justify\">
				<td>Total Devido:</td>
				<td>R$ $totalvalor</td>
			</tr>
	";
?>
</table>
