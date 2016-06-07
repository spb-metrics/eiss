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
//conect ao banco
include("../../conect.php"); 
include("../../../funcoes/util.php");

//busca o codigo do prestador
$sql = mysql_query("SELECT emissores.codigo, emissores.nome, emissores.notalimite, emissores.ultimanota FROM emissores INNER JOIN aidf_solicitacoes ON aidf_solicitacoes.codemissor = emissores.codigo WHERE emissores.nfe = 'n' GROUP BY emissores.codigo");
$result = mysql_num_rows($sql);
if($result>0){
?>
	<fieldset><legend><b><?php echo $result;?> - Solicitantes</b></legend>
	<table width="100%">
		<tr bgcolor="#999999">
			<td width="230" align="center">Nome</td>
			<td width="140" align="center">Ultima nota emitida</td>
			<td width="100" align="center">Limite de notas</td>
			<td align="center">Solicitações</td>
		</tr>
	</table>
<div <?php if($result >12){ echo "style=\"overflow:auto; height:250px;\""; }?>>
	<table width="100%">
		<?php
			while(list($codigo,$nome,$notalimite,$ultimanota) = mysql_fetch_array($sql)){
				//conta quantas solicitacoes o prestador fez
				$sql_solicitacoes = mysql_query("SELECT COUNT(codigo) FROM aidf_solicitacoes WHERE codemissor = '$codigo'");
				list($cont) = mysql_fetch_array($sql_solicitacoes);?>
		<tr bgcolor="#FFFFFF">
			<td width="230" align="left"><?php echo $nome;?></td>
			<td width="140" align="center"><?php echo $ultimanota;?></td>
			<td width="100" align="center"><?php echo $notalimite;?></td>
			<td align="center"><?php if($cont == 0){$cont="Não solicitou";} echo $cont;?></td>
		</tr>
		<?php
			}//fim while
		?>
	</table>
</div>
<?php	
}else{?>
	<table width="100%">
		<tr>
			<td align="center"><b>Não há nenhuma solicitação</b></td>
		</tr>
	</table>	
<?php
}//fim else
?>