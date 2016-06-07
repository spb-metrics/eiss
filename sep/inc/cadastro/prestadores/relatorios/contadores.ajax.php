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
<title>Relat&oacute;rios - Prestadores</title>
<?php 
include("../../conect.php"); 
include("../../../funcoes/util.php");

//recebimento de variaveis por get
$acao = $_GET["hdAcao"];

if($acao == "Cadastrados"){
	//Sql buscando as informacoes dos prestadores
	$sql = mysql_query("SELECT emissores.nome, emissores.razaosocial, emissores.endereco, emissores.municipio, emissores.uf, emissores.estado, emissores.ultimanota, emissores.notalimite FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador'");
	$result = mysql_num_rows($sql);
	if($result>0){
?>
	<fieldset><legend><b><?php echo $result;?> - Contadores cadastrados</b></legend>
	<table width="100%">
		<tr bgcolor="#999999">
			<td align="center">Nomes</td>
			<td align="center">Endere&ccedil;o</td>
			<td align="center">Município</td>
			<td align="center">Uf</td>
			<td align="center">Ultima Nota</td>
			<td align="center">AIDF</td>
			<td align="center">Estado</td>
		</tr>
		<?php
		while(list($nome,$rs,$endereco,$municipio,$uf,$estado,$ultima,$limite) = mysql_fetch_array($sql))
			{
				switch($limite){
					case 0:  $aidf = "Liberado"; break;
					default: $aidf = $limite;    break;
				}//fim switch
				switch($estado){
					case "A": $estado = "Ativo";   break;
					case "I": $estado = "Inativo"; break;
				}//fim switch
		?>
		<tr bgcolor="#FFFFFF" height="25">
			<td width="24%" align="left"><?php echo $nome;?></td>
			<td width="27%" align="left"><?php echo $endereco;?></td>
			<td width="20%" align="center"><?php echo $municipio;?></td>
			<td width="4%" align="center"><?php echo $uf;?></td>
			<td width="10%" align="center"><?php echo $ultima;?></td>
			<td width="8%" align="center"><?php echo $aidf;?></td>
			<td width="7%" align="center"><?php echo $estado;?></td>			
		</tr>
		<?php
		}//fim while
		?>
	</table>
</fieldset>
<?php
	}else{
		echo "<p align=\"center\">Não foi encontrado nenhum resultado</p>";
	}//fim else mysql_num_rows()
}elseif($acao == "Ativos"){
	//Sql buscando as informacoes dos prestadores ativos
	$sql = mysql_query("SELECT emissores.nome, emissores.razaosocial, emissores.endereco, emissores.municipio, emissores.uf, emissores.estado, emissores.ultimanota, emissores.notalimite FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador' AND emissores.estado = 'A'");
	$result = mysql_num_rows($sql);
	if($result>0){
?>
	<fieldset><legend><b><?php echo $result;?> - Prestadores ativos</b></legend>
	<table width="100%">
		<tr bgcolor="#999999">
			<td align="center">Nomes</td>
			<td align="center">Endere&ccedil;o</td>
			<td align="center">Município</td>
			<td align="center">Uf</td>
			<td align="center">Ultima Nota</td>
			<td align="center">AIDF</td>
			<td align="center">Estado</td>
		</tr>
		<?php
		while(list($nome,$rs,$endereco,$municipio,$uf,$estado,$ultima,$limite) = mysql_fetch_array($sql))
			{
				switch($limite){
					case 0:  $aidf = "Liberado"; break;
					default: $aidf = $limite;    break;
				}//fim switch
				switch($estado){
					case "A": $estado = "Ativo";   break;
					case "I": $estado = "Inativo"; break;
				}//fim switch
		?>
		<tr bgcolor="#FFFFFF" height="25">
			<td width="24%" align="left"><?php echo $nome;?></td>
			<td width="27%" align="left"><?php echo $endereco;?></td>
			<td width="20%" align="center"><?php echo $municipio;?></td>
			<td width="4%" align="center"><?php echo $uf;?></td>
			<td width="10%" align="center"><?php echo $ultima;?></td>
			<td width="8%" align="center"><?php echo $aidf;?></td>
			<td width="7%" align="center"><?php echo $estado;?></td>			
		</tr>
		<?php
		}//fim while
		?>
	</table>
</fieldset>
<?php
	}else{
		echo "<p align=\"center\">Não foi encontrado nenhum resultado</p>";
	}//fim else
}elseif($acao == "Inativos"){
	//Sql buscando as informacoes dos prestadores inativos
	$sql = mysql_query("SELECT emissores.nome, emissores.razaosocial, emissores.endereco, emissores.municipio, emissores.uf, emissores.estado, emissores.ultimanota, emissores.notalimite FROM emissores INNER JOIN usuarios ON usuarios.login = emissores.cnpjcpf WHERE usuarios.tipo = 'contador' AND emissores.estado = 'I'");
	$result = mysql_num_rows($sql);
	if($result>0){
?>
	<fieldset><legend><b><?php echo $result;?> - Prestadores cadastrados</b></legend>
	<table width="100%">
		<tr bgcolor="#999999">
			<td align="center">Nomes</td>
			<td align="center">Endere&ccedil;o</td>
			<td align="center">Município</td>
			<td align="center">Uf</td>
			<td align="center">Ultima Nota</td>
			<td align="center">AIDF</td>
			<td align="center">Estado</td>
		</tr>
		<?php
		while(list($nome,$rs,$endereco,$municipio,$uf,$estado,$ultima,$limite) = mysql_fetch_array($sql))
			{
				switch($limite){
					case 0:  $aidf = "Liberado"; break;
					default: $aidf = $limite;    break;
				}//fim switch
				switch($estado){
					case "A": $estado = "Ativo";   break;
					case "I": $estado = "Inativo"; break;
				}//fim switch
		?>
		<tr bgcolor="#FFFFFF" height="25">
			<td width="24%" align="left"><?php echo $nome;?></td>
			<td width="27%" align="left"><?php echo $endereco;?></td>
			<td width="20%" align="center"><?php echo $municipio;?></td>
			<td width="4%" align="center"><?php echo $uf;?></td>
			<td width="10%" align="center"><?php echo $ultima;?></td>
			<td width="8%" align="center"><?php echo $aidf;?></td>
			<td width="7%" align="center"><?php echo $estado;?></td>			
		</tr>
		<?php
		}//fim while
		?>
	</table>
</fieldset>
<?php
	}else{
		echo "<p align=\"center\">Não foi encontrado nenhum resultado</p>";
	}//fim else
}//fim elseif
?>