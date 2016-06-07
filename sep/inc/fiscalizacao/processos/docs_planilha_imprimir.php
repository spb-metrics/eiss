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
include ("../../conect.php");
include ("../../../funcoes/util.php");

$nroautuacao = $_POST["txtNroAutuacao"];
$anoautuacao = $_POST["txtAnoAutuacao"];
$nroprocesso = $_POST["txtNroProcesso"];
$anoprocesso = $_POST["txtAnoProcesso"];

$sqlcod = mysql_query("SELECT codigo FROM processosfiscais_autuacoes WHERE nroautuacao = '$nroautuacao' AND anoautuacao = '$anoautuacao'");
list($codautuacao) = mysql_fetch_array($sqlcod);

$sqlrelacionamento = mysql_query("SELECT guias_declaracoes.relacionamento, guias_declaracoes.codrelacionamento FROM guias_declaracoes INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia INNER JOIN processosfiscais ON SUBSTRING(guia_pagamento.datavencimento,1,7) = SUBSTRING(processosfiscais.data_inicial,1,7) GROUP BY guias_declaracoes.codrelacionamento") or die ('Nenhuma Autuação');

$sqlinfdoc = mysql_query("SELECT processosfiscais_autuacoes.nroautuacao, processosfiscais_autuacoes.anoautuacao, processosfiscais_infracoes.nroinfracao, processosfiscais_infracoes.anoinfracao FROM processosfiscais_autuacoes INNER JOIN processosfiscais_infracoes ON processosfiscais_autuacoes.codinfracao = processosfiscais_infracoes.codigo WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao' AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' ORDER BY processosfiscais_autuacoes.anoautuacao, processosfiscais_autuacoes.nroautuacao");
						
$sqlconfig = mysql_query("SELECT configuracoes.taxacorrecao, configuracoes.taxamulta, configuracoes.taxajuros FROM configuracoes");

$sql_nome=mysql_query("SELECT processosfiscais.nroprocesso, processosfiscais.anoprocesso, cadastro.razaosocial, cadastro.cnpj, cadastro.cpf, cadastro.inscrmunicipal, cadastro.codigo FROM processosfiscais INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo INNER JOIN processosfiscais_autuacoes ON processosfiscais.nroprocesso=processosfiscais_autuacoes.nroprocesso WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao' AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' GROUP BY processosfiscais.nroprocesso");

		list($taxacorrecao,$taxamulta,$taxajuros) = mysql_fetch_array($sqlconfig);
		list($nroprocesso, $anoprocesso, $razaosocial, $cnpj, $cpf, $inscrmunicipal, $cadastrocod) = mysql_fetch_array($sql_nome);
		list($nroautuacao, $anoautuacao, $nroinfracao, $anoinfracao) = mysql_fetch_array($sqlinfdoc);

$isspago = 0;
$issdevido = 0;	
if(mysql_num_rows($sqlrelacionamento)>0){
while(list($relacionamento, $codrelacionamento) = mysql_fetch_array($sqlrelacionamento)){

	if($relacionamento == 'des'){
		$sql_select = "	SELECT guia_pagamento.pago, des.total, processosfiscais_competencias.competencia, des.iss
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN des ON cadastro.codigo=des.codcadastro 
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=des.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='des' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY guia_pagamento.codigo";
	}
	elseif($relacionamento == 'cartorios_des'){
		$sql_select = "	SELECT guia_pagamento.pago, cartorios_des.total, processosfiscais_competencias.competencia, (SELECT SUM(cartorios_des.iss_emo) FROM cartorios_des WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN cartorios_des ON cadastro.codigo=cartorios_des.codcartorio
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=cartorios_des.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='cartorios_des' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY processosfiscais_competencias.competencia";
	}
	elseif($relacionamento =='des_temp'){
		$sql_select = "	SELECT guia_pagamento.pago, des_temp.base, processosfiscais_competencias.competencia, (SELECT SUM(des_temp.aliq) FROM des_temp WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN des_temp ON cadastro.codigo=des_temp.codemissores_temp
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=des_temp.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='des_temp' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY processosfiscais_competencias.competencia";
	}
	elseif($relacionamento =='dop_des'){
		$sql_select = "	SELECT guia_pagamento.pago, dop_des.total, processosfiscais_competencias.competencia, (SELECT SUM(dop_des.iss) FROM dop_des WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN dop_des ON cadastro.codigo=dop_des.codorgaopublico 
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=dop_des.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='dop_des' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY processosfiscais_competencias.competencia";
	}
	elseif($relacionamento =='dif_des'){
		$sql_select = "AND guias_declaracoes.relacionamento='dif_des' AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' GROUP BY processosfiscais_autuacoes.codigo";
		$codigo = "codinst_financeira";
		$total="total";
	}
	elseif($relacionamento =='decc_des'){
		$sql_select = "	SELECT guia_pagamento.pago, decc_des.total, processosfiscais_competencias.competencia, (SELECT SUM(decc_des.iss) FROM decc_des WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN decc_des ON cadastro.codigo=decc_des.codempreiteira
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=decc_des.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='decc_des' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' 
						GROUP BY processosfiscais_competencias.competencia";
	}
	elseif($relacionamento =='doc_des'){
		$sql_select = "AND guias_declaracoes.relacionamento='doc_des' AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' GROUP BY processosfiscais_autuacoes.codigo";
		$codigo = "codopr_credito";
		$total="total";
	}
	elseif($relacionamento =='nfe'){
		$sql_select = "	SELECT guia_pagamento.pago, notas.valortotal, processosfiscais_competencias.competencia, (SELECT SUM(notas.valoriss) FROM notas WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN notas ON cadastro.codigo=notas.codemissor
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7) 
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=notas.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='notas' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY processosfiscais_competencias.competencia";
	}
	elseif($relacionamento =='des_issretido'){
		$sql_select = "	SELECT guia_pagamento.pago, des_issretido.total, processosfiscais_competencias.competencia, (SELECT SUM(des_issretido.iss) FROM des_issretido WHERE estado='B')
						FROM processosfiscais_autuacoes 
						INNER JOIN processosfiscais ON processosfiscais_autuacoes.anoprocesso=processosfiscais.anoprocesso 
						AND processosfiscais_autuacoes.nroprocesso=processosfiscais.nroprocesso 
						INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo 
						INNER JOIN des_issretido ON cadastro.codigo=des_issretido.codcadastro 
						INNER JOIN processosfiscais_competencias ON processosfiscais_competencias.competencia = SUBSTRING(des.competencia,1,7)
						INNER JOIN guias_declaracoes ON guias_declaracoes.codrelacionamento=des_issretido.codigo 
						INNER JOIN guia_pagamento ON guia_pagamento.codigo=guias_declaracoes.codguia 
						WHERE guias_declaracoes.relacionamento='des_issretido' 
						AND processosfiscais_autuacoes.nroautuacao = '$nroautuacao' 
						AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao'
						GROUP BY processosfiscais_competencias.competencia";
	}
}//fim do while
$sql = mysql_query($sql_select);
						
$sqlconfig = mysql_query("SELECT configuracoes.taxacorrecao, configuracoes.taxamulta, configuracoes.taxajuros FROM configuracoes");

$sql_nome=mysql_query("SELECT processosfiscais.nroprocesso, processosfiscais.anoprocesso, cadastro.razaosocial, cadastro.cnpj, cadastro.cpf, cadastro.inscrmunicipal FROM processosfiscais INNER JOIN cadastro ON processosfiscais.codemissor=cadastro.codigo INNER JOIN processosfiscais_autuacoes ON processosfiscais.nroprocesso=processosfiscais_autuacoes.nroprocesso WHERE processosfiscais_autuacoes.nroautuacao = '$nroautuacao' AND processosfiscais_autuacoes.anoautuacao = '$anoautuacao' GROUP BY processosfiscais.nroprocesso");

$sql = mysql_query($sql_select);
}//fim do if numrows
?>
	<fieldset style="margin-left:7px; margin-right:7px;">
	<form method="post" id="form1" target="_blank" action="inc/fiscalizacao/processos/docs_planilha_imprimir.php">
	<?php 
		if($cnpj==""){
			$cnpjcpf=$cpf;
		}else{
			$cnpjcpf=$cnpj;
		}
	?>
<title>E-ISS</title>
			<table width="100%" align="center">
				<tr bgcolor="#999999">
					<td align="center">Processo Fiscal:<?php echo "$nroprocesso/$anoprocesso - $razaosocial"; ?></td>
				</tr>
			</table>
			<table width="50%" align="center">
				<tr>
					<td align="right" width="50%">CNPJ:</td>
					<td align="left"><?php echo "$cnpjcpf"; ?></td>
				</tr>
				<tr>	
					<td align="right">Inscrição Municipal:</td>
					<td align="left"><?php echo verificacampo($inscrmunicipal);  ?></td>
				</tr>
				<tr>
					<td align="right">Documento:</td>
					<td align="left"><?php echo "$nroautuacao/$anoautuacao"; ?></td>
				</tr>
				<tr>
					<td align="right">Infração:</td>
					<td align="left"><?php echo "$nroinfracao/$anoinfracao"; ?></td>
				</tr>
			</table>
			<table width="100%" align="center">
			<tr bgcolor="#999999">
				<td align="center">Competência</td>
				<td align="center">ISS Devido </td>
				<td align="center">ISS Pago </td>
				<td align="center">Tributo</td>
				<td align="center">Correção</td>
				<td align="center">Juros</td>
				<td align="center">Multa</td>
				<td align="center">Imposto Total </td>
			</tr>
<?php
			$contador_guias=mysql_num_rows($sql);
			while(list($pago, $total, $competencia, $issguia) = mysql_fetch_array($sql))
				{
					$isspago = 0;
					$issdevido = 0;
					$data = DataPt($competencia);
					switch($pago)
					{
						case "S": $isspago+=$issguia; break;
						case "N": $issdevido+=$issguia; break;
					}
					$tributo = $issdevido - $isspago;
					if ($tributo < 0){$tributo = 0;}
					
					$imposto = $tributo + $taxajuros + $taxacorrecao + $taxamulta;
					if($pago=="S"){
					$imposto=0;
					}
					$totalimp += $imposto;		
			print ("
				<tr bgcolor='#FFFFFF'>
					<td align=\"center\">$competencia</td>
					<td align=\"center\">$issdevido</td>
					<td align=\"center\">$isspago</td>
					<td align=\"center\">$tributo</td>
					<td align=\"center\">$taxacorrecao</td>
					<td align=\"center\">$taxajuros</td>
					<td align=\"center\">$taxamulta</td>
					<td align=\"center\">$imposto</td> 
				</tr>
				");
				} // FIM DO WHILE SQL
			?>
		<tr>
			<td align="center" bgcolor="#999999" colspan="8">Imposto Total: <?php echo "$totalimp"; ?></td>
		</tr>
	</table>
<div id='imp'>
	<table width="100%">
		<tr align="center">
			<td>
				<input type="button" name="btnImprimir" value="Imprimir" onclick="document.getElementById('imp').style.display='none'; print(); document.getElementById('imp').style.display='block';"/>
			</td>
		</tr>
	</table>
</div>