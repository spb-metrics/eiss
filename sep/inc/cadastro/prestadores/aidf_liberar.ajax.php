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
<link href="../../css/padrao.css" rel="stylesheet" type="text/css">
<?php 
//$include =  $_GET['include'];
require_once("../conect.php");


$codaidf = $_GET['hdCodAidf'];
$sql_aidf = mysql_query("
						SELECT 
							emissor.razaosocial AS emissor_razao,
							emissor.cnpjcpf AS emissor_cnpj,
							emissor.inscrmunicipal AS emissor_im,
							emissor.endereco AS emissor_endereco,
							emissor.municipio AS emissor_municipio,
							emissor.uf AS emissor_uf,
							grafica.razaosocial AS grafica_razao,
							grafica.cnpjcpf AS grafica_cnpj,
							grafica.inscrmunicipal AS grafica_im,
							grafica.endereco AS grafica_endereco,
							grafica.municipio AS grafica_municipio,
							grafica.uf AS grafica_uf,
							aidf.data,
							aidf.observacoes,
							docs.especie,
							docs.serie,
							docs.subserie,
							docs.nroinicial,
							docs.nrofinal,
							docs.quantidade,
							docs.tipo
						FROM 
							aidf_solicitacoes AS aidf
						INNER JOIN 
							emissores AS emissor ON aidf.codemissor = emissor.codigo
						INNER JOIN 
							graficas AS grafica ON aidf.codgrafica = grafica.codigo
						INNER JOIN 
							aidf_docs AS docs ON aidf.codigo = docs.codsolicitacao
						WHERE 
							aidf.codigo = '$codaidf'
						");
	
?>
<input type="hidden" name="txtCodAidf" id="txtCodAidf" value="<?php echo $codaidf;?>">
<fieldset style="width:663px;"><legend>Lista de documentos</legend>
    <table width="100%">
        <tr>	
            <td align="right" width="38%">
            	<input type="submit" value="Liberar" name="btLiberar"  class="botao"
            	onclick="acessoAjax('inc/prestadores/aidf_busca.php','frmAidf','divaidf');alert('Liberado com sucesso!')">
            </td>
            <td align="left" colspan="6">
            	<input type="submit" value="Liberar e Imprimir" name="btLiberar" class="botao"
            	onclick="cancelaAction('frmAidf','inc/prestadores/aidf_imprimir.php','_blank');'">
            </td>
        </tr>	
        <tr bgcolor="#999999">
            <td align="center">Espécie</td>
            <td width="10%" align="center">Série</td>
            <td width="13%" align="center">Sub série</td>
            <td width="14%" align="center">N° nota inicial</td>
            <td width="13%" align="center">N° nota final</td>
            <td width="12%" align="center">Quantidade</td>
        </tr>
        <?php
			while(list($emissor_razao,$emissor_cnpj,$emissor_im,$emissor_endereco,$emissor_municipio,$emissor_uf,
			 $grafica_razao,$grafica_cnpj,$grafica_im,$grafica_endereco,$grafica_municipio,$grafica_uf,
			 $data,$observacoes,$especie,$serie,$subserie,$nroinicial,$nrofinal,$quantidade,$tipo) = mysql_fetch_array($sql_aidf)){
		 ?>
        <tr bgcolor="#FFFFFF">
            <td align="left"><?php echo $especie;?></td>
            <td align="center"><?php echo $serie;?></td>
            <td align="center"><?php echo $subserie;?></td>
            <td align="center"><?php echo $nroinicial;?></td>
            <td align="center"><?php echo $nrofinal;?></td>
            <td align="center"><?php echo $quantidade;?></td>
        </tr>
        <?php
			}//fim while
		?>
    </table>
</fieldset>


<?php /*
 echo "
 	<table width=\"100%\" style=\"text-indent:25px;\" border=\"0\">
		<tr>
			<td bgcolor=\"#ffffff\" colspan=\"2\">
				Dados da AIDF
			</td>			
		</tr>	
		<tr>
			<td bgcolor=\"#ffffff\" colspan=\"2\" >
				Espécie: <font color=\"#FF0000\">$especie</font>
			</td>
			
		</tr>
		<tr>
			<td bgcolor=\"#ffffff\" colspan=\"2\">
				Série: <font color=\"#FF0000\">$serie</font>
			</td>
			
		</tr>	
		<tr>
			<td  bgcolor=\"#ffffff\" colspan=\"2\">
				Sub série: <font color=\"#FF0000\">$subserie</font>
			</td>
			
		</tr>
		<tr>
			<td  bgcolor=\"#ffffff\" colspan=\"2\"> 
				Número Nota: Inicial <font color=\"#FF0000\">$nroinicial</font> - Final <font color=\"#FF0000\">$nrofinal</font>
			</td>
			
		</tr>
		<tr>
			<td  bgcolor=\"#ffffff\" colspan=\"2\">
				Quantidade: <font color=\"#FF0000\">$quantidade</font>
			</td>
			
		</tr>	
		<tr>
			<td  bgcolor=\"#ffffff\" colspan=\"2\">
				Tipo: <font color=\"#FF0000\">$tipo</font>
			</td>			
			
		</tr>	
		<tr>	
			<td align=\"right\" width=\"50%\">
				<input type=\"submit\" value=\"Liberar\" name=\"btLiberar\"  class=\"botao\"
				 onclick=\"cancelaAction('frmPendentes','','_parent')\">				
			</td>
			<td align=\"left\">
				<input type=\"submit\" value=\"Liberar e Imprimir\" name=\"btLiberar\" class=\"botao\"
				 onclick=\"cancelaAction('frmPendentes','../issdigital/site/inc/aidf/aidf_imprimir.php','_blank')\">
			</td>
		</tr>	
	</table>";*/
	
?> 
<title>Lista de documentos da libera&ccedil;&atilde;o</title>