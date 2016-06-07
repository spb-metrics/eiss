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
<div id='imp'>
	<input type="button" name="btnImprimir" value="Imprimir" onclick="document.getElementById('imp').style.display='none';print();document.getElementById('imp').style.display='block';"/>
</div>
<?php
	include("../../conect.php");
	//recebe o codigo apreencao da pagina apreencao de documentos
	$nroprocesso=$_POST["txtNroProcesso"];
	$anoprocesso=$_POST["txtAnoProcesso"];
	$nroapreensao=$_POST["txtNroApreensao"];
	$anoapreensao=$_POST["txtAnoApreensao"];
	$emissao=implode("/",array_reverse(explode("-",$_POST["txtEmissao"])));
	$observacoes=$_POST["txtObservacoes"];

	$sql=mysql_query("SELECT codigo
                      FROM processosfiscais_apreensoes
                      WHERE nroapreensao='$nroapreensao'
                      AND anoapreensao='$anoapreensao'");
	list($codapreensao)=mysql_fetch_array($sql);
	
	$d=date("d");
	$m=date("m");
	$y=date("Y");
	
	if($m=="01"){$m="Janeiro";}
	elseif($m=="02"){$m="Fevereiro";}
	elseif($m=="03"){$m="Março";}
	elseif($m=="04"){$m="Abril";}
	elseif($m=="05"){$m="Maio";}
	elseif($m=="06"){$m="Junho";}
	elseif($m=="07"){$m="Julho";}
	elseif($m=="08"){$m="Agosto";}
	elseif($m=="09"){$m="Setembro";}
	elseif($m=="10"){$m="Outubro";}
	elseif($m=="11"){$m="Novembro";}
	elseif($m=="12"){$m="Dezembro";}
	
	$sql=mysql_query("SELECT cidade,
                      endereco,
                      estado,
                      secretaria,
                      logo
                      FROM configuracoes");
	list($CIDADE,$ENDERECO,$ESTADO,$SECRETARIA,$LOGO)=mysql_fetch_array($sql);
	
	$sql_emissor=mysql_query("SELECT cadastro.nome
                              FROM cadastro
                              INNER JOIN processosfiscais
                              ON cadastro.codigo=processosfiscais.codemissor
                              WHERE processosfiscais.nroprocesso='$nroprocesso'
                              AND processosfiscais.anoprocesso='$anoprocesso'");
	list($emissor)=mysql_fetch_array($sql_emissor);
	
	$sql_docs=mysql_query("SELECT processosfiscais_docs.nrodoc, 
                           processosfiscais_docs.descricao
                           FROM processosfiscais_docs
                           INNER JOIN processosfiscais_apreensoes_docs
                           ON processosfiscais_docs.codigo=processosfiscais_apreensoes_docs.coddoc
                           WHERE processosfiscais_apreensoes_docs.codapreensao='$codapreensao'
                           ORDER BY processosfiscais_docs.nrodoc");
	
?>
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
<br /><br /><br />
<table align="center" width="700">
	<tr align="justify">
		<td>
			Aos <?php echo $d; ?> do mês de <?php echo $m; ?> do ano de <?php echo $y; ?>, na cidade de <?php echo $CIDADE; ?>, no estado de <?php echo $ESTADO; ?>, às <?php echo date("H:i"); ?> horas, em cumprimento ao mandato de apreensão de documentos expedido pela <?php echo $SECRETARIA; ?> da Prefeitura Municipal de <?php echo $CIDADE; ?> efetuamos, com as devidas formalidades legais, os procedimentos de praxe para a apreensão nas instalações da empresa <?php echo $emissor ?> e/ou na(s) residência(s) de seu(s) sócio(s)/responsável(eis).
		</td>
	</tr>
	<tr align="justify">
		<td>
			No curso da busca, nós, executores, adotamos providências para resguardar os bens, valores e numerários existentes no local, preservar a dignidade e evitar constrangimentos desnecessários aos seus ocupantes. Resultante desta diligência de apreensão, foram apreendidos os seguintes documentos: 
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<?php
					while(list($nrodoc,$doc)=mysql_fetch_array($sql_docs))
						{
							echo "
								<tr>
									<td>$nrodoc</td>
									<td>$doc</td>
								</tr>
							";
						}
				?>
			</table>
		</td>
	</tr>
	<tr align="justify">
		<td>
			OBSERVAÇÕES: <?php echo $observacoes; ?>
		</td>
	</tr>
</table>