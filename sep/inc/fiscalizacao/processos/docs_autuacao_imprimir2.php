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
	<br /><br /><br /><br /><br />
<?php
	echo "	
		<table align=\"center\" width=\"700\">
			<tr align=\"justify\">
				<td width=\"200\">Processo Fiscal:</td>
				<td width=\"500\"> $processo</td>
			</tr>
			<tr align=\"justify\">
				<td>Empresa:</td>
				<td>$razaosocial</td>
			</tr>
			<tr align=\"justify\">
				<td></td>
				<td></td>
			</tr>
			<tr align=\"justify\">
				<td>Documento:</td>
				<td>$doc</td>
			</tr>
			<tr align=\"justify\">
				<td>Infração:</td>
				<td>$infracao</td>
			</tr>
			<tr>
				<td>Histórico:</td>
				<td>$historico</td>
			</tr>
			<tr align=\"justify\">
				<td>Descricao:</td>
				<td>$descricao</td>
			</tr>
			<tr align=\"justify\">
				<td valign=\"top\">Fundamentação legal:</td>
				<td>$fundamentacao</td>
			</tr>
	";
	if($tipo[0]=="Notificação")
		{
			echo "
				<tr align=\"justify\">
					<td>Competências:</td>
					<td>$competencias</td>
				</tr>
			";
		}
	else
		{
			if($reincidencia=="S"){$reincidencia="Sim";}
			else{$reincidencia="Não";}
			echo "
				<tr align=\"justify\">
					<td>Reincidente:</td>
					<td>$reincidencia</td>
				</tr>
			";
		}
	
	$today=date("Y-m-d");
	$divida=0;
	
	$sqldes=mysql_query("SELECT guia_pagamento.pago,
                         guia_pagamento.datavencimento,
                         des.total
                         FROM guia_pagamento
                         INNER JOIN guias_declaracoes
                         ON guia_pagamento.codigo=guias_declaracoes.codguia
                         INNER JOIN des
                         ON guias_declaracoes.codrelacionamento = des.codigo
                         INNER JOIN processosfiscais_competencias
                         ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7)
                         WHERE processosfiscais_competencias.codautuacao='$codautuacao'
                         AND guias_declaracoes.relacionamento='des'");
	while(list($pago,$vencimento,$valor)=mysql_fetch_array($sqldes))
		{
			if(($pago=="N")&&($vencimento<$today)){$divida+=$valor;}
		}	
	
	$sqldes_issretido=mysql_query("SELECT guia_pagamento.pago,
                                   guia_pagamento.datavencimento,
                                   des_issretido.valor
                                   FROM guia_pagamento
                                   INNER JOIN guias_declaracoes
                                   ON guia_pagamento.codigo=guias_declaracoes.codguia
                                   INNER JOIN des_issretido
                                   ON guias_declaracoes.codrelacionamento = des_issretido.codigo
                                   INNER JOIN processosfiscais_competencias
                                   ON processosfiscais_competencias.competencia = SUBSTRING(des_issretido.competencia,1,7)
                                   WHERE processosfiscais_competencias.codautuacao = '$codautuacao'
                                   AND guias_declaracoes.relacionamento = 'des_issretido'");
	while(list($pago,$vencimento,$valor)=mysql_fetch_array($sqldes))
		{
			if(($pago=="N")&&($vencimento<$today)){$divida+=$valor;}
		}	
	
	$sqlnfe=mysql_query("SELECT guia_pagamento.pago,
                         guia_pagamento.datavencimento,
                         notas.valortotal
                         FROM guia_pagamento
                         INNER JOIN guias_declaracoes
                         ON guia_pagamento.codigo=guias_declaracoes.codguia
                         INNER JOIN notas
                         ON guias_declaracoes.codrelacionamento = notas.codigo
                         INNER JOIN processosfiscais_competencias
                         ON processosfiscais_competencias.competencia = SUBSTRING(notas.datahoraemissao,1,7)
                         WHERE guias_declaracoes.relacionamento = 'nfe'
                         AND processosfiscais_competencias.codautuacao='$codautuacao'");
	while(list($pago,$vencimento,$valor)=mysql_fetch_array($sqldes))
		{
			if(($pago=="N")&&($vencimento<$today)){$divida+=$valor;}
		}

	$divida=number_format($divida, 2, '.', '');
	echo "
			<tr align=\"justify\">
				<td>ISS Devido:</td>
				<td>R$ $divida</td>
			</tr>
		</table>	
	";	
?>