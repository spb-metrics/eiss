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
	$cnpj = $_SESSION['login'];
	$sql_nome = mysql_query("SELECT nome, razaosocial, cnpj FROM cadastro WHERE cnpj = '$cnpj'");
	list($nome, $razao, $cnpj) = mysql_fetch_array($sql_nome);
	$sql_des = mysql_query("
		SELECT 
			cartorios_des_notas.codigo, 
			cartorios_des_notas.valornota, 
			cartorios_des_notas.nota_nro, 
			cartorios_des_notas.emolumento, 
			cartorios_des.competencia, 
			cartorios_des.data_gerado, 
			cartorios_des.total,
            cartorios_servicos.servicos,
			cartorios_servicos.aliquota,
			cartorios_servicos.codigo
		FROM 
			cartorios_des_notas 
		INNER JOIN 
			cartorios_des ON cartorios_des_notas.coddec_des = cartorios_des.codigo
		INNER JOIN
			cadastro ON cartorios_des.codcartorio = cadastro.codigo
		INNER JOIN
			cartorios_servicos ON cartorios_des_notas.codservico = cartorios_servicos.codigo
		WHERE cadastro.cnpj = '$cnpj'
			");
?>
<table width="100%" border="0" cellpadding="0" cellspacing="1">
	<tr>
		<td width="5%" height="5" bgcolor="#FFFFFF"></td>
		<td width="30%" align="center" bgcolor="#FFFFFF" rowspan="3">Histórico</td>
		<td width="65%" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td height="1" bgcolor="#CCCCCC"></td>
		<td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="10" bgcolor="#FFFFFF"></td>
		<td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">
<form method="post" action="include/dec/relatorio.php" target="_blank">
	<input name="hdNome" type="hidden" value="<?php echo $nome;?>" />
    <input name="txtCNPJ" type="hidden" value="<?php echo $cnpj;?>" />
    <table width="100%" cellpadding="0" cellspacing="2" border="0">
        <tr>
            <td colspan="1" width="100" align="left">Nome Cartório:</td><td><?php echo $nome;?></td>
      	</tr>
        <tr height="8"></tr>
        <tr>
            <td colspan="1" align="left">Razão Social:</td><td><?php echo $razao;?></td>
      	</tr>
        <tr height="8"></tr>
        <tr>
            <td colspan="1" align="left">CNPJ:</td><td><?php echo $cnpj;?></td>
      	</tr>
        <tr height="30"></tr>
        <tr>
        	<td align="left" colspan="4">
				<?php if(mysql_num_rows($sql_des)){ echo "Número de Declarações feitas:". mysql_num_rows($sql_des);}else{ echo "Este cart&oacute;rio não fez nenhuma declara&ccedil;&atilde;o!";}?> 
            </td>
        </tr>
        </table>
        <table>

        <tr height="30">
            <td width="5%">M&ecirc;s</td>
            <td width="14%">
            	<select name="cmbMes" class="combo">
                	<option value=""></option>
                    <option value="01">Janeiro</option>
                    <option value="02">Fevereiro</option>
                    <option value="03">Mar&ccedil;o</option>
                    <option value="04">Abril</option>
                    <option value="05">Maio</option>
                    <option value="06">Junho</option>
                    <option value="07">Julho</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>
            </td>
            <td width="3%" align="left">Ano</td>
            <td width="78%" align="left">
            	<select name="cmbAno" class="combo">
                	<option value=""></option>
                <?php
					$sql_ano = mysql_query("SELECT SUBSTRING(data_gerado,1,4) FROM cartorios_des GROUP BY SUBSTRING(data_gerado,1,4) ORDER BY SUBSTRING(data_gerado,1,4) DESC");
					while(list($ano) = mysql_fetch_array($sql_ano)){
						echo "<option value=\"$ano\">$ano</option>";
					}
				?>
                </select>
            </td>
        </tr>
        <tr height="30" valign="bottom" align="left">
            <td colspan="4"><input type="submit" class="botao" name="btRelatorio" value="Emitir Relat&oacute;rio"></td>
        </tr>
    </table>
</form>
	</tr>
	<tr>
        <td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>