<?php
/*
LICENÇA PÚBLICA GERAL GNU
Versão 3, 29 de junho de 2007
    Copyright (C) <2010>  <PORTAL PÚBLICO INFORMÁTICA LTDA>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

Este programa é software livre: você pode redistribuí-lo e / ou modificar sob os termos da GNU General Public License como publicado pela Free Software Foundation, tanto a versão 3 da Licença, ou (por sua opção) qualquer versão posterior.

Este programa é distribuído na esperança que possa ser útil, mas SEM QUALQUER GARANTIA, sem mesmo a garantia implícita de COMERCIALIZAÇÃO ou ADEQUAÇÃO A UM DETERMINADO PROPÓSITO. Veja a GNU General Public License para mais detalhes.

Você deve ter recebido uma cópia da GNU General Public License  junto com este programa. Se não, veja <http://www.gnu.org/licenses/>.


This is an unofficial translation of the GNU General Public License into Portuguese. It was not published by the Free Software Foundation, and does not legally state the distribution terms for software that uses the GNU GPL — only the original English text of the GNU GPL does that. However, we hope that this translation will help Portuguese speakers understand the GNU GPL better.

Esta é uma tradução não oficial em português da Licença Pública Geral GNU (da sigla em inglês GNU GPL). Ela não é publicada pela Free Software Foundation e não declara legalmente os termos de distribuição para softwares que a utilizam — somente o texto original da licença, escrita em inglês, faz isto. Entretanto, acreditamos que esta tradução ajudará aos falantes do português a entendê-la melhor.


// Originado do Projeto ISS Digital – Portal Público que tiveram colaborações de Vinícius Kampff, 
// Rafael Romeu, Lucas dos Santos, Guilherme Flores, Maikon Farias, Jean Farias e Daniel Bohn
// Acesse o site do Projeto www.portalpublico.com.br             |
// Equipe Coordenação Projeto ISS Digital: <informatica@portalpublico.com.br>   |

*/
?>



<?php
include ("../../conect.php");
include ("../../../funcoes/util.php");

$codintimacao 	= $_POST["txtIntimacao"];


//pega as informacoes da prefeitura
$sql=mysql_query("SELECT endereco, cidade, estado, secretaria, brasao FROM configuracoes");
list($ENDERECO,$CIDADE,$ESTADO,$SECRETARIA,$BRASAO)=mysql_fetch_array($sql);


$sql = mysql_query("
					SELECT processosfiscais_intimacoes.nroprocesso, processosfiscais_intimacoes.anoprocesso, 
					processosfiscais_intimacoes.nrointimacao, processosfiscais_intimacoes.anointimacao, 
					processosfiscais_intimacoes.dataemissao, processosfiscais_intimacoes.prazo, 
					processosfiscais_intimacoes.observacoes, legislacao.titulo
					FROM processosfiscais_intimacoes 
					INNER JOIN legislacao ON processosfiscais_intimacoes.codlegislacao = legislacao.codigo
					WHERE processosfiscais_intimacoes.codigo = '$codintimacao'
					");
list($nroprocesso, $anoprocesso, $nrointimacao, $anointimacao, $dataemissao, $prazo, $observacoes, $legislacao) = mysql_fetch_array($sql);
$processofiscal = $nroprocesso."/".$anoprocesso;

$dataemissao=implode("/",array_reverse(explode("-",$dataemissao)));
$data=explode("/",$dataemissao);
$dataapresentacao=date("d/m/Y", mktime(0,0,0, $data[1], $data[0]+$prazo, $data[2]));
//pega a razao social da empresa
$sqlproc = mysql_query("
SELECT cadastro.razaosocial
FROM cadastro
INNER JOIN processosfiscais ON processosfiscais.codemissor = cadastro.codigo
WHERE processosfiscais.nroprocesso = '$nroprocesso' AND processosfiscais.anoprocesso = '$anoprocesso'");
list($razaosocial) = mysql_fetch_array($sqlproc);

?>
<title>Intimação</title>
<div id="imprimir">
	<input type="button" class="botao" name="btImprimir" value="Imprimir" onClick="document.getElementById('imprimir').style.display='none'; print(); document.getElementById('imprimir').style.display='block';" />
</div>
<table align="center" width="700">
	<tr>
		<td align="center"><?php if($BRASAO){ ?><img src="../../../img/brasoes/<?php echo rawurlencode($BRASAO); ?>" /><?php }?></td>
	</tr>
	<tr align="center" valign="bottom">
		<td>Prefeitura Municipal de <?php echo $CIDADE; ?></td>
	</tr>
	<tr>
		<td align="center"><?php echo $SECRETARIA; ?></td>
	</tr>
	<tr align="center">
		<td colspan="3"><?php echo $ENDERECO.", ".$CIDADE.", ".$ESTADO; ?></td>
	</tr>
</table>
<br /><br />
<center><h2>INTIMAÇÃO</h2></center>
<br /><br />
<table align="center" width="700">
	<tr align="justify">
		<td>Processo Fiscal: <?php echo $processofiscal; ?></td>
	</tr>
	<tr>
		<td>Assunto: Intimação para Apresentação de Documentos</td>
	</tr>
</table>
<br /><br /><br />
<table align="center" width="700">
	<tr>
		<td>
			<p align="justify" style="text-indent:40mm">A <strong><?php echo $SECRETARIA;?></strong> no desempenho de suas atribuições institucionais, com fundamentos nos artigos da lei: <?php echo $legislacao; ?>, <strong>INTIMA</strong> <?php echo $razaosocial; ?> a apresentar nesta Secretaria Municipal os documentos listados abaixo no dia <?php echo $dataapresentacao; ?> para a verificação do regular cumprimento das obrigações previdenciárias principais e acessórias, os quais deverão ser deixados à disposição da fiscalização até o término do procedimento fiscal.</p>
		</td>
	</tr>
	<tr>
		<td>
		<br />Documentos solicitados:<br />
		<?php  
		//seleciona os documentos solicitados na intimação.
		$sqldocs = mysql_query("
								SELECT processosfiscais_docs.nrodoc, processosfiscais_docs.descricao 
								FROM processosfiscais_docs 
								INNER JOIN processosfiscais_intimacoes_docs ON processosfiscais_intimacoes_docs.coddoc = processosfiscais_docs.codigo
								INNER JOIN processosfiscais_intimacoes ON processosfiscais_intimacoes.codigo = processosfiscais_intimacoes_docs.codintimacao
								WHERE processosfiscais_intimacoes.codigo = '$codintimacao'
								ORDER BY processosfiscais_docs.nrodoc
								");
		while(list($doc_nro,$doc_descricao) = mysql_fetch_array($sqldocs)){
			$string .= "$doc_descricao<br>\t";
		}//fim while para listar os documentos
		echo substr($string, 0, -8).".";//mostra os documentos tirando a ultima virgula e acrecentando um ponto final.
		?>
		</td>
	</tr>
	<tr>
		<td align="right"><br /><br /><br /><?php echo "$CIDADE, ".DataPtExt(); ?></td>
	</tr>
</table>