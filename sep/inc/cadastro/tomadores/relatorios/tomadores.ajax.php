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
//conecta ao banco
include("../../conect.php"); 
include("../../../funcoes/util.php");

//recebimento das variaveis por get
$tomador = $_GET["txtTomador"];
?>

<table width="100%">
	<tr>
		<td>
			<fieldset><legend>Créditos</legend>
			<?php
				$sql_tomador = ("SELECT tomador_nome, tomador_cnpjcpf FROM notas WHERE tomador_nome LIKE '$tomador%' GROUP BY tomador_nome");
				$sql=Paginacao($sql_tomador,'frmRelatoriosTomadores','divresultados');
				$resultados=mysql_num_rows($sql);
				if(mysql_num_rows($sql)>0){
			?>
				<table width="100%">
					<tr bgcolor="#999999">
						<td width="40%" align="center">Nome</td>
                        <td width="25%" align="center">CNPJ/CPF</td>
						<td width="15%" align="center">Créditos NF-e</td>
						<td width="15%" align="center">Créditos Des</td>
						<td width="15%" align="center">Total</td>
					</tr>
					<?php 
						while(list($nome,$cnpjcpf) = mysql_fetch_array($sql)){
							//soma os creditos do tomador referente ao nfe
							$sql_credito_nfe = mysql_query("SELECT SUM(credito) FROM notas WHERE tomador_cnpjcpf = '$cnpjcpf'");
							list($credito_nfe) = mysql_fetch_array($sql_credito_nfe);
							//soma os creditos do tomador referente ao des
							$sql_credito_des = mysql_query("SELECT SUM(des_tomadores_notas.credito) FROM des_tomadores_notas 
							INNER JOIN tomadores ON tomadores.codigo = des_tomadores_notas.cod_tomador WHERE tomadores.cnpjcpf = '$cnpjcpf'");
							list($credito_des) = mysql_fetch_array($sql_credito_des);
							//soma os dois resultados e obtem o valor total
							$result = $credito_nfe + $credito_des;						
					?>
					<tr bgcolor="#FFFFFF">
						<td title="<?php echo $nome;?>" align="left"><?php echo $nome;?></td>
                        <td title="<?php echo $cnpjcpf;?>" align="left"><?php echo $cnpjcpf;?></td>
						<td align="center"><?php if($credito_nfe < 0.01){ echo "N/A";}else{ echo DecToMoeda($credito_nfe);}?></td>
						<td align="center"><?php if($credito_des < 0.01){ echo "N/A";}else{ echo DecToMoeda($credito_des);}?></td>
						<td align="center"><?php if($result < 0.01){ echo "N/A";}else{ echo DecToMoeda($result);}?></td>
					</tr>
					<?php
						}//fim while
					?>
				</table>
			</fieldset>
			<?php
				}else{
				echo "Náo há creditos para $tomador";
			
				}//fim else
			?>
		</td>
	</tr>
</table>