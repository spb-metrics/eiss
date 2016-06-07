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
	$nroted=$_POST["txtNroTed"];
	$anoted=$_POST["txtAnoTed"];

	$sql=mysql_query("SELECT cadastro.razaosocial
                      FROM cadastro
                      INNER JOIN processosfiscais
                      ON cadastro.codigo=processosfiscais.codemissor
                      WHERE processosfiscais.nroprocesso='$nroprocesso'
                      AND processosfiscais.anoprocesso='$anoprocesso'");
	list($emissor)=mysql_fetch_array($sql);
	
	$sql=mysql_query("SELECT codigo, dataemissao, observacoes FROM processosfiscais_ted WHERE nroted='$nroted' AND anoted='$anoted'");
	list($codted,$dataemissao,$observacoes)=mysql_fetch_array($sql);
	$dataemissao=implode("/",array_reverse(explode("-",$dataemissao)));

	$sql_docs=mysql_query("SELECT processosfiscais_docs.nrodoc, processosfiscais_docs.descricao FROM processosfiscais_docs INNER JOIN processosfiscais_ted_docs ON processosfiscais_docs.codigo=processosfiscais_ted_docs.coddoc WHERE processosfiscais_ted_docs.estado='T'");
	
	$sql=mysql_query("SELECT cidade, endereco, secretaria, logo, estado FROM configuracoes");
	list($CIDADE, $ENDERECO, $SECRETARIA, $LOGO, $ESTADO)=mysql_fetch_array($sql);
?>
<div id="imprimir">
	<input type="button" value="Imprimir" onclick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" />
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
			Viemos através deste confirmar a V.Sª que recebemos os documentos solicitados a V.S.ª no Termo de Entrega de Documentos <?php echo "$nroted/$anoted"; ?>, referente ao Processo Fiscal <?php echo "$nroprocesso/$anoprocesso"; ?>, movido contra a empresa <?php echo $emissor; ?>
		</td>
	<tr>	
		<td align="justify">
			Este Termo de Entrega de Documentos é emitido no dia <?php echo $dataemissao; ?>, sob as seguintes observações:
		</td>
	</tr>	
		<td>
			<?php echo $observacoes; ?>
		</td>
	</tr>
</table>
<br /><br />
<table width="700" align="center">
	<tr>
		<td align="justify">
			Os seguintes documentos foram entregues:<br />
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
				mysql_query("UPDATE processosfiscais_ted_docs SET estado='E' WHERE estado='T'");
			?>
			</table>
		</td>
	</tr>
</table>