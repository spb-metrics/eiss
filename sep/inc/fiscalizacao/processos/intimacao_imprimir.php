<?php
/*
LICEN�A P�BLICA GERAL GNU
Vers�o 3, 29 de junho de 2007
    Copyright (C) <2010>  <PORTAL P�BLICO INFORM�TICA LTDA>

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

Este programa � software livre: voc� pode redistribu�-lo e / ou modificar sob os termos da GNU General Public License como publicado pela Free Software Foundation, tanto a vers�o 3 da Licen�a, ou�(por sua op��o) qualquer vers�o posterior.

Este programa � distribu�do na esperan�a que possa ser �til, mas SEM QUALQUER GARANTIA, sem mesmo a garantia impl�cita de COMERCIALIZA��O ou ADEQUA��O A UM DETERMINADO PROP�SITO. Veja a GNU General Public License para mais detalhes.

Voc� deve ter recebido uma c�pia da GNU General Public License��junto com este programa. Se n�o, veja <http://www.gnu.org/licenses/>.


This is an unofficial translation of the GNU General Public License into Portuguese. It was not published by the Free Software Foundation, and does not legally state the distribution terms for software that uses the GNU GPL � only the original English text of the GNU GPL does that. However, we hope that this translation will help Portuguese speakers understand the GNU GPL better.

Esta � uma tradu��o n�o oficial em portugu�s da Licen�a P�blica Geral GNU (da sigla em ingl�s GNU GPL). Ela n�o � publicada pela Free Software Foundation e n�o declara legalmente os termos de distribui��o para softwares que a utilizam � somente o texto original da licen�a, escrita em ingl�s, faz isto. Entretanto, acreditamos que esta tradu��o ajudar� aos falantes do portugu�s a entend�-la melhor.


// Originado do Projeto ISS Digital � Portal P�blico que tiveram colabora��es de Vin�cius Kampff, 
// Rafael Romeu, Lucas dos Santos, Guilherme Flores, Maikon Farias, Jean Farias e Daniel Bohn
// Acesse o site do Projeto www.portalpublico.com.br             |
// Equipe Coordena��o Projeto ISS Digital: <informatica@portalpublico.com.br>   |

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
<title>Intima��o</title>
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
<center><h2>INTIMA��O</h2></center>
<br /><br />
<table align="center" width="700">
	<tr align="justify">
		<td>Processo Fiscal: <?php echo $processofiscal; ?></td>
	</tr>
	<tr>
		<td>Assunto: Intima��o para Apresenta��o de Documentos</td>
	</tr>
</table>
<br /><br /><br />
<table align="center" width="700">
	<tr>
		<td>
			<p align="justify" style="text-indent:40mm">A <strong><?php echo $SECRETARIA;?></strong> no desempenho de suas atribui��es institucionais, com fundamentos nos artigos da lei: <?php echo $legislacao; ?>, <strong>INTIMA</strong> <?php echo $razaosocial; ?> a apresentar nesta Secretaria Municipal os documentos listados abaixo no dia <?php echo $dataapresentacao; ?> para a verifica��o do regular cumprimento das obriga��es previdenci�rias principais e acess�rias, os quais dever�o ser deixados � disposi��o da fiscaliza��o at� o t�rmino do procedimento fiscal.</p>
		</td>
	</tr>
	<tr>
		<td>
		<br />Documentos solicitados:<br />
		<?php  
		//seleciona os documentos solicitados na intima��o.
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