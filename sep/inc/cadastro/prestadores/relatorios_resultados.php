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
//conecta ao banco e chama as funcoes
include("../conect.php");
include("../../funcoes/util.php");
	
//recebimento de variaveis por get
$combo = $_GET["cmbAssunto"];

//testa o valor do combo
if($combo == "aidf"){
?>
	<fieldset><legend>Reltórios - Aidf</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td align="left">Maior emissor:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Menor emissor:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Maior requisitante:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Menor requisitante:</td>
				<td align="left"></td>
			</tr>
		</table>
	</fieldset>
<?php
}elseif($combo == "aidfe"){
?>
	<fieldset><legend>Reltórios - Aidf eletrônico</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td align="left">Maior emissor:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Menor emissor:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Maior requisitante:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Menor requisitante:</td>
				<td align="left"></td>
			</tr>
		</table>
	</fieldset>
<?php
}elseif($combo == "prestadores"){
?>
	<fieldset><legend>Reltórios - Prestadores</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td align="left">Cadastrados:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Ativos:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left">Inativos:</td>
				<td align="left"></td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<input name="btVizualizar" type="button" class="botao" value="Prestadores por serviço" 
					onClick="cancelaAction('frmRelatoriosPrestadores','inc/servicos/relatorio.php','_parent')">
				</td>
			</tr>
		</table>
	</fieldset>
	<!-- inc/servicos/relatorio.php -->
	<!-- <input type="hidden" name="include" id="include" value="<?php //echo  $_POST['include'];?>" /> -->
<?php
}elseif($combo == "contadores"){
?>
	<fieldset><legend>Reltórios - Contadores</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td>Maior emissor:</td>
				<td></td>
			</tr>
		</table>
	</fieldset>
<?php
}
?>
