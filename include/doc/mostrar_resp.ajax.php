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
	require_once("../conect.php");
	require_once("../../funcoes/util.php");
	
	$codigo = $_GET['hdCodigo'];
	$sql_resp = mysql_query("SELECT nome, cpf, codcargo FROM cadastro_resp WHERE codemissor = '$codigo'");
	while(list($nome, $cpf, $codcargo) = mysql_fetch_array($sql_resp)){
		$sql_cargo = mysql_query("SELECT cargo FROM cargos WHERE codigo = '$codcargo'");
		list($cargo_resp) = mysql_fetch_array($sql_cargo);
?>
<table width="100%">
	<tr>
    	<td align="left">Nome</td>
        <td align="left"><input type="text" class="texto" size="40" maxlength="100" value="<?php echo $nome;?>" disabled="disabled"></td>
    </tr>
    <tr>
    	<td align="left">CPF</td>
        <td align="left"><input type="text" class="texto" size="40" maxlength="100" value="<?php echo $cpf;?>" disabled="disabled"></td>
    </tr>
    <tr>
    	<td align="left">Cargo</td>
        <td align="left">
        	<select name="cmbCargo" class="combo" disabled="disabled">
            	<?php
					$sql = mysql_query("SELECT codigo, cargo FROM cargos");
					while(list($codigo,$cargo) = mysql_fetch_array($sql)){
						echo "<option value=\"$codigo\"";if($cargo == $cargo_resp){ echo "selected = selected";} echo ">$cargo</option>";
					}
				?>
            </select>
        </td>
    </tr>
    <tr>
    	<td colspan="2"><hr color="#999999" size="2"></td>
    </tr>
</table>
<?php
	}//fim while
?>