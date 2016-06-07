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
	// recebe o cnpj e busca o codigo do emissor
	$cnpj=$_SESSION["login"];
	$sql=mysql_query("
		SELECT codigo 
		FROM cadastro 
		WHERE cnpj='$cnpj' OR 
		cpf='$cnpj'
	");
	list($codemissor)=mysql_fetch_array($sql);
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
		<td height="60" colspan="3" bgcolor="#CCCCCC" align="center">

<form method="post">
	<table>
		<tr>
			<td>Escolha o período

				<select name="cmbMes" id="cmbMes">
					<option value="">==Mês==</option>
					<option value="01">Janeiro</option>
					<option value="02">Fevereiro</option>
					<option value="03">Março</option>
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
			<td>
				<select name="cmbAno" id="cmbAno">
					<option value="">==Ano==</option>
					<?php
						$ano=date("Y");
						for($i=0; $i<5; $i++)
							{
								$year=$ano-$i;
								echo "<option value=\"$year\">$year</option>";
							}
					?>
				</select>
			</td>
			<td><input type="submit" class="botao" name="btBuscar" value="Buscar" /></td>
		</tr>
	</table>
</form>
<?php
	if($_POST["btBuscar"]=="Buscar")
		{
			// recebe os dados
			$ano=$_POST["cmbAno"];
			$mes=$_POST["cmbMes"];
			echo "
			<script>
				document.getElementById('cmbMes').value = '$mes';
				document.getElementById('cmbAno').value = '$ano';
			</script>"
			?>
				<div>
					<table width="100%">
						<tr align="center">
							<td>Data Emissão</td>
							<td>Valor declarado</td>
							<td>Valor do ISS</td>
							<td>Cód. verificação</td>
							<td>Estado da DES</td>
						</tr>
						<?php
						// busca as declaracoes do periodo
						$sql=mysql_query("
							SELECT 
								data_gerado,
								total, 
								iss, 
								codverificacao, 
								estado 
							FROM des 
							WHERE codcadastro='$codemissor' AND competencia = '$ano-$mes-01'
							ORDER BY codigo
						");
						// enauqnto houver resultados, joga os resultados no vetor $dados, as posicoes do vetor tem nome, em vez de ordem numerica, iguais aos nomes dos campos da tabela
						while($dados=mysql_fetch_array($sql))
							{
								// faz o tratamento dos dados
								$estado = array(
									"N" => "Normal",
									"B" => "Boleto",
									"C" => "Cancelada",
									"E" => "Escriturada"
								);
								
								// exibe os dados na tela
								echo "
									<tr align=\"center\">
										<td bgcolor=#ffffff>".DataPt($dados["data_gerado"])."</td>
										<td bgcolor=#ffffff>R$ ".DecToMoeda($dados["total"])."</td>
										<td bgcolor=#ffffff>R$ ".DecToMoeda($dados["iss"])."</td>
										<td bgcolor=#ffffff>".$dados["codverificacao"]."</td>
										<td bgcolor=#ffffff>".$estado[$dados["estado"]]."</td>
									</tr>
								";
							}
							?>
						</table>
					</div>	
<?php						
		}
?>
		</td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>