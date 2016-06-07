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
	
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$prorrogacao=$_POST["txtDiasProrrogacao"];
	$observacoes=$_POST["txtObservacoes"];
	
	$sql=mysql_query("SELECT cidade, estado, endereco, secretaria, logo FROM configuracoes");
	list($CIDADE,$ESTADO,$ENDERECO,$SECRETARIA,$LOGO)=mysql_fetch_array($sql);
	
	$sql=mysql_query("SELECT cadastro.razaosocial,
                      processosfiscais.data_inicial,
                      processosfiscais.data_final
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($emissor,$dataini,$datafim)=mysql_fetch_array($sql);
	$dataini=implode("/",array_reverse(explode("-",$dataini)));
    $datafim=implode("/",array_reverse(explode("-",$datafim)));

?>
<div id="imprimir">
	<input type="button" value="Imprimir" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" />
</div>
<table width="700" align="center">
	<tr>
		<td>Prefeitura Municipal de <?php echo $CIDADE; ?></td>
		<td><?php echo $SECRETARIA; ?></td>
		<td><img src="../../../img/logos/<?php echo $LOGO; ?>" /></td>
	</tr>
		<tr align="center">
			<td colspan="3"><?php echo $ENDERECO.", ".$CIDADE.", ".$ESTADO; ?></td>
		</tr>
</table>
<br /><br /><br /><br /><br />
<table width="700" align="center">
	<tr> 
		<td align="justify">	
			Viemos através deste comunicar a V.S.ª que, o processo fiscal <?php echo "$nroprocesso/$anoprocesso"; ?>, aberto em <?php echo $dataini; ?> foi prorrogado na data de <?php echo date("d/m/Y"); ?> pelo período de <?php echo $prorrogacao; ?> dias, sob as seguintes observações: 
		</td>
	</tr>
	<tr>
		<td><?php echo $observacoes; ?></td>
	</tr>
	<tr>
		<td align="justify">
			O processo acima citado passa a ter o seu período de apuração até <?php echo $datafim; ?>
		</td>
	</tr>		
</table>