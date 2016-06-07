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
	$cnpj = $_SESSION["login"];
	$nome = $_SESSION["nome"];
	$sql_nome = mysql_query("SELECT nome FROM cadastro WHERE cnpj = '$cnpj'");
	list($nome) = mysql_fetch_array($sql_nome);
	$sql_des = mysql_query("
		SELECT 
			dif_des_contas.codigo, 
			dif_des_contas.contaoficial, 
			dif_des_contas.contacontabil, 
			dif_des_contas.titulo, 
			dif_des_contas.item, 
			dif_des_contas.saldo_mesanterior, 
			dif_des_contas.debito, 
			dif_des_contas.credito, 
			dif_des_contas.saldo_mesatual, 
			dif_des_contas.receita, 
			dif_des_contas.aliquota, 
			dif_des_contas.iss, 
			dif_des.data, 
			dif_des.competencia 
		FROM 
			dif_des_contas 
		INNER JOIN 
			dif_des ON dif_des_contas.coddif_des = dif_des.codigo
		INNER JOIN
			cadastro ON dif_des.codinst_financeira = cadastro.codigo
		WHERE 
			cadastro.cnpj = '$cnpj'
			");
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0">
	<tr>
		<td width="10" height="10" bgcolor="#FFFFFF"></td>
		<td width="200" align="center" bgcolor="#FFFFFF" rowspan="3">Histórico de DIF</td>
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
		<td height="60" colspan="3" bgcolor="#CCCCCC" align="center">

<form method="post" action="include/dif/historico/relatorio.php" target="_blank">
	<input name="hdNome" type="hidden" value="<?php echo $nome;?>" />
    <input name="txtCNPJ" type="hidden" value="<?php echo $cnpj;?>" />
    <table width="100%">
        <tr>
            <td colspan="5" align="left">Instituição financeira: <font color="#FF0000"><b><?php echo $nome;?></b></font></td>
      </tr>
        <tr>
        	<td align="left" colspan="5">
				<?php 
					if(mysql_num_rows($sql_des)){ 
						echo "Número de contas declaradas:". mysql_num_rows($sql_des);
					}else{ 
						echo "<font color=\"#FF0000\">Esta instituição não fez nenhuma declaração!</font>";
					}?> 
            </td>
        </tr>
        <tr>
        	<td width="7%" align="left">Estado</td>
            <td align="left" colspan="4">
            	<select name="cmbEstado" class="combo">
                	<option value=""></option>
                    <option value="B">Boleto</option>
                    <option value="C">Cancelada</option>
                    <option value="E">Escriturada</option>
                    <option value="N">Normal</option>
                </select>
            </td>
        </tr>
        <tr height="30">
        	<td align="left">Competência</td>
            <td width="11%">
            <select name="cmbMes" class="combo">
                <option value=""></option>
                <?php
                //array dos meses comecando na posição 1 ate 12 e faz um for listando os meses no combo
                $meses = array(1=>"Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
                for($x=1;$x<=12;$x++){
                    echo "<option value='$x'>$meses[$x]</option>";
                }//fim for meses
                ?>
            </select>
            </td>
            <td width="3%">Mês</td>
            <td width="5%">
                <select name="cmbAno" class="combo">
                    <option value=""></option>
                    <?php
						$year = date("Y");
						for($h=0; $h<5; $h++){
							$y = $year - $h;
							echo "<option value=\"$y\">$y</option>";
                    	}
                    ?>
                </select>
            </td>
            <td width="74%" align="left">Ano</td>
        </tr>
        <tr height="30" valign="bottom">
            <td colspan="5"><input type="submit" class="botao" name="btRelatorio" value="Emitir Relatório"></td>
        </tr>
    </table>
</form>
				</td>
			</tr>
			<tr>
				<td height="1" bgcolor="#CCCCCC" colspan="3"></td>
				<td bgcolor="#CCCCCC"></td>
			</tr>
        </table>
