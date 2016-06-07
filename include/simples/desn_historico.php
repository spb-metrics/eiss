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
	//Recebe o cnpj de quem logou e busca o nome na tabela emissores
	$cnpj = $_SESSION['login'];
	$sql_nome = mysql_query("SELECT nome FROM cadastro WHERE cnpj = '$cnpj' OR cpf = '$cnpj'");
	list($nome) = mysql_fetch_array($sql_nome);
	
	$sql_des = mysql_query("
				SELECT 
					simples_des.codigo,
					simples_des.codemissor,
					simples_des.competencia,
					simples_des.data_gerado,
					simples_des.total,
					simples_des.tomador,
					simples_des.codverificacao,
					simples_des.estado
				FROM 
					simples_des 
				INNER JOIN 
					cadastro ON	cadastro.codigo = simples_des.codemissor
				WHERE
					cadastro.cpf = '$cnpj' OR cadastro.cnpj = '$cnpj'
	");
?>

<table border="0" cellspacing="1" cellpadding="0">
<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
	    <td width="165" align="center" bgcolor="#FFFFFF" rowspan="3" class="fieldsetCab">Relatórios</td>
      <td width="405" bgcolor="#FFFFFF"></td>
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
        
        
<form method="post" action="include/simples/desn_relatorio.php" target="_blank">
	<input name="hdNome" type="hidden" value="<?php echo $nome;?>" />
    <input name="txtCNPJ" type="hidden" value="<?php echo $cnpj;?>" />




    <?php
	if(mysql_num_rows($sql_des)>0){
	?>
    <table width="100%" border="0" cellpadding="3" cellspacing="2">
        <tr>
        	<td align="left" colspan="5">N&uacute;mero de declara&ccedil;&otilde;es feitas: <?php echo mysql_num_rows($sql_des);?></td>
        </tr>
        <tr>
        	<td width="8%">Estado: </td>
       	  <td colspan="4">
            	<select name="cmbEstado" class="combo">
                	<option value=""></option>
                    <option value="B">Boleto</option>
                    <option value="C">Cancelada</option>
                    <option value="E">Escriturada</option>
                    <option value="N">Normal</option>
                </select>
          </td>
        </tr>
        <tr>
        	<td>Tomador: </td>
            <td colspan="4">
            	<input type="radio" name="rdTomador" value="s" />Sim&nbsp;
            	<input type="radio" name="rdTomador" value="n" />n&atilde;o
            </td>
        </tr>
		<tr height="30">
        	<td>Compet&ecirc;ncia: </td>
            <td width="9%">
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
            <td width="3%">M&ecirc;s</td>
            <td width="5%">
            	<select name="cmbAno" class="combo">
                	<option value=""></option>
                <?php
					$sql_ano = mysql_query("SELECT SUBSTRING(competencia,1,4) FROM simples_des GROUP BY SUBSTRING(competencia,1,4) ORDER BY SUBSTRING(competencia,1,4) DESC");
					while(list($ano) = mysql_fetch_array($sql_ano)){
						if($ano != "0000"){
							echo "<option value=\"$ano\">$ano</option>";
						}
					}
				?>
                </select>
          </td>
          <td width="75%">Ano</td>
        </tr>
        <tr height="30" valign="bottom">
            <td colspan="5"><input type="submit" class="botao" name="btRelatorio" value="Emitir Relat&oacute;rio"></td>
        </tr>
  </table>
<?php
}else{
?>
	<table width="100%">
    	<tr>
        	<td align="center"><font color="#FF0000"><b>Este cnpj ainda n&atilde;o fez nenhuma declara&ccedil;&atilde;o</b></font></td>
        </tr>
    </table>
<?php
}
?>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>    
</form>
