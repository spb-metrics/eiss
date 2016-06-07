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
require_once("inc/conecta.pg.php");
$mysql_sql = mysql_query("SELECT cnpj,cpf FROM cadastro WHERE codigo = '$codemissor'");
list($cnpj_cadastro,$cpf_cadastro)=mysql_fetch_array($mysql_sql);
$cnpjcpf_cadastro = $cnpj_cadastro.$cpf_cadastro;
//insert na base postgre de novahartz
$mes_atual = date('n');
$pg_sql_vcto = pg_query("SELECT data_vcto_$mes_atual FROM smadivid WHERE codigo_divida=4");
list($pg_vcto) = pg_fetch_array($pg_sql_vcto);
$pg_vcto = substr($pg_vcto,4).substr($pg_vcto,2,2).substr($pg_vcto,0,2);
//$pg_vcto = implode('',explode('-',$datavencimento));
$pg_lancamto = date('Ymd');
//pg_query

$pg_sql_cod = pg_query("SELECT MAX(numero_conhecimto) FROM smafinan");
list($pg_last_id) = pg_fetch_array($pg_sql_cod);
$numero_conhecimento = $pg_last_id +1;

$pg_sql_numcad = pg_query("SELECT numcad FROM smabas02 WHERE coduni = $codemissor");
list($pg_numcad) = pg_fetch_array($pg_sql_numcad);
if($pg_numcad == ''){
	$pg_numcad = '0';
}
//$pg_numcad = $codemissor;
$pg_coduni= $codemissor;
$query = "
	INSERT INTO smafinan (
		numero_conhecimto,
		codigo_unico,
		codigo_cadastro,
		numero_cadastro,
		ano_divida,
		codigo_divida,
		parcela_divida,
		digito_divida,
		situacao_divida,
		situacao_divida_aux,
		
		numero_lancamento,
		numero_inscricao,
		numero_livro,
		numero_folha,
		
		data_vcto_inv,
		
		valor_taxa_1,
		valor_taxa_2,
		valor_taxa_3,
		valor_taxa_4,
		valor_taxa_5,
		valor_taxa_6,
		valor_taxa_7,
		valor_taxa_8,
		valor_taxa_9,
		valor_taxa_10,
		valor_taxa_11,
		valor_taxa_12,
		valor_divida,
		
		valor_reparcelado,
		valor_origi_repar,
		valor_desco_repar,
		valor_acres_repar,
		valor_corre_repar,
		valor_multa_repar,
		valor_juros_repar,
		valor_jufin_repar,
		
		data_lancamto_inv,
		
		data_cancel_inv,
		data_reparc_inv,
		data_estorno_inv,
		data_reabilita_inv,
		data_inscricao_inv,
		data_ajuiza_inv,
		numero_ajuiza,
		
		data_pagto_inv,
		valor_pagto,
		valor_desconto,
		valor_acrescimo,
		valor_correcao,
		valor_multa,
		valor_juros,
		faturado_info,
		faturado_fisc,
		
		nfiscal_inicial,
		nfiscal_final,
		operacao_efetuada,
		
		data_alteracao_inv,
		data_exclusao_inv,
		
		num_cert_ajuiza,
		ano_cert_ajuiza,
		dt_emi_cert_ajuiza_inv,
		
		num_avis_debito,
		ano_avis_debito,
		dt_emi_avis_debito_inv,
		num_cert_neg_deb,
		ano_cert_neg_deb,
		dt_emi_cert_neg_deb_inv,
		dt_prescricao_inv
	)VALUES(
		'$numero_conhecimento',
		'$pg_coduni',
		'1',
		'$pg_numcad',
		'{$data[0]}',
		'4',
		'1',
		'1',
		'0',
		'1',
		
		'0',
		'0',
		'0',
		'0',
		
		'$pg_vcto',
		
		'$totaliss',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'$total',
		
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		
		'$pg_lancamto',
		
		'00000000',
		'00000000',
		'00000000',
		'00000000',
		'00000000',
		'00000000',
		'0',
		
		'00000000',
		'0.00',
		'0.00',
		'0.00',
		'0.00',
		'$multa',
		'0.00',
		'0.00',
		'0.00',
		
		'0',
		'0',
		'0',
		
		'00000000',
		'00000000',
		
		'0',
		'0',
		'00000000',
		
		'0',
		'0',
		'00000000',
		'0',
		'0',
		'00000000',
		'00000000'
	)
";
//echo $query;
pg_query($query);
geraLog('smafinan',"Prestador $cnpjcpf_cadastro gerou uma guia");
?>