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
$nroautuacao = $_POST["txtNroAutuacao"];
$anoautuacao = $_POST["txtAnoAutuacao"];
$nroprocesso = $_POST["txtNroProcesso"];
$anoprocesso = $_POST["txtAnoProcesso"];

	if($_POST["btCancelar"] == "Cancelar Autuação")
		{
			$anoautuacao = $_POST["txtAnoAutuacao"];
			$nroautuacao = $_POST["txtNroAutuacao"];
			mysql_query("UPDATE processosfiscais_autuacoes 
                         SET cancelado = 'C'
                         WHERE nroautuacao = '$nroautuacao'
                         AND anoautuacao = '$anoautuacao'");
			Mensagem("Autuação Cancelada");
		}

$sqlcod = mysql_query("SELECT codigo
                        FROM processosfiscais_autuacoes
                        WHERE nroautuacao = '$nroautuacao'
                        AND anoautuacao = '$anoautuacao'");
list($codautuacao) = mysql_fetch_array($sqlcod);

$sqlrelacionamento = mysql_query("SELECT guia_pagamento.relacionamento,
                                  guia_pagamento.codrelacionamento
                                  FROM guia_pagamento
                                  INNER JOIN processosfiscais
                                  ON SUBSTRING(guia_pagamento.datavencimento,1,7) = SUBSTRING(processosfiscais.data_inicial,1,7)
                                  GROUP BY guia_pagamento.codrelacionamento");

$sqlcompetencias = mysql_query("SELECT competencia
                                FROM processosfiscais_competencias
                                WHERE codautuacao = '$nroautuacao'
                                ORDER BY competencia");

$sqlinfdoc = mysql_query("SELECT processosfiscais_autuacoes.nroautuacao, 
                         processosfiscais_autuacoes.anoautuacao,
                         processosfiscais_infracoes.nroinfracao,
                         processosfiscais_infracoes.anoinfracao
                         FROM processosfiscais_autuacoes
                         INNER JOIN processosfiscais_infracoes
                         ON processosfiscais_autuacoes.codinfracao = processosfiscais_infracoes.codigo
                         WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao'
                         AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
                         ORDER BY processosfiscais_autuacoes.anoautuacao,
                         processosfiscais_autuacoes.nroautuacao");

$isspago = 0;
$issdevido = 0;					
while(list($relacionamento, $codrelacionamento) = mysql_fetch_array($sqlrelacionamento))
    {
        if($relacionamento=="des")
            {
                $sqlpago = "SELECT guia_pagamento.pago,	
                            des.total,
                            processosfiscais_competencias.competencia
                            FROM guia_pagamento
                            INNER JOIN des
                            ON guia_pagamento.codrelacionamento = des.codigo
                            INNER JOIN processosfiscais_competencias
                            ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7)
                            WHERE processosfiscais_competencias.codautuacao='$codautuacao'
                            AND guia_pagamento.relacionamento='des'
                            GROUP BY processosfiscais_competencias.competencia";
            }
        elseif($relacionamento=="des_issretido")
            {
                $sqlpago = "SELECT guia_pagamento.pago,
                            des_issretido.valor,
                            processosfiscais_competencias.competencia
                            FROM guia_pagamento
                            INNER JOIN des_issretido
                            ON guia_pagamento.codrelacionamento = des_issretido.codigo
                            INNER JOIN processosfiscais_competencias
                            ON processosfiscais_competencias.competencia = SUBSTRING(des_issretido.competencia,1,7)
                            WHERE processosfiscais_competencias.codautuacao = '$codautuacao'
                            AND guia_pagamento.relacionamento = 'des_issretido'
                            GROUP BY processosfiscais_competencias.competencia";
            }
        elseif($relacionamento=="nfe")
            {
                $sqlpago = "SELECT guia_pagamento.pago,
                            notas.valortotal,
                            processosfiscais_competencias.competencia
                            FROM guia_pagamento
                            INNER JOIN notas
                            ON guia_pagamento.codrelacionamento = notas.codigo
                            INNER JOIN processosfiscais_competencias
                            ON processosfiscais_competencias.competencia = SUBSTRING(notas.datahoraemissao,1,7)
                            WHERE processosfiscais_competencias.codautuacao = '$codautuacao'
                            AND guia_pagamento.relacionamento = 'nfe'
                            GROUP BY processosfiscais_competencias.competencia";
            }
    }
							
$sql = mysql_query($sqlpago);
						
$sqlconfig = mysql_query("SELECT configuracoes.taxacorrecao,
                          configuracoes.taxamulta,
                          configuracoes.taxajuros
                          FROM configuracoes");

$sql_nome=mysql_query("SELECT processosfiscais.nroprocesso,
                       processosfiscais.anoprocesso,
                       cadastro.razaosocial, cadastro.cnpjcpf,
                       cadastro.inscrmunicipal
					   FROM processosfiscais
					   INNER JOIN cadastro
                       ON processosfiscais.codemissor=cadastro.codigo
					   WHERE processosfiscais.nroprocesso = '$nroprocesso'
					   AND processosfiscais.anoprocesso = '$anoprocesso'");

?>
	<form method="post">
	<?php 
		list($taxacorrecao,$taxamulta,$taxajuros) = mysql_fetch_array($sqlconfig);
		list($nroprocesso, $anoprocesso, $razaosocial, $cnpjcpf, $inscrmunicipal) = mysql_fetch_array($sql_nome);
		list($nroautuacao, $anoautuacao, $nroinfracao, $anoinfracao) = mysql_fetch_array($sqlinfdoc);

	?>
	<table width="100%">
		<tr>
			<td width="120">Processo Fiscal:</td>
			<td><?php echo "$nroprocesso/$anoprocesso - $razaosocial"; ?></td>
		</tr>
		<tr>
			<td>CNPJ:</td>
			<td><?php echo "$cnpjcpf"; ?></td>
		</tr>
		<tr>	
			<td>Inscrição Municipal:</td>
			<td><?php echo "$inscrmunicipal"; ?></td>
		</tr>
		<tr>
			<td>Documento:</td>
			<td><?php echo "$nroautuacao/$anoautuacao"; ?></td>
		</tr>
		<tr>
			<td>Infração:</td>
			<td><?php echo "$nroinfracao/$anoinfracao"; ?></td>
		</tr>
	</table>
		<table width="100%">
			<tr bgcolor="#999999">
				<td align="center">Compet</td>
				<td align="center">ISS Devido </td>
				<td align="center">ISS Pago </td>
				<td align="center">Tributo</td>
				<td align="center">Corre&ccedil;&atilde;o</td>
				<td align="center">Juros</td>
				<td align="center">Multa</td>
				<td align="center">Imp. Total </td>
			</tr>
<?php
			while(list($pago, $total, $competencia) = mysql_fetch_array($sql))
				{	
		
					$data = DataPt($competencia);
					switch($pago)
					{
						case "S": $isspago+=$total; break;
						case "N": $issdevido+=$total; break;
					}
					$tributo = $issdevido - $isspago;
					if ($tributo < 0){$tributo = 0;}
					
					$imposto = $tributo + $taxajuros + $taxacorrecao + $taxamulta;
					$totalimp += $imposto;			
			print ("
				<tr bgcolor='#FFFFFF'>
					<td align=\"center\">$data</td>
					<td align=\"center\">$issdevido</td>
					<td align=\"center\">$isspago</td>
					<td align=\"center\">$tributo</td>
					<td align=\"center\">$taxacorrecao</td>
					<td align=\"center\">$taxajuros</td>
					<td align=\"center\">$taxamulta</td>
					<td align=\"center\">$imposto</td> 
				</tr>
				");
		} // FIM DO WHILE SQL?>
		
		</table>
		<table width="100%">
		<tr>
			<td align="right">Imposto Total: <?php echo "$totalimp"; ?></td>
		</tr>
	

			
	<input type="hidden" name="txtNroProcesso"  value="<?php echo "$nroprocesso"; ?>" />
	<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
	<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
	<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />
	<input name="btnConfirmar" value="Confirmar" type="button" class="botao">
	<tr><input name="btnVoltar" value="Voltar" type="button" class="botao" onclick="window.location='processofiscal.php'"/>
</form>	
<form method="post" target="_blank" action="inc/fiscalizacao/processos/docs_planilha_imprimir.php">		
	<input name="btnImprimir" value="Imprimir" type="submit" class="botao"></tr>
	<input type="hidden" name="txtNroProcesso"  value="<?php echo "$nroprocesso"; ?>" />
	<input type="hidden" name="txtAnoProcesso" value="<?php echo "$anoprocesso"; ?>" />
	<input type="hidden" name="txtNroAutuacao" value="<?php echo "$nroautuacao"; ?>" />
	<input type="hidden" name="txtAnoAutuacao" value="<?php echo "$anoautuacao"; ?>" />			
	<input type="hidden" name="txtData"  value="<?php echo "$data"; ?>" />
	<input type="hidden" name="txtIssDevido"  value="<?php echo "$issdevido"; ?>" />
	<input type="hidden" name="txtIssPago"  value="<?php echo "$isspago"; ?>" />
	<input type="hidden" name="txtTributo"  value="<?php echo "$tributo"; ?>" />
	<input type="hidden" name="txtTaxaCorrecao"  value="<?php echo "$taxacorrecao"; ?>" />
	<input type="hidden" name="txtTaxaJuros"  value="<?php echo "$taxajuros"; ?>" />
	<input type="hidden" name="txtTaxaMulta"  value="<?php echo "$taxamulta"; ?>" />
	<input type="hidden" name="txtImposto"  value="<?php echo "$imposto"; ?>" />
</form>
</table>