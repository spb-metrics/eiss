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
include("../../conect.php");
include("../../../funcoes/util.php");
	
//recebimento de variaveis por get
$combo = $_GET["cmbAssunto"];

//testa o valor do combo
if($combo == "aidf"){
	//busca o maior numero de notas emitidas do banco
	$sql_max_ultimanota = mysql_query("SELECT MAX(ultimanota) FROM emissores WHERE nfe = 'n'");
	list($maiornumero) = mysql_fetch_array($sql_max_ultimanota);
	//verifica o nome do emissor que tenha o maior numero de notas emitidas
	$sql_maior_emissor = mysql_query("SELECT nome FROM emissores WHERE ultimanota = '$maiornumero' AND nfe = 'n'");
	list($nome_maioremissor) = mysql_fetch_array($sql_maior_emissor);
	//busca o menor numero de notas emitidas do banco
	$sql_min_ultimanota = mysql_query("SELECT MIN(ultimanota) FROM emissores WHERE nfe = 'n'");
	list($menornumero) = mysql_fetch_array($sql_min_ultimanota);
	//verifica o nome do emissor que tenha o menor numero de notas emitidas
	$sql_menor_emissor = mysql_query("SELECT nome FROM emissores WHERE ultimanota = '$menornumero'  AND nfe = 'n'");
	list($nome_menoremissor) = mysql_fetch_array($sql_menor_emissor);
	//sql para listar a quantidade e o solicitante dos registros no banco
	$sql_lista_codemissor = mysql_query("SELECT codemissor FROM aidf_solicitacoes GROUP BY codemissor");
	$cont =0;
	while(list($result) = mysql_fetch_array($sql_lista_codemissor)){
		$codigos[$cont] = $result;
		$cont++;
	}//fim while
	$cont = 0;
	//enquanto $x for menor que o numero de posicoes do array, recebe o resultado do sql em outro array
	for($x=0;$x<count($codigos);$x++){
		//sql que conta quantos solicitantes ha com o mesmo codemissor
		$sql_conta_solicitacoes = mysql_query("SELECT COUNT(codemissor) FROM aidf_solicitacoes WHERE codemissor = '$codigos[$x]'");
		list($quantidade) = mysql_fetch_array($sql_conta_solicitacoes);
		$quant[$cont] = $quantidade;
		$cont++;
	}//fim for
	$maior_valor = 0;                 //inicia a variavel com o maior valor valendo zero para testar se ha maiores
	$menor_valor = $quant[0];         //inicia a variavel com a primeira posicao do array
	$cod_menor_emissor = $codigos[0]; //inicia com o codigo da primeira posicao do array, caso esta posicao tenha o menor valor mantem este codigo 
	//enquanto $x for menor que o numero de posicoes do array, faz esses dois teste
	for($x=0;$x<count($quant);$x++){
		//testa se o valor da variavel maior_valor e menor que o valor do array nessa posicao se for recebe o valor do array e pega o codigo dessa posicao
		if($maior_valor<$quant[$x]){
			$maior_valor       = $quant[$x];
			$cod_maior_emissor = $codigos[$x];
		}//fim if
		//testa se o valor da variavel $menor_valor e maior que o valor do array nessa posicao se for recebe o valor do array e pega o codigo dessa posicao senao mantem o que ja havia
		if($menor_valor>$quant[$x]){
			$menor_valor       = $quant[$x];
			$cod_menor_emissor = $codigos[$x];
		}//fim if
	}//fim for
	//busca o nome do maior requisitante
	$sql_maior_solicitante = mysql_query("SELECT nome FROM emissores WHERE codigo = '$cod_maior_emissor'");
	list($nome_maior_requisitante) = mysql_fetch_array($sql_maior_solicitante);
	//busca o nome do menor requisitante
	$sql_menor_requisitante = mysql_query("SELECT nome FROM emissores WHERE codigo = '$cod_menor_emissor'");
	list($nome_menor_requisitante) = mysql_fetch_array($sql_menor_requisitante);
	
?>
	<fieldset><legend>Relatórios - Aidf</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td width="17%" align="left">Maior emissor:</td>
				<td width="83%" align="left"><?php echo $nome_maioremissor;?></td>
			</tr>
			<tr>
				<td align="left">Menor emissor:</td>
				<td align="left"><?php echo $nome_menoremissor;?></td>
			</tr>
			<tr>
				<td align="left">Maior requisitante:</td>
				<td align="left"><?php echo $nome_maior_requisitante;?></td>
			</tr>
			<tr>
				<td align="left">Menor requisitante:</td>
				<td align="left"><?php echo $nome_menor_requisitante;?></td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<input name="btTodas" type="button" class="botao" value="Todos os solicitantes"  
				     onclick="acessoAjax('inc/prestadores/relatorios/solicitacoes_aidf.php','frmRelatoriosPrestadores','divaidf')"/>
				</td>
			</tr>
		</table>
		<div id="divaidf"></div>
	</fieldset>
<?php
}elseif($combo == "aidfe"){
	//busca o maior numero de notas emitidas do banco
	$sql_max_ultimanota = mysql_query("SELECT MAX(ultimanota) FROM emissores WHERE nfe = 's'");
	list($maiornumero) = mysql_fetch_array($sql_max_ultimanota);
	//verifica o nome do emissor que tenha o maior numero de notas emitidas
	$sql_maior_emissor = mysql_query("SELECT nome FROM emissores WHERE ultimanota = '$maiornumero' AND nfe = 's'");
	list($nome_maioremissor) = mysql_fetch_array($sql_maior_emissor);
	//busca o menor numero de notas emitidas do banco
	$sql_min_ultimanota = mysql_query("SELECT MIN(ultimanota) FROM emissores WHERE nfe = 's'");
	list($menornumero) = mysql_fetch_array($sql_min_ultimanota);
	//verifica o nome do emissor que tenha o menor numero de notas emitidas
	$sql_menor_emissor = mysql_query("SELECT nome FROM emissores WHERE ultimanota = '$menornumero' AND nfe = 's'");
	list($nome_menoremissor) = mysql_fetch_array($sql_menor_emissor);
	//sql para listar a quantidade e o solicitante dos registros no banco
	$sql_lista_solicitante = mysql_query("SELECT solicitante FROM aidfe_solicitacoes GROUP BY solicitante");
	$cont =0;
	while(list($result) = mysql_fetch_array($sql_lista_solicitante)){
		$codigos[$cont] = $result;
		$cont++;
	}//fim while
	$cont = 0;
	//enquanto $x for menor que o numero de posicoes do array, recebe o resultado do sql em outro array
	for($x=0;$x<count($codigos);$x++){
		//sql que conta quantos solicitantes ha com o mesmo numero solicitante
		$sql_conta_solicitante = mysql_query("SELECT COUNT(solicitante) FROM aidfe_solicitacoes WHERE solicitante = '$codigos[$x]'");
		list($quantidade) = mysql_fetch_array($sql_conta_solicitante);
		$quant[$cont] = $quantidade;
		$cont++;
	}//fim for
	$maior_valor = 0;                 //inicia a variavel com o maior valor valendo zero para testar se ha maiores
	$menor_valor = $quant[0];         //inicia a variavel com a primeira posicao do array
	$cod_menor_emissor = $codigos[0]; //inicia com o codigo da primeira posicao do array, caso esta posicao tenha o menor valor mantem este codigo 
	//enquanto $x for menor que o numero de posicoes do array, faz esses dois teste
	for($x=0;$x<count($quant);$x++){
		//testa se o valor da variavel maior_valor e menor que o valor do array nessa posicao se for recebe o valor do array e pega o codigo dessa posicao
		if($maior_valor<$quant[$x]){
			$maior_valor       = $quant[$x];
			$cod_maior_emissor = $codigos[$x];
		}//fim if
		//testa se o valor da variavel $menor_valor e maior que o valor do array nessa posicao se for recebe o valor do array e pega o codigo dessa posicao senao mantem o que ja havia
		if($menor_valor>$quant[$x]){
			$menor_valor       = $quant[$x];
			$cod_menor_emissor = $codigos[$x];
		}//fim if
	}//fim for
	//busca o nome do maior requisitante
	$sql_maior_solicitante = mysql_query("SELECT nome FROM emissores WHERE codigo = '$cod_maior_emissor'");
	list($nome_maior_requisitante) = mysql_fetch_array($sql_maior_solicitante);
	//busca o nome do menor requisitante
	$sql_menor_requisitante = mysql_query("SELECT nome FROM emissores WHERE codigo = '$cod_menor_emissor'");
	list($nome_menor_requisitante) = mysql_fetch_array($sql_menor_requisitante);
?>
	<fieldset><legend>Relatórios - Aidfe</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td width="17%" align="left">Maior emissor:</td>
				<td width="83%" align="left"><?php echo $nome_maioremissor;?></td>
			</tr>
			<tr>
				<td align="left">Menor emissor:</td>
				<td align="left"><?php echo $nome_menoremissor;?></td>
			</tr>
			<tr>
				<td align="left">Maior requisitante:</td>
				<td align="left"><?php echo $nome_maior_requisitante;?></td>
			</tr>
			<tr>
				<td align="left">Menor requisitante:</td>
				<td align="left"><?php echo $nome_menor_requisitante;?></td>
			</tr>
			<tr>
				<td align="left" colspan="2">
					<input name="btTodas" type="button" class="botao" value="Todos os solicitantes"  
				     onclick="acessoAjax('inc/prestadores/relatorios/solicitacoes_aidfe.php','frmRelatoriosPrestadores','divaidfe')"/>
				</td>
			</tr>
		</table>
		<div id="divaidfe"></div>
	</fieldset>
<?php
}elseif($combo == "prestadores"){
	//verifica quantos prestadores tem cadastrados
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON emissores.cnpjcpf = usuarios.login WHERE usuarios.tipo = 'empresa'");
	list($cadastrados) = mysql_fetch_array($sql);
	//verifica quantos prestadores cadastrados estao ativos
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON emissores.cnpjcpf = usuarios.login WHERE usuarios.tipo = 'empresa' AND emissores.estado = 'A'");
	list($ativos) = mysql_fetch_array($sql);
	//verifica quantos prestadores cadastrados estao inativos
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON emissores.cnpjcpf = usuarios.login WHERE usuarios.tipo = 'empresa' AND emissores.estado = 'I'");
	list($inativos) = mysql_fetch_array($sql);
?>
	<fieldset><legend>Relatórios - Prestadores</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td width="10%" align="left">Cadastrados:</td>
				<td align="left" colspan="3"><?php if($cadastrados == 0){ echo "Não há prestador cadastrado";}else{ echo $cadastrados;}?></td>
			</tr>
			<tr>
				<td align="left">Ativos:</td>
				<td align="left" colspan="3"><?php if($ativos == 0){ echo "Não há nenhum prestador ativo";}else{ echo $ativos;}?></td>
			</tr>
			<tr>
				<td align="left">Inativos:</td>
				<td align="left" colspan="3"><?php if($inativos == 0){ echo "Não há nenhum prestador inativo";}else{ echo $inativos;}?></td>
			</tr>
			<tr>
				<td align="left">
					<input name="btAcao" id="btCadastroPrestadores" type="button" value="Cadastrados" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btCadastroPrestadores').value;
					acessoAjax('inc/prestadores/relatorios/prestadores.php','frmRelatoriosPrestadores','divprestadores')">
				</td>
			    <td width="7%" align="left">
					<input name="btAcao" id="btAtivosPrestadores" type="button" value="Ativos" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btAtivosPrestadores').value;
					acessoAjax('inc/prestadores/relatorios/prestadores.php','frmRelatoriosPrestadores','divprestadores')">
				</td>
			    <td width="7%" align="left">
					<input name="btAcao" id="btInativosPrestadores" type="button" value="Inativos" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btInativosPrestadores').value;
					acessoAjax('inc/prestadores/relatorios/prestadores.php','frmRelatoriosPrestadores','divprestadores')">
				</td>
				<td width="76%" align="left">
					<input name="btVizualizar" type="button" class="botao" value="Prestadores por serviço" 
					onClick="cancelaAction('frmRelatoriosPrestadores','principal.php','_parent')">
					<input type="hidden" name="include" value="inc/servicos/relatorio.php">
					<input type="hidden" name="hdAcao" id="hdAcao">
			    </td>
			</tr>
		</table>
		<div id="divprestadores"></div>
	</fieldset>
<?php
}elseif($combo == "contadores"){
	//verifica quantos contadores tem cadastrados
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador'");
	list($cadastrados) = mysql_fetch_array($sql);
	//verifica quantos contadores cadastrados estao ativos
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador' AND emissores.estado = 'A'");
	list($ativos) = mysql_fetch_array($sql);
	//verifica quantos contadores cadastrados estao inativos
	$sql = mysql_query("SELECT COUNT(emissores.codigo) FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador' AND emissores.estado = 'I'");
	list($inativos) = mysql_fetch_array($sql);
?>
	<fieldset><legend>Relatórios - Contadores</legend>
		<table width="100%" cellpadding="3" cellspacing="3">
			<tr>
				<td width="10%" align="left">Cadastrados:</td>
				<td align="left" colspan="2"><?php if($cadastrados == 0){ echo "Não há contador cadastrado";}else{ echo $cadastrados;}?></td>
			</tr>
			<tr>
				<td align="left">Ativos:</td>
				<td align="left" colspan="2"><?php if($ativos == 0){ echo "Não há contador ativo";}else{ echo $ativos;}?></td>
			</tr>
			<tr>
				<td align="left">Inativos:</td>
				<td align="left" colspan="2"><?php if($inativos == 0){ echo "Não há contador inativo";}else{ echo $inativos;}?></td>
			</tr>
			<tr>
				<td align="left">
					<input name="btAcao" id="btCadastroContadores" type="button" value="Cadastrados" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btCadastroContadores').value;
					acessoAjax('inc/prestadores/relatorios/contadores.php','frmRelatoriosPrestadores','divcontadores')">
				</td>
			    <td width="6%" align="left">
					<input name="btAcao" id="btAtivosContadores" type="button" value="Ativos" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btAtivosContadores').value;
					acessoAjax('inc/prestadores/relatorios/contadores.php','frmRelatoriosPrestadores','divcontadores')">
			  </td>
			    <td width="84%" align="left">
					<input name="btAcao" id="btInativosContadores" type="button" value="Inativos" class="botao" 
					onClick="document.getElementById('hdAcao').value=document.getElementById('btInativosContadores').value;
					acessoAjax('inc/prestadores/relatorios/contadores.php','frmRelatoriosPrestadores','divcontadores')">
					<input type="hidden" name="hdAcao" id="hdAcao">
			  </td>
			</tr>
		</table>
		<div id="divcontadores"></div>
	</fieldset>
<?php
}//fim elseif
?>
