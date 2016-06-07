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
include("../../../funcoes/util.php");
$codigo=$_GET['hdcod'];

$sql_consulta=mysql_query("SELECT nome, cnpjcpf, inscrmunicipal, endereco, cep, municipio, uf, email FROM tomadores WHERE codigo = '$codigo'");
$dados = mysql_fetch_array($sql_consulta);
?>
<table align="center" bgcolor="#999999" width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr bgcolor="#FFFFFF">
        <td width="20%" align="left">&nbsp;Nome: </td>
        <td align="left" colspan="3">&nbsp;<?php echo $dados['nome'];?></td>
	</tr>
    <tr bgcolor="#FFFFFF">
		<td align="left">&nbsp;CNPJ/CPF: </td>
        <td align="left" colspan="3">&nbsp;<?php echo $dados['cnpjcpf'];?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
		<td align="left">&nbsp;Inscrição Municipal: </td>
        <td align="left" colspan="3">&nbsp;<?php echo $dados['inscrmunicipal'];?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
		<td align="left">&nbsp;Endereço: </td>
        <td align="left" colspan="3">&nbsp;<?php echo $dados['endereco'];?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td align="left">&nbsp;Município: </td>
        <td align="left" colspan="1" width="250">&nbsp;<?php echo $dados['municipio'];?></td>
		<td align="left" width="50">&nbsp;UF: </td>
        <td align="left">&nbsp;<?php echo $dados['uf'];?></td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td align="left">&nbsp;Cep: </td>
        <td align="left" width="250" colspan="1">&nbsp;<?php echo $dados['cep'];?></td>
		<td align="left" width="50">&nbsp;E-mail: </td>
        <td align="left">&nbsp;<?php echo $dados['email'];?></td>
    </tr>
</table>
